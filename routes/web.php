<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

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

Route::middleware('auth')->group(function () {

    Route::get('home', [DashboardController::class, 'redirectUser'])->name('home');

    //dashboard routes
    Route::resource('dashboard', DashboardController::class);

    //profile routes
    Route::resource('profile', ProfileController::class);
    Route::put('profile/passwordsave/{profile}', [ProfileController::class,'savePassword'])->name('profile.save_password');

});

require __DIR__.'/auth.php';
