<?php

namespace App\Jobs;

use App\Models\Visit;
use Error;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class WhatsappSender implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $visit;
    public $flow;

    /**
     * Create a new job instance.
     */
    public function __construct($visit , $flow)
    {
        $this->visit = $visit;
        $this->flow =  $flow;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //obtener el visitante

        $visitor = $this->visit->visitor;
        $business = $this->visit->business;
        $flow = $this->flow;

        // preparar mensaje
        // // header
        // guardar el token en el .env
        $token = env('WP_TOKEN');
        $version = 'v18.0';
        $whatsappBusinessId = env('WP_ID'); // este es el del negocio de facebook
        $visitorNumber = $visitor->phone;
        $hashedId = $this->visit->hashedId;

        $name = $visitor->firstName;
        $imageUrl = asset('storage/businesses/images/placeholders/' . $this->visit->businessId . '.png');


        $response = Http::withToken($token)->post('https://graph.facebook.com/'. $version . '/' . $whatsappBusinessId . '/messages', [
            'messaging_product' => 'whatsapp',
            'to' => '528715757804',//$visitorNumber,
            'type' => 'template',
            'template' => [
                'name' => 'satisfaccion_general_prueba', // $flow->objetivo
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
                                    'link' => 'https://picsum.photos/700/400?random' //$imageUrl
                                ]

                            ]

                    ]

                    ],
                    [
                        'type' => 'body',
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => $name

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
                                'text' =>  $hashedId

                            ]

                        ]

                    ]


                ]
            ]

        ]);

        echo $response;

    }
}
