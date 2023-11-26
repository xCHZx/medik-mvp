<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FlowsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\VisitController;
use App\Mail\confircorreoMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth' , 'verified')->group(function () {
    Route::prefix('panel')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

        // ver y modificar los datos de su cuenta
        Route::get('/perfil', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/perfil', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/perfil/cambiarContrasena', [ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::post('/contrasena' , [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

        Route::get('/negocio', [BusinessController::class, 'index'])->name('business.index');
        Route::post('/negocio', [BusinessController::class, 'store'])->name('business.store');
        Route::get('/negocio/{id}/editar', [BusinessController::class, 'edit'])->name('business.edit');
        Route::post('/negocio/{id}/editar', [BusinessController::class, 'update'])->name('business.update');
        // Route::get('/negocio/{id}/image', [BusinessController::class, 'createImage'])->name('business.image');

        // Route::post('/qr', [BusinessController::class, 'downloadQr'])->name('business.qr');

        //flujos
        Route::get('/flujos',[FlowsController::class, 'index'])->name('flows.index');
        Route::get('flujos/crear', [FlowsController::class , 'create'])->name('flows.create');
        Route::post('/flujos/crear', [FlowsController::class , 'store'])->name('flows.store');
        Route::get('/flujos/editar' , [FlowsController::class , 'edit'])->name('flows.edit');
        Route::post('/flujos/editar' , [FlowsController::class , 'update'])->name('flows.update');
        Route::post('/flujos/changeStatus' , [FlowsController::class , 'changeStatus'])->name('flows.changeStatus');
        Route::post('/flujos/eliminar', [FlowsController::class , 'delete'])->name('flows.delete');

        Route::get('/suscripcion', [SubscriptionController::class, 'index'])->name('subscription.index');
        Route::get('/suscripcion/metodo-de-pago', [SubscriptionController::class, 'paymentMethod'])->name('subscription.paymentMethod');
        Route::post('/suscripcion/checkout', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');



        Route::get('/reportes', [ReportController::class, 'index'])->name('reports.index');
    });
});

//Visitas
Route::prefix('visita')->group(function () {
    Route::get('/{businessId}', [VisitController::class, 'create'])->name('visit.create');
    Route::post('/{businessId}', [VisitController::class, 'store'])->name('visit.store');
    Route::get('/{businessId}/gracias', [VisitController::class, 'success'])->name('visit.success');
    Route::get('/{businessId}/denegado', [VisitController::class, 'denied'])->name('visit.denied');
});

//Opiniones
Route::prefix('opinion')->group(function () {
    Route::get('/{visitEncrypted}', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/{visitEncrypted}', [ReviewController::class, 'update'])->name('review.update');
    Route::get('/gracias/g/{visitEncrypted}', [ReviewController::class, 'thankYouGood'])->name('review.thankYouGood');
    Route::get('/gracias/b/{visitEncrypted}', [ReviewController::class, 'thankYouBad'])->name('review.thankYouBad');
});

Route::get('/confirmar', function(){
    Mail::to('rpayns16@gmail.com')->send(new confircorreoMailable);
});
require __DIR__.'/auth.php';
