<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\TreeController;
use App\Http\Controllers\AuthController;

Route::get('test', function () {
    return response()->json(['message' => 'Hello, API! Fuck! Luck']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::prefix('trees')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [TreeController::class, 'index']); // Получить список деревьев
    Route::post('/', [TreeController::class, 'store']); // Создать новое дерево
    Route::get('/{id}', [TreeController::class, 'show']); // Получить конкретное дерево
    Route::put('/{id}', [TreeController::class, 'update']); // Обновить дерево
    Route::delete('/{id}', [TreeController::class, 'destroy']); // Удалить дерево
});

Route::prefix('persons')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [PersonController::class, 'index']); // Получить список персон
    Route::post('/', [PersonController::class, 'store']); // Создать новую персону
    Route::get('/{id}', [PersonController::class, 'show']); // Получить конкретную персону
    Route::get('/tree/{tree_id}', [PersonController::class, 'byTree']); // Получить конкретную персону
    Route::put('/{id}', [PersonController::class, 'update']); // Обновить персону
    Route::delete('/{id}', [PersonController::class, 'destroy']); // Удалить персону
});