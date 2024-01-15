<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;


class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        try {
            
            $req = $request->all();
            if(!isset($req['type'] , $req['data']))
            {
                throw new Exception('error en data o type');
            }
            $type = $req['type'];
            $data = $req['data'];
            $costumer = $this->getCostumer($data);
            
            switch ($type) {
                case 'invoice.payment_succeeded':
                    // Handle the call to a method for updating last payment date
                    $this->handlePaymentSucceeded($costumer);
                    return response('good', 200);
                case 'invoice.payment_failed':
                    // Handle the call to a method for updating user ´s account status
                    $this->handlePaymentFailed($costumer);
                    return response('good', 200);
                // case 'customer.subscription.updated':
                // // Handle "customer.subscription.updated" event
                // // ...
                default:
                    // Handle unexpected event types
                    return response('Unknown event type', 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'succes' => 'false',
                'error' => $e->getMessage()
            ],500);
        }

    }

    private function getCostumer($data)
    {
        if(isset($data['object']))
        {
            $object = $data['object'];
            if(isset($object['customer']))
            {
                $customer = $object['customer'];
                return $customer;
            }

            throw new Exception('no hay costumer');

        }
        else
        {
            throw new Exception('no hay object');
        }
    }

    private function handlePaymentSucceeded($costumer)
    {
        $user = app(UserController::class)->getUserByCostumerId($costumer);
        $statusId = app(AccountStatusController::class)->getStatusId('Activa');
        app(UserController::class)->changeAccountStatus($statusId , $user);
        app(UserController::class)->changeLastPaymentDate($user);

    }

    private function handlePaymentFailed($costumer)
    {
        
        $user = app(UserController::class)->getUserByCostumerId($costumer);
        $statusId = app(AccountStatusController::class)->getStatusId('Pausada');
        app(UserController::class)->changeAccountStatus($statusId , $user);
    }
}