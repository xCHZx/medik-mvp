<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendMesage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mesage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia los mensajes de Whatsapp';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // header
        $token = "EAASZBihnHCu8BO0ubQMuMYjIa5FgwUETK1ieTFYvLdBxh0YtZA4E97ezdvnkgEgJKI3w7JOrRgBpoi3oSC6AKZCSdpExxnVpKiCIWCwZBC0VkYjVZCgJsCQzaXRRVhvXjPPsTHVfH2e95NEi2IH3iguNfV4ZC4wz7vGQDCEwps47FbofjgFXgtlz9POfuRymhSCylvK6HZCKuhdXswFuJ0ZD";
        $version = 'v18.0';
        $businessId = "124810020717259";
        $visitorNumber = '528715757804';

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

        echo $response;
    }
}
