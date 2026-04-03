{{-- Service Card Component --}}
@props(['servicio'])

<article class="card-hover p-6 flex flex-col h-full" id="service-card-{{ $servicio->id_servicio ?? '' }}">
    <div class="flex-1">
        <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center mb-4">
            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
            {{ $servicio->nombre_servicio }}
        </h3>

        @if($servicio->descripcion)
            <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-4">
                {{ $servicio->descripcion }}
            </p>
        @endif
    </div>

    <div class="mt-4 flex items-center justify-between pt-4 border-t border-gray-100 dark:border-surface-700">
        <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">
            ${{ number_format($servicio->precio, 0, ',', '.') }}
        </span>
    </div>
</article>
