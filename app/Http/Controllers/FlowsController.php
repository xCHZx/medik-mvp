<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\CalificationLink;
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
            
            $flows = $business->flows;
            if (count($flows) > 0)
            {
                // vista de sus flujos
                return view('dashboard.flows.index',['flows' => $flows]);
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

    public function create(Request $request)
    {
        return view('dashboard.flows.create');
    }

    public function store(Request $request){

        $validated = $request->validate([
            'name' => 'required', // nuevo flujo de + objetivo
            'objetivo' => 'required',
        ]);
        

        $user = Auth::user();
        $business = $user->businesses->first();
        $flows = Flow::where('businessId', $business->id)
                   ->where('isActive' , true)->get();

        $flow = new Flow();
        $flow->name = $request->name;
        $flow->objetivo = $request->objetivo;
        $flow->businessId = $business->id;

        if(count($flows) > 0)
        {
            $flow->isActive = false;

        }
        else
        {
            $flow->isActive = true;
        }
        
        
        $flow->save();


        if(isset($request->googleUrl) && !empty($request->googleUrl))
         {
            $calification1 = new CalificationLink();
            $calification1->name = 'google';
            $calification1->url = $request->googleUrl;
            $calification1->flowId = $flow->id;
            $calification1->save();
         }


    
        if (isset($request->facebookUrl) && !empty($request->facebookUrl)) {
            $calification2 = new CalificationLink();
            $calification2->name = 'facebook';
            $calification2->url = $request->facebookUrl;
            $calification2->flowId = $flow->id;
            $calification2->save();
            
        };
        
        

        return Redirect::route('flows.index')->with('status', 'Flow-Created');

    }

    public function edit(Request $request)
    {
        // recibo el id , y retorno la vista de creacion los datos del flujo
        // con un status que diga editando
    }

    public function update(Request $request)
    {
        // recibo los datos del flujo y lo sobreescribo
    }

    public function changeStatus(Request $request)
    {  
        // este metodo sirve para modificar el status de un flujo
        // la vista tiene que enviarme el id del flujo a modificar y si lo intenta activar o desactivar
        $validated = $request->validate([
            'flowId' => 'required',
            'activate' => 'required'
        ]);
    
        if ($request->activate === 'true')
        {
            $business = Auth::user()->businesses->first();
            $flows = Flow::where('businessId' , $business->id)
                          ->where('isActive' , true)->get();
            if (count($flows) == 0){

                Flow::where('id', $request->flowId)
                       ->update(['isActive' => true]);
               
                return Redirect::route('flows.index');
            }
            else
            {
                // devolver con mensaje de error
                return Redirect::route('flows.index')->with('flow-status' , 'error');
            }

        }
        else
        {
            Flow::where('id', $request->flowId)
                       ->update(['isActive' => false]);

            return Redirect::route('flows.index');
        }

        


    }
}
