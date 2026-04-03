<?php

namespace Database\Factories;

use App\Models\Masajista;
use Illuminate\Database\Eloquent\Factories\Factory;

class MasajistaFactory extends Factory
{
    protected $model = Masajista::class;

    public function definition(): array
    {
        return [
            'cedula'           => $this->faker->unique()->numberBetween(2000000000, 2999999999),
            'nombre_masajista' => $this->faker->name(),
            'telefono'         => $this->faker->numerify('3#########'),
        ];
    }
}
