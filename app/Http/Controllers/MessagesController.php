<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class MessagesController extends Controller
{
    public function __invoke()
    {
        echo "hola mundillo";
    }

    public function create()
    {
        // header
        $token = 'EAAKJjnghhhUBOZBp50ZCxZB57ptAbANu5q4EwkPFOVhBZCQdcQynjoJTlxEucuuAOoJAIoJvjwJ4lZAXQZChsmFWPlM0Ki8CnrKJHv1VqAM1ZCaWmfFpqFhruyQdZA5n3rbc5n2aRmRT2kUJFdykO4C5RXsUchjO2OwRgkM56csnJzESjAiMvBV8v6zGWfdVhQa4P5mZALixZBRZAufrSwV';
        $baseUrl = 'https://graph.facebook.com/v18.0';
        $wabaId = '151669821369238';

        // peticion

        $response = http::withToken($token)->post($baseUrl . '/' . $wabaId . '/' . 'flows' , [
            'name' => 'satisfaccion general',
            'categories' => ['SURVEY']
        ]);
        echo $response;
    }


    public function send()
    {
        // header
        $token = "EAASZBihnHCu8BO0ubQMuMYjIa5FgwUETK1ieTFYvLdBxh0YtZA4E97ezdvnkgEgJKI3w7JOrRgBpoi3oSC6AKZCSdpExxnVpKiCIWCwZBC0VkYjVZCgJsCQzaXRRVhvXjPPsTHVfH2e95NEi2IH3iguNfV4ZC4wz7vGQDCEwps47FbofjgFXgtlz9POfuRymhSCylvK6HZCKuhdXswFuJ0ZD";
        $version = 'v18.0';
        $businessId = "124810020717259";
        $visitorNumber = '51923873767';

        $response = http::withToken($token)->post('https://graph.facebook.com/'. $version . '/' . $businessId . '/messages', [
            'messaging_product' => 'whatsapp',
            'to' => $visitorNumber,
            'type' => 'template',
            'template' => [
                'name' => 'calidad_de_la_atencion_medica_clinica',
                'language' => [
                    'code' => 'es_MX'
                ],
                'components' => [
                    [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => 'image',
                                'image' => [
                                    'link' => 'https://picsum.photos/700/400?random'
                                ]

                            ]
                       
                    ]

                    ],
                    [
                        'type' => 'body',
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => 'carlos'

                            ]
                        
                    ]
                        ],
                    [
                        'type' => 'button',
                        'index' => '1',
                        'sub_type' => 'url',
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => 'https://retador360.com'
                                
                            ]
                            
                        ]

                    ]
                    
                   
                ]
            ]

        ]);

        return response($response);

    }
}
