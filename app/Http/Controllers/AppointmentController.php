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
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->patient = $request->patient;
            $appointment->duration = 60;
            $appointment->description = $request->description;
            $appointment->status = 'Agendada';
            $appointment->save();
        }else{
            $appointment = new Appointment();
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->patient = $request->patient;
            $appointment->duration = 60;
            $appointment->description = $request->description;
            $appointment->status = 'Agendada';
            $appointment->userId = Auth::user()->id;
            $appointment->save();
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

    public function externalStore(Request $request){
        $appointment = new Appointment();
        $appointment->date = $request->date;
        $appointment->time = $request->time;
        $appointment->patient = $request->patient;
        $appointment->duration = 60;
        $appointment->description = $request->description;
        $appointment->status = 'En revisión';
        $appointment->userId = $request->hidden;
        $appointment->save();

        return redirect()->route('appointments.success', ['id' => $appointment->id]);
    }

    public function success($id){
        $appointment = Appointment::with('user')->find($id);
        return view('appointment.success', compact('appointment'));
    }
}