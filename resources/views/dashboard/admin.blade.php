@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">

    <h1 class="text-3xl font-bold mb-8 text-gray-800">Dashboard Administrativo</h1>

    {{-- Tarjetas de resumen mejoradas --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white shadow-lg rounded-xl p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-600 mb-2">Total Detecciones</h2>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalDetecciones }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-xl p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-600 mb-2">Detecciones Hoy</h2>
                    <p class="text-3xl font-bold text-gray-800">{{ $deteccionesHoy }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-xl p-6 border-l-4 border-purple-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-600 mb-2">Sectores Activos</h2>
                    <p class="text-3xl font-bold text-gray-800">{{ $sectoresActivos }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-xl p-6 border-l-4 border-amber-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-600 mb-2">Usuarios Activos</h2>
                    <p class="text-3xl font-bold text-gray-800">{{ $usuariosActivos }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráfico de crecimiento de detecciones --}}
{{-- En la sección de gráficos, actualiza esto: --}}

    {{-- Métricas de precisión mejoradas --}}
    <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
        <h2 class="text-xl font-semibold mb-6 text-gray-700">Precisión del Sistema</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- Precisión Humedad --}}
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-gray-700">Precisión Humedad</h3>
                    <span class="text-2xl font-bold @if($precisionPromedioHumedad >= 90) text-green-600 @else text-amber-600 @endif">
                        {{ $precisionPromedioHumedad }}%
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-green-500 h-3 rounded-full transition-all duration-500"
                         style="width: {{ $precisionPromedioHumedad }}%"></div>
                </div>
            </div>

            {{-- Precisión Temperatura --}}
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-gray-700">Precisión Temperatura</h3>
                    <span class="text-2xl font-bold @if($precisionPromedioTemperatura >= 90) text-green-600 @else text-amber-600 @endif">
                        {{ $precisionPromedioTemperatura }}%
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-blue-500 h-3 rounded-full transition-all duration-500"
                         style="width: {{ $precisionPromedioTemperatura }}%"></div>
                </div>
            </div>
        </div>

        {{-- Tabla de precisión detallada --}}
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-3 text-left font-semibold text-gray-700">Hora</th>
                        <th class="border px-4 py-3 text-center font-semibold text-gray-700">Humedad Medida</th>
                        <th class="border px-4 py-3 text-center font-semibold text-gray-700">Referencia</th>
                        <th class="border px-4 py-3 text-center font-semibold text-gray-700">Precisión</th>
                        <th class="border px-4 py-3 text-center font-semibold text-gray-700">Temp. Medida</th>
                        <th class="border px-4 py-3 text-center font-semibold text-gray-700">Referencia</th>
                        <th class="border px-4 py-3 text-center font-semibold text-gray-700">Precisión</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datosPrecision as $dato)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="border px-4 py-2 text-gray-600">{{ $dato['hora'] }}</td>
                            <td class="border px-4 py-2 text-center">{{ $dato['humedad_medida'] }}%</td>
                            <td class="border px-4 py-2 text-center text-gray-500">{{ $dato['humedad_referencia'] }}%</td>
                            <td class="border px-4 py-2 text-center">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium @if($dato['humedad_prec'] >= 90) bg-green-100 text-green-800 @elseif($dato['humedad_prec'] >= 80) bg-amber-100 text-amber-800 @else bg-red-100 text-red-800 @endif">
                                    {{ $dato['humedad_prec'] }}%
                                </span>
                            </td>
                            <td class="border px-4 py-2 text-center">{{ $dato['temp_medida'] }}°C</td>
                            <td class="border px-4 py-2 text-center text-gray-500">{{ $dato['temp_referencia'] }}°C</td>
                            <td class="border px-4 py-2 text-center">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium @if($dato['temp_prec'] >= 90) bg-green-100 text-green-800 @elseif($dato['temp_prec'] >= 80) bg-amber-100 text-amber-800 @else bg-red-100 text-red-800 @endif">
                                    {{ $dato['temp_prec'] }}%
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de crecimiento de detecciones
        const deteccionesCtx = document.getElementById('deteccionesChart').getContext('2d');
        const deteccionesChart = new Chart(deteccionesCtx, {
            type: 'line',
            data: {
                labels: @json($deteccionesMensualesLabels),
                datasets: [{
                    label: 'Detecciones Mensuales',
                    data: @json($deteccionesMensualesData),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Número de Detecciones'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Meses'
                        }
                    }
                }
            }
        });

        // Gráfico de distribución por enfermedad
        const enfermedadesCtx = document.getElementById('enfermedadesChart').getContext('2d');
        const enfermedadesChart = new Chart(enfermedadesCtx, {
            type: 'doughnut',
            data: {
                labels: @json($enfermedadesLabels),
                datasets: [{
                    data: @json($enfermedadesData),
                    backgroundColor: [
                        '#ef4444', '#f59e0b', '#10b981', '#3b82f6',
                        '#8b5cf6', '#ec4899', '#06b6d4', '#84cc16'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    });
</script>
@endpush
