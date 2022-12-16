<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistrationPageController;


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
    Route::get('registration-pages-dt', [RegistrationPageController::class, 'dataTable'])->name('registration-pages-datatable');

    Route::group(['prefix' => 'registration-pages/{registrationPageId}/', 'as' => 'registration-pages.'], function()
    {
        //ticket routes
        Route::resource('tickets', TicketController::class);
        Route::get('tickets-dt', [TicketController::class, 'dataTable'])->name('tickets-datatable');
    });
    
    //user routes
    Route::resource('users', UserController::class);
    Route::get('users-dt', [UserController::class, 'dataTable'])->name('users-datatable');
});