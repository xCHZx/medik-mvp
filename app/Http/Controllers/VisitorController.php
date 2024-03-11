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

            app(LogController::class)->store(
                "Succes",
                "El visitante #".$visitor->id." se registro para el negocio #".Auth::user()->bussinesId,
                "Visitor",
                Auth::user()->id,
                $visitor
            );
 
            return $visitor;
        }catch(Exception $e){
            app(LogController::class)->store(
                "Error",
                "Error al registrar una visita al negocio #".Auth::user()->businessId,
                "Visitor",
                Auth::user()->id,
                $e
            );
        }
    }
}
