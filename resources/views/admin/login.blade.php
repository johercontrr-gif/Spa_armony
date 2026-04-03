@extends('layouts.app')

@section('title', 'Iniciar Sesión - SPA Armonía')
@section('no-footer', true)

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12 bg-surface-50 dark:bg-surface-900" id="login-page">
    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">SPA Armonía</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Panel de Administración</p>
        </div>

        {{-- Login Card --}}
        <div class="card p-8">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Iniciar Sesión</h2>

            <form method="POST" action="{{ route('login.submit') }}" id="login-form">
                @csrf

                <div class="mb-5">
                    <label for="usuario" class="label-field">Usuario</label>
                    <input type="text" name="usuario" id="usuario" value="{{ old('usuario') }}" required autofocus
                           class="input-field @error('usuario') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="Ingresa tu usuario">
                    @error('usuario')
                        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="contrasena" class="label-field">Contraseña</label>
                    <div class="relative" x-data="{ showPassword: false }">
                        <input :type="showPassword ? 'text' : 'password'" name="contrasena" id="contrasena" required
                               class="input-field pr-10"
                               placeholder="Ingresa tu contraseña">
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full text-base py-3" id="btn-login">
                    Ingresar
                </button>
            </form>
        </div>

        <p class="text-center mt-6 text-sm text-gray-400 dark:text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">&larr; Volver al inicio</a>
        </p>
    </div>
</div>
@endsection
