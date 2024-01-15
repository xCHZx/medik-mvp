<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
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
