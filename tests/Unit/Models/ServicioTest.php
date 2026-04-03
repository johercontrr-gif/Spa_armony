<?php

use App\Models\Servicio;
use App\Models\Masajista;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('servicio has correct primary key', function () {
    $s = Servicio::factory()->create(['id_servicio' => 99]);
    expect($s->getKeyName())->toBe('id_servicio');
    expect($s->id_servicio)->toBe(99);
});

test('servicio belongs to many masajistas', function () {
    $s = Servicio::factory()->create();
    $m = Masajista::factory()->create();
    $s->masajistas()->attach($m->cedula, ['comision' => 3000]);

    expect($s->masajistas)->toHaveCount(1);
});
