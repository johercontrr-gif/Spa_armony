<?php

namespace Database\Factories;

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Masajista;
use Illuminate\Database\Eloquent\Factories\Factory;

class CitaFactory extends Factory
{
    protected $model = Cita::class;

    public function definition(): array
    {
        return [
            'id_cita'    => $this->faker->unique()->numberBetween(1, 99999),
            'fecha'      => now()->addDays($this->faker->numberBetween(1, 30)),
            'masajista'  => Masajista::factory(),
            'id_cliente' => Cliente::factory(),
            'nota'       => $this->faker->optional(0.3)->sentence(),
            'estado'     => $this->faker->randomElement(['pendiente', 'confirmada', 'cancelada', 'finalizada']),
            'habitacion' => $this->faker->optional(0.7)->numberBetween(101, 110),
        ];
    }
}
