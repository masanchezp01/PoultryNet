@extends('layouts.app')

@section('title', 'Ambiente')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100/70 py-8 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8">
                <div class="mb-6 lg:mb-0">
                    <h1 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent mb-2">
                        Configuraciones Ambientales
                    </h1>
                    <p class="text-slate-500 flex items-center gap-2 text-sm">
                        <i class="fas fa-wave-square text-emerald-500"></i>
                        Sistema de monitoreo ambiental avanzado
                    </p>
                </div>
                <a href="{{ route('registros_ambientales.create') }}"
                   class="group relative overflow-hidden bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-6 py-3 rounded-xl hover:shadow-lg hover:shadow-emerald-500/25 transition-all duration-300 hover:scale-105">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-plus-circle"></i>
                        <span class="font-semibold">Nuevo Registro</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-white/5 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Total Configuraciones</p>
                            <p class="text-2xl font-bold text-slate-800" id="totalConfig">0</p>
                        </div>
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-sliders-h text-emerald-600 text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Sectores Activos</p>
                            <p class="text-2xl font-bold text-slate-800" id="totalSectores">0</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-blue-600 text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Última Actualización</p>
                            <p class="text-sm font-semibold text-slate-800" id="ultimaActualizacion">-</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-clock text-purple-600 text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Table Container -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-slate-200/60 bg-gradient-to-r from-slate-50 to-slate-100/50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-table text-emerald-600"></i>
                            Configuraciones Registradas
                        </h3>
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                                <input type="text" placeholder="Buscar..." class="pl-10 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                        <tr class="bg-slate-100/80 border-b border-slate-200/60">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-emerald-600 text-xs"></i>
                                    Sector
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-thermometer-half text-blue-600 text-xs"></i>
                                    Temp Ideal (°C)
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-exclamation-triangle text-orange-600 text-xs"></i>
                                    Temp Crítica (°C)
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-tint text-cyan-600 text-xs"></i>
                                    Humedad Ideal (%)
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-wind text-red-600 text-xs"></i>
                                    Humedad Crítica (%)
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/60">
                        @forelse ($registros as $registro)
                            <tr class="hover:bg-slate-50/80 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
                                            <i class="fas fa-map-marker-alt text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-800">{{ $registro->sector->nombre ?? 'Sin sector' }}</div>
                                            <div class="text-xs text-slate-500">Sector ambiental</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="bg-blue-50 text-blue-700 px-3 py-2 rounded-lg text-sm font-medium border border-blue-200/60">
                                        {{ $registro->temp_min_ideal }} - {{ $registro->temp_max_ideal }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="bg-orange-50 text-orange-700 px-3 py-2 rounded-lg text-sm font-medium border border-orange-200/60">
                                        {{ $registro->temp_min_critica }} - {{ $registro->temp_max_critica }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="bg-cyan-50 text-cyan-700 px-3 py-2 rounded-lg text-sm font-medium border border-cyan-200/60">
                                        {{ $registro->humedad_min_ideal }} - {{ $registro->humedad_max_ideal }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="bg-red-50 text-red-700 px-3 py-2 rounded-lg text-sm font-medium border border-red-200/60">
                                        {{ $registro->humedad_min_critica }} - {{ $registro->humedad_max_critica }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('registros_ambientales.destroy', $registro->id) }}" method="POST"
                                          onsubmit="return confirm('¿Estás seguro de eliminar esta configuración?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="group relative bg-red-50 text-red-600 hover:bg-red-100 border border-red-200/60 px-4 py-2 rounded-lg font-medium transition-all duration-200 hover:scale-105 hover:shadow-sm">
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-trash-alt"></i>
                                                <span>Eliminar</span>
                                            </div>
                                            <div class="absolute inset-0 bg-red-500 rounded-lg transform scale-0 group-hover:scale-100 transition-transform duration-200 opacity-10"></div>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                    <i class="fas fa-inbox text-4xl mb-3"></i>
                                    <p class="text-lg font-medium">No hay configuraciones registradas</p>
                                    <p class="text-sm mt-1">Comienza creando tu primera configuración ambiental</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabla = document.getElementById('tablaRegistros');
            const registros = JSON.parse(localStorage.getItem('registrosAmbientales')) || [];

            // Actualizar estadísticas
            document.getElementById('totalConfig').textContent = registros.length;
            document.getElementById('totalSectores').textContent = new Set(registros.map(r => r.sector)).size;
            document.getElementById('ultimaActualizacion').textContent = registros.length > 0 ?
                new Date().toLocaleTimeString() : '-';

            // Mostrar registros si existen
            if (registros.length > 0) {
                tabla.innerHTML = '';
                registros.forEach((r, index) => {
                    const fila = document.createElement('tr');
                    fila.className = 'hover:bg-slate-50/80 transition-colors duration-200';
                    fila.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-white text-sm"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-slate-800">${r.sector}</div>
                                <div class="text-xs text-slate-500">Sector ambiental</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="bg-blue-50 text-blue-700 px-3 py-2 rounded-lg text-sm font-medium border border-blue-200/60">
                            ${r.temp_min_ideal || 'N/A'} - ${r.temp_max_ideal || 'N/A'}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="bg-orange-50 text-orange-700 px-3 py-2 rounded-lg text-sm font-medium border border-orange-200/60">
                            ${r.temp_min_critica || 'N/A'} - ${r.temp_max_critica || 'N/A'}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="bg-cyan-50 text-cyan-700 px-3 py-2 rounded-lg text-sm font-medium border border-cyan-200/60">
                            ${r.humedad_min_ideal || 'N/A'} - ${r.humedad_max_ideal || 'N/A'}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="bg-red-50 text-red-700 px-3 py-2 rounded-lg text-sm font-medium border border-red-200/60">
                            ${r.humedad_min_critica || 'N/A'} - ${r.humedad_max_critica || 'N/A'}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <button onclick="eliminarRegistro(${index})"
                                class="group relative bg-red-50 text-red-600 hover:bg-red-100 border border-red-200/60 px-4 py-2 rounded-lg font-medium transition-all duration-200 hover:scale-105 hover:shadow-sm">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-trash-alt"></i>
                                <span>Eliminar</span>
                            </div>
                            <div class="absolute inset-0 bg-red-500 rounded-lg transform scale-0 group-hover:scale-100 transition-transform duration-200 opacity-10"></div>
                        </button>
                    </td>
                `;
                    tabla.appendChild(fila);
                });
            }
        });

        function eliminarRegistro(index) {
            if (confirm('¿Estás seguro de que quieres eliminar esta configuración?')) {
                const registros = JSON.parse(localStorage.getItem('registrosAmbientales')) || [];
                registros.splice(index, 1);
                localStorage.setItem('registrosAmbientales', JSON.stringify(registros));

                // Mostrar notificación de éxito
                mostrarNotificacion('Configuración eliminada correctamente', 'success');

                // Recargar después de un breve delay
                setTimeout(() => {
                    location.reload();
                }, 1500);
            }
        }

        function mostrarNotificacion(mensaje, tipo) {
            // Crear elemento de notificación
            const notificacion = document.createElement('div');
            notificacion.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg border-l-4 ${
                tipo === 'success' ? 'bg-emerald-50 border-emerald-500 text-emerald-700' : 'bg-red-50 border-red-500 text-red-700'
            } transform translate-x-full transition-transform duration-300`;

            notificacion.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fas ${tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} text-lg"></i>
                <div>
                    <p class="font-semibold">${mensaje}</p>
                </div>
            </div>
        `;

            document.body.appendChild(notificacion);

            // Animación de entrada
            setTimeout(() => {
                notificacion.classList.remove('translate-x-full');
            }, 100);

            // Animación de salida
            setTimeout(() => {
                notificacion.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notificacion);
                }, 300);
            }, 3000);
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .backdrop-blur-sm {
            backdrop-filter: blur(8px);
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease;
        }

        .gradient-border {
            position: relative;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            padding: 1px;
            border-radius: 12px;
        }

        .gradient-border > div {
            background: white;
            border-radius: 11px;
        }
    </style>
@endsection
