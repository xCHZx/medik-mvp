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

class ReviewController extends Controller
{
    public function index()
    {
        // validar que el usuario tenga reviews con un status de complatada y devolver esa review
        try {

            $Business = Auth::user()->businesses->first();
            $reviews = $Business->reviews()->where('status' , 'finalizada')->get();

            if($reviews)
            {
                return view('dashboard.reviews.index' , ['reviews' => $reviews]);
            }
            else
            {
                throw new ModelNotFoundException('No se encontraron opiniones para este usuario.');
            }

        } catch (ModelNotFoundException $e)
         {
            return view('dashboard.reviews.index' , ['message' => 'no tienes opiniones que mostrar']);
        }

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($visitEncrypted)
    {
        try{
            $visitId = decrypt($visitEncrypted, env('ENCRYPT_KEY'));
            $visit = Visit::with('visitor','business')->findOrFail($visitId);
            return view('reviews.create',compact('visit', 'visitEncrypted'));
        }catch(Exception $e){
            dd($e);
        }
    }

    // realizar la mayoria de esto desde un metodo update

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

    // indicamos que una review ha sido enviada

    public function reviewSended($visit , $flow)
    {
         // buscar la review asociada a esa visita
         $review =Review::where('visitId' , $visit->id)->firstOrFail();
         $review->flowId = $flow->id;
         $review->status = 'enviada';
         $review->save();

    }




}
