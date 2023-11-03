<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Review;
use App\Models\Visit;
use Exception;
use Illuminate\Http\Request;
use Money\Exchange;

class ReviewController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create($visitEncrypted)
    {
        try{
            $visitId = decrypt($visitEncrypted, env('ENCRYPT_KEY'));
            $visit = Visit::find($visitId);
            $business = $visit->visitor;
        }catch(Exception $e){
            dd($e);
        }
        return view('reviews.create', compact('visit','business'));
    }

    public function store(Request $request, $visitEncrypted){
        try{
            $visitId = decrypt($visitEncrypted, env('ENCRYPT_KEY'));
            $review = new Review();
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->visitId = $visitId;
            $review->save();

            if ($review->rating >= 4){
                return redirect()->route('review.thankYouGood', ['visitEncrypted' => $visitEncrypted]);
            }else{
                return redirect()->route('review.thankYouBad', ['visitEncrypted' => $visitEncrypted]);
            }

        }catch(Exception $e){

        }

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



}
