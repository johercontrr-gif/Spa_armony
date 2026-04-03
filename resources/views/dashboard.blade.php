@extends('layouts.app')

@section('title', 'Dashboard - SPA Armonía')

@section('content')
<div class="bg-surface-50 dark:bg-surface-900 min-h-[calc(100vh-4rem)]" id="dashboard-page">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Resumen general de SPA Armonía</p>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Citas --}}
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalCitas }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Total Citas</div>
            </div>

            {{-- Citas Hoy --}}
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $citasHoy }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Citas Hoy</div>
            </div>

            {{-- Clientes --}}
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalClientes }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Clientes</div>
            </div>

            {{-- Masajistas --}}
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalMasajistas }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Masajistas</div>
            </div>
        </div>

        {{-- Quick Actions + Recent Citas --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Quick Actions --}}
            <div class="card p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Acciones Rápidas</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.citas.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary-50 dark:hover:bg-surface-700 transition-colors group">
                        <div class="w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center group-hover:bg-primary-200 dark:group-hover:bg-primary-900/50 transition-colors">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Nueva Cita</span>
                    </a>
                    <a href="{{ route('admin.clientes.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 dark:hover:bg-surface-700 transition-colors group">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Ver Clientes</span>
                    </a>
                    <a href="{{ route('admin.masajistas.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-purple-50 dark:hover:bg-surface-700 transition-colors group">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Ver Masajistas</span>
                    </a>
                    <a href="{{ route('admin.servicios.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-amber-50 dark:hover:bg-surface-700 transition-colors group">
                        <div class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Ver Servicios</span>
                    </a>
                </div>
            </div>

            {{-- Recent Citas --}}
            <div class="lg:col-span-2 card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Citas Recientes</h2>
                    <a href="{{ route('admin.citas.index') }}" class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 font-medium">Ver todas &rarr;</a>
                </div>

                @if($citasRecientes->count() > 0)
                    <div class="space-y-4">
                        @foreach($citasRecientes as $cita)
                            <div class="flex items-center gap-4 p-4 rounded-lg bg-surface-50 dark:bg-surface-700/50">
                                {{-- Avatar --}}
                                <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-700 dark:text-primary-400 font-bold text-sm shrink-0">
                                    {{ strtoupper(substr($cita->cliente->nombre ?? '?', 0, 2)) }}
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-900 dark:text-white truncate">{{ $cita->cliente->nombre ?? 'N/A' }}</span>
                                        <x-badge :estado="$cita->estado" />
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ $cita->fecha->format('d M Y, H:i') }} · {{ $cita->masajistaRelation->nombre_masajista ?? 'N/A' }}
                                    </div>
                                </div>

                                {{-- Total --}}
                                <div class="text-right shrink-0">
                                    <span class="font-bold text-gray-900 dark:text-white">${{ number_format($cita->total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">No hay citas registradas aún.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
