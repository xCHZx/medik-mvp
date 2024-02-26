<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Events\RegisteredVisit;
use App\Models\Visit;
use App\Models\Visitor;
use App\Models\Review;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create($businessId)
    {
        try{
            $businessId = decrypt($businessId);
            $business = Business::select('name')->findOrFail($businessId);
        }catch(Exception $e){
            abort(404);
        }
        return view('visit.create',compact('business','businessId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $businessId){

        try{

            $visitor = $this->getVisitor($request);

            if ($visitor){

                if ($this->isPast12Hours($visitor)){

                   $visit = $this->createVisit($businessId, $visitor, $request);
                   app(ReviewController::class)->store($visit);
                   event(new RegisteredVisit($visit));
                   return redirect()->route('visit.success', ['businessId' => encrypt($businessId)]);
                } else {
                    return redirect()->route('visit.denied', ['businessId' => encrypt($businessId)]);
                }

            } else {
                $visit = $this->createVisit($businessId, $visitor, $request);
                app(ReviewController::class)->store($visit);
                event(new RegisteredVisit($visit));
                return redirect()->route('visit.success', ['businessId' => encrypt($businessId)]);
            }
            return $visitor;
        }catch(Exception $e){
            // return $e;
            // desde aqui returnar el mensaje si ocurrio algo con el envio de mensajes
            dd($e);
        }
    }

    private function getVisitor($request){
        $visitor = Visitor::with(['visits'=>function($query){
            $query->orderByDesc('id');
            $query->select('id','visitorId','visitDate')->get();
            $query->skip(0);
            $query->take(1);
        }])->where('phone', $request->phone)->select('id','firstName','lastName')->first();

        return $visitor;
    }

    private function createVisit($businessId, $visitor, $request){
        $visitor = app(VisitorController::class)->store($request);
        $visit = new Visit();
        $visit->businessId = $businessId;
        $visit->visitorId = $visitor->id;
        $visit->visitDate = Carbon::now();
        $visit->save();

        $this->generateHashedId($visit->id);
        return $visit;
    }

    private function isPast12Hours($visitor){
        $now = Carbon::now();
        $diffMins = $now->diffInMinutes($visitor->visits[0]->visitDate);
        $diffHours = $diffMins / 60;

        if ($diffHours >= 12){
            return true;
        }
        return false;
    }

    public function generateHashedId($visitId){
        $visit = Visit::find($visitId);
        $visit->hashedId = encrypt($visit->id, env('ENCRYPT_KEY'), ['length' => 10]);
        $visit->save();
    }

    public function success($businessId){
        try{
            $businessId = decrypt($businessId);
            $business = Business::select('name')->findOrFail($businessId);
        }catch(Exception $e){
            abort(404);
        }
        return view('visit.success',compact('business','businessId'));
    }

    public function denied($businessId){
        try{
            $businessId = decrypt($businessId);
            $business = Business::select('name')->findOrFail($businessId);
        }catch(Exception $e){
            abort(404);
        }
        return view('visit.denied',compact('business','businessId'));
    }

}
