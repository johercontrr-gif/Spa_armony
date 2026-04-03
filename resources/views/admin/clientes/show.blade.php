@extends('layouts.app')
@section('title', $cliente->nombre . ' - SPA Armonía')
@section('content')
<div class="bg-surface-50 dark:bg-surface-900 min-h-[calc(100vh-4rem)]" id="cliente-show-page">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ route('admin.clientes.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-primary-600 mb-6">&larr; Volver</a>
        <div class="card p-8 mb-6">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-700 dark:text-blue-400 font-bold text-2xl">
                    {{ strtoupper(substr($cliente->nombre, 0, 2)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $cliente->nombre }}</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Cédula: {{ $cliente->cedula }} · Tel: {{ $cliente->telefono ?? 'N/A' }} · Email: {{ $cliente->correo ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        <div class="card p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Historial de Citas ({{ $cliente->citas->count() }})</h2>
            @forelse($cliente->citas->sortByDesc('fecha') as $cita)
                <div class="p-4 rounded-lg bg-surface-50 dark:bg-surface-700/50 mb-3">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-medium text-gray-900 dark:text-white">{{ $cita->fecha->format('d M Y, H:i') }}</span>
                        <x-badge :estado="$cita->estado" />
                    </div>
                    <p class="text-sm text-gray-500">Masajista: {{ $cita->masajistaRelation->nombre_masajista ?? 'N/A' }}</p>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Sin citas.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
