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
use Illuminate\Support\Facades\Storage;

class WhatsappSender implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $visit;
    public $flow;

    /**
     * Create a new job instance.
     */
    public function __construct($visit, $flow)
    {
        $this->visit = $visit;
        $this->flow = $flow;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //obtener el visitante

        $visitor = $this->visit->visitor;
        $flow = $this->flow;

        // preparar mensaje
        //header
        $token = env('WP_TOKEN');
        $version = 'v18.0';
        $whatsappBusinessId = env('WP_ID'); // este es el del negocio de facebook
        $visitorNumber = $visitor->phone;
        $hashedId = $this->visit->hashedId;

        $name = $visitor->firstName;
        $imageUrl = Storage::url('businesses/images/placeholders/'.$this->visit->businessId.'.png');


        try {
            $response = Http::withToken($token)->post('https://graph.facebook.com/' . $version . '/' . $whatsappBusinessId . '/messages', [
                'messaging_product' => 'whatsapp',
                'to' => $visitorNumber,
                'type' => 'template',
                'template' => [
                    'name' => 'satisfaccion_general',
                    // $flow->objetivo
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
                                        'link' => 'https://app.medik.mx'. $imageUrl 
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
                            'index' => '0',
                            'sub_type' => 'url',
                            'parameters' => [
                                [
                                    'type' => 'text',
                                    'text' => $hashedId

                                ]

                            ]

                        ]


                    ]
                ]

            ]);
        echo $response;
        $this->modifyReview($this->visit , $flow);

        } catch (Error $e) {
            echo $e;
        }

    }

    // editar la review para que tenga el flujo al que esta opinando y el status de enviada

    public function modifyReview($visit , $flow)
    {
        // buscar la review asociada a esa visita
        $review = Review::where('visitId' , $Visit->id)->firstOrFail();
        $review->flowId = $flow->id;
        $review->status = 'enviada';
        $review->save();

    }
}