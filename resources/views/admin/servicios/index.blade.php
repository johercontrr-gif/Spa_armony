@extends('layouts.app')
@section('title', 'Servicios - SPA Armonía')
@section('content')
<div class="bg-surface-50 dark:bg-surface-900 min-h-[calc(100vh-4rem)]" id="admin-servicios-page">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestión de Servicios</h1>
                <p class="text-primary-600 dark:text-primary-400 text-sm mt-0.5">{{ $servicios->count() }} servicios</p>
            </div>
            <button @click="$dispatch('open-modal-new-servicio')" class="btn-primary mt-4 sm:mt-0" x-data id="btn-nuevo-servicio">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Servicio
            </button>
        </div>

        @if($servicios->count() > 0)
            <div class="table-container">
                <table>
                    <thead><tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Descripción</th><th class="text-right">Acciones</th></tr></thead>
                    <tbody>
                        @foreach($servicios as $srv)
                            <tr>
                                <td class="font-mono text-sm">{{ $srv->id_servicio }}</td>
                                <td class="font-medium text-gray-900 dark:text-white">{{ $srv->nombre_servicio }}</td>
                                <td class="font-bold text-primary-600 dark:text-primary-400">${{ number_format($srv->precio, 0, ',', '.') }}</td>
                                <td class="text-sm">{{ $srv->descripcion ?? '-' }}</td>
                                <td class="text-right">
                                    <form method="POST" action="{{ route('admin.servicios.destroy', $srv->id_servicio) }}" class="inline" onsubmit="return confirm('¿Eliminar?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:text-red-700 text-sm font-medium">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="card p-12 text-center"><p class="text-gray-500 text-lg">No hay servicios.</p></div>
        @endif
    </div>
</div>

<x-modal name="new-servicio" title="Nuevo Servicio" maxWidth="md">
    <form method="POST" action="{{ route('admin.servicios.store') }}">
        @csrf
        <div class="space-y-4">
            <div><label for="s_id" class="label-field">ID Servicio *</label><input type="number" name="id_servicio" id="s_id" class="input-field" required></div>
            <div><label for="s_nombre" class="label-field">Nombre *</label><input type="text" name="nombre_servicio" id="s_nombre" class="input-field" required></div>
            <div><label for="s_precio" class="label-field">Precio *</label><input type="number" name="precio" id="s_precio" class="input-field" required min="0"></div>
            <div><label for="s_desc" class="label-field">Descripción</label><textarea name="descripcion" id="s_desc" class="input-field" rows="2"></textarea></div>
        </div>
        <div class="flex gap-3 mt-6">
            <button type="submit" class="btn-primary flex-1">Crear Servicio</button>
            <button type="button" @click="$dispatch('close-modal-new-servicio')" class="btn-secondary">Cancelar</button>
        </div>
    </form>
</x-modal>
@endsection
