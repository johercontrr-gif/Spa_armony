<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Masajista;
use App\Models\Servicio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Get all servicios (public catalog).
     */
    public function servicios(): JsonResponse
    {
        $servicios = Servicio::orderBy('nombre_servicio')->get();

        return response()->json([
            'data' => $servicios->map(function ($s) {
                return [
                    'id_servicio'     => $s->id_servicio,
                    'nombre_servicio' => $s->nombre_servicio,
                    'precio'          => $s->precio,
                    'descripcion'     => $s->descripcion,
                ];
            }),
        ]);
    }

    /**
     * Get all masajistas with their servicios (public).
     */
    public function masajistas(): JsonResponse
    {
        $masajistas = Masajista::with('servicios')->orderBy('nombre_masajista')->get();

        return response()->json([
            'data' => $masajistas->map(function ($m) {
                return [
                    'cedula'           => $m->cedula,
                    'nombre_masajista' => $m->nombre_masajista,
                    'servicios'        => $m->servicios->map(function ($s) {
                        return [
                            'id_servicio'     => $s->id_servicio,
                            'nombre_servicio' => $s->nombre_servicio,
                            'precio'          => $s->precio,
                        ];
                    }),
                ];
            }),
        ]);
    }

    /**
     * Get availability / schedule for a specific masajista.
     */
    public function disponibilidadMasajista(Request $request, int $cedula): JsonResponse
    {
        $masajista = Masajista::where('cedula', $cedula)->firstOrFail();

        $fecha = $request->input('fecha', now()->toDateString());

        $citasDelDia = $masajista->citas()
            ->whereDate('fecha', $fecha)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->with('servicios')
            ->orderBy('fecha')
            ->get();

        return response()->json([
            'masajista'     => $masajista->nombre_masajista,
            'fecha'         => $fecha,
            'citas_ocupadas' => $citasDelDia->map(function ($c) {
                return [
                    'id_cita' => $c->id_cita,
                    'hora'    => $c->fecha->format('H:i'),
                    'duracion_total' => $c->servicios->sum('pivot.duracion'),
                ];
            }),
        ]);
    }
}
