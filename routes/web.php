<?php
use Illuminate\Support\Facades\Route;
require __DIR__ . '/auth.php';

// Главная страница
Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PersonController;

// Группа маршрутов, требующих аутентификации и подтверждения email
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Группа маршрутов для /dashboard/tree
    Route::prefix('dashboard/tree')->group(function () {

        Route::get('/', [DashboardController::class, 'chooseTree'])->name('dashboard.tree.choose');
        Route::get('/{tree_id}', [DashboardController::class, 'showTree'])->name('dashboard.tree.show');

        // Маршрут для персоны
        Route::get('/person/{id}', [PersonController::class, 'edit'])->name('dashboard.person.edit');
        Route::put('/person/{id}', [PersonController::class, 'update'])->name('dashboard.person.update');

    });

    Route::get('/dd/{tree_id}', [DashboardController::class, 'dd'])->name('dd');
    
});
