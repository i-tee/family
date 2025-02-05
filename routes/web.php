<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Группа маршрутов для /dashboard/tree
    Route::prefix('dashboard/tree')->group(function () {

        Route::get('/', [DashboardController::class, 'chooseTree'])->name('dashboard.tree.choose');
        Route::get('/{id}', [DashboardController::class, 'showTree'])->name('dashboard.tree.show');

    });
    
});
