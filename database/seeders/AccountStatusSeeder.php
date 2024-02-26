<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('account_statuses')->insert([
            ['name' => 'Activa' , 'description' => 'usuario al dia con sus pagos'],
            ['name' => 'Restringida', 'description' => 'usuario alcanzo el limite de mensajes'], 
            ['name' => 'Pausada' , 'description' => 'hubo un problema con el pago del usuario y no se pudo completar'],  
            ['name' => 'Cancelada' , 'description' => 'su cuenta duro inactiva o sin realizar pagos demasiado tiempo'],
            ['name' => 'Inconclusa' , 'description' => 'el usuario esta registrado pero no tiene suscripcion']
        ]);
    }
}
