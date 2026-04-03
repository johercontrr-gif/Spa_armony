<?php

use App\Models\Servicio;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('GET /api/servicios returns all servicios', function () {
    Servicio::factory()->create(['id_servicio' => 1, 'nombre_servicio' => 'Masaje Relajante', 'precio' => 40000]);
    Servicio::factory()->create(['id_servicio' => 2, 'nombre_servicio' => 'Aromaterapia', 'precio' => 48000]);

    $response = $this->getJson('/api/servicios');

    $response->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonFragment(['nombre_servicio' => 'Masaje Relajante'])
        ->assertJsonFragment(['nombre_servicio' => 'Aromaterapia']);
});

test('GET /api/servicios response matches expected contract', function () {
    Servicio::factory()->create([
        'id_servicio' => 1,
        'nombre_servicio' => 'Test Service',
        'precio' => 50000,
        'descripcion' => 'A test description',
    ]);

    $response = $this->getJson('/api/servicios');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                ['id_servicio', 'nombre_servicio', 'precio', 'descripcion'],
            ],
        ]);
});
