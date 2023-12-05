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

        $review = new Review();
        $review->visitId = $visit->id;
        $review->save();


    }

    public function thankYouGood($visitEncrypted)
    {
        return view('reviews.thankYouGood');
    }

    public function thankYouBad($visitEncrypted)
    {
        // Se necesitan recuperar las redes sociales
        return view('reviews.thankYouBad');

    }

    public function update(Request $request, $visitEncrypted)
    {
        try {
            $visitId = decrypt($visitEncrypted, env('ENCRYPT_KEY'));
            $review = Review::where('visitId', $visitId)->firstOrFail();
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->status = 'finalizada';
            $review->save();

            $newReview = Review::with('visit')->findOrFail($review->id);

            app(BusinessController::class)->calculateRating($newReview->visit->businessId);

            if ($review->rating >= 4) {
                return redirect()->route('review.thankYouGood', ['visitEncrypted' => $visitEncrypted]);
            } else {
                return redirect()->route('review.thankYouBad', ['visitEncrypted' => $visitEncrypted]);
            }

        } catch (Exception $e) {

            dd($e);
        }

    }

    // modificamos el status de la review cuando se envia, se recibe y se lee

    public function changeStatus($whatssAppId, $status)
    {
        $status = $this->translate($status);

        try {
            Review::where('whatsappId', $whatssAppId)->update([
                'status' => $status
            ]);
        } catch (Exception $e) {
            dd($e);
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