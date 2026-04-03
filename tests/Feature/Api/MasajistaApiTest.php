<?php

use App\Models\Masajista;
use App\Models\Servicio;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('GET /api/masajistas returns all masajistas with servicios', function () {
    $masajista = Masajista::factory()->create();
    $servicio = Servicio::factory()->create();
    $masajista->servicios()->attach($servicio->id_servicio, ['comision' => 5000]);

    $response = $this->getJson('/api/masajistas');

    $response->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonStructure([
            'data' => [
                ['cedula', 'nombre_masajista', 'servicios'],
            ],
        ]);
});

test('POST /api/masajistas/{cedula}/servicios attaches servicios', function () {
    $masajista = Masajista::factory()->create();
    $s1 = Servicio::factory()->create();
    $s2 = Servicio::factory()->create();

    $response = $this->postJson("/api/masajistas/{$masajista->cedula}/servicios", [
        'servicios' => [
            ['id_servicio' => $s1->id_servicio, 'comision' => 5000],
            ['id_servicio' => $s2->id_servicio, 'comision' => 7000],
        ],
    ]);

    $response->assertOk()
        ->assertJsonFragment(['success' => true]);

    $masajista->refresh();
    expect($masajista->servicios)->toHaveCount(2);
});
