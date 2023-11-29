<?php

namespace App\Listeners;

use App\Events\RegisteredVisit;
use App\Jobs\WhatsappSender;
use Carbon\Carbon;
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
        $business = $event->visit->business;
        $flow = $business->flows->where('isActive' , 1)->first();
        // $flow = DB::table('flows')
        //     ->where('businessId', '=', $businessId)
        //     ->where('isActive', '=', true)
        //     ->get();

        if ($flow) {
            WhatsappSender::dispatch($event->visit, $flow)->delay($event->visit->visitDate->addMinutes(env('DELAYMINUTES')));

        }

    }
}