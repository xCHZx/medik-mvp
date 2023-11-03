<?php

namespace App\Http\Controllers;

use App\Events\RegisteredVisit;
use App\Jobs\WhatsappSender;
use App\Models\Flow;
use App\Models\Visit;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($businessId, $visitorId)
    {
        $visit = new Visit();
        $visit->businessId = $businessId;
        $visit->visitorId = $visitorId;
        $visit->visitDate = Carbon::now();
        $visit->save();

        $this->generateHashedId($visit->id);

        event(new RegisteredVisit($visit));
    }

    private function generateHashedId($visitId){
        $visit = Visit::find($visitId);
        $visit->hashedId = encrypt($visit->id, env('ENCRYPT_KEY'), ['length' => 10]);
        $visit->save();
    }


    /**
     * Display the specified resource.
     */
    public function show(Visit $visit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visit $visit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visit $visit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit)
    {
        //
    }
}
