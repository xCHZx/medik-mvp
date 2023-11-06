<?php

namespace Database\Seeders;

use App\Http\Controllers\VisitController;
use App\Models\Review;
use App\Models\Visit;
use App\Models\Visitor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    use WithFaker;

    public function run(): void
    {
        // DB::table('visits')->insert([
        //     'businessId' => 1,
        //     'visitorId' => 1,
        //     'isMessageSent' => 0
        // ]);

        // DB::table('visits')->insert([
        //     'businessId' => 1,
        //     'visitorId' => 1,
        //     'isMessageSent' => 0
        // ]);

        $visits = Visit::factory(20)->create();
        $visitors = Visitor::factory(10)->create();

        foreach ($visits as $visit){
            app(VisitController::class)->generateHashedId($visit->id);
            $visit->visitorId = rand(1, 10);
            $visit->save();
            $review = Review::factory()->create([
                'visitId' => $visit->id
            ]);
        }
    }
}
