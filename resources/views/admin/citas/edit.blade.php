@extends('layouts.app')
@section('title', 'Editar Cita #' . $cita->id_cita . ' - SPA Armonía')
@section('content')
<div class="bg-surface-50 dark:bg-surface-900 min-h-[calc(100vh-4rem)]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ route('admin.citas.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-primary-600 mb-6">&larr; Volver a citas</a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Editar Cita #{{ $cita->id_cita }}</h1>
        <form method="POST" action="{{ route('admin.citas.update', $cita->id_cita) }}" class="card p-6" x-data="{ serviciosArr: @js($cita->servicios->map(fn($s)=>['id'=>$s->id_servicio,'nombre'=>$s->nombre_servicio,'precio'=>$s->precio,'duracion'=>$s->pivot->duracion??60])) }">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div><label class="label-field">Masajista *</label>
                    <select name="masajista" class="select-field" required>
                        @foreach($masajistas as $m)
                            <option value="{{ $m->cedula }}" {{ $cita->masajista == $m->cedula ? 'selected' : '' }}>{{ $m->nombre_masajista }}</option>
                        @endforeach
                    </select>
                </div>
                <div><label class="label-field">Habitación</label><input type="number" name="habitacion" value="{{ $cita->habitacion }}" class="input-field"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div><label class="label-field">Fecha *</label><input type="datetime-local" name="fecha" value="{{ $cita->fecha->format('Y-m-d\TH:i') }}" class="input-field" required></div>
                <div><label class="label-field">Estado</label>
                    <select name="estado" class="select-field">
                        @foreach(['pendiente','confirmada','cancelada','finalizada'] as $e)
                            <option value="{{ $e }}" {{ $cita->estado === $e ? 'selected' : '' }}>{{ ucfirst($e) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-4"><label class="label-field">Notas</label><textarea name="nota" rows="3" class="input-field">{{ $cita->nota }}</textarea></div>
            <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Servicios</h3>
            <template x-for="(srv, i) in serviciosArr" :key="i">
                <div class="flex items-center gap-3 mb-2 p-3 bg-surface-50 dark:bg-surface-700/50 rounded-lg">
                    <input type="hidden" :name="'servicios['+i+'][id_servicio]'" :value="srv.id">
                    <span class="flex-1 font-medium text-gray-900 dark:text-white" x-text="srv.nombre"></span>
                    <input type="number" :name="'servicios['+i+'][duracion]'" x-model="srv.duracion" class="input-field w-24 text-sm" min="1">
                    <button type="button" @click="serviciosArr.splice(i,1)" class="text-red-400 hover:text-red-600">&times;</button>
                </div>
            </template>
            <div class="flex gap-4 mt-6">
                <button type="submit" class="btn-primary flex-1">Guardar Cambios</button>
                <a href="{{ route('admin.citas.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
