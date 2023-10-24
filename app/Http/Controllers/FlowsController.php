<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\CalificactionLink;
use App\Models\Flow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FlowsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // comprobamos que el usuario tenga un negocio
        $business = Business::where('userId' , $user->id)->first();
        if ($business){
            // comprobamos que el usuario tenga un flujo
            $flow = Flow::where('businessId' , $business->id)->first();
            if ($flow)
            {
                // vista de sus flujos
                return view('dashboard.flows.index',['flow' => $flow]);
            }else{
                // vista para crear su primer flujo
                return view('dashboard.flows.create');
            }
        }
        else{
            // le negamos que pueda ver un flujo o crearlo hasta que cree un negocio
            $message = "Debes tener un negocio antes de crear tu primer flujo";
            return view('dashboard.flows.notpermited' , ['message' => $message]);
        }
    }

    public function store(Request $request){

        $validated = $request->validate([
            'name' => 'required', // nuevo flujo de + objetivo
            'objetivo' => 'required',
        ]);
        

        $user = Auth::user();
        $business = $user->businesses->first();

        $flow = new Flow();
        $flow->name = $request->name;
        $flow->objetivo = $request->objetivo;
        $flow->isActive = true;
        $flow->businessId = $business->id;
        $flow->save();


        if ($request->googleUrl)
        {
            $calification1 = new CalificactionLink();
            $calification1->name = 'google';
            $calification1->url = $request->googleUrl;
            $calification1->flowId = $flow->id;


        };
        if ($request->facebookUrl)
        {
            $calification2 = new CalificactionLink();
            $calification2->name = 'facebook';
            $calification2->url = $request->facebookUrl;
            $calification2->flowId = $flow->id;

        }
        

        return Redirect::route('flows.index')->with('status', 'Flow-Created');

    }

    public function changeStatus(Request $request)
    {
        // cambio el  status del flujo al que me enviaron
        $validated = $request->validate([
            'status' => 'required'
        ]);

        if ( $request->status === 'true' || $request->status === 'false')
        {
            $user = Auth::user();
            $flow = $user->businesses->flow;

            $flow->isActive = $request->status;
             
        }    


    }
}
