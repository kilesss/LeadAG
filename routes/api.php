<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('submitCredit',[\App\Http\Controllers\CreditsController::class, 'submitCredit'] )->name('submitCredit');
Route::post('makePayment',[\App\Http\Controllers\CreditsController::class, 'makePayment'] )->name('makePayment');
Route::get('getCredits',[\App\Http\Controllers\CreditsController::class, 'getCredits'] )->name('getCredits');

