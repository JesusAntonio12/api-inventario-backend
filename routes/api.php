<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Endpoints de consulta (protegidos por token)
    Route::get('/tiendas', function () {
        return response()->json(DB::table('tiendas')->get());
    });

    Route::get('/productos', function () {
        return response()->json(DB::table('productos')->get());
    });
});