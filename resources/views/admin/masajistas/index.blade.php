@extends('layouts.app')

@section('title', 'Gestión de Masajistas - SPA Armonía')

@section('content')
<div class="bg-surface-50 dark:bg-surface-900 min-h-[calc(100vh-4rem)]" id="masajistas-index-page">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestión de Masajistas</h1>
                <p class="text-primary-600 dark:text-primary-400 text-sm mt-0.5">{{ $masajistas->count() }} masajistas registrados</p>
            </div>
            <button @click="$dispatch('open-modal-new-masajista')" class="btn-primary mt-4 sm:mt-0" id="btn-nuevo-masajista" x-data>
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Masajista
            </button>
        </div>

        {{-- Search --}}
        <div class="card p-4 mb-6">
            <form method="GET" action="{{ route('admin.masajistas.index') }}">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o cédula..."
                       class="input-field" id="search-masajistas">
            </form>
        </div>

        {{-- Masajistas Grid --}}
        @if($masajistas->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($masajistas as $masajista)
                    <div class="card-hover p-6" id="masajista-{{ $masajista->cedula }}">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-700 dark:text-primary-400 font-bold">
                                    {{ strtoupper(substr($masajista->nombre_masajista, 0, 2)) }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $masajista->nombre_masajista }}</h3>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 space-y-0.5">
                                        <div class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                                            {{ $masajista->cedula }}
                                        </div>
                                        @if($masajista->telefono)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                                {{ $masajista->telefono }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-surface-700 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-1 w-40 bg-white dark:bg-surface-800 rounded-xl shadow-lg border border-gray-100 dark:border-surface-700 py-1 z-10">
                                    <a href="{{ route('admin.masajistas.show', $masajista->cedula) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-700">Ver detalle</a>
                                    <form method="POST" action="{{ route('admin.masajistas.destroy', $masajista->cedula) }}" onsubmit="return confirm('¿Eliminar este masajista?')">
                                        @csrf @method('DELETE')
                                        <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50 dark:hover:bg-surface-700">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Stats --}}
                        <div class="grid grid-cols-3 gap-3 mb-4 p-3 bg-surface-50 dark:bg-surface-700/50 rounded-lg">
                            <div class="text-center">
                                <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $masajista->citas->count() }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Citas</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-primary-600 dark:text-primary-400">{{ $masajista->citas->where('estado', 'finalizada')->count() }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Finalizadas</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-primary-600 dark:text-primary-400">
                                    ${{ number_format($masajista->servicios->sum('pivot.comision') ?? 0, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Comisión</div>
                            </div>
                        </div>

                        {{-- Services --}}
                        @if($masajista->servicios->count() > 0)
                            <div>
                                <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mb-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    Servicios que ofrece
                                </span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($masajista->servicios as $srv)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700 dark:bg-surface-700 dark:text-gray-300 border border-gray-200 dark:border-surface-600">
                                            {{ $srv->nombre_servicio }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="card p-12 text-center">
                <p class="text-gray-500 dark:text-gray-400 text-lg">No hay masajistas registrados.</p>
            </div>
        @endif
    </div>
</div>

{{-- Modal: New Masajista --}}
<x-modal name="new-masajista" title="Nuevo Masajista" maxWidth="md">
    <form method="POST" action="{{ route('admin.masajistas.store') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="m_cedula" class="label-field">Cédula *</label>
                <input type="number" name="cedula" id="m_cedula" class="input-field" required>
            </div>
            <div>
                <label for="m_nombre" class="label-field">Nombre *</label>
                <input type="text" name="nombre_masajista" id="m_nombre" class="input-field" required>
            </div>
            <div>
                <label for="m_telefono" class="label-field">Teléfono</label>
                <input type="text" name="telefono" id="m_telefono" class="input-field">
            </div>
            
            {{-- Servicios selection --}}
            <div>
                <label class="label-field mb-2">Servicios que ofrece</label>
                <div class="space-y-2 max-h-48 overflow-y-auto pr-2 border border-gray-200 dark:border-surface-600 rounded-lg p-3 bg-gray-50 dark:bg-surface-900 border-opacity-50">
                    @foreach($servicios as $servicio)
                        <label class="flex items-center gap-3 cursor-pointer p-1.5 hover:bg-white dark:hover:bg-surface-800 rounded-md transition-colors">
                            <input type="checkbox" name="servicios[]" value="{{ $servicio->id_servicio }}" 
                                   class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 dark:bg-surface-800 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm text-gray-700 dark:text-white font-medium">{{ $servicio->nombre_servicio }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button type="submit" class="btn-primary flex-1">Crear Masajista</button>
            <button type="button" @click="$dispatch('close-modal-new-masajista')" class="btn-secondary">Cancelar</button>
        </div>
    </form>
</x-modal>
@endsection
