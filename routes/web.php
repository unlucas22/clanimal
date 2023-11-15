<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DashboardController, PetController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('qr/verification/{hashid}/{date}', [DashboardController::class, 'qrVerification'])->name('qr.verification');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard.index');
    
    Route::prefix('dashboard')->group(function () {

        Route::middleware(['admin'])->group(function () {
            Route::view('/users', 'dashboard')->name('dashboard.users');
            Route::view('/roles', 'dashboard')->name('dashboard.roles');
            Route::view('/clients', 'dashboard')->name('dashboard.clients');
            Route::view('/controls', 'dashboard')->name('dashboard.controls');
            Route::view('/classifications', 'dashboard')->name('dashboard.classifications');
            Route::view('/sedes', 'dashboard')->name('dashboard.sedes');
            Route::view('/turnos', 'dashboard')->name('dashboard.shifts');
            Route::view('/recepcion', 'dashboard')->name('dashboard.receptions');
            Route::view('/servicios', 'dashboard')->name('dashboard.services');
            Route::view('/mascotas', 'dashboard')->name('dashboard.pets');
        });

        Route::view('/create/client', 'dashboard')->name('dashboard.create.client');
        Route::get('/show/client/{hashid}', [DashboardController::class, 'showClient'])->name('dashboard.show.client');
        
        Route::get('/create/pet-images/{hashid}', [PetController::class, 'createPetImages'])->name('dashboard.create.pet-images');
        Route::post('/store/pet-images', [PetController::class, 'storePetImages'])->name('dashboard.update.pet-images');

        Route::get('/create/pet/{hashid?}', function(){
            return view('create.pet');
        })->name('dashboard.create.pet');
        Route::post('/store/pet', [PetController::class, 'storePet'])->name('dashboard.store.pet');

        Route::get('/create/shift/{hashid?}', function() {
            return view('create.turno');  
        })->name('dashboard.create.shift');
        
        Route::post('/store/shift', [PetController::class, 'storeShift'])->name('dashboard.store.shift');

        Route::get('/create/reception/{hashid?}', [PetController::class, 'createReception'])->name('dashboard.create.reception');
        Route::post('/store/reception', [PetController::class, 'storeReception'])->name('dashboard.store.reception');
    });

    Route::view('panel', 'panel')->name('panel.overview');

});

Route::get('control-de-colaboradores', function(){
    return view('control');
})->name('control');

Route::get('perfil-colaborador', function(){
    return view('perfil');
})->name('perfil.colaborador');

// Obtener citas (temporal)
Route::post('get-turnos', [PetController::class, 'getShifts'])->name('api.get.shifts');

Route::get('/', function () {
    return redirect('dashboard');
});
