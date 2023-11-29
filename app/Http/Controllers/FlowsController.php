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
    //No dejar más de 2 saltos de línea seguidos porfa
    //Implementar llamado de los logs con trycatch6, ejemplo en Business
    //Agregar descripciones contextuales si son necesarias, de funciones del Controler
    //Si vas a manejar validaciones con If no tires error con Else, sino con Throw
    //Ver ejemplo en http/requests/auth/loginrequest
    public function index()
    {
        $user = Auth::user();
        // comprobamos que el usuario tenga un negocio
        $business = Business::where('userId' , $user->id)->first();
        if ($business){

            $flows = Flow::where('businessId' , $business->id)->orderByDesc('isActive')->get();
            if (count($flows) > 0)
            {
                // vista de sus flujos
                return view('dashboard.flows.index',['flows' => $flows, 'businessName' => $business->name]);
            }else{
                // vista para crear su primer flujo
                return view('dashboard.flows.create', ['businessName' => $business->name]);
            }
        }
        else{
            // le negamos que pueda ver un flujo o crearlo hasta que cree un negocio
            //Esta validación se debe hacer frontside para no cargar el mvp de vistas ya que no estamos trabajando por componentes -CJ
            $message = "Debes tener un negocio antes de crear tu primer flujo";
            return view('dashboard.flows.notpermited' , ['message' => $message]);
        }
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $business = Business::where('userId' , $user->id)->first();
        return view('dashboard.flows.create', ['businessName' => $business->name]);
    }

    public function store(Request $request){

        $validated = $request->validate([
            'name' => 'required', // nuevo flujo de + objetivo
            'objetive' => 'required',
        ]); //No debes asignar la función a una variable si no se usará después -CJ

        $user = Auth::user();
        $business = $user->businesses->first();
        $flows = Flow::where('businessId', $business->id)
                   ->where('isActive' , true)->get(); //Hay que meter select para jalar datos específicos de los modelos -CJ
        //^^^^No debes llamar una lista de un modelo desde la misma función dónde lo creas-CJ^^^^^

        $flow = new Flow();
        $flow->name = $request->name;
        $flow->objetive = $request->objetive;
        $flow->businessId = $business->id;

        if(count($flows) > 0) //No se recomienda meter comparativos a 0, mejor utiliza if($flows)
        {
            $flow->isActive = false;

        }
        else
        {
            $flow->isActive = true;
        }
        $flow->save();


        if(isset($request->googleUrl) && !empty($request->googleUrl)) //Al recibir en null puedes meter una validación más sencilla y no un AND -CJ
         {
            $calification1 = new CalificationLink(); //Hay que cambiar el nombre del modelo ya que no se usa Calification en ninguna instancia, sino Review -CJ
            $calification1->name = 'google';
            $calification1->url = $request->googleUrl;
            $calification1->flowId = $flow->id;
            $calification1->save();
            //^^^^El nombre calification1 no es descriptivo -CJ^^^^
         }



        if (isset($request->facebookUrl) && !empty($request->facebookUrl)) {
            $calification2 = new CalificationLink();
            $calification2->name = 'facebook';
            $calification2->url = $request->facebookUrl;
            $calification2->flowId = $flow->id;
            $calification2->save();

        }
        //^^^^Mismos comentarios de la función anterior -CJ^^^^



        return Redirect::route('flows.index')->with('status', 'Flow-Created'); //Hay que homologar los status a minúsculas, comunícaselo a Fer -CJ

    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        $business = Business::where('userId' , $user->id)->first();
        // recibo el id , y retorno la vista de creacion los datos del flujo

        $validated = $request->validate(['flowId' => 'required']);

        $flow = Flow::where('id', $request->flowId)->first();
        $facebookLink = CalificationLink::where('name', 'facebook')->where('flowId', $flow->id)->first();
        $googleLink = CalificationLink::where('name' , 'google')->where('flowId' , $flow->id)->first();
        return view('dashboard.flows.edit',[
            'businessName' => $business->name,
            'flow' => $flow,
            'facebookLink' => $facebookLink,
            'googleLink' => $googleLink
        ]);

    }

    public function update(Request $request) //Mismas correccciones que en Store
    {
        // recibo los datos del flujo y lo sobreescribo

        $validated = $request->validate([
            'flowId' => 'required',
            'name' => 'required', // validar que sea string
            'objetive' => 'required' // validar que sea string
        ]);

        Flow::where('id' , $request->flowId)->update([
                               'name' => $request->name,
                               'objetive' => $request->objetive
                           ]);

        if(isset($request->googleUrl) && !empty($request->googleUrl))
        {
            $calificationLink = CalificationLink::updateOrCreate(
                ['name' => 'google' , 'flowId' => $request->flowId],
                ['url' => $request->googleUrl]
            );
        }

        if (isset($request->facebookUrl) && !empty($request->facebookUrl))
        {
            $calificationLink2 = CalificationLink::updateOrCreate(
                ['name' => 'facebook', 'flowId' => $request->flowId],
                ['url' => $request->facebookUrl]
            );
        }
        return Redirect::route('flows.index')->with('status', 'Flow-Changed');
    }

    public function changeStatus(Request $request) //Mismas correcciones anteriores
    {
        // este metodo sirve para modificar el status de un flujo
        // la vista tiene que enviarme el id del flujo a modificar y si lo intenta activar o desactivar
        $validated = $request->validate([
            'flowId' => 'required',
            'activate' => 'required'
        ]);

        if ($request->activate === 'true') //Puedes utilizar una validación más resumida. True nunca se evalúa cómo String. Si lo guardas como String es error de modelo de datos
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
                //Falta manejo de excepciones -CJ
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
     public function delete(Request $request) //Mismas correcciones
     {
         // metodo para recibir el id de un flujo y eliminarlo de la bd permanentemente
         $validated = $request->validate(['flowId' => 'required']);

        Flow::destroy($request->flowId);
        return Redirect::route('flows.index')->with('flow-status' , 'success');
    }
}
