<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;
use Intervention\Image\Drivers\Gd\Driver;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     * Acting as Create while there is only 1 business for the user
     */
    public function index(){
        try{
            $user = Auth::user();
            $business = Business::where('userId', $user->id)->first();
            if ($business) {
                $qrUrl = Storage::url($business->qrImageUrl);
                $svg= htmlspecialchars_decode($business->rawQr);
                return view('dashboard.business.index', compact('business','user','svg','qrUrl'));
            }else{
                return view('dashboard.business.index', compact('business','user'));
            }
        }catch(Exception $e){
            abort(403);
        }
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

            app(LogController::class)->store(
                "success", //tipo
                "El usuario #".Auth::user()->id.", creó el negocio #".$business->id, //contenido
                "Negocio", //categoria
                Auth::user()->id, //userId
                $business //descripcion (Obj o Exception)
                );

            $this->generateHashedId($business->id);
            $this->generateQr($business->hashedId);
            $this->generateImage($business->id);
            //$this->generateImage($business->id);

            return back()->with("action", "ok");
        }catch(Exception $e){
            app(LogController::class)->store(
                "error", //tipo
                "El usuario #".Auth::user()->id.", error en crear el negocio", //contenido
                "Negocio", //categoria
                Auth::user()->id, //userId
                $e //descripcion
                );
            return $e; //Falta regresar la vista con status error para disparar el SWAL
        }
    }

    /**
     * Generate QR via Api for the Visit functionality
     */
    public function generateQr ($businessId){
        try{
            // $url = urlencode(env('APP_URL'));
            // $svgQr = Http::get("http://api.qrserver.com/v1/create-qr-code/?data=".$url."/visita/".$businessId."&size=400x400&format=svg");
            // $rawQr = htmlspecialchars($svgQr);
            // $business = Business::find(decrypt($businessId));
            // $business->rawQr = $rawQr;
            // $business->save();

            $business = Business::find(decrypt($businessId));
            $url = urldecode(env('APP_URL'));
            $savePath = "businesses/images/qr";
            $pngQr = Http::get("http://api.qrserver.com/v1/create-qr-code/?data=".$url."/visita/".$businessId."&size=400x400");
            Storage::disk('public')->makeDirectory($savePath);
            Storage::disk('public')->put($savePath. '/'.$business->id .'.png', $pngQr);
            $business->qrImageUrl = $savePath. '/'.$business->id.'.png';
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
            $this->deleteImage($business->id);
            $this->generateImage($business->id);

            app(LogController::class)->store(
                "success", //tipo
                "El usuario #".Auth::user()->id.", editó el negocio #".$business->id, //contenido
                "Negocio", //categoria
                Auth::user()->id, //userId
                $business //descripcion (Obj o Exception)
                );

            return redirect()->route('business.index')->with("action", "ok");
        }catch(Exception $e){
            app(LogController::class)->store(
                "error", //tipo
                "El usuario #".Auth::user()->id.", error en editar el negocio", //contenido
                "Negocio", //categoria
                Auth::user()->id, //userId
                $e //descripcion
                );
            return($e); //Falta enviarlo al front con SWAL
        }
    }

    /**
     * Create placeholder image for whatsapp and other uses via InterventionImage facade
     */
    public function generateImage($id){

        $manager = new ImageManager(Driver::class);

        $business = Business::find($id);
        $title = $business->name;



        $templatePath = resource_path('images/placeholder-medik-flat.png');
        $watermarkPath = resource_path('images/logo-medik-white.png');

        // $img = Image::make($templatePath);
        $img = $manager->read($templatePath);
        // $watermark = Image::make($watermarkPath);
        $watermark = $manager->read($watermarkPath);

        $watermark->resize(179, 67);
        $img->text($title, 30, 70, function(FontFactory $font){
            $font->file(resource_path('fonts/nunito-semibold.ttf'));
            $font->size(35);
            $font->color('#ffffff');
            $font->valign('top');
            $font->lineHeight(1.6);
            $font->wrap(550);
        });
        // $img->insert($watermark, 'bottom-right', 30, 20);
        $img->place($watermark, 'bottom-right', 30, 20);
        // Storage::disk('public')->put('businesses/images/placeholders/'.$id.'.png', $img->encode('png'));
        Storage::disk('public')->put('businesses/images/placeholders/'.$id.'.png', $img->toPng());
        // $img->destroy();

        // return response($img->encode('png'), 200, [
        //     'Content-Type' => 'image/png',
        // ]);

    }

    /**
     * Calculate the Rating counting all the reviews and dividing by the total
     * --->NEEDS IMPROVEMENT, NEED A CRON JOB<---
     */
    /* aqui no se esta tomando en cuenta que los reviews tienen diferentes estados
    solo los que tienen status completada deberian considerarse */

    public function calculateRating($businessId){
        $business = Business::find($businessId);
        $reviews = $business->reviews()->where('status','Finalizada')->get();
        $total = 0.0;
        foreach ($reviews as $review) {
            $total += $review->rating;
        }
        $business->averageRating = $total/count($reviews);
        $business->save();
    }

    private function generateHashedId($bussinesId)
    {
        $bussines = Business::find($bussinesId);
        $bussines->hashedId = encrypt($bussinesId,env('ENCRYPT_KEY'), ['length' => 10]);
        $bussines->save();
    }


    private function deleteImage($id)
    {
        // eliminar la imagen para que se pueda crear de nuevo en el mismo espacio
        $imagePath = Storage::url('businesses/images/placeholders/'.$id.'.png');
        Storage::disk('public')->delete($imagePath);
    }

    
}


