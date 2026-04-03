@extends('layouts.app')

@section('title', 'SPA Armonía - Tu espacio de relajación y bienestar')

@section('content')
{{-- Hero Section --}}
<section class="relative overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900" id="hero">
    {{-- Decorative elements --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-primary-300 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
        <div class="max-w-3xl">
            <h1 class="text-4xl md:text-6xl font-bold text-white leading-tight animate-fade-in">
                Tu espacio de
                <span class="text-primary-200">relajación</span>
                y bienestar
            </h1>
            <p class="mt-6 text-lg md:text-xl text-primary-100 leading-relaxed max-w-2xl animate-slide-up">
                Descubre nuestros tratamientos exclusivos diseñados para renovar tu cuerpo y mente. En SPA Armonía, cada momento es una experiencia de paz.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4 animate-slide-up">
                <a href="{{ route('servicios') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-primary-700 font-bold rounded-xl hover:bg-primary-50 transition-all duration-300 shadow-lg hover:shadow-xl text-lg" id="hero-cta-servicios">
                    Ver Todos los Servicios
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </div>

    {{-- Wave decoration --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" class="fill-surface-50 dark:fill-surface-900"/>
        </svg>
    </div>
</section>

{{-- Stats Section --}}
<section class="py-12 -mt-1 bg-surface-50 dark:bg-surface-900" id="stats">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-primary-600 dark:text-primary-400">500+</div>
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Clientes Felices</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-primary-600 dark:text-primary-400">15+</div>
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tratamientos</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-primary-600 dark:text-primary-400">8+</div>
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Especialistas</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-primary-600 dark:text-primary-400">5★</div>
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Calificación</div>
            </div>
        </div>
    </div>
</section>

{{-- Services Section --}}
<section class="py-20 bg-surface-50 dark:bg-surface-900" id="servicios-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                Nuestros Servicios
            </h2>
            <p class="mt-4 text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                Descubre nuestra amplia gama de tratamientos diseñados para tu bienestar
            </p>
        </div>

        @if($servicios->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($servicios as $servicio)
                    <div class="animate-slide-up" style="animation-delay: {{ $loop->index * 100 }}ms">
                        <x-service-card :servicio="$servicio" />
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('servicios') }}" class="btn-secondary text-base">
                    Ver todos los servicios
                    <svg class="w-4 h-4 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 dark:text-gray-400">No hay servicios disponibles aún.</p>
            </div>
        @endif
    </div>
</section>

{{-- CTA Section --}}
<section class="py-20 bg-gradient-to-r from-primary-600 to-primary-800 relative overflow-hidden" id="cta-section">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
            Nuestros especialistas te esperan
        </h2>
        <p class="text-lg text-primary-100 mb-10 max-w-2xl mx-auto">
            Vive una experiencia de bienestar única. Descubre todo lo que SPA Armonía puede ofrecerte y renueva tu energía con nosotros.
        </p>
        <a href="{{ route('servicios') }}" class="inline-flex items-center justify-center px-10 py-4 bg-white text-primary-700 font-bold rounded-xl hover:bg-primary-50 transition-all duration-300 shadow-lg hover:shadow-xl text-lg" id="cta-reservar">
            Explorar Tratamientos
        </a>
    </div>
</section>
@endsection
