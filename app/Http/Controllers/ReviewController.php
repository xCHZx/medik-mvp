<?php

namespace App\Http\Controllers;

use App\Models\Business;
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
    public function index()
    {
        // validar que el usuario tenga reviews con un status de complatada y devolver esa review
        try {
            $business = Auth::user()->businesses->first();
            if (!$business)
            {
                return redirect()->route('business.index');
            }

            //agregar filtros para queryparams donde el usuario me pueda pasar 3 filtros, los recibo y verifico que esten y si estan hago el filtrado antes de enviar las reviews

            $reviews = $business->reviews()->where('status' , 'finalizada')->paginate(5);

            if($reviews->count() > 0)
            {
                return view('dashboard.reviews.index', ['reviews' => $reviews , 'error' => false]);

            }
            else
            {
                return view('dashboard.reviews.index' , ['error' => true]);
            }

        } catch (Exception $e)
         {
            dd($e);

        }

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($visitEncrypted)
    {
        try{
            $visitId = decrypt($visitEncrypted, env('ENCRYPT_KEY'));
            $visit = Visit::with('visitor','business','review','review.flow')->findOrFail($visitId);
            // return $visit;
            return view('reviews.create',compact('visit', 'visitEncrypted'));
        }catch(Exception $e){
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
        try{
            $visitId = decrypt($visitEncrypted, env('ENCRYPT_KEY'));
            $review = Review::where('visitId' , $visitId)->firstOrFail();
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->status = 'finalizada';
            $review->save();

            $newReview = Review::with('visit')->findOrFail($review->id);

            app(BusinessController::class)->calculateRating($newReview->visit->businessId);

            if ($review->rating >= 4){
                return redirect()->route('review.thankYouGood', ['visitEncrypted' => $visitEncrypted]);
            }else{
                return redirect()->route('review.thankYouBad', ['visitEncrypted' => $visitEncrypted]);
            }

        }catch(Exception $e){

            dd($e);
        }

    }

    // modificamos el status de la review cuando se envia, se recibe y se lee

    public function changeStatus($whatssAppId , $status)
    {
        $status = $this->translate($status);
        
        try {
            Review::where('whatsappId' , $whatssAppId)->update([
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


}
