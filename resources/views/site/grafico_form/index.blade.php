@extends('layouts.app')

@section('title', 'Gráficos de Satisfacción')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Resultados de Encuesta de Satisfacción</h1>
                <p class="text-gray-600 mt-2">Análisis detallado de las respuestas de los usuarios</p>
            </div>

            @php
                // Calcular métricas desde las preguntas y respuestas
                $totalUsuarios = collect();
                $totalRespuestas = 0;
                $sumaPuntuaciones = 0;

                foreach($preguntas as $pregunta) {
                    foreach($pregunta->respuestas as $respuesta) {
                        if ($respuesta->user) {
                            $totalUsuarios->put($respuesta->user_id, $respuesta->user);
                        }
                        $totalRespuestas++;
                        $sumaPuntuaciones += $respuesta->puntuacion;
                    }
                }

                $promedioGeneral = $totalRespuestas > 0 ? $sumaPuntuaciones / $totalRespuestas : 0;
                $usuariosUnicos = $totalUsuarios->count();
            @endphp

                <!-- Resumen General -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-blue-100">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Usuarios</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $usuariosUnicos }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-green-100">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Preguntas</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $preguntas->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-purple-100">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Respuestas Totales</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalRespuestas }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-amber-100">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Puntuación Promedio</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ number_format($promedioGeneral, 1) }}/5
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos por Pregunta -->
            <div class="space-y-8">
                @foreach($preguntas as $pregunta)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <!-- Header de la Pregunta -->
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <span class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">
                            {{ $loop->iteration }}
                        </span>
                                {{ $pregunta->pregunta }}
                            </h3>
                            <div class="mt-2 flex flex-wrap gap-4 text-sm text-gray-600">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $pregunta->respuestas->count() }} respuestas
                        </span>
                                <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            Promedio: {{ number_format($pregunta->respuestas->avg('puntuacion') ?? 0, 2) }}/5
                        </span>
                            </div>
                        </div>

                        <!-- Contenido: Gráfico y Tabla -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Gráfico de Barras -->
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">Distribución de Respuestas</h4>
                                    <div class="space-y-3">
                                        @php
                                            $distribucion = [];
                                            for ($i = 1; $i <= 5; $i++) {
                                                $distribucion[$i] = $pregunta->respuestas->where('puntuacion', $i)->count();
                                            }
                                            $maxCount = max($distribucion) ?: 1;
                                        @endphp

                                        @foreach($distribucion as $puntuacion => $count)
                                            <div class="flex items-center">
                                                <span class="w-16 text-sm font-medium text-gray-600">{{ $puntuacion }} ★</span>
                                                <div class="flex-1 ml-2">
                                                    <div class="bg-gray-200 rounded-full h-6 overflow-hidden">
                                                        <div
                                                            class="h-6 rounded-full transition-all duration-500 ease-out {{ [
                                                    1 => 'bg-red-500',
                                                    2 => 'bg-orange-500',
                                                    3 => 'bg-yellow-500',
                                                    4 => 'bg-lime-500',
                                                    5 => 'bg-green-500'
                                                ][$puntuacion] }}"
                                                            style="width: {{ ($count / $maxCount) * 100 }}%"
                                                        ></div>
                                                    </div>
                                                </div>
                                                <span class="w-12 text-right text-sm font-semibold text-gray-700 ml-2">
                                        {{ $count }}
                                    </span>
                                                <span class="w-16 text-right text-sm text-gray-500">
                                        ({{ $pregunta->respuestas->count() > 0 ? number_format(($count / $pregunta->respuestas->count()) * 100, 1) : 0 }}%)
                                    </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Gráfico Circular -->
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">Resumen Visual</h4>
                                    <div class="flex items-center justify-center">
                                        <div class="relative w-48 h-48">
                                            @php
                                                $totalRespuestasPregunta = $pregunta->respuestas->count();
                                                $porcentajes = [];
                                                for ($i = 1; $i <= 5; $i++) {
                                                    $porcentajes[$i] = $totalRespuestasPregunta > 0 ? ($distribucion[$i] / $totalRespuestasPregunta) * 100 : 0;
                                                }

                                                $colors = [
                                                    1 => '#ef4444',
                                                    2 => '#f97316',
                                                    3 => '#eab308',
                                                    4 => '#84cc16',
                                                    5 => '#22c55e'
                                                ];

                                                $currentAngle = 0;
                                            @endphp

                                            <svg class="w-full h-full" viewBox="0 0 100 100">
                                                @foreach($porcentajes as $puntuacion => $porcentaje)
                                                    @if($porcentaje > 0)
                                                        <circle
                                                            cx="50"
                                                            cy="50"
                                                            r="40"
                                                            fill="transparent"
                                                            stroke="{{ $colors[$puntuacion] }}"
                                                            stroke-width="20"
                                                            stroke-dasharray="{{ 2 * pi() * 40 }}"
                                                            stroke-dashoffset="{{ 2 * pi() * 40 * (1 - $currentAngle / 100) }}"
                                                            transform="rotate(-90 50 50)"
                                                        />
                                                        @php $currentAngle += $porcentaje; @endphp
                                                    @endif
                                                @endforeach

                                                <text x="50" y="50" text-anchor="middle" dy="0.3em" font-size="12" font-weight="bold" fill="#374151">
                                                    {{ number_format($pregunta->respuestas->avg('puntuacion') ?? 0, 1) }}
                                                </text>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex justify-center">
                                        <div class="grid grid-cols-5 gap-2 text-xs">
                                            @foreach($colors as $puntuacion => $color)
                                                <div class="flex items-center">
                                                    <div class="w-3 h-3 rounded-full mr-1" style="background-color: {{ $color }}"></div>
                                                    <span>{{ $puntuacion }}★</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de Respuestas Detalladas (SIN NOMBRES) -->
                            <div class="mt-6">
                                <h4 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">Resumen de Respuestas</h4>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                        <tr class="bg-gray-50 border-b border-gray-200">
                                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Puntuación</th>
                                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Cantidad</th>
                                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Porcentaje</th>
                                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Distribución</th>
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                        @foreach($distribucion as $puntuacion => $count)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-4 py-3 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ [
                                                1 => 'bg-red-100 text-red-800',
                                                2 => 'bg-orange-100 text-orange-800',
                                                3 => 'bg-yellow-100 text-yellow-800',
                                                4 => 'bg-lime-100 text-lime-800',
                                                5 => 'bg-green-100 text-green-800'
                                            ][$puntuacion] }}">
                                                {{ $puntuacion }} ★
                                            </span>
                                                </td>
                                                <td class="px-4 py-3 text-center text-gray-700 font-semibold">
                                                    {{ $count }}
                                                </td>
                                                <td class="px-4 py-3 text-center text-gray-600">
                                                    {{ $pregunta->respuestas->count() > 0 ? number_format(($count / $pregunta->respuestas->count()) * 100, 1) : 0 }}%
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="flex justify-center">
                                                        <div class="w-32 bg-gray-200 rounded-full h-3 overflow-hidden">
                                                            <div
                                                                class="h-3 rounded-full {{ [
                                                            1 => 'bg-red-500',
                                                            2 => 'bg-orange-500',
                                                            3 => 'bg-yellow-500',
                                                            4 => 'bg-lime-500',
                                                            5 => 'bg-green-500'
                                                        ][$puntuacion] }}"
                                                                style="width: {{ $pregunta->respuestas->count() > 0 ? ($count / $pregunta->respuestas->count()) * 100 : 0 }}%"
                                                            ></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!-- Fila de total -->
                                        <tr class="bg-gray-50 font-semibold">
                                            <td class="px-4 py-3 text-center text-gray-700">Total</td>
                                            <td class="px-4 py-3 text-center text-gray-700">{{ $pregunta->respuestas->count() }}</td>
                                            <td class="px-4 py-3 text-center text-gray-700">100%</td>
                                            <td class="px-4 py-3 text-center text-gray-700">-</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Sección eliminada: Resumen de Usuarios -->

        </div>
    </div>

    <style>
        .animate-grow {
            animation: grow 1s ease-out forwards;
        }

        @keyframes grow {
            from { transform: scaleX(0); }
            to { transform: scaleX(1); }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animación para las barras de progreso
            const progressBars = document.querySelectorAll('.bg-gray-200 > div');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        });
    </script>
@endsection
