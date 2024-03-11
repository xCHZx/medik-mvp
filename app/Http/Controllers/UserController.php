<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store($firstName,$lastName,$phone,$email,$password)
    {
        try {
            $user = new User();
            $user->firstName = $firstName;
            $user->lastName = $lastName;
            $user->phone = $phone;
            $user->email = $email;
            $user->password = $password;
            $user->save();

            app(LogController::class)->store(
                "Succes",
                "El usuario #".$user->id." se registro",
                "Registro",
                $user->id,
                $user
            );

            return $user;
    
        } catch (Exception $e)
        {
            app(LogController::class)->store(
                "Error",
                "Fallo de intento de registro de usuario",
                "Registro",
                0,
                $e
            );

            return $e;
        }
    }

    public function update($request)
    {
        try {
            $request->user()->fill($request->all());

            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }

            $request->user()->save();

            app(LogController::class)->store(
                "Succes",
                "El usuario #".Auth::user()->id." modifico los datos de su cuenta",
                "Profile",
                Auth::user()->id,
                Auth::user()
            );

        } catch (Exception $e) {
            app(LogController::class)->store(
                "Error",
                "El usuario #".Auth::user()->id." erro al intentar modificar los datos de su cuenta",
                "Profile",
                Auth::user()->id,
                $e
            );
            return $e;
        }
    }

    public function changePassword($request)
    {
        try {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request['newPassword']);
            $user->save();

            app(LogController::class)->store(
                "Succes",
                "El usuario #".$user->id." modifico su contraseña",
                "Profile",
                $user->id,
                $user
            );
        } catch (Exception $e) {
            // app(LogController::class)->store(
            //     "Error",
            //     "El usuario #".Auth::user()->id." erro al intentar modificar su contraseña",
            //     "Profile",
            //     Auth::user()->id,
            //     $e
            // );
            return $e;
        }
    }
    // eata funcion se utiliza para cambiar el status de la cuenta del usuario
    public function changeAccountStatus($statusId , $user)
    {
        $user->accountStatusId = $statusId;
        $user->save();

    }

    // esta funcion la utiliza el stripewebhookcontroller para obtener el usuario con el que esta relacionado el evento de stripe
    public function getUserByCostumerId($costumer)
    {
        $user = User::where('stripe_id', $costumer)->firstOrFail();
        return $user;

    }

     // esta funcion la usa el stripewebhokcontroller para cambiar la fecha en la que hizo su ultimo pago el usuario
     public function changeLastPaymentDate($user)
     {
         $lastPaymentDate = Carbon::now();
         $user->lastPaymentDate = $lastPaymentDate;
         $user->save();
     }
}
