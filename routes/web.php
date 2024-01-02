<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DashboardController, PetController, ProductController, SaleController, MarketingController};

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

            Route::view('/puestos', 'dashboard')->name('dashboard.puestos');

            Route::view('/entidades-bancarias', 'dashboard')->name('dashboard.entidades-bancarias');
        });

        Route::view('/proveedores', 'dashboard')->name('dashboard.suppliers');
        Route::view('/compras', 'dashboard')->name('dashboard.compras');
        Route::view('/classifications', 'dashboard')->name('dashboard.classifications');
        Route::view('/sedes', 'dashboard')->name('dashboard.sedes');
        Route::view('/gerente-de-tienda', 'dashboard')->name('dashboard.manager');

        /* MARKETING */
        Route::view('/marketing/campaigns', 'dashboard')->name('dashboard.marketing-campaigns');
        Route::view('/marketing/plantillas', 'dashboard')->name('dashboard.marketing-templates');
        Route::view('/marketing/trackings', 'dashboard')->name('dashboard.marketing-trackings');

        Route::get('/create/marketing/plantillas', function() {
            return view('create.marketing-templates');  
        })->name('dashboard.create.marketing-templates');

        Route::get('/show/marketing/plantillas/{hashid}', function(){
            return view('show.marketing-templates');
        })->name('dashboard.show.marketing-templates');

        /* FINANZAS: PLANILLAS; INGRESOS DEL GERENTE; FACTURAS DE COMPRAS */
        Route::view('/finanzas', 'dashboard')->name('dashboard.finanzas');
        Route::view('/finanzas/ingresos', 'dashboard')->name('dashboard.finanzas-ingresos');
        Route::view('/finanzas/planillas', 'dashboard')->name('dashboard.finanzas-planillas');
        Route::view('/finanzas/facturas', 'dashboard')->name('dashboard.finanzas-facturas');

        Route::get('/show/planilla/{hashid}', function(){
            return view('show.spreadsheet');
        })->name('dashboard.show.spreadsheet');

        Route::post('/store/marketing-templates', [MarketingController::class, 'storeTemplate'])->name('dashboard.store.marketing-templates');

        Route::post('/update/marketing-templates', [MarketingController::class, 'updateTemplate'])->name('dashboard.update.marketing-templates');

        /* RECURSOS HUMANOS */
        Route::view('/recursos-humanos', 'dashboard')->name('dashboard.recursos-humanos');
        Route::view('/rrhh/planillas', 'dashboard')->name('dashboard.rrhh-planillas');

        Route::get('/show/rrhh-planilla/{hashid}', function(){
            return view('show.rrhh-spreadsheet');
        })->name('dashboard.show.rrhh-spreadsheet');
        
        /* CAJA */
        Route::view('/cajas', 'dashboard')->name('dashboard.caja');

        Route::get('/show/caja/{hashid}', function(){
            return view('show.caja');
        })->name('dashboard.show.caja');

        /* Turnos y Recepcion */
        Route::view('/turnos', 'dashboard')->name('dashboard.shifts');
        Route::view('/atencion-veterinaria', 'dashboard')->name('dashboard.atencion-veterinaria');
        Route::view('/peluqueria-canina', 'dashboard')->name('dashboard.peluqueria-canina');
        Route::view('/recepcion', 'dashboard')->name('dashboard.receptions');

        Route::get('/create/shift/{hashid?}', function() {
            return view('create.turno');  
        })->name('dashboard.create.shift');
        
        Route::post('/store/shift', [PetController::class, 'storeShift'])->name('dashboard.store.shift');

        Route::get('/create/reception/{hashid?}', [PetController::class, 'createReception'])->name('dashboard.create.reception');
        Route::post('/store/reception', [PetController::class, 'storeReception'])->name('dashboard.store.reception');

        /*** Modulo en Desuso ---> Servicios ***/
        Route::view('/servicios', 'dashboard')->name('dashboard.services');

        /* PRODUCTO */
        Route::view('/productos-para-tienda', 'dashboard')->name('dashboard.tienda');
        
        Route::view('/ingreso-de-productos', 'dashboard')->name('dashboard.ingreso-de-productos');
        Route::view('/stock-de-tienda', 'dashboard')->name('dashboard.stock-de-tienda');
        Route::view('/productos', 'dashboard')->name('dashboard.products');
        
        Route::get('/create/product', function(){
            return view('create.product');
        })->name('dashboard.create.product');

        Route::get('/create/manpower', function(){
            return view('create.manpower');
        })->name('dashboard.create.manpower');

        Route::post('/store/product', [ProductController::class, 'store'])->name('dashboard.store.product');

        Route::get('/show/product/{hashid}', function(){
            return view('show.product');
        })->name('dashboard.show.product');

        Route::post('/update/product', [ProductController::class, 'update'])->name('dashboard.update.product');

        /*** Almacen de Productos ***/
        Route::get('/create/warehouse', function(){
            return view('create.warehouse');
        })->name('dashboard.create.warehouse');

        Route::get('/show/warehouse/{hashid}', function(){
            return view('show.warehouse');
        })->name('dashboard.show.warehouse');

        Route::get('/show/finanzas-facturas/{hashid}', function(){
            return view('show.finanzas-facturas');
        })->name('dashboard.show.finanzas-facturas');

        Route::post('store/warehouse', [ProductController::class, 'storeWarehouse'])->name('dashboard.store.warehouse');

        /*** Salida de Productos ***/
        Route::view('/salida-de-productos', 'dashboard')->name('dashboard.transfers');

        Route::get('/create/salida-de-productos', function(){
            return view('create.transfer');
        })->name('dashboard.create.transfer');

        Route::get('/show/transfer/{hashid}', function(){
            return view('show.transfer');
        })->name('dashboard.show.transfer');

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
