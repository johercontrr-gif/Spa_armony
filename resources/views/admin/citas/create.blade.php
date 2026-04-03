@extends('layouts.app')

@section('title', 'Nueva Cita - SPA Armonía')

@section('content')
<div class="bg-surface-50 dark:bg-surface-900 min-h-[calc(100vh-4rem)]" id="cita-create-page">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header Banner --}}
        <div class="bg-gradient-to-r from-primary-500 to-primary-700 rounded-2xl p-8 mb-8 relative overflow-hidden" id="cita-header-banner">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/4"></div>
            <h1 class="text-2xl font-bold text-white relative z-10">Nueva Cita</h1>
            <p class="text-primary-100 mt-1 relative z-10">Agenda una nueva cita para tus clientes</p>
        </div>

        <form method="POST" action="{{ route('admin.citas.store') }}" id="form-nueva-cita" x-data="citaForm()">
            @csrf

            {{-- Client Section --}}
            <div class="card p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Información del Cliente</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Selecciona un cliente existente o registra uno nuevo</p>

                {{-- Toggle --}}
                <div class="flex gap-2 mb-6">
                    <button type="button" @click="clienteNuevo = false"
                            :class="!clienteNuevo ? 'btn-primary' : 'btn-secondary'" class="text-sm">
                        Cliente Existente
                    </button>
                    <button type="button" @click="clienteNuevo = true"
                            :class="clienteNuevo ? 'btn-primary' : 'btn-secondary'" class="text-sm">
                        Cliente Nuevo
                    </button>
                </div>

                <template x-if="!clienteNuevo">
                    <div>
                        <label for="id_cliente" class="label-field">Seleccionar Cliente *</label>
                        <select name="id_cliente" id="id_cliente" class="select-field" required>
                            <option value="">Selecciona un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->cedula }}">{{ $cliente->cedula }} - {{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </template>

                <template x-if="clienteNuevo">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="new_cedula" class="label-field">Cédula *</label>
                            <input type="number" id="new_cedula" x-model="newCliente.cedula" class="input-field" placeholder="1001234567" required>
                        </div>
                        <div>
                            <label for="new_nombre" class="label-field">Nombre Completo *</label>
                            <input type="text" id="new_nombre" x-model="newCliente.nombre" class="input-field" placeholder="María González" required>
                        </div>
                        <div>
                            <label for="new_telefono" class="label-field">Teléfono *</label>
                            <input type="text" id="new_telefono" x-model="newCliente.telefono" class="input-field" placeholder="3121234567">
                        </div>
                        <div>
                            <label for="new_correo" class="label-field">Email *</label>
                            <input type="email" id="new_correo" x-model="newCliente.correo" class="input-field" placeholder="maria@email.com">
                        </div>
                    </div>
                </template>
            </div>

            {{-- Appointment Details --}}
            <div class="card p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Detalles de la Cita</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Configura la fecha, hora y asignación</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="masajista" class="label-field">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Masajista *
                            </span>
                        </label>
                        <select name="masajista" id="masajista" class="select-field" required>
                            <option value="">Selecciona un masajista</option>
                            @foreach($masajistas as $m)
                                <option value="{{ $m->cedula }}">{{ $m->nombre_masajista }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="habitacion" class="label-field">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                Habitación
                            </span>
                        </label>
                        <select name="habitacion" id="habitacion" class="select-field">
                            <option value="">Selecciona una habitación</option>
                            @for($i = 101; $i <= 110; $i++)
                                <option value="{{ $i }}">Habitación {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="fecha" class="label-field">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Fecha *
                            </span>
                        </label>
                        <input type="date" name="fecha_date" id="fecha_date" class="input-field" min="{{ date('Y-m-d') }}" required>
                    </div>
                    <div>
                        <label for="hora" class="label-field">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Hora *
                            </span>
                        </label>
                        <select name="hora" id="hora" class="select-field" required>
                            <option value="">Selecciona una hora</option>
                            @for($h = 8; $h <= 20; $h++)
                                <option value="{{ sprintf('%02d', $h) }}:00">{{ sprintf('%02d', $h) }}:00</option>
                                <option value="{{ sprintf('%02d', $h) }}:30">{{ sprintf('%02d', $h) }}:30</option>
                            @endfor
                        </select>
                    </div>
                </div>

                {{-- Hidden combined fecha field --}}
                <input type="hidden" name="fecha" :value="combineFecha()" id="fecha-hidden">

                <div class="mb-4">
                    <label for="estado" class="label-field">Estado de la Cita</label>
                    <select name="estado" id="estado" class="select-field">
                        <option value="pendiente" selected>Pendiente</option>
                        <option value="confirmada">Confirmada</option>
                    </select>
                </div>

                <div>
                    <label for="nota" class="label-field">Notas (opcional)</label>
                    <textarea name="nota" id="nota" rows="3" class="input-field" placeholder="Preferencias, alergias, comentarios especiales..."></textarea>
                </div>
            </div>

            {{-- Services Section --}}
            <div class="card p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Servicios</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Agrega los servicios que incluirá esta cita</p>

                {{-- Add Service --}}
                <div class="mb-4">
                    <label class="label-field">Agregar Servicio</label>
                    <select @change="addServicio($event.target.value); $event.target.value = ''" class="select-field" id="add-servicio-select">
                        <option value="">Selecciona un servicio para agregar</option>
                        @foreach($servicios as $srv)
                            <option value="{{ $srv->id_servicio }}" data-nombre="{{ $srv->nombre_servicio }}" data-precio="{{ $srv->precio }}">
                                {{ $srv->nombre_servicio }} - ${{ number_format($srv->precio, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Selected Services --}}
                <template x-if="selectedServicios.length > 0">
                    <div class="space-y-3">
                        <template x-for="(srv, index) in selectedServicios" :key="index">
                            <div class="flex items-center gap-4 p-4 bg-surface-50 dark:bg-surface-700/50 rounded-lg">
                                <input type="hidden" :name="'servicios['+index+'][id_servicio]'" :value="srv.id">
                                <div class="flex-1">
                                    <span class="font-medium text-gray-900 dark:text-white" x-text="srv.nombre"></span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 ml-2" x-text="'$' + srv.precio.toLocaleString()"></span>
                                </div>
                                <div class="w-32">
                                    <input type="number" :name="'servicios['+index+'][duracion]'" x-model="srv.duracion" class="input-field text-sm" placeholder="min" min="1">
                                </div>
                                <button type="button" @click="removeServicio(index)" class="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </template>

                        {{-- Total --}}
                        <div class="flex items-center justify-between p-4 bg-primary-50 dark:bg-primary-900/20 rounded-lg border border-primary-200 dark:border-primary-800">
                            <span class="font-semibold text-primary-700 dark:text-primary-300">Total</span>
                            <span class="text-xl font-bold text-primary-700 dark:text-primary-300" x-text="'$' + totalServicios.toLocaleString()"></span>
                        </div>
                    </div>
                </template>

                <template x-if="selectedServicios.length === 0">
                    <p class="text-gray-400 dark:text-gray-500 text-center py-4">No se han agregado servicios aún.</p>
                </template>
            </div>

            {{-- Submit --}}
            <div class="flex gap-4">
                <button type="submit" class="btn-primary flex-1 text-base py-3" id="btn-submit-cita">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Crear Cita
                </button>
                <a href="{{ route('admin.citas.index') }}" class="btn-secondary text-base py-3">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function citaForm() {
    return {
        clienteNuevo: false,
        newCliente: { cedula: '', nombre: '', telefono: '', correo: '' },
        selectedServicios: [],

        get totalServicios() {
            return this.selectedServicios.reduce((sum, s) => sum + s.precio, 0);
        },

        combineFecha() {
            const date = document.getElementById('fecha_date')?.value || '';
            const hora = document.getElementById('hora')?.value || '00:00';
            return date ? `${date}T${hora}:00` : '';
        },

        addServicio(id) {
            if (!id) return;
            if (this.selectedServicios.find(s => s.id == id)) return;

            const option = document.querySelector(`#add-servicio-select option[value="${id}"]`);
            this.selectedServicios.push({
                id: parseInt(id),
                nombre: option.dataset.nombre,
                precio: parseInt(option.dataset.precio),
                duracion: 60
            });
        },

        removeServicio(index) {
            this.selectedServicios.splice(index, 1);
        }
    };
}
</script>
@endpush
@endsection
