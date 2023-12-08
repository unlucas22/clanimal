<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DashboardController, PetController, ProductController, SaleController};

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
    'verified',
    'active'
])->group(function () {

    /*** Index: Charts e informacion general ***/
    Route::view('/dashboard', 'dashboard')->name('dashboard.index');
    
    Route::prefix('dashboard')->group(function () {

        /*** Modulos para administradores: configuracion y colaboradores ***/
        Route::middleware(['admin'])->group(function () {
            Route::view('/users', 'dashboard')->name('dashboard.users');
            Route::view('/roles', 'dashboard')->name('dashboard.roles');
            Route::view('/clients', 'dashboard')->name('dashboard.clients');
            Route::view('/controls', 'dashboard')->name('dashboard.controls');
            Route::view('/cajeros', 'dashboard')->name('dashboard.cajeros');
        });

        Route::view('/proveedores', 'dashboard')->name('dashboard.suppliers');
        Route::view('/compras', 'dashboard')->name('dashboard.compras');
        Route::view('/classifications', 'dashboard')->name('dashboard.classifications');
        Route::view('/sedes', 'dashboard')->name('dashboard.sedes');
        Route::view('/turnos', 'dashboard')->name('dashboard.shifts');

        /* Turnos y Recepcion */
        Route::view('/turnos', 'dashboard')->name('dashboard.shifts');
        Route::view('/atencion-veterinaria', 'dashboard')->name('dashboard.atencion-veterinaria');
        Route::view('/peluqueria-canina', 'dashboard')->name('dashboard.peluqueria-canina');
        Route::view('/recepcion', 'dashboard')->name('dashboard.receptions');
        
        /*** Modulo en Desuso ---> Servicios ***/
        Route::view('/servicios', 'dashboard')->name('dashboard.services');


        /*** Producto ***/
        
        Route::view('/productos', 'dashboard')->name('dashboard.products');
        
        Route::get('/create/product', function(){
            return view('create.product');
        })->name('dashboard.create.product');

        Route::post('/store/product', [ProductController::class, 'store'])->name('dashboard.store.product');

        /*** Almacen de Productos ***/
        Route::get('/create/warehouse', function(){
            return view('create.warehouse');
        })->name('dashboard.create.warehouse');

        Route::get('/show/warehouse/{hashid}', function(){
            return view('show.warehouse');
        })->name('dashboard.show.warehouse');

        Route::post('store/warehouse', [ProductController::class, 'storeWarehouse'])->name('dashboard.store.warehouse');

        /*** Salida de Productos ***/

        Route::view('/salida-de-productos', 'dashboard')->name('dashboard.transfers');

        Route::get('/create/salida-de-productos', function(){
            return view('create.transfer');
        })->name('dashboard.create.transfer');

        /*** Configuracion para productos ***/
        Route::view('product/categories', 'create.product.category')->name('product.categories');
        Route::view('product/brands', 'create.product.brand')->name('product.brands');
        Route::view('product/presentations', 'create.product.presentation')->name('product.presentations');

        /*** Cliente ***/
        Route::view('/create/client', 'dashboard')->name('dashboard.create.client');
        Route::get('/show/client/{hashid}', [DashboardController::class, 'showClient'])->name('dashboard.show.client');

        /*** Mascotas ***/

        Route::view('/mascotas', 'dashboard')->name('dashboard.pets');

        Route::get('/create/pet-images/{hashid}', [PetController::class, 'createPetImages'])->name('dashboard.create.pet-images');
        Route::post('/store/pet-images', [PetController::class, 'storePetImages'])->name('dashboard.update.pet-images');

        Route::get('/create/pet/{hashid?}', function(){
            return view('create.pet');
        })->name('dashboard.create.pet');

        Route::get('/show/pet/{hashid}', function(){
            return view('show.pet');
        })->name('dashboard.show.pet');


        /*** Turno y Recepción ***/

        Route::get('/create/shift/{hashid?}', function() {
            return view('create.turno');  
        })->name('dashboard.create.shift');
        
        Route::post('/store/shift', [PetController::class, 'storeShift'])->name('dashboard.store.shift');

        Route::get('/create/reception/{hashid?}', [PetController::class, 'createReception'])->name('dashboard.create.reception');
        Route::post('/store/reception', [PetController::class, 'storeReception'])->name('dashboard.store.reception');

        /*** Venta de Servicios y Productos ***/
        
        Route::view('/sales', 'dashboard')->name('dashboard.sales');
        
        Route::get('venta/atencion-veterinaria/{hashid}', function() {
            return view('create.venta.atencion-veterinaria');  
        })->name('dashboard.venta.atencion-veterinaria');

        Route::get('venta/peluqueria-canina/{hashid}', function() {
            return view('create.venta.peluqueria-canina');  
        })->name('dashboard.venta.peluqueria-canina');

        Route::get('venta/productos', function() {
            return view('create.venta.productos');  
        })->name('dashboard.venta.productos');

        Route::post('venta/productos', [SaleController::class, 'store'])->name('dashboard.store.venta.productos');

        /*** Comprobante de Compra ***/
        Route::get('comprobante/{bill_id}', [SaleController::class, 'show'])->name('dashboard.show.venta.factura');
    });
});

/*** QR de colaboradores ***/

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

/*** JSON en desuso para obtener turnos del día ***/
Route::post('get-turnos', [PetController::class, 'getShifts'])->name('api.get.shifts');

/*** Redirección general ***/
Route::get('/', function () {
    return redirect('dashboard');
});
