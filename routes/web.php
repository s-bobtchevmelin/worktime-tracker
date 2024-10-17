<?php

use App\Http\Controllers\WorkedPeriodController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');
    Route::get('/workedPeriod/week/{start}/{end}', [WorkedPeriodController::class, 'indexWeek'])->name('workedPeriodWeek');
    Route::post('/workedPeriod', [WorkedPeriodController::class, 'store'])->name('workedPeriodAdd');
    Route::post('/workedPeriod/{id}/delete', [WorkedPeriodController::class, 'destroy'])->name('workedPeriodDelete');
});
