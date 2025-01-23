<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonController;

Route::get('test', function () {
    return response()->json(['message' => 'Hello, API! Fuck! Luck']);
});

Route::prefix('persons')->group(function () {
    Route::get('/', [PersonController::class, 'index']); // Получить список персон
    Route::post('/', [PersonController::class, 'store']); // Создать новую персону
    Route::get('/{id}', [PersonController::class, 'show']); // Получить конкретную персону
    Route::put('/{id}', [PersonController::class, 'update']); // Обновить персону
    Route::delete('/{id}', [PersonController::class, 'destroy']); // Удалить персону
});