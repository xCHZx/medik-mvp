<?php

namespace App\Jobs;

use App\Http\Controllers\ReviewController;
use App\Models\Review;
use App\Models\Visit;
use Error;
use Exception;
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
    public $tries = 1;

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
        $visit = $this->visit;

        // preparar mensaje
        //header
        $token = env('WP_TOKEN');
        $version = 'v18.0';
        $whatsappBusinessId = env('WP_ID'); // este es el del negocio de facebook
        $visitorNumber = $visitor->phone;
        $hashedId = $this->visit->hashedId;

        $name = $visitor->firstName;
        $imageUrl = Storage::url('businesses/images/placeholders/' . $this->visit->businessId . '.png');


        try {
            $response = Http::withToken($token)->post('https://graph.facebook.com/' . $version . '/' . $whatsappBusinessId . '/messages', [
                'messaging_product' => 'whatsapp',
                'to' => '528715757804',
                'type' => 'template',
                'template' => [
                    'name' => 'encuesta_test',
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
                                        'link' => 'https://app.medik.mx' . $imageUrl
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

                                ],
                                [
                                    'type' => 'text',
                                    'text' => $this->visit->business->name
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
            $this->changeReviewStatus($this->visit->id, $this->flow->id,$response);
            //app(ReviewController::class)->reviewSended($this->visit->id , $this->flow->id);
            





        } catch (Error $e) {
            echo $e;
        }

    }

    public function changeReviewStatus($visitId, $flowId ,$response)
    {
        $res = json_decode($response, true);
        $message = $res['messages'][0];
        $whatsappId = $message['id'];

        Review::where('visitId', $visitId)->update([
            'status' => 'aceptado',
            'flowId' => $flowId,
            'whatsappId' => $whatsappId
        ]);

    }


}
