@extends('layouts.app')

@section('title', "Historial de $sectorNombre")

@section('content')
    <div class="w-full min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
        <!-- Header Section -->
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
                <div class="mb-6 lg:mb-0">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-white rounded-2xl shadow-sm">
                            <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg"></div>
                        </div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                            Historial de Detecciones
                        </h1>
                    </div>
                    <p class="text-gray-500 mt-2 font-medium">{{ $sectorNombre }}</p>
                </div>

                <!-- Stats Cards -->
                <div class="flex space-x-4">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-4 shadow-sm border border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Total</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $cantidad }}</p>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-4 shadow-sm border border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Tiempo Promedio</p>
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($tiempo_promedio, 2) }}s</p>
                    </div>
                </div>
            </div>

            <!-- Detections Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($detecciones as $d)
                    <div class="group bg-white/90 backdrop-blur-sm rounded-3xl p-6 shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-gray-200">
                        <!-- Image Container -->
                        <div class="relative mb-4 overflow-hidden rounded-2xl">
                            <img
                                src="{{ $d->imagen_url }}"
                                alt="Imagen de detección"
                                class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500"
                            >
                            <div class="absolute top-3 right-3">
                                <span class="px-3 py-1 bg-white/90 backdrop-blur-sm rounded-full text-xs font-semibold text-gray-700">
                                    {{ $d->confianza }}%
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <h3 class="font-bold text-gray-800 text-lg truncate">{{ $d->enfermedad }}</h3>
                            </div>

                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                <span>Tiempo: {{ number_format($d->tiempo_deteccion, 2) }}s</span>
                            </div>

                            @if($d->observaciones)
                                <div class="bg-blue-50 rounded-xl p-3">
                                    <p class="text-sm text-blue-700 font-medium">📝 {{ $d->observaciones }}</p>
                                </div>
                            @endif

                            @if($d->recomendacion)
                                <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-4 border border-emerald-100">
                                    <div class="flex items-center space-x-2 mb-3">
                                        <div class="w-8 h-8 bg-gradient-to-r from-emerald-500 to-green-500 rounded-lg flex items-center justify-center">
                                            <span class="text-white text-sm">💡</span>
                                        </div>
                                        <h4 class="font-bold text-gray-800">Plan de Acción</h4>
                                    </div>

                                    <div class="space-y-2">
                                        @php
                                            // Convertir el string JSON a array y limpiar cada item
                                            $recomendaciones = json_decode($d->recomendacion, true);
                                            if (is_string($recomendaciones)) {
                                                $recomendaciones = json_decode($recomendaciones, true);
                                            }
                                            $recomendaciones = array_slice($recomendaciones, 0, 5); // Mostrar máximo 5
                                        @endphp

                                        @foreach($recomendaciones as $index => $recomendacion)
                                            <div class="flex items-start space-x-3 group/item hover:bg-white/50 rounded-lg p-2 transition-colors">
                                                <div class="flex-shrink-0 w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center mt-0.5">
                                                    <span class="text-emerald-600 text-xs font-bold">{{ $index + 1 }}</span>
                                                </div>
                                                <p class="text-sm text-gray-700 leading-relaxed flex-1">{{ $recomendacion }}</p>
                                            </div>
                                        @endforeach

                                        @if(count($recomendaciones) > 5)
                                            <div class="pt-2 border-t border-emerald-100">
                                                <p class="text-xs text-emerald-600 font-medium text-center">
                                                    +{{ count($recomendaciones) - 5 }} recomendaciones más
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-400 font-medium">
                                    {{ $d->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-3xl mx-auto mb-4 flex items-center justify-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                        </div>
                        <p class="text-gray-500 text-lg font-medium">No hay detecciones registradas</p>
                        <p class="text-gray-400 text-sm mt-1">Este sector aún no tiene historial de detecciones</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
