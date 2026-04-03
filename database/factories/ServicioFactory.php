<?php

namespace Database\Factories;

use App\Models\Servicio;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServicioFactory extends Factory
{
    protected $model = Servicio::class;

    public function definition(): array
    {
        return [
            'id_servicio'     => $this->faker->unique()->numberBetween(1, 99999),
            'nombre_servicio' => $this->faker->randomElement([
                'Masaje Relajante', 'Masaje Deportivo', 'Aromaterapia',
                'Tratamiento Facial', 'Masaje de Piedras Calientes',
                'Reflexología', 'Masaje Thai', 'Exfoliación Corporal',
            ]),
            'precio'      => $this->faker->randomElement([35000, 40000, 45000, 48000, 50000, 60000, 75000]),
            'descripcion' => $this->faker->sentence(),
        ];
    }
}
