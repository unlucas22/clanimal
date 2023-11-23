<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DashboardController, PetController, ProductController};

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard.index');
    
    Route::prefix('dashboard')->group(function () {

        /* Modulos para admin */
        Route::middleware(['admin'])->group(function () {
            Route::view('/users', 'dashboard')->name('dashboard.users');
            Route::view('/roles', 'dashboard')->name('dashboard.roles');
            Route::view('/clients', 'dashboard')->name('dashboard.clients');
            Route::view('/controls', 'dashboard')->name('dashboard.controls');
            Route::view('/classifications', 'dashboard')->name('dashboard.classifications');
            Route::view('/sedes', 'dashboard')->name('dashboard.sedes');
            Route::view('/turnos', 'dashboard')->name('dashboard.shifts');

            /* Turnos */
            Route::view('/turnos', 'dashboard')->name('dashboard.shifts');
            Route::view('/atencion-veterinaria', 'dashboard')->name('dashboard.atencion-veterinaria');
            Route::view('/peluqueria-canina', 'dashboard')->name('dashboard.peluqueria-canina');

            Route::view('/recepcion', 'dashboard')->name('dashboard.receptions');
            Route::view('/servicios', 'dashboard')->name('dashboard.services');
            Route::view('/mascotas', 'dashboard')->name('dashboard.pets');
            Route::view('/productos', 'dashboard')->name('dashboard.products');

            Route::view('/sales', 'dashboard')->name('dashboard.sales');
        });

        /* Producto */
        Route::get('/create/product', function(){
            return view('create.product');
        })->name('dashboard.create.product');

        Route::post('/store/product', [ProductController::class, 'store'])->name('dashboard.store.product');

        /* Configuracion de producto */
        Route::view('product/categories', 'create.product.category')->name('product.categories');
        Route::view('product/brands', 'create.product.brand')->name('product.brands');
        Route::view('product/presentations', 'create.product.presentation')->name('product.presentations');

        /* Cliente Y Mascotas */
        Route::view('/create/client', 'dashboard')->name('dashboard.create.client');
        Route::get('/show/client/{hashid}', [DashboardController::class, 'showClient'])->name('dashboard.show.client');
        
        Route::get('/create/pet-images/{hashid}', [PetController::class, 'createPetImages'])->name('dashboard.create.pet-images');
        Route::post('/store/pet-images', [PetController::class, 'storePetImages'])->name('dashboard.update.pet-images');

        Route::get('/create/pet/{hashid?}', function(){
            return view('create.pet');
        })->name('dashboard.create.pet');

        Route::get('/show/pet/{hashid}', function(){
            return view('show.pet');
        })->name('dashboard.show.pet');

        /* Turno y Recepción */

        Route::get('/create/shift/{hashid?}', function() {
            return view('create.turno');  
        })->name('dashboard.create.shift');
        
        Route::post('/store/shift', [PetController::class, 'storeShift'])->name('dashboard.store.shift');

        Route::get('/create/reception/{hashid?}', [PetController::class, 'createReception'])->name('dashboard.create.reception');
        Route::post('/store/reception', [PetController::class, 'storeReception'])->name('dashboard.store.reception');

        /* Venta */
        Route::get('venta/atencion-veterinaria/{hashid}', function() {
            return view('create.venta.atencion-veterinaria');  
        })->name('dashboard.venta.atencion-veterinaria');

        Route::get('venta/peluqueria-canina/{hashid}', function() {
            return view('create.venta.peluqueria-canina');  
        })->name('dashboard.venta.peluqueria-canina');

    });

    Route::view('panel', 'panel')->name('panel.overview');

});

/* QR de colaboradores */

Route::get('qr/verification/{hashid}/{date}', [DashboardController::class, 'qrVerification'])->name('qr.verification');

Route::get('/qr/client-pet/{hashid}', function(){
    return view('show.client-pet');
})->name('qr.client-pet');

Route::get('control-de-colaboradores', function(){
    return view('control');
})->name('control');
Route::get('perfil-colaborador', function(){
    return view('perfil');
})->name('perfil.colaborador');

/* Obtener día y hora con turno */
Route::post('get-turnos', [PetController::class, 'getShifts'])->name('api.get.shifts');

/* Vista General */
Route::get('/', function () {
    return redirect('dashboard');
});
