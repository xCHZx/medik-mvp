<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{

    public function index(){
        $appointments = Appointment::where('userId', Auth::user()->id)->get();
        $id=0;

        return view('dashboard.appointments.index', compact('appointments','id'));
    }

    public function store(Request $request){

        $appointment = Appointment::find($request->id);

        if($appointment){
           try {
              $appointment->date = $request->date;
              $appointment->time = $request->time;
              $appointment->patient = $request->patient;
              $appointment->duration = 60;
              $appointment->description = $request->description;
              $appointment->status = 'Agendada';
              $appointment->save();

              app(LogController::class)->store(
                  "Succes",
                  "El usuario #".Auth::user()->id." modifico la cita #".$appointment->id,
                  "Appointment",
                  Auth::user()->id,
                  $appointment
              );
           } catch (Excpetion $e)
           {
               app(LogController::class)->store(
                   "Error",
                   "El usuario #".Auth::user()->id." erro al modificar la cita".$appointment->id,
                   "Appointment",
                   Auth::user()->id,
                   $e
               );
           }
        }else
        {
            try {
                $appointment = new Appointment();
                $appointment->date = $request->date;
                $appointment->time = $request->time;
                $appointment->patient = $request->patient;
                $appointment->duration = 60;
                $appointment->description = $request->description;
                $appointment->status = 'Agendada';
                $appointment->userId = Auth::user()->id;
                $appointment->save();

                app(LogController::class)->store(
                    "Succes",
                    "El usuario #".Auth::user()->id." registro la cita #".$appointment->id,
                    "Appointment",
                    Auth::user()->id,
                    $appointment
                );
            } catch (Exception $e) {
                app(LogController::class)->store(
                    "Error",
                    "El usuario #".Auth::user()->id." erro al registrar una cita",
                    "Appointment",
                    Auth::user()->id,
                    $e
                );
            }
            
        }
        return redirect()->route('appointments.index');
    }

    // public function update(Request $request, $id){
    //     $appointment = Appointment::find($id);
    //     $appointment->date = $request->date;
    //     $appointment->time = $request->time;
    //     $appointment->patient = $request->patient;
    //     $appointment->duration = 60;
    //     $appointment->description = $request->description;
    //     $appointment->status = 'scheduled';
    //     $appointment->userId = Auth::user()->id;
    //     $appointment->save();

    //     return redirect()->route('appointments.index');

    // }

    public function externalCreate($id){
        $doctor = User::with('appointments')->find($id);
        $appointments = $doctor->appointments;
        if(!$appointments){
            $appointments = [];
        }
        return view('appointment.create', compact('doctor','appointments'));
    }

    public function externalStore(Request $request)
    {
        try {
            $appointment = new Appointment();
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->patient = $request->patient;
            $appointment->duration = 60;
            $appointment->description = $request->description;
            $appointment->status = 'En revisión';
            $appointment->userId = $request->hidden;
            $appointment->save();

            app(LogController::class)->store(
                "Succes",
                "Se registro la cita #".$appointment->id." para el usuario #".Auth::user()->id,
                "Appointment",
                Auth::user()->id,
                $appointment
            );

            return redirect()->route('appointments.success', ['id' => $appointment->id]);
        } catch (Exception $e) {
            app(LogController::class)->store(
                "Error",
                "Error al registrar una cita para el usuario #".Auth::user()->id,
                "Appointment",
                Auth::user()->id,
                $e
            );
        }
        
    }

    public function success($id){
        $appointment = Appointment::with('user')->find($id);
        return view('appointment.success', compact('appointment'));
    }
}
