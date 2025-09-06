<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;



Route::get('/', [FormController::class, 'showForm'])->name('form.show');
Route::post('/submit', [FormController::class, 'submitForm'])->name('form.submit');
Route::get('/thankyou', [FormController::class, 'thankyou'])->name('form.thankyou');
