<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController; // <-- Importamos tu nuevo controlador

// Ruta de prueba (la que ya tenías)
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'success' => true,
            'mensaje' => '¡Conexión exitosa a la base de datos: ' . DB::connection()->getDatabaseName() . '!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'mensaje' => 'Error de conexión: ' . $e->getMessage()
        ]);
    }
});

// NUEVA RUTA: La puerta de entrada para el Login desde React
Route::post('/home', [AuthController::class, 'home']);
Route::post('/crear-prueba', [AuthController::class, 'crearPrueba']);