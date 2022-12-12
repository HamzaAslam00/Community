<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistrationPageController;

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
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //dashboard routes
    Route::resource('dashboard', DashboardController::class);

    //profile routes
    Route::resource('profile', ProfileController::class);
    Route::put('profile/passwordsave/{profile}', [ProfileController::class,'savePassword'])->name('profile.save_password');

    //groups routes
    Route::resource('groups', GroupController::class);
    Route::get('groups-dt', [GroupController::class, 'dataTable'])->name('groups-datatable');

    //registration-pages routes
    Route::resource('registration-pages', RegistrationPageController::class);

    //user routes
    Route::resource('users', UserController::class);

    //user routes
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
