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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function visit($id){

        try{
            $business = Business::select('name')->findOrFail($id);

        }catch(Exception $e){

            abort(404);
        }
        return view('visitor.visit',compact('business','id'));
    }

    public function success($id){
        try{
            $business = Business::select('name')->findOrFail($id);
        }catch(Exception $e){
            abort(404);
        }
        return view('visitor.success',compact('business','id'));
    }


    public function denied($id){
        try{
            $business = Business::select('name')->findOrFail($id);
        }catch(Exception $e){
            abort(404);
        }
        return view('visitor.denied',compact('business','id'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id){

        try{
            $visitor = Visitor::with(['visits'=>function($query){
                $query->orderByDesc('id');
                $query->select('id','visitorId','visitDate')->get();
                $query->skip(0);
                $query->take(1);
            }])->where('phone', $request->phone)->select('id','firstName','lastName')->first();

            if ($visitor){
                //validar si la diferencia entre la visita actual y la última es de 12 horas
                $now = Carbon::now();
                $diffMins = $now->diffInMinutes($visitor->visits[0]->visitDate);
                $diffHours = $diffMins / 60;


                if ($diffHours >= 12){
                    app(VisitController::class)->store($id, $visitor->id);
                    // hacer aqui el cron job
                    return redirect()->route('visitor.success', ['id' => $id]);
                } else {
                    return redirect()->route('visitor.denied', ['id' => $id]);
                }

            } else {

                $visitor = new Visitor();
                $visitor->firstName = $request->firstName;
                $visitor->lastName = $request->lastName;
                $visitor->phone = $request->phone;
                $visitor->email = $request->email;
                $visitor->save();

                app(VisitController::class)->store($id, $visitor->id);
                // hacer el cron job aqui
                return redirect()->route('visitor.success', ['id' => $id]);
            }

            return $visitor;
        }catch(Exception $e){
            // return $e;
            dd($e);
        }

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Visitor $visitor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visitor $visitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visitor $visitor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visitor $visitor)
    {
        //
    }
}
