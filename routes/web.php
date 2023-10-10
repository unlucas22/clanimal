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

Route::get('/', function () {
    return redirect('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::view('/', 'dashboard')->name('dashboard.index');
    
    Route::prefix('dashboard')->group(function () {

        Route::middleware(['admin'])->group(function () {
            Route::view('/users', 'dashboard')->name('dashboard.users');
            Route::view('/roles', 'dashboard')->name('dashboard.roles');
            Route::view('/clients', 'dashboard')->name('dashboard.clients');
        });

        Route::view('/create/client', 'dashboard')->name('dashboard.create.client');
        Route::get('/show/client/{hashid}', [DashboardController::class, 'showClient'])->name('dashboard.show.client');
        
        Route::get('/create/pet-images/{hashid}', [PetController::class, 'createPetImages'])->name('dashboard.create.pet-images');
        Route::post('/store/pet-images', [PetController::class, 'storePetImages'])->name('dashboard.update.pet-images');
    });

    Route::view('panel', 'panel')->name('panel.overview');

});
