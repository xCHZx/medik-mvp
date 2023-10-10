<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Attribute\WithHttpStatus;

class MessagesController extends Controller
{
    public function send()
    {
        // header
        $token = "EAASZBihnHCu8BOwAzAKhs4XylDgf6F5xwH9OcojOrCsx9Ob3mTPzE8EXcGkcDSYnXAxPvu4L4FdNwdU7AwRg3QLbwNlhdqRjeuezAhA7ZBq2qDiHcCiSpOmJ81eMFOMDZBLyY65YjXxlSNFbWOjeBkK4zYZBzAgkbM4Iyx4AMw2QVCu6fn4wlPPZA3cYZBJFiO3AjilpZChRDZAW1EWPtNkZD";
        $version = 'v17.0';
        $businessId = "124810020717259";
        $visitorNumber = '528715757804';

        $response = http::withToken($token)->post('https://graph.facebook.com/'. $version . '/' . $businessId . '/messages', [
            'messaging_product' => 'whatsapp',
            'to' => '528715757804',
            'type' => 'template',
            'template' => [
                'name' => 'alidad_de_la_atencion_medica_particular',
                'language' => [
                    'code' => 'es_Mx'
                ]
            ]

        ]);

        return response()->json($response);

    }
}
