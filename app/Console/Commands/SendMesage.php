<?php

namespace App\Console\Commands;

use App\Jobs\WhatsappSender;
use App\Models\Flow;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SendMesage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia los mensajes de reputacion de  Whatsapp';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      // obtener la visita que no haya recibido un mensaje y se paso su tiempo de espera
        $visits = DB::table('visit')
                    ->where('isMessageSent', '=' , 0)
                    ->where('scheduledFirstMessage', '>', Carbon::now())
                    ->get();

        foreach($visits as $visit)
        {
            WhatsappSender::dispatch($visit);
        
        }
               
    }
}
