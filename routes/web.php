<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BidhaaController;
use App\Http\Controllers\WatejaController;
use App\Http\Controllers\MauzoController;
use App\Http\Controllers\MaswalijController;
use App\Http\Controllers\RipotiController;
use App\Http\Controllers\LughaController;
use Illuminate\Support\Facades\Route;

// Badilisha lugha
Route::get('/lugha/{lugha}', [LughaController::class, 'badilisha'])->name('lugha.badilisha');

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Bidhaa (Products)
Route::resource('bidhaa', BidhaaController::class);

// Wateja (Customers)
Route::resource('wateja', WatejaController::class);

// Mauzo (Sales)
Route::resource('mauzo', MauzoController::class);

// Maswali (Inquiries)
Route::resource('maswali', MaswalijController::class)->only(['index', 'create', 'store', 'update', 'destroy']);

// Ripoti (Reports)
Route::get('/ripoti', [RipotiController::class, 'index'])->name('ripoti.index');
