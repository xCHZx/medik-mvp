<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Visitor;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){

        try{
            $visitor = new Visitor();
            $visitor->firstName = $request->firstName;
            $visitor->lastName = $request->lastName;
            $visitor->phone = $request->phone;
            $visitor->email = $request->email;
            $visitor->save();

            return $visitor;
        }catch(Exception $e){
            // return $e;
            dd($e);
        }
    }
}
