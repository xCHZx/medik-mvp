<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Flow;
use App\Models\Review;
use App\Models\Visit;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Money\Exchange;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public $flows = [
        'Calidad de la atención médica' => '1',
        'Accesibilidad y tiempo de espera' => '2',
        'Comunicación médico-paciente' => '3',
        'Satisfacción general' => '4'
    ];

    public function index(Request $request)
    {
        try {
            $business = Auth::user()->businesses->first();
            if (!$business) {
                return redirect()->route('business.index');
            }

            $startDate = $request->query('startDate');
            $endDate = $request->query('endDate');
            $flowObjective = $request->query('flowObjective');

            if ($startDate && $endDate && $flowObjective) {
                $flowObjective = $this->getFlowObjective($flowObjective);
                $flowId = Flow::where('objective', $flowObjective)->pluck('id');
                $reviews = $business->reviews()->where('status', 'Finalizada')->whereDate('reviews.created_at', '>=', $startDate)->whereDate('reviews.created_at', '<=', $endDate)->where('flowId', $flowId)->orderByDesc('id')->paginate(5);
            } else if ($startDate && $endDate) {
                $reviews = $business->reviews()->where('status', 'Finalizada')->whereDate('reviews.created_at', '>=', $startDate)->whereDate('reviews.created_at', '<=', $endDate)->orderByDesc('id')->paginate(5);
            } else if ($flowObjective) {
                $flowObjective = $this->getFlowObjective($flowObjective);
                $flowId = Flow::where('objective', $flowObjective)->pluck('id');
                $reviews = $business->reviews()->where('status', 'Finalizada')->where('flowId', $flowId)->orderByDesc('id')->paginate(5);

            } else {
                $reviews = $business->reviews()->where('status', 'Finalizada')->orderByDesc('id')->paginate(5);

            }


            if ($reviews->count() > 0) {
                $flowsObjectives = $business->flows()->pluck('objective');
                return view('dashboard.reviews.index', [
                    'reviews' => $reviews,
                    'flowsObjectives' => $flowsObjectives,
                    'flows' => $this->flows,
                    'error' => false
                ]);

            } elseif ($reviews->isEmpty()) {
                $flowsObjectives = $business->flows()->pluck('objective');
                // Crear una instancia de LengthAwarePaginator con una colección vacía y el número total de elementos
                $emptyReviews = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 5);
                //Luego retorna vista
                return view('dashboard.reviews.index', [
                    'reviews' => $emptyReviews,
                    'flowsObjectives' => $flowsObjectives,
                    'flows' => $this->flows,
                    'error' => false
                ]);
            } else {
                return view('dashboard.reviews.index', ['error' => true]);
            }

        } catch (Exception $e) {
            dd($e);

        }

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($visitEncrypted)
    {
        try {
            $visitId = decrypt($visitEncrypted, env('ENCRYPT_KEY'));
            $visit = Visit::with('visitor', 'business', 'review', 'review.flow')->findOrFail($visitId);
            // return $visit;
            return view('reviews.create', compact('visit', 'visitEncrypted'));
        } catch (Exception $e) {
            dd($e);
        }
    }



    public function store($visit)
    {
        try { 
           $review = new Review();
           $review->visitId = $visit->id;
           $review->save();

           app(LogController::class)->store(
               "Succes",
               "El visitante #".$visit->id." creo una review para el negocio #".$review->visit->businessId,
               "Review",
               Auth::user()->id,
               $review   
           );
        } catch (Exception $e) {
            app(LogController::class)->store(
                "Error",
                "El visitante #".$visit->id." erro al crear una review para el negocio #".$review->visit->businessId,
                "Review",
                Auth::user()->id,
                $e
            );
        }
    }

    public function thankYouGood($visitEncrypted)
    {
        try {
            $visitId = 
            $review = Review::where('visitId', decrypt($visitEncrypted, env('ENCRYPT_KEY')))->first();
            $flow = $review->flow;
            $calificationLinks = $flow->calificationLinks()->get();

            if ($calificationLinks) {
                return view('reviews.thankYouGood', ['links' => $calificationLinks]);
            }
            return view('reviews.thankYouGood');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function thankYouBad($visitEncrypted)
    {

        return view('reviews.thankYouBad');

    }

    public function update(Request $request, $visitEncrypted)
    {
        try {
            $visitId = decrypt($visitEncrypted, env('ENCRYPT_KEY'));
            $review = Review::where('visitId', $visitId)->firstOrFail();
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->status = 'Finalizada';
            $review->save();

            app(LogController::class)->store(
                "Succes",
                "El visitante #".$visitId." finalizo una review al negocio #".$review->visit->businessId,
                "Review",
                Auth::user()->id,
                $review
            );

            $newReview = Review::with('visit')->findOrFail($review->id);

            app(BusinessController::class)->calculateRating($newReview->visit->businessId);

            if ($review->rating >= 4) {
                return redirect()->route('review.thankYouGood', ['visitEncrypted' => $visitEncrypted]);
            } else {
                return redirect()->route('review.thankYouBad', ['visitEncrypted' => $visitEncrypted]);
            }

        } catch (Exception $e)
        {
            app(LogController::class)->store(
                "Error",
                "El visitante #".$visitId." erro al finalizar una review al negocio #".$review->visit->businessId,
                "Review",
                Auth::user()->id,
                $e
            );

        }

    }

    // modificamos el status de la review cuando se envia, se recibe y se lee

    public function changeStatus($whatssAppId, $status)
    {
        $status = $this->translate($status);

        try {
            // Review::where('whatsappId', $whatssAppId)->update([
            //     'status' => $status
            // ]);
            $review = Review::where('whatsappId', $whatssAppId)->get();
            $review->status = $status;
            $review->save();

            app(LogController::class)->store(
                "Succes",
                "La review #".$review->id." cambio de status a ".$review->status,
                "Review",
                Auth::user()->id,
                $review
            );
            
        } catch (Exception $e) {
            app(LogController::class)->store(
                "Error",
                "La review #".$review->id." erro al intentar cambiar de status",
                "Review",
                $e
            );
        }

    }

    // traducir el status que nos manda whatsapp
    private function translate($status)
    {
        $traduccion = [
            'read' => 'Leida',
            'sent' => 'Enviada',
            'delivered' => 'Entregada'
        ];

        return $status = $traduccion[$status];

    }

    private function getFlowObjective($objective)
    {
       $flowObjectives = [
            '1' => 'Calidad de la atención médica',
            '2' => 'Accesibilidad y tiempo de espera',
            '3' => 'Comunicación médico-paciente',
            '4' => 'Satisfacción general'

        ];

        return $flowObjectives[$objective];

    }

}
