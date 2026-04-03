@extends('layouts.app')

@section('title', $masajista->nombre_masajista . ' - SPA Armonía')

@section('content')
<div class="bg-surface-50 dark:bg-surface-900 min-h-[calc(100vh-4rem)]" id="masajista-show-page">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <a href="{{ route('admin.masajistas.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-primary-600 mb-6">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Volver a masajistas
        </a>

        {{-- Profile Card --}}
        <div class="card p-8 mb-6">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-700 dark:text-primary-400 font-bold text-2xl">
                    {{ strtoupper(substr($masajista->nombre_masajista, 0, 2)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $masajista->nombre_masajista }}</h1>
                    <p class="text-gray-500 dark:text-gray-400">Cédula: {{ $masajista->cedula }} · Tel: {{ $masajista->telefono ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        {{-- Services & Commissions --}}
        <div class="card p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Servicios y Comisiones</h2>
            @if($masajista->servicios->count() > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Servicio</th>
                                <th>Precio</th>
                                <th>Comisión</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($masajista->servicios as $srv)
                                <tr>
                                    <td class="font-medium">{{ $srv->nombre_servicio }}</td>
                                    <td>${{ number_format($srv->precio, 0, ',', '.') }}</td>
                                    <td>${{ number_format($srv->pivot->comision ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No tiene servicios asignados.</p>
            @endif
        </div>

        {{-- Citas History --}}
        <div class="card p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Historial de Citas</h2>
            @if($masajista->citas->count() > 0)
                <div class="space-y-3">
                    @foreach($masajista->citas->sortByDesc('fecha')->take(10) as $cita)
                        <div class="flex items-center gap-4 p-3 rounded-lg bg-surface-50 dark:bg-surface-700/50">
                            <div class="flex-1">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $cita->cliente->nombre ?? 'N/A' }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">{{ $cita->fecha->format('d M Y, H:i') }}</span>
                            </div>
                            <x-badge :estado="$cita->estado" />
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No tiene citas registradas.</p>
            @endif
        </div>
    </div>
</div>
@endsection
