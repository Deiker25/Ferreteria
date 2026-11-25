<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EmpleadoController;

Route::resource('productos', ProductoController::class);

Route::resource('empleados', EmpleadoController::class);

Route::get('/', function () {
    return redirect()->route('productos.index');
});

Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index');

