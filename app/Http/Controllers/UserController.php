<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

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
            app(LogController::class)->stor(
                "Error",
                "Fallo de intento de registro de usuario",
                "Registro",
                0,
                $e
            );

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
