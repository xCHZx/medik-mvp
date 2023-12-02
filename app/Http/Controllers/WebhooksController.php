<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhooksController extends Controller
{
    public function __invoke(Request $request)
    {

    }

    public function verifyWhatsappWebhook(Request $request)
    {
        try {
            $token = "calamardotentaculos";
            $query = $request->query();

            $mode = $query['hub_mode'];
            $challenge = $query['hub_challenge'];
            $verifyToken = $query['hub_verify_token'];

            if ($mode && $verifyToken) {
                if ($mode == 'subscribe' && $token == $verifyToken) {
                    return response($challenge, 200)->header('content-type', 'text/plain');
                }

                throw new Exception('invalid request');

            }

        } catch (Exception $e) {
            return response()->json([
                'succes' => 'false',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function processRequest(Request $request)
    {
        try {
            $req = $request->all();
            $entry = $req['entry'];
            $changes = $entry[0]['changes'][0];
            $statuses = $changes['value']['statuses'][0];
            

            if ($statuses) {
                $whatsappId = $statuses['id'];
                $status = $statuses['status'];
                app(ReviewController::class)->changeStatus($whatsappId , $status);
                return response('todo fine' , 200);

            }

            throw new Exception('invalid request');
        } catch (Exception $e) {
            return response()->json([
                'succes' => 'false',
                'error' => $e->getMessage()
            ],500);
        }
    }
}