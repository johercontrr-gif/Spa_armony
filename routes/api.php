<?php

use App\Http\Controllers\Api\PublicController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MasajistaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ─── Public API ──────────────────────────────────────────────────────────
Route::get('/servicios', [PublicController::class, 'servicios']);
Route::get('/masajistas', [PublicController::class, 'masajistas']);
Route::get('/masajistas/{cedula}/disponibilidad', [PublicController::class, 'disponibilidadMasajista']);

// ─── Client-facing API ───────────────────────────────────────────────────
Route::get('/clientes/{cedula}/citas', [ClienteController::class, 'citasPorCliente']);
Route::get('/clientes/search', [ClienteController::class, 'search']);



// ─── Masajistas API ─────────────────────────────────────────────────────
Route::post('/masajistas/{cedula}/servicios', [MasajistaController::class, 'attachServicios']);
