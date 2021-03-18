<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GoogleController;
 
Route::get('/', function () {
    return view('welcome');
});
 
Auth::routes();
Route::group(['middleware' => ['auth','ceklevel:admin,user']], function () {
    route::get('/home',[HomeController::class,'index'])->name('home');    
});

Route::get('auth/google',[GoogleController::class,'redirectToGoole'])->name('google.login');
Route::get('auth/google/callback',[GoogleController::class,'handleGoogleCallback'])->name('google.callback');