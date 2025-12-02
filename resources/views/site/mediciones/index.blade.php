@extends('layouts.app')

@section('title', 'Mediciones IoT vs Físicas')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Mediciones IoT vs Físicas</h1>
                    <p class="text-gray-600 mt-2">Monitoreo en tiempo real y comparación de datos</p>
                </div>

            </div>

            <!-- Formulario Guardar -->
            <form action="{{ route('mediciones.store') }}" method="POST" id="medicionesForm">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

                    <!-- IoT Panel -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-satellite-dish text-blue-500 mr-3"></i>
                                Medición IoT
                            </h2>
                            <div class="text-right">
                                <div class="text-sm text-gray-500 font-mono bg-gray-50 px-3 py-1 rounded-lg">
                                    <i class="far fa-clock mr-1"></i>
                                    <span id="iotClock">--:--:--</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <!-- Temperatura IoT -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-thermometer-half mr-2 text-red-500"></i>
                                    Temperatura (°C)
                                </label>
                                <div class="relative">
                                    <input type="number" step="0.1" id="iotTemp" name="temp_iot"
                                           class="w-full input-modern rounded-xl px-4 py-3 bg-gray-50 text-gray-900 font-medium"
                                           value="" required readonly>
                                    <!-- Skeleton mientras carga -->
                                    <div id="iotTempSkeleton" class="skeleton absolute inset-0 rounded-xl hidden"></div>
                                </div>
                            </div>

                            <!-- Humedad IoT -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tint mr-2 text-blue-500"></i>
                                    Humedad (%)
                                </label>
                                <div class="relative">
                                    <input type="number" step="0.1" id="iotHum" name="humedad_iot"
                                           class="w-full input-modern rounded-xl px-4 py-3 bg-gray-50 text-gray-900 font-medium"
                                           value="" required readonly>
                                    <!-- Skeleton mientras carga -->
                                    <div id="iotHumSkeleton" class="skeleton absolute inset-0 rounded-xl hidden"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Indicador de estado IoT -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Estado del sensor</span>
                                <div class="flex items-center space-x-2">
                                    <div id="iotStatusIndicator" class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                                    <span id="iotStatusText" class="text-sm font-medium text-gray-700">Conectando...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Física Panel -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-clipboard-check text-green-500 mr-3"></i>
                                Medición Física
                            </h2>
                            <div class="text-right">
                                <div class="text-sm text-gray-500 font-mono bg-gray-50 px-3 py-1 rounded-lg">
                                    <i class="far fa-clock mr-1"></i>
                                    <span id="fisicaClock">--:--:--</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <!-- Temperatura Física -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-thermometer-half mr-2 text-red-500"></i>
                                    Temperatura (°C)
                                </label>
                                <input type="number" step="0.1" id="fisicaTemp" name="temp_fisica"
                                       class="w-full input-modern rounded-xl px-4 py-3 bg-white border border-gray-300 text-gray-900 font-medium focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                       required>
                            </div>

                            <!-- Humedad Física -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tint mr-2 text-blue-500"></i>
                                    Humedad (%)
                                </label>
                                <input type="number" step="0.1" id="fisicaHum" name="humedad_fisica"
                                       class="w-full input-modern rounded-xl px-4 py-3 bg-white border border-gray-300 text-gray-900 font-medium focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                       required>
                            </div>
                        </div>

                        <!-- Indicador de validación -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Listo para guardar</span>
                                <div id="fisicaValidation" class="flex items-center space-x-2 opacity-0 transition-opacity duration-300">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="text-sm font-medium text-green-600">Validado</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Botones de acción -->
                <div class="flex justify-center mb-8 space-x-4">
                    <button type="submit" class="btn-primary px-8 py-3 text-white rounded-xl font-semibold shadow-lg flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Mediciones
                    </button>
                    <button type="button" id="limpiarBtn" class="btn-danger px-8 py-3 text-white rounded-xl font-semibold shadow-lg flex items-center">
                        <i class="fas fa-eraser mr-2"></i>
                        Limpiar Campos
                    </button>
                </div>
            </form>

            <!-- Tabla de Mediciones -->
            <div class="bg-white rounded-2xl shadow-lg p-6 overflow-hidden">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar text-purple-500 mr-3"></i>
                        Comparación / Precisión
                    </h2>
                    <div class="mt-2 sm:mt-0 flex items-center space-x-2 text-sm text-gray-600">
                        <i class="fas fa-info-circle text-blue-500"></i>
                        <span>Actualizado en tiempo real</span>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full table-modern min-w-full">
                        <thead>
                        <tr class="text-left">
                            <th class="px-6 py-4 font-semibold text-gray-700">Hora</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Temp IoT (°C)</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Humedad IoT (%)</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Temp Física (°C)</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Humedad Física (%)</th>
                            <th class="px-6 py-4 font-semibold text-gray-700 text-center">Precisión Temp</th>
                            <th class="px-6 py-4 font-semibold text-gray-700 text-center">Precisión Hum</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200" id="tablaMediciones">
                        @forelse($mediciones as $medicion)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 text-gray-900 font-medium">{{ $medicion->hora->format('H:i:s') }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $medicion->temp_iot }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $medicion->humedad_iot }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $medicion->temp_fisica }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $medicion->humedad_fisica }}</td>
                                <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $medicion->precision_temp >= 90 ? 'precision-excellent' :
                                               ($medicion->precision_temp >= 80 ? 'precision-good' : 'precision-poor') }}">
                                            {{ $medicion->precision_temp }}%
                                        </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $medicion->precision_hum >= 90 ? 'precision-excellent' :
                                               ($medicion->precision_hum >= 80 ? 'precision-good' : 'precision-poor') }}">
                                            {{ $medicion->precision_hum }}%
                                        </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-inbox text-gray-400 text-4xl mb-3"></i>
                                        <p class="text-lg">No hay mediciones registradas</p>
                                        <p class="text-sm mt-1">Los datos aparecerán aquí una vez que guardes la primera medición</p>
                                    </div>
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
            const iotTemp = document.getElementById('iotTemp');
            const iotHum = document.getElementById('iotHum');
            const fisicaTemp = document.getElementById('fisicaTemp');
            const fisicaHum = document.getElementById('fisicaHum');
            const form = document.getElementById('medicionesForm');
            const iotTempSkeleton = document.getElementById('iotTempSkeleton');
            const iotHumSkeleton = document.getElementById('iotHumSkeleton');
            const iotStatusIndicator = document.getElementById('iotStatusIndicator');
            const iotStatusText = document.getElementById('iotStatusText');
            const fisicaValidation = document.getElementById('fisicaValidation');

            // Mostrar skeletons inicialmente
            iotTempSkeleton.classList.remove('hidden');
            iotHumSkeleton.classList.remove('hidden');

            // Reloj en tiempo real
            function updateClocks() {
                const now = new Date();
                const timeStr = now.toLocaleTimeString();
                document.getElementById('iotClock').innerText = timeStr;
                document.getElementById('fisicaClock').innerText = timeStr;
            }

            setInterval(updateClocks, 1000);
            updateClocks();

            // Validación de campos físicos
            function validatePhysicalInputs() {
                const tempValid = fisicaTemp.value.trim() !== '';
                const humValid = fisicaHum.value.trim() !== '';

                if (tempValid && humValid) {
                    fisicaValidation.classList.remove('opacity-0');
                    fisicaValidation.classList.add('opacity-100');
                } else {
                    fisicaValidation.classList.remove('opacity-100');
                    fisicaValidation.classList.add('opacity-0');
                }
            }

            fisicaTemp.addEventListener('input', validatePhysicalInputs);
            fisicaHum.addEventListener('input', validatePhysicalInputs);

            // Traer datos de Firebase a inputs IoT
            async function fetchFirebaseData() {
                try {
                    // Actualizar estado a conectando
                    iotStatusIndicator.className = 'w-2 h-2 bg-yellow-500 rounded-full animate-pulse';
                    iotStatusText.textContent = 'Conectando...';

                    const response = await fetch("{{ route('firebase.data') }}");
                    if (!response.ok) throw new Error('Error al obtener datos de Firebase');

                    const data = await response.json();
                    const sensores = data.sensores ?? {};

                    // Ocultar skeletons y mostrar datos
                    setTimeout(() => {
                        iotTempSkeleton.classList.add('hidden');
                        iotHumSkeleton.classList.add('hidden');

                        // Asegurar que siempre haya valores, incluso si son 0
                        iotTemp.value = parseFloat(sensores.temperatura ?? 0).toFixed(1);
                        iotHum.value = parseFloat(sensores.humedad ?? 0).toFixed(1);

                        // Actualizar estado a conectado
                        iotStatusIndicator.className = 'w-2 h-2 bg-green-500 rounded-full';
                    }, 500);

                } catch (error) {
                    console.error(error);

                    // Ocultar skeletons y establecer valores por defecto
                    setTimeout(() => {
                        iotTempSkeleton.classList.add('hidden');
                        iotHumSkeleton.classList.add('hidden');

                        iotTemp.value = '0.0';
                        iotHum.value = '0.0';

                        // Actualizar estado a error
                        iotStatusIndicator.className = 'w-2 h-2 bg-red-500 rounded-full';
                        iotStatusText.textContent = 'Error de conexión';
                    }, 500);
                }
            }

            // Validar antes de enviar
            form.addEventListener('submit', function(e){
                const tempIot = parseFloat(iotTemp.value);
                const humIot = parseFloat(iotHum.value);
                const tempFisica = parseFloat(fisicaTemp.value);
                const humFisica = parseFloat(fisicaHum.value);

                if(isNaN(tempIot) || isNaN(humIot)){
                    e.preventDefault();
                    showNotification('Error: Datos IoT no disponibles', 'error');
                    return;
                }

                if(isNaN(tempFisica) || isNaN(humFisica)){
                    e.preventDefault();
                    showNotification('Error: Complete todos los campos físicos', 'error');
                    return;
                }

                // Asegurar que los campos IoT tengan valores válidos
                if (iotTemp.value === '') iotTemp.value = '0.0';
                if (iotHum.value === '') iotHum.value = '0.0';
            });

            // Botón Limpiar
            document.getElementById('limpiarBtn').addEventListener('click', () => {
                fisicaTemp.value = '';
                fisicaHum.value = '';
                validatePhysicalInputs();
                showNotification('Campos físicos limpiados', 'info');
            });

            // Función para mostrar notificaciones
            function showNotification(message, type = 'info') {
                // Crear elemento de notificación
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg transform transition-transform duration-300 translate-x-full`;

                let bgColor = 'bg-blue-500';
                let icon = 'fas fa-info-circle';

                if (type === 'error') {
                    bgColor = 'bg-red-500';
                    icon = 'fas fa-exclamation-triangle';
                } else if (type === 'success') {
                    bgColor = 'bg-green-500';
                    icon = 'fas fa-check-circle';
                } else if (type === 'info') {
                    bgColor = 'bg-blue-500';
                    icon = 'fas fa-info-circle';
                }

                notification.className += ` ${bgColor} text-white`;
                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="${icon} mr-3"></i>
                        <span>${message}</span>
                    </div>
                `;

                document.body.appendChild(notification);

                // Animación de entrada
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 10);

                // Animación de salida después de 3 segundos
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }

            // Carga inicial
            fetchFirebaseData();
            setInterval(fetchFirebaseData, 2000); // Actualiza cada 3s
        });
    </script>

    <style>
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 12px;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }

        .input-modern {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .input-modern:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .precision-excellent {
            background: linear-gradient(135deg, #10b981, #34d399);
            color: white;
            font-weight: 600;
        }

        .precision-good {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: white;
            font-weight: 600;
        }

        .precision-poor {
            background: linear-gradient(135deg, #ef4444, #f87171);
            color: white;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        .table-modern {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-modern th {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            font-weight: 600;
        }
    </style>
@endsection
