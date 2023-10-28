<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhooksController extends Controller
{
    public function __invoke(Request $request){

        $stripe = new \Stripe\StripeClient(config(key: 'stripe.sk'));
        $endpoint_secret = 'whsec_0580ae1f4114a7fa3c8eb6ab097841daad23e9e937004276692495d81f53e374';

        Log::info($request);


    }
}
