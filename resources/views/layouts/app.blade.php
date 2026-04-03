<!DOCTYPE html>
<html lang="es" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="SPA Armonía - Tu espacio de relajación y bienestar. Reserva masajes, tratamientos faciales y más.">

    <title>@yield('title', 'SPA Armonía')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col">

    @hasSection('no-navbar')
    @else
        <x-navbar />
    @endif

    {{-- Flash Messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg bg-primary-600 text-white font-medium animate-slide-down"
             id="flash-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div x-data="{ show: true }" x-show="show"
             class="fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg bg-red-600 text-white font-medium animate-slide-down max-w-md"
             id="flash-error">
            <button @click="show = false" class="absolute top-1 right-2 text-white/80 hover:text-white">&times;</button>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    @hasSection('no-footer')
    @else
        <x-footer />
    @endif

    @stack('scripts')
</body>
</html>
