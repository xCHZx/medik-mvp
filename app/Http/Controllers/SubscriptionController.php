<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index(){
        $user = Auth::user();
        $status = $user->subscribed('default');
        return view('dashboard.subscription.index', compact('user','status'));
    }

    public function hola(){
        return "hola";
    }

    public function paymentMethod(){
        // return view('dashboard.subscription.paymentMethod', [
        //     'intent' => auth()->user()->createSetupIntent(),
        // ]);
    }

    public function checkout(){ //Cuando haya oportunidad utilizar facade de Cashier
        $user = Auth::user();
        \Stripe\Stripe::setApiKey(config(key: 'stripe.sk'));

        $session = \Stripe\Checkout\Session::create([
            // 'customer_id' => $user->id,

            // 'customer'  => [
            //     ['email' => 'hola@jiji.com']
            // ],
            'customer' => auth()->user()->stripe_id,
            // 'submit_type' => 'donate',
            // 'billing_address_collection' => 'required',
            // 'shipping_address_collection' => [
            //   'allowed_countries' => ['US', 'CA'],
            // ],
            'line_items' => [[
                'price' => 'price_1NrXsAJrAkaG1EW4Ju2Yu28i',
                'quantity' => 1,
                ]],
                'mode' => 'subscription',
                // 'success_url' => route('subscription.success', []),
                'success_url' => route('dashboard.index'),
                'cancel_url' => 'https://bing.com'
        ]);

        // $this->transaction($session);
        return redirect()->away($session->url);
    }

    public function success(Request $request){
        $sessionId = $request->query('session');
        return $sessionId;
    }
}
