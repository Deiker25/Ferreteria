<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductoController;
use App\Http\Controllers\API\EmpleadoController;
use App\Http\Controllers\API\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas para productos
//Route::apiResource('producto', ProductoController::class);

// Rutas para empleados
//Route::apiResource('empleado', EmpleadoController::class);

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('producto', ProductoController::class);
    Route::apiResource('empleado', EmpleadoController::class);
});




