@extends('layouts.app')

@section('title', 'Configurar Ambiente')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Nuevo Registro Ambiental</h1>
                    <p class="text-gray-500 mt-2">Configure los parámetros ambientales para el monitoreo</p>
                </div>
                <div class="flex items-center gap-2 text-emerald-600">
                    <i class="fas fa-leaf text-xl"></i>
                    <span class="font-semibold">PoultryNet</span>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

                <!-- Modal de Validación personalizado -->
                <div id="validationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
                    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
                        <!-- Header del Modal -->
                        <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 rounded-t-2xl flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                            </div>
                            <h2 class="text-xl font-bold text-white">Validación de Rangos</h2>
                        </div>

                        <!-- Contenido del Modal -->
                        <div class="p-6">
                            <p class="text-gray-700 mb-4 text-base">
                                Por favor, verifica los siguientes problemas en tu configuración:
                            </p>
                            <div id="validationErrors" class="space-y-3 max-h-64 overflow-y-auto">
                                <!-- Los errores se agregarán aquí con JavaScript -->
                            </div>
                        </div>

                        <!-- Footer del Modal -->
                        <div class="bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200 flex justify-end">
                            <button type="button" onclick="closeValidationModal()"
                                    class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors duration-200">
                                <i class="fas fa-check mr-2"></i>Entendido
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Notificación de Errores de Validación del Servidor -->
                @if ($errors->any())
                    <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-600 text-2xl mt-1"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-red-800 mb-3">
                                    <i class="fas fa-times-circle mr-2"></i>Errores en el Formulario
                                </h3>
                                <ul class="space-y-2 text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li class="flex items-start gap-2">
                                            <i class="fas fa-chevron-right text-xs mt-1.5 flex-shrink-0"></i>
                                            <span>{{ $error }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" onclick="this.parentElement.parentElement.remove()"
                                    class="text-red-600 hover:text-red-800 transition-colors">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Notificación de Éxito -->
                @if (session('success'))
                    <div class="mb-8 bg-emerald-50 border-l-4 border-emerald-500 p-6 rounded-lg" id="successAlert">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-emerald-600 text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-emerald-800">
                                    <i class="fas fa-check mr-2"></i>¡Éxito!
                                </h3>
                                <p class="text-emerald-700 mt-1">{{ session('success') }}</p>
                            </div>
                            <button type="button" onclick="this.parentElement.parentElement.remove()"
                                    class="text-emerald-600 hover:text-emerald-800 transition-colors">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <script>
                        setTimeout(() => {
                            const alert = document.getElementById('successAlert');
                            if (alert) {
                                alert.style.transition = 'opacity 0.3s ease';
                                alert.style.opacity = '0';
                                setTimeout(() => alert.remove(), 300);
                            }
                        }, 5000);
                    </script>
                @endif

                <form action="{{ route('registros_ambientales.store') }}" method="POST" id="ambientalForm">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                        <!-- Columna Izquierda -->
                        <div class="space-y-8">
                            <!-- Sector -->
                            <div>
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-map-marker-alt text-emerald-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Información del Sector</h3>
                                        <p class="text-sm text-gray-500">Seleccione el área de monitoreo</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Sector de Monitoreo <span class="text-red-500">*</span></label>
                                        <select name="sector_id"
                                                class="w-full px-4 py-3 border @error('sector_id') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                                                value="{{ old('sector_id') }}">
                                            <option value="">Seleccione un sector</option>
                                            @foreach ($sectores as $sector)
                                                <option value="{{ $sector->id }}" {{ old('sector_id') == $sector->id ? 'selected' : '' }}>
                                                    {{ $sector->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sector_id')
                                        <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Temperatura - Rango Ideal -->
                            <div>
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-check-circle text-emerald-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Temperatura Ideal</h3>
                                        <p class="text-sm text-gray-500">Rango óptimo en °C</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Temperatura Mínima <span class="text-red-500">*</span></label>
                                        <input type="number" step="0.1" name="temp_min_ideal"
                                               class="w-full px-4 py-3 border @error('temp_min_ideal') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                                               placeholder="Ej: 18.5"
                                               value="{{ old('temp_min_ideal') }}">
                                        @error('temp_min_ideal')
                                        <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Temperatura Máxima <span class="text-red-500">*</span></label>
                                        <input type="number" step="0.1" name="temp_max_ideal"
                                               class="w-full px-4 py-3 border @error('temp_max_ideal') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                                               placeholder="Ej: 24.0"
                                               value="{{ old('temp_max_ideal') }}">
                                        @error('temp_max_ideal')
                                        <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Humedad - Rango Ideal -->
                            <div>
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-check-circle text-emerald-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Humedad Ideal</h3>
                                        <p class="text-sm text-gray-500">Rango óptimo en %</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Humedad Mínima <span class="text-red-500">*</span></label>
                                        <input type="number" step="0.1" name="humedad_min_ideal"
                                               class="w-full px-4 py-3 border @error('humedad_min_ideal') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                                               placeholder="Ej: 40.0"
                                               value="{{ old('humedad_min_ideal') }}">
                                        @error('humedad_min_ideal')
                                        <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Humedad Máxima <span class="text-red-500">*</span></label>
                                        <input type="number" step="0.1" name="humedad_max_ideal"
                                               class="w-full px-4 py-3 border @error('humedad_max_ideal') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                                               placeholder="Ej: 60.0"
                                               value="{{ old('humedad_max_ideal') }}">
                                        @error('humedad_max_ideal')
                                        <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Columna Derecha -->
                        <div class="space-y-8">
                            <!-- Temperatura - Rango Crítico -->
                            <div>
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Temperatura Crítica</h3>
                                        <p class="text-sm text-gray-500">Límites de alerta en °C</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Temperatura Mínima <span class="text-red-500">*</span></label>
                                        <input type="number" step="0.1" name="temp_min_critica"
                                               class="w-full px-4 py-3 border @error('temp_min_critica') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                                               placeholder="Ej: 15.0"
                                               value="{{ old('temp_min_critica') }}">
                                        @error('temp_min_critica')
                                        <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Temperatura Máxima <span class="text-red-500">*</span></label>
                                        <input type="number" step="0.1" name="temp_max_critica"
                                               class="w-full px-4 py-3 border @error('temp_max_critica') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                                               placeholder="Ej: 28.0"
                                               value="{{ old('temp_max_critica') }}">
                                        @error('temp_max_critica')
                                        <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Humedad - Rango Crítico -->
                            <div>
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Humedad Crítica</h3>
                                        <p class="text-sm text-gray-500">Límites de alerta en %</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Humedad Mínima <span class="text-red-500">*</span></label>
                                        <input type="number" step="0.1" name="humedad_min_critica"
                                               class="w-full px-4 py-3 border @error('humedad_min_critica') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                                               placeholder="Ej: 30.0"
                                               value="{{ old('humedad_min_critica') }}">
                                        @error('humedad_min_critica')
                                        <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Humedad Máxima <span class="text-red-500">*</span></label>
                                        <input type="number" step="0.1" name="humedad_max_critica"
                                               class="w-full px-4 py-3 border @error('humedad_max_critica') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                                               placeholder="Ej: 75.0"
                                               value="{{ old('humedad_max_critica') }}">
                                        @error('humedad_max_critica')
                                        <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Información Adicional -->
                            <div class="bg-gray-50 rounded-xl p-6 mt-8">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-info-circle text-blue-600 text-sm"></i>
                                    </div>
                                    <h4 class="font-semibold text-gray-900">Recomendaciones</h4>
                                </div>
                                <ul class="text-sm text-gray-600 space-y-2">
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check text-emerald-500 text-xs mt-1"></i>
                                        <span>Los rangos ideales garantizan el máximo bienestar animal</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-exclamation text-red-500 text-xs mt-1"></i>
                                        <span>Los rangos críticos activan alertas automáticas</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-sync text-blue-500 text-xs mt-1"></i>
                                        <span>Revise periódicamente los parámetros establecidos</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end gap-4 pt-8 mt-8 border-t border-gray-100">
                        <a href="{{ route('registros_ambientales.index') }}" class="px-8 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors duration-200 flex items-center gap-3">
                            <i class="fas fa-arrow-left"></i>
                            Volver al Listado
                        </a>
                        <button type="submit" class="px-8 py-3 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition-colors duration-200 flex items-center gap-3 shadow-sm hover:shadow-md">
                            <i class="fas fa-save"></i>
                            Guardar Configuración
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer Note -->
            <div class="text-center text-gray-400 text-sm mt-8">
                <p>Sistema de Monitoreo Ambiental • PoultryNet</p>
            </div>
        </div>
    </div>

    <style>
        .form-input {
            transition: all 0.2s ease;
        }

        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            transform: translateY(-1px);
        }

        .icon-card {
            transition: all 0.3s ease;
        }

        .icon-card:hover {
            transform: translateY(-2px);
        }
    </style>

    <script>
        // Función para abrir modal de validación
        function showValidationModal(errors) {
            const modal = document.getElementById('validationModal');
            const errorList = document.getElementById('validationErrors');

            errorList.innerHTML = '';

            errors.forEach(error => {
                const errorItem = document.createElement('div');
                errorItem.className = 'bg-red-50 border border-red-200 rounded-lg p-3 flex items-start gap-3';
                errorItem.innerHTML = `
                    <i class="fas fa-circle-xmark text-red-600 text-lg flex-shrink-0 mt-0.5"></i>
                    <span class="text-red-800 text-sm">${error}</span>
                `;
                errorList.appendChild(errorItem);
            });

            modal.style.display = 'flex';
            modal.classList.remove('hidden');
        }

        // Función para cerrar modal
        function closeValidationModal() {
            const modal = document.getElementById('validationModal');
            modal.style.display = 'none';
            modal.classList.add('hidden');
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('validationModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeValidationModal();
            }
        });

        // Mejoras de UX: Efectos de enfoque en inputs
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.add('ring-2', 'ring-emerald-200', 'border-emerald-500');
            });

            input.addEventListener('blur', function() {
                this.classList.remove('ring-2', 'ring-emerald-200', 'border-emerald-500');
            });
        });

        // Validación del formulario
        document.getElementById('ambientalForm').addEventListener('submit', function(e) {
            const errors = [];

            // Validar sector
            const sector = document.querySelector('select[name="sector_id"]').value;
            if (!sector) {
                errors.push('Debe seleccionar un sector de monitoreo');
            }

            // Validar Temperatura Ideal
            const tempMinIdeal = parseFloat(document.querySelector('input[name="temp_min_ideal"]').value);
            const tempMaxIdeal = parseFloat(document.querySelector('input[name="temp_max_ideal"]').value);

            if (!tempMinIdeal || !tempMaxIdeal) {
                errors.push('Debe completar los rangos de mediciones ideal');
            } else if (tempMinIdeal >= tempMaxIdeal) {
                errors.push('La mediciones mínima ideal debe ser menor que la máxima (Ideal)');
            }

            // Validar Humedad Ideal
            const humedadMinIdeal = parseFloat(document.querySelector('input[name="humedad_min_ideal"]').value);
            const humedadMaxIdeal = parseFloat(document.querySelector('input[name="humedad_max_ideal"]').value);

            if (!humedadMinIdeal || !humedadMaxIdeal) {
                errors.push('Debe completar los rangos de humedad ideal');
            } else if (humedadMinIdeal >= humedadMaxIdeal) {
                errors.push('La humedad mínima ideal debe ser menor que la máxima (Ideal)');
            }

            // Validar Temperatura Crítica
            const tempMinCritica = parseFloat(document.querySelector('input[name="temp_min_critica"]').value);
            const tempMaxCritica = parseFloat(document.querySelector('input[name="temp_max_critica"]').value);

            if (!tempMinCritica || !tempMaxCritica) {
                errors.push('Debe completar los rangos de mediciones crítica');
            } else if (tempMinCritica >= tempMaxCritica) {
                errors.push('La mediciones mínima crítica debe ser menor que la máxima (Crítica)');
            }

            // Validar Humedad Crítica
            const humedadMinCritica = parseFloat(document.querySelector('input[name="humedad_min_critica"]').value);
            const humedadMaxCritica = parseFloat(document.querySelector('input[name="humedad_max_critica"]').value);

            if (!humedadMinCritica || !humedadMaxCritica) {
                errors.push('Debe completar los rangos de humedad crítica');
            } else if (humedadMinCritica >= humedadMaxCritica) {
                errors.push('La humedad mínima crítica debe ser menor que la máxima (Crítica)');
            }

            // Si hay errores, mostrar modal y prevenir envío
            if (errors.length > 0) {
                e.preventDefault();
                showValidationModal(errors);
                return;
            }

            // Mostrar confirmación
            const submitBtn = document.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            submitBtn.disabled = true;

            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });

        // Efectos hover en las tarjetas de iconos
        document.querySelectorAll('.w-10.h-10').forEach(icon => {
            icon.addEventListener('mouseenter', function() {
                this.classList.add('transform', 'scale-105');
            });

            icon.addEventListener('mouseleave', function() {
                this.classList.remove('transform', 'scale-105');
            });
        });
    </script>
@endsection
