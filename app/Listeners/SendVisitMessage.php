<?php

namespace App\Listeners;

use App\Events\RegisteredVisit;
use App\Http\Controllers\AccountStatusController;
use App\Http\Controllers\UserController;
use App\Jobs\WhatsappSender;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class SendVisitMessage
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RegisteredVisit $event): void
    {
        $user = null;
        try {
            $business = $event->visit->business;
            $user = $business->user;
            if ($user->accountStatus->name == 'Activa') {
                $this->checkMessagesLimit($business, $user); // checa el numero de mensajes que ha enviado el usuario y lo compara con su limita para tirar un error si lo alcanzo
                $flow = $business->flows->where('isActive', 1)->first();
                if ($flow) {
                    WhatsappSender::dispatch($event->visit, $flow)->delay($event->visit->visitDate->addMinutes(env('DELAYMINUTES')));
                }
            }
        } catch (\Throwable $th) {

            if ($th->getMessage() === 'Messages Limit Exceded') {
                $user->sendLimitExcededNotification();
                // aqui voy a cambiar el status a restringida 
                // obtener el id de un status
                $statusId = app(AccountStatusController::class)->getStatusId('Restringida');
                // dado ese id cambiar el status de la cuenta
                app(UserController::class)->changeAccountStatus($statusId , $user);
                
            }
        }
    }

    private function getReviewsSend($business, $lastPaymentDate)
    {
        $reviews = $business->reviews()
            ->where(function ($query) {
                $query->where('status', 'Enviada')
                    ->orWhere('status', 'Entregada')
                    ->orWhere('status', 'Finalizada');
            })
            ->whereDate('reviews.created_at', '>=', $lastPaymentDate)
            ->count();

        return $reviews;
    }

    private function checkMessagesLimit($business, $user)
    {
        $reviewsSend = $this->getReviewsSend($business, $user->lastPaymentDate);
        $reviewsLimit = $user->limitMessages;
        if ($reviewsSend >= $reviewsLimit) {
            throw new Exception('Messages Limit Exceded');
        }
    }
}
