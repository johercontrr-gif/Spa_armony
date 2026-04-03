<?php

use App\Models\Masajista;
use App\Models\Servicio;
use App\Models\Cita;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('masajista has correct primary key', function () {
    $m = Masajista::factory()->create(['cedula' => 200111222]);
    expect($m->getKeyName())->toBe('cedula');
});

test('masajista has many citas', function () {
    $m = Masajista::factory()->create();
    Cita::factory()->create(['masajista' => $m->cedula]);

    expect($m->citas)->toHaveCount(1);
});

test('masajista belongs to many servicios with comision pivot', function () {
    $m = Masajista::factory()->create();
    $s = Servicio::factory()->create();

    $m->servicios()->attach($s->id_servicio, ['comision' => 5000]);

    $m->refresh();
    expect($m->servicios)->toHaveCount(1);
    expect($m->servicios->first()->pivot->comision)->toBe(5000);
});
