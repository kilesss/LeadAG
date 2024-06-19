<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('submitCredit',[\App\Http\Controllers\CreditsController::class, 'submitCredit'] )->name('submitCredit')->middleware('login');
Route::post('makePayment',[\App\Http\Controllers\CreditsController::class, 'makePayment'] )->name('makePayment')->middleware('login');
Route::get('getCredits',[\App\Http\Controllers\CreditsController::class, 'getCredits'] )->name('getCredits')->middleware('login');

