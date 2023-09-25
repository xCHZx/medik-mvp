<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $user = Auth::user();
        // $business = Business::find(Auth::id());
        $business = Business::find(11);

        $svg= htmlspecialchars_decode($business->rawQr);
        // return $svg;
        return view('dashboard.business.index', compact('business','user','svg'));
        // return $business;
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
    public function store(Request $request)
    {
        try{
            $business = new Business();
            $business->name = $request->name;
            $business->description = $request->description;
            // $business->userId = $request->Auth::id();
            $business->save();
            $this->generateQr($business->id);

        }catch(Exception $e){
            return $e;
        }
    }

    private function generateQr ($businessId){
        $url = urlencode(env('APP_URL'));
        $svgQr = Http::get("http://api.qrserver.com/v1/create-qr-code/?data=".$url."/visita/".$businessId."&size=500x500&format=svg");
        $rawQr = htmlspecialchars($svgQr);

        // htmlspecialchars_decode()

        $business = Business::find($businessId);
        $business->rawQr = $rawQr;
        $business->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Business $business)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Business $business)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Business $business)
    {
        //
    }
}
