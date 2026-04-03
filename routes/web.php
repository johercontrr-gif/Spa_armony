<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MasajistaController;
use App\Http\Controllers\ServicioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ─── Public Routes ───────────────────────────────────────────────────────
Route::get('/', function () {
    $servicios = \App\Models\Servicio::limit(6)->get();
    return view('welcome', compact('servicios'));
})->name('home');

Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios');

// ─── Auth Routes ─────────────────────────────────────────────────────────
Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminController::class, 'login'])->name('login.submit');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

// ─── Admin Protected Routes ─────────────────────────────────────────────
Route::middleware('auth:admin')->prefix('dashboard')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Clientes
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/{cedula}', [ClienteController::class, 'show'])->name('clientes.show');
    Route::put('/clientes/{cedula}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/clientes/{cedula}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

    // Masajistas
    Route::get('/masajistas', [MasajistaController::class, 'index'])->name('masajistas.index');
    Route::get('/masajistas/create', [MasajistaController::class, 'create'])->name('masajistas.create');
    Route::post('/masajistas', [MasajistaController::class, 'store'])->name('masajistas.store');
    Route::get('/masajistas/{cedula}', [MasajistaController::class, 'show'])->name('masajistas.show');
    Route::put('/masajistas/{cedula}', [MasajistaController::class, 'update'])->name('masajistas.update');
    Route::delete('/masajistas/{cedula}', [MasajistaController::class, 'destroy'])->name('masajistas.destroy');
    Route::post('/masajistas/{cedula}/servicios', [MasajistaController::class, 'attachServicios'])->name('masajistas.servicios');

    // Servicios
    Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios.index');
    Route::get('/servicios/create', [ServicioController::class, 'create'])->name('servicios.create');
    Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
    Route::get('/servicios/{id_servicio}', [ServicioController::class, 'show'])->name('servicios.show');
    Route::put('/servicios/{id_servicio}', [ServicioController::class, 'update'])->name('servicios.update');
    Route::delete('/servicios/{id_servicio}', [ServicioController::class, 'destroy'])->name('servicios.destroy');

    // Citas
    Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
    Route::get('/citas/create', [CitaController::class, 'create'])->name('citas.create');
    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/{id_cita}', [CitaController::class, 'show'])->name('citas.show');
    Route::get('/citas/{id_cita}/edit', [CitaController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{id_cita}', [CitaController::class, 'update'])->name('citas.update');
    Route::delete('/citas/{id_cita}', [CitaController::class, 'destroy'])->name('citas.destroy');
    Route::put('/citas/{id_cita}/cancel', [CitaController::class, 'cancel'])->name('citas.cancel');
    Route::put('/citas/{id_cita}/confirm', [CitaController::class, 'confirm'])->name('citas.confirm');
    Route::put('/citas/{id_cita}/finalize', [CitaController::class, 'finalize'])->name('citas.finalize');

    // Admins
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
    Route::delete('/admins/{id_admin}', [AdminController::class, 'destroy'])->name('admins.destroy');
});
