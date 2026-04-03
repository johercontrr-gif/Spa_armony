<?php

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Masajista;
use App\Models\Servicio;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('cita belongs to cliente', function () {
    $cita = Cita::factory()->create();
    expect($cita->cliente)->toBeInstanceOf(Cliente::class);
});

test('cita belongs to masajista', function () {
    $cita = Cita::factory()->create();
    expect($cita->masajistaRelation)->toBeInstanceOf(Masajista::class);
});

test('cita belongs to many servicios with duracion pivot', function () {
    $cita = Cita::factory()->create();
    $srv = Servicio::factory()->create();
    $cita->servicios()->attach($srv->id_servicio, ['duracion' => 60]);

    $cita->refresh();
    expect($cita->servicios)->toHaveCount(1);
    expect($cita->servicios->first()->pivot->duracion)->toBe(60);
});

test('cita total attribute calculates sum of service prices', function () {
    $cita = Cita::factory()->create();
    $srv1 = Servicio::factory()->create(['precio' => 40000]);
    $srv2 = Servicio::factory()->create(['precio' => 50000]);
    $cita->servicios()->attach([
        $srv1->id_servicio => ['duracion' => 60],
        $srv2->id_servicio => ['duracion' => 45],
    ]);

    $cita->refresh();
    expect($cita->total)->toBe(90000);
});

test('cita fecha is cast to datetime', function () {
    $cita = Cita::factory()->create(['fecha' => '2026-05-10 14:00:00']);
    expect($cita->fecha)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});
