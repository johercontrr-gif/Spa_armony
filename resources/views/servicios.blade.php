@extends('layouts.app')

@section('title', 'Servicios - SPA Armonía')

@section('content')
<section class="py-16 bg-surface-50 dark:bg-surface-900" id="servicios-page">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Nuestros Servicios</h1>
            <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Encuentra el tratamiento perfecto para ti</p>
        </div>

        {{-- Filters --}}
        <div class="card p-4 mb-8">
            <form method="GET" action="{{ route('servicios') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar servicio..."
                           class="input-field" id="search-servicios">
                </div>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Buscar
                </button>
            </form>
        </div>

        {{-- Services Grid --}}
        @if($servicios->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($servicios as $servicio)
                    <x-service-card :servicio="$servicio" />
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-gray-500 dark:text-gray-400 text-lg">No se encontraron servicios.</p>
            </div>
        @endif
    </div>
</section>
@endsection
