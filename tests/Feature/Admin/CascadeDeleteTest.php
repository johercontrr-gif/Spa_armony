<?php

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Masajista;
use App\Models\Servicio;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('deleting a cliente cascades to its citas', function () {
    $cliente = Cliente::factory()->create();
    $cita = Cita::factory()->create(['id_cliente' => $cliente->cedula]);

    $this->assertDatabaseHas('citas', ['id_cita' => $cita->id_cita]);

    $cliente->delete();

    $this->assertDatabaseMissing('citas', ['id_cita' => $cita->id_cita]);
});

test('deleting a masajista cascades to its citas', function () {
    $masajista = Masajista::factory()->create();
    $cita = Cita::factory()->create(['masajista' => $masajista->cedula]);

    $masajista->delete();

    $this->assertDatabaseMissing('citas', ['id_cita' => $cita->id_cita]);
});

test('deleting a masajista cascades to masa_servicio pivot', function () {
    $masajista = Masajista::factory()->create();
    $servicio = Servicio::factory()->create();
    $masajista->servicios()->attach($servicio->id_servicio, ['comision' => 5000]);

    $this->assertDatabaseHas('masa_servicio', ['id_masajista' => $masajista->cedula]);

    $masajista->delete();

    $this->assertDatabaseMissing('masa_servicio', ['id_masajista' => $masajista->cedula]);
});

test('deleting a servicio cascades to masa_servicio pivot', function () {
    $masajista = Masajista::factory()->create();
    $servicio = Servicio::factory()->create();
    $masajista->servicios()->attach($servicio->id_servicio, ['comision' => 5000]);

    $servicio->delete();

    $this->assertDatabaseMissing('masa_servicio', ['id_servicio' => $servicio->id_servicio]);
});

test('deleting a cita cascades to citas_servicios pivot', function () {
    $cita = Cita::factory()->create();
    $servicio = Servicio::factory()->create();
    $cita->servicios()->attach($servicio->id_servicio, ['duracion' => 60]);

    $this->assertDatabaseHas('citas_servicios', ['id_cita' => $cita->id_cita]);

    $cita->delete();

    $this->assertDatabaseMissing('citas_servicios', ['id_cita' => $cita->id_cita]);
});

test('deleting a servicio cascades to citas_servicios pivot', function () {
    $cita = Cita::factory()->create();
    $servicio = Servicio::factory()->create();
    $cita->servicios()->attach($servicio->id_servicio, ['duracion' => 60]);

    $servicio->delete();

    $this->assertDatabaseMissing('citas_servicios', ['id_servicio' => $servicio->id_servicio]);
});
