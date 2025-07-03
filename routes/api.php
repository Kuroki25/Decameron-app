<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\TipoHabitacionController;
use App\Http\Controllers\AcomodacionController;
use App\Http\Controllers\HotelTipoAcomodacionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí van las rutas de tu API. Ya usarán el prefijo /api y el middleware 'api'.
|
*/

// CRUD de hoteles
Route::apiResource('hoteles', HotelController::class);

// CRUD de tipos de habitación (forzamos el parámetro singular para el binding)
Route::apiResource('tipos-habitacion', TipoHabitacionController::class)
     ->parameters(['tipos-habitacion' => 'tipo_habitacion']);

// CRUD de acomodaciones
Route::apiResource('acomodaciones', AcomodacionController::class);

// Rutas para la tabla pivote (asignaciones de tipo+acomodación a un hotel)
Route::post   ('hoteles/{hotel}/asignaciones',               [HotelTipoAcomodacionController::class, 'store']);
Route::delete ('hoteles/{hotel}/asignaciones/{asignacion}',  [HotelTipoAcomodacionController::class, 'destroy']);
