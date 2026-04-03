@extends('layouts.app')

@section('title', 'Clientes - SPA Armonía')

@section('content')
<div class="bg-surface-50 dark:bg-surface-900 min-h-[calc(100vh-4rem)]" id="clientes-index-page">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestión de Clientes</h1>
                <p class="text-primary-600 dark:text-primary-400 text-sm mt-0.5">{{ $clientes->total() }} clientes registrados</p>
            </div>
            <button @click="$dispatch('open-modal-new-cliente')" class="btn-primary mt-4 sm:mt-0" x-data id="btn-nuevo-cliente">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Cliente
            </button>
        </div>

        {{-- Search --}}
        <div class="card p-4 mb-6">
            <form method="GET" action="{{ route('admin.clientes.index') }}">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre, cédula o correo..." class="input-field" id="search-clientes">
            </form>
        </div>

        {{-- Table --}}
        @if($clientes->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Citas</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $cliente)
                            <tr id="cliente-{{ $cliente->cedula }}">
                                <td class="font-mono text-sm">{{ $cliente->cedula }}</td>
                                <td class="font-medium text-gray-900 dark:text-white">{{ $cliente->nombre }}</td>
                                <td>{{ $cliente->telefono ?? '-' }}</td>
                                <td>{{ $cliente->correo ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">{{ $cliente->citas_count ?? $cliente->citas->count() }}</span>
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.clientes.show', $cliente->cedula) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium mr-3">Ver</a>
                                    <form method="POST" action="{{ route('admin.clientes.destroy', $cliente->cedula) }}" class="inline" onsubmit="return confirm('¿Eliminar este cliente?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:text-red-700 text-sm font-medium">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $clientes->withQueryString()->links() }}</div>
        @else
            <div class="card p-12 text-center">
                <p class="text-gray-500 text-lg">No hay clientes registrados.</p>
            </div>
        @endif
    </div>
</div>

<x-modal name="new-cliente" title="Nuevo Cliente" maxWidth="md">
    <form method="POST" action="{{ route('admin.clientes.store') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="c_cedula" class="label-field">Cédula *</label>
                <input type="number" name="cedula" id="c_cedula" class="input-field" required>
            </div>
            <div>
                <label for="c_nombre" class="label-field">Nombre *</label>
                <input type="text" name="nombre" id="c_nombre" class="input-field" required>
            </div>
            <div>
                <label for="c_telefono" class="label-field">Teléfono</label>
                <input type="text" name="telefono" id="c_telefono" class="input-field">
            </div>
            <div>
                <label for="c_correo" class="label-field">Correo</label>
                <input type="email" name="correo" id="c_correo" class="input-field">
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button type="submit" class="btn-primary flex-1">Crear Cliente</button>
            <button type="button" @click="$dispatch('close-modal-new-cliente')" class="btn-secondary">Cancelar</button>
        </div>
    </form>
</x-modal>
@endsection
