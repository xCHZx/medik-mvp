<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        try{
            $user = Auth::user();
            $business = Business::where('userId', $user->id)->first();
            if ($business) {
                $svg= htmlspecialchars_decode($business->rawQr);
                return view('dashboard.business.index', compact('business','user','svg'));
            }else{
                return view('dashboard.business.index', compact('business','user'));
            }
        }catch(Exception $e){
            abort(403);
        }
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
            $business->address = $request->address;
            $business->userId = Auth::id();
            $business->save();
            $this->generateQr($business->id);

            return back()->with("action", "ok");
        }catch(Exception $e){
            return $e;
        }
    }

    private function generateQr ($businessId){
        try{
            $url = urlencode(env('APP_URL'));
            $svgQr = Http::get("http://api.qrserver.com/v1/create-qr-code/?data=".$url."/visita/".$businessId."&size=400x400&format=svg");
            $rawQr = htmlspecialchars($svgQr);
            $business = Business::find($businessId);
            $business->rawQr = $rawQr;
            $business->save();
        }catch(Exception $e){
            return $e;
        }
    }

    // public function downloadQr (){
    //     $business = Business::where('userId', Auth::id())->first();
    //     $rawQr = $business->rawQr;
    //     $qr = htmlspecialchars_decode($rawQr);
    //     $pdf = App::make('dompdf.wrapper');
    //     $data = [
    //         'qr' => $rawQr
    //     ];
    //     $pdf->loadView('dashboard.business.qr',$data);

    //     return $pdf->download();
    // }

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
    public function edit($id)
    {
        try{
            $user = Auth::user();
            $business = Business::find($id);
            return view('dashboard.business.edit', compact('business'));

        }catch(Exception $e){
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try{
            $business = Business::find($id);
            $business->name = $request->name;
            $business->description = $request->description;
            $business->address = $request->address;
            $business->save();
            return redirect()->route('business.index')->with("action", "ok");
        }catch(Exception $e){
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Business $business)
    {
        //
    }
}
