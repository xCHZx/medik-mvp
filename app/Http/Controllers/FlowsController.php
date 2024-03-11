<?php

namespace App\Http\Controllers;

use App\Exceptions\objectiveNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\CalificationLink;
use App\Models\Flow;
use Exception;
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

    private $description = [ // crear este arreglo con todas las descripciones y guardalas en la bd en la creacion del flujo
        'Calidad de la atención médica' => 'Escoge este objetivo si deseas evaluar cómo tus pacientes perciben la calidad de la atención médica proporcionada, incluida la efectividad de los tratamientos y la gestión de las condiciones de salud.',
        'Accesibilidad y tiempo de espera' => ''

    ];

    public $aliases = [ //pregunta personalizada
        'Calidad de la atención médica' => 'Por favor, evalúa nuestra atención médica y la calidad del trato que recibiste. ¡Gracias por tu ayuda!',
        'Accesibilidad y tiempo de espera' => 'Por favor, evalúa el tiempo de espera durante tu visita y tu experiencia al solicitar la consulta. ¡Gracias por tu ayuda!',
        'Comunicación médico-paciente' => 'Por favor, evalúa la comunicación con tu médico durante la visita. ¡Gracias por tu ayuda!',
        'Satisfacción general' => 'Por favor, evalúa nuestros servicios, la atencion, el tiempo de espera y la comunicacion con nuestro personal. ¡Gracias por tu ayuda!'
    ];
    
    public function index()
    {
        $user = Auth::user();
        // comprobamos que el usuario tenga un negocio
        $business = Business::where('userId' , $user->id)->first();
        if ($business){

            $flows = Flow::where('businessId' , $business->id)
                           ->where('isDeleted', false)->orderByDesc('isActive')->get();
            if (count($flows) > 0)
            {
                // vista de sus flujos
                return view('dashboard.flows.index',['flows' => $flows, 'businessName' => $business->name]);
            }else{
                // vista para crear su primer flujo
                return view('dashboard.flows.create', ['businessName' => $business->name , 'aliases' => $this->aliases]);
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
        return view('dashboard.flows.create', ['businessName' => $business->name , 'aliases' => $this->aliases]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required', // nuevo flujo de + objetivo
                'objective' => 'required',
            ]); 
    
            $user = Auth::user();
            $business = $user->businesses->first();
    
            $flows = $this->getFlows($business->id);
    
            $alias = $this->getAlias($request->objective, $this->aliases);
    
            $flow = new Flow();
            $flow->name = $request->name;
            $flow->objective = $request->objective;
            $flow->alias = $alias;
            $flow->businessId = $business->id;
    
            if($flows->count() > 0) //No se recomienda meter comparativos a 0, mejor utiliza if($flows)
            {
                $flow->isActive = false;
    
            }
            else
            {
                $flow->isActive = true;
            }
            $flow->save();

            app(LogController::class)->store(
                "Succes",
                "El usuario #". Auth::user()->id.", creo el flujo #".$flow->id,
                "Flujo",
                Auth::user()->id,
                $flow
            );
    
            $this->generateHasedId($flow->id);
    
    
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
        } catch (Exception $e) {
            app(LogController::class)->store(
                "Error",
                "El usuario #".Auth::user()->id." erro al intentar crear un flujo",
                "Flujo",
                Auth::user()->id,
                $e
            );
        }

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
            'googleLink' => $googleLink,
            'aliases' => $this->aliases
        ]);

    }

    public function update(Request $request) //Mismas correccciones que en Store
    {
        try {
            $request->validate([
                'flowId' => 'required',
                'name' => 'required', // validar que sea string
                'objective' => 'required' // validar que sea string
            ]);
    
            $flow = Flow::find($request->flowId);
            $flow->name = $request->name;
            $flow->objective = $request->objective;
            $flow->save();
    
            if(isset($request->googleUrl) && !empty($request->googleUrl))
            {
                CalificationLink::updateOrCreate(
                    ['name' => 'google' , 'flowId' => $request->flowId],
                    ['url' => $request->googleUrl]
                );
            }
    
            if (isset($request->facebookUrl) && !empty($request->facebookUrl))
            {
                CalificationLink::updateOrCreate(
                    ['name' => 'facebook', 'flowId' => $request->flowId],
                    ['url' => $request->facebookUrl]
                );
            }
            
            app(LogController::class)->store(
                "Succes",
                "El usuario #".Auth::user()->id." , edito el flujo #".$flow->id,
                "Flujo",
                Auth::user()->id,
                $flow
            );
            return Redirect::route('flows.index')->with('status', 'Flow-Changed');
        } catch (Exception $e) {
            app(LogController::class)->store(
                "Error",
                "El usuario #".Auth::user()->id." ,erro al editar un flujo",
                "Flujo",
                Auth::user()->id,
                $e
            );
        }

        
    }

    public function changeStatus(Request $request) //Mismas correcciones anteriores
    {
        try {
            // este metodo sirve para modificar el status de un flujo
            // la vista tiene que enviarme el id del flujo a modificar y si lo intenta activar o desactivar
            $request->validate([
                'flowId' => 'required',
                'activate' => 'required'
            ]);

            $flow = Flow::find($request->flowId);
            $status = "";

            if ($request->activate === 'true') //Puedes utilizar una validación más resumida. True nunca se evalúa cómo String. Si lo guardas como String es error de modelo de datos
            {
                $business = Auth::user()->businesses->first();
                $flows = Flow::where('businessId' , $business->id)
                              ->where('isActive' , true)->get();
                
                if (count($flows) == 0){
                    $flow->isActive = true;
                    $status = "Activado";
          
                }
                else
                {
                    // devolver con mensaje de error
                    // $message = "intento de activar un flujo cuando ya hay uno activado";
                    // throw new Exception($message);
                    return Redirect::route('flows.index')->with('flow-status' , 'error');
                }

            }
            else
            {
                $flow->isActive = false;
                $status = "Desactivado";
            }

            $flow->save();

            app(LogController::class)->store(
                "Succes",
                "El usuario #".Auth::user()->id." , cambio el status de el flujo #".$flow->id." a ".$status,
                "Flujo",
                Auth::user()->id,
                $flow
            );
            return Redirect::route('flows.index');

        } catch (Exception $e) {
            app(LogController::class)->store(
                "Error",
                "El usuario #".Auth::user()->id." , erro al intentar cambiar el status de un flujo",
                "Flujo",
                Auth::user()->id,
                $e->getMessage()
            );
        }

    }

    // el softDelete al flujo
    public function softDelete(Request $request)
    {
        try {
            $request->validate(['flowId' => 'required']);
            $flowId = decrypt($request->flowId);
            Flow::where('flowId',$flowId)
                 ->update(['isDeleted' => true]);

            app(LogController::class)->store(
                "Succes",
                "El usuario #".Auth::user()->id." , elimino el flujo #".$flowId,
                "Flujo",
                Auth::user()->id,
                "Eliminacion de un flujo con softdelete"
            );
            return Redirect::route('flows.index')->with('flow-status' , 'succes');
        } catch (Exception $e) {
            app(LogController::class)->store(
                "Error",
                "El usuario #".Auth::user()->id." , erro al eliminar el flujo #".$flowId,
                "Flujo",
                Auth::user()->id,
                $e
            );
        }
    }

    public function getFlows($id)
    {
        $flows = Flow::where('businessId', $id)
                   ->where('isActive' , true)->get();

        return $flows;

    }

    private function getAlias($objective,$aliases)
    {
        

        if(!array_key_exists($objective,$aliases))
        {
            throw new objectiveNotFoundException('objetivo no encontrado');
        }
        return $aliases[$objective];

    }

    private function generateHasedId($id)
    {
        $flow = Flow::find($id);
        $flow->hashedId = encrypt($id,env('ENCRYPT_KEY'), ['length' => 10]);
        $flow->save();
    }
}
