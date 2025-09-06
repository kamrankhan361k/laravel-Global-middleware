<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [FormController::class, 'showForm'])->name('form.show');
Route::post('/submit', [FormController::class, 'submitForm'])->name('form.submit');
Route::get('/thankyou', [FormController::class, 'thankyou'])->name('form.thankyou');
