<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Masajista;
use App\Models\Servicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ─── Admin ───────────────────────────────────────────────────
        Admin::create([
            'usuario'    => 'admin',
            'contrasena' => 'admin123',
        ]);

        // ─── Servicios ──────────────────────────────────────────────
        $servicios = [
            ['id_servicio' => 1, 'nombre_servicio' => 'Masaje Relajante',            'precio' => 40000, 'descripcion' => 'Masaje suave para aliviar el estrés y la tensión muscular'],
            ['id_servicio' => 2, 'nombre_servicio' => 'Masaje Deportivo',            'precio' => 50000, 'descripcion' => 'Ideal para deportistas, trabaja músculos profundos'],
            ['id_servicio' => 3, 'nombre_servicio' => 'Aromaterapia',                'precio' => 48000, 'descripcion' => 'Masaje con aceites esenciales para equilibrio emocional'],
            ['id_servicio' => 4, 'nombre_servicio' => 'Tratamiento Facial',          'precio' => 35000, 'descripcion' => 'Limpieza e hidratación facial profunda'],
            ['id_servicio' => 5, 'nombre_servicio' => 'Masaje de Piedras Calientes', 'precio' => 60000, 'descripcion' => 'Terapia con piedras volcánicas para relajación profunda'],
            ['id_servicio' => 6, 'nombre_servicio' => 'Reflexología',                'precio' => 40000, 'descripcion' => 'Estimulación de puntos reflejos en pies y manos'],
        ];

        foreach ($servicios as $s) {
            Servicio::create($s);
        }

        // ─── Masajistas ─────────────────────────────────────────────
        $masajistas = [
            ['cedula' => 2001234567, 'nombre_masajista' => 'Sandra Pérez',    'telefono' => '3201234567'],
            ['cedula' => 2002345678, 'nombre_masajista' => 'Carolina Díaz',   'telefono' => '3202345678'],
            ['cedula' => 2003456789, 'nombre_masajista' => 'Juliana Castro',  'telefono' => '3203456789'],
            ['cedula' => 2004567890, 'nombre_masajista' => 'Diana Moreno',    'telefono' => '3204567890'],
        ];

        foreach ($masajistas as $m) {
            $masajista = Masajista::create($m);
        }

        // Assign services to masajistas
        Masajista::find(2001234567)->servicios()->attach([1 => ['comision' => 5000], 2 => ['comision' => 7000]]);
        Masajista::find(2002345678)->servicios()->attach([1 => ['comision' => 5000], 5 => ['comision' => 9000]]);
        Masajista::find(2003456789)->servicios()->attach([4 => ['comision' => 5000], 3 => ['comision' => 6000]]);
        Masajista::find(2004567890)->servicios()->attach([6 => ['comision' => 5000]]);

        // ─── Clientes ───────────────────────────────────────────────
        $clientes = [
            ['cedula' => 1001234567, 'nombre' => 'María González',   'telefono' => '3121234567', 'correo' => 'maria@email.com'],
            ['cedula' => 1004567890, 'nombre' => 'Ana López',        'telefono' => '3154567890', 'correo' => 'ana@email.com'],
            ['cedula' => 1003456789, 'nombre' => 'Laura Martínez',   'telefono' => '3103456789', 'correo' => 'laura@email.com'],
            ['cedula' => 1005678901, 'nombre' => 'Carlos Ramírez',   'telefono' => '3005678901', 'correo' => 'carlos@email.com'],
            ['cedula' => 1006789012, 'nombre' => 'Daniela Torres',   'telefono' => '3116789012', 'correo' => 'daniela@email.com'],
        ];

        foreach ($clientes as $c) {
            Cliente::create($c);
        }

        // ─── Citas ──────────────────────────────────────────────────
        $cita1 = Cita::create([
            'id_cita' => 1, 'fecha' => '2026-03-30 10:30:00', 'masajista' => 2004567890,
            'id_cliente' => 1001234567, 'estado' => 'confirmada', 'habitacion' => 104,
        ]);
        $cita1->servicios()->attach([6 => ['duracion' => 45]]);

        $cita2 = Cita::create([
            'id_cita' => 2, 'fecha' => '2026-03-29 16:00:00', 'masajista' => 2003456789,
            'id_cliente' => 1004567890, 'nota' => 'Alergia a lavanda', 'estado' => 'confirmada', 'habitacion' => 101,
        ]);
        $cita2->servicios()->attach([3 => ['duracion' => 60]]);

        $cita3 = Cita::create([
            'id_cita' => 3, 'fecha' => '2026-03-29 11:00:00', 'masajista' => 2002345678,
            'id_cliente' => 1003456789, 'estado' => 'pendiente', 'habitacion' => 103,
        ]);
        $cita3->servicios()->attach([5 => ['duracion' => 75]]);

        $cita4 = Cita::create([
            'id_cita' => 4, 'fecha' => '2026-04-05 09:00:00', 'masajista' => 2001234567,
            'id_cliente' => 1005678901, 'estado' => 'pendiente', 'habitacion' => 102,
        ]);
        $cita4->servicios()->attach([1 => ['duracion' => 60], 2 => ['duracion' => 45]]);

        $cita5 = Cita::create([
            'id_cita' => 5, 'fecha' => '2026-03-28 14:00:00', 'masajista' => 2001234567,
            'id_cliente' => 1006789012, 'estado' => 'finalizada', 'habitacion' => 105,
        ]);
        $cita5->servicios()->attach([1 => ['duracion' => 60]]);
    }
}
