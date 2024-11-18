<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HospedeController;


Route::get('/', function () {
    return view('welcome');
});
Route::resource('hospedes', HospedeController::class);


Route::get('hospedes/create', [HospedeController::class, 'create'])->name('hospedes.create');
