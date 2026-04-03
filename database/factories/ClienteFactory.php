<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition(): array
    {
        return [
            'cedula'   => $this->faker->unique()->numberBetween(1000000000, 1999999999),
            'nombre'   => $this->faker->name(),
            'telefono' => $this->faker->numerify('3#########'),
            'correo'   => $this->faker->unique()->safeEmail(),
        ];
    }
}
