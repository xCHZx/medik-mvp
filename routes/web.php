<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FlowsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VisitorController;
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

Route::middleware('auth')->group(function () {
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
        // Route::post('/qr', [BusinessController::class, 'downloadQr'])->name('business.qr');

        //flujos
        Route::get('/flujos',[FlowsController::class, 'index'])->name('flows.index');
        Route::post('/flujos/crear', [FlowsController::class , 'store'])->name('flows.store');
        Route::post('/flujos/changeStatus' , [FlowsController::class , 'changeStatus'])->name('flows.changeStatus');

        Route::get('/reportes', [ReportController::class, 'index'])->name('reports.index');
    });
});

Route::prefix('visita')->group(function () {
    Route::get('/{id}', [VisitorController::class, 'visit'])->name('visitor.visit');
    Route::post('/{id}', [VisitorController::class, 'store'])->name('visitor.store');
    Route::get('/{id}/gracias', [VisitorController::class, 'success'])->name('visitor.success');
    Route::get('/{id}/denegado', [VisitorController::class, 'denied'])->name('visitor.denied');
});

require __DIR__.'/auth.php';
