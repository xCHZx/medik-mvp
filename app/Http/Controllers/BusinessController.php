<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


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
            $this->createImage($business->id);
            //$this->generateImage($business->id);

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

    private function generateImage($businessId)
    {
        $ruta = 'C:\xampp\htdocs\medik-mvp\images/';
        $image = 'C:\xampp\htdocs\medik-mvp\images/template.jpg';
        $business = Business::find($businessId);
        $imgName = 'imagen' . strval($businessId) . '.png';

        // crear imagen y obtener su tamaño
        $img = imagecreatefromjpeg($image);
        $imgSize = getimagesize($image);
        // definir el color y la fuente de texto
        $color = imagecolorallocate($img,255,255,255);
        $font = 'C:\Users\carlo\AppData\Local\Microsoft\Windows\Fonts\ASMAN.TTF';
        $gris = imagecolorallocate($img, 128, 128, 128);

        // texto a superponer
        $text = $business->name;

        // ubicacion del texto
        $x = $imgSize[0] / 2;
        $positionX = intval($x);
        $y = $imgSize[1] / 2;
        $positionY = intval($y);

        // tamaño del texto
        $textSize = 20.0;

        // sombra con direccion
        imagettftext($img, 20, 0, 11, 21, $gris, $font, $business->address);

        // texto con el nombre
        imagettftext($img,$textSize,0,$positionX,$positionY,$color,$font,$text);

        // guardar la imagen
        imagejpeg($img,$ruta . $imgName);

        //limpiar memoria
        imagedestroy($img);

        //guardar en negocio
        $business->imageUrl = $ruta . $imgName;
        $business->save();



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
            $this->createImage($business->id);
            return redirect()->route('business.index')->with("action", "ok");
        }catch(Exception $e){
            // abort(403);
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Business $business)
    {
        //
    }

    public function createImage($id){

        $business = Business::find($id);
        $title = $business->name;

        $templatePath = resource_path('images/placeholder-medik.png');
        $watermarkPath = resource_path('images/logo-medik-white.png');

        $img = Image::make($templatePath);
        $watermark = Image::make($watermarkPath);

        $watermark->resize(179, 67);
        $img->text($title, 30, 70, function($font){
            $font->file(resource_path('fonts/nunito-semibold.ttf'));
            $font->size(50);
            $font->color('#ffffff');
        });
        $img->insert($watermark, 'bottom-right', 30, 20);
        Storage::disk('public')->put('businesses/images/placeholders/'.$id.'.png', $img->encode('png'));
        $img->destroy();

        // return response($img->encode('png'), 200, [
        //     'Content-Type' => 'image/png',
        // ]);

    }
}
