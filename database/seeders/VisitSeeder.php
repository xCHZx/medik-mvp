<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('visits')->insert([
            'businessId' => 1,
            'visitorId' => 1,
            'isMessageSent' => 0
        ]);

        DB::table('visits')->insert([
            'businessId' => 1,
            'visitorId' => 1,
            'isMessageSent' => 0
        ]);
    }
}
