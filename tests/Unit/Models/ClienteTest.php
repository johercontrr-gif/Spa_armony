<?php

use App\Models\Cliente;
use App\Models\Cita;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('cliente has correct primary key', function () {
    $cliente = Cliente::factory()->create(['cedula' => 123456789]);
    expect($cliente->getKeyName())->toBe('cedula');
    expect($cliente->cedula)->toBe(123456789);
});

test('cliente has many citas', function () {
    $cliente = Cliente::factory()->create();
    $cita = Cita::factory()->create(['id_cliente' => $cliente->cedula]);

    expect($cliente->citas)->toHaveCount(1);
    expect($cliente->citas->first()->id_cita)->toBe($cita->id_cita);
});

test('cliente fillable attributes work', function () {
    $data = ['cedula' => 111222333, 'nombre' => 'Test', 'telefono' => '3001112233', 'correo' => 'test@test.com'];
    $cliente = Cliente::create($data);

    expect($cliente->nombre)->toBe('Test');
    expect($cliente->telefono)->toBe('3001112233');
    expect($cliente->correo)->toBe('test@test.com');
});
