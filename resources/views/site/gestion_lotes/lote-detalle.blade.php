@extends('layouts.app')

@section('title', 'Lotes de ' . $sector->nombre)

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 p-4 md:p-8">
        @include('partials.header', ['sector' => $sector, 'lotes' => $lotes])

        <div class="max-w-7xl mx-auto">
            <!-- Header Premium -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-4 mb-2">
                            <div class="bg-gradient-to-br from-blue-600 to-blue-500 p-3 rounded-2xl shadow-lg">
                                <i class="fas fa-microscope text-2xl text-white"></i>
                            </div>
                            <div>
                                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Detección de Enfermedades</h1>
                                <p class="text-gray-600 mt-1">Monitoreo ambiental con Machine Learning</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white px-6 py-4 rounded-2xl shadow-md border border-gray-200">
                        <div class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></div>
                        <span class="text-gray-700 font-semibold">{{ $sector->nombre }}</span>
                    </div>
                </div>
            </div>

            <!-- Grid Principal -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Columna Izquierda: Métricas -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Temperatura Card -->
                    <div class="bg-white rounded-3xl shadow-md border border-gray-200 p-8 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-blue-100 p-3 rounded-xl">
                                <i class="fas fa-thermometer-half text-2xl text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Temperatura</h3>
                                <span id="tempAmb" class="text-3xl font-bold text-blue-600">--</span><span class="text-2xl text-gray-600">°C</span>
                            </div>
                        </div>

                        <!-- Barra de progreso -->
                        <div class="mb-6">
                            <div class="relative h-4 bg-gradient-to-r from-red-400 via-green-400 to-red-400 rounded-full overflow-hidden shadow-sm">
                                <div id="tempIndicator" class="absolute h-4 w-2 bg-gray-900 rounded-full shadow-md transition-all duration-500" style="left: 50%;"></div>
                            </div>
                        </div>

                        <!-- Rango de valores -->
                        <div class="grid grid-cols-4 gap-2 text-center">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-600 mb-1">Mín. Crítica</p>
                                <p class="font-semibold text-gray-900">{{ $registroAmbiental->temp_min_critica ?? 0 }}°</p>
                            </div>
                            <div class="bg-green-50 p-3 rounded-lg border-2 border-green-200">
                                <p class="text-xs text-gray-600 mb-1">Mín. Ideal</p>
                                <p class="font-semibold text-green-700">{{ $registroAmbiental->temp_min_ideal ?? 0 }}°</p>
                            </div>
                            <div class="bg-green-50 p-3 rounded-lg border-2 border-green-200">
                                <p class="text-xs text-gray-600 mb-1">Máx. Ideal</p>
                                <p class="font-semibold text-green-700">{{ $registroAmbiental->temp_max_ideal ?? 0 }}°</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-600 mb-1">Máx. Crítica</p>
                                <p class="font-semibold text-gray-900">{{ $registroAmbiental->temp_max_critica ?? 0 }}°</p>
                            </div>
                        </div>
                    </div>

                    <!-- Humedad Card -->
                    <div class="bg-white rounded-3xl shadow-md border border-gray-200 p-8 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-cyan-100 p-3 rounded-xl">
                                <i class="fas fa-water text-2xl text-cyan-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Humedad Relativa</h3>
                                <span id="humAmb" class="text-3xl font-bold text-cyan-600">--</span><span class="text-2xl text-gray-600">%</span>
                            </div>
                        </div>

                        <!-- Barra de progreso -->
                        <div class="mb-6">
                            <div class="relative h-4 bg-gradient-to-r from-yellow-400 via-green-400 to-blue-400 rounded-full overflow-hidden shadow-sm">
                                <div id="humIndicator" class="absolute h-4 w-2 bg-gray-900 rounded-full shadow-md transition-all duration-500" style="left: 60%;"></div>
                            </div>
                        </div>

                        <!-- Rango de valores -->
                        <div class="grid grid-cols-4 gap-2 text-center">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-600 mb-1">Mín. Crítica</p>
                                <p class="font-semibold text-gray-900">{{ $registroAmbiental->humedad_min_critica ?? 0 }}%</p>
                            </div>
                            <div class="bg-green-50 p-3 rounded-lg border-2 border-green-200">
                                <p class="text-xs text-gray-600 mb-1">Mín. Ideal</p>
                                <p class="font-semibold text-green-700">{{ $registroAmbiental->humedad_min_ideal ?? 0 }}%</p>
                            </div>
                            <div class="bg-green-50 p-3 rounded-lg border-2 border-green-200">
                                <p class="text-xs text-gray-600 mb-1">Máx. Ideal</p>
                                <p class="font-semibold text-green-700">{{ $registroAmbiental->humedad_max_ideal ?? 0 }}%</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-600 mb-1">Máx. Crítica</p>
                                <p class="font-semibold text-gray-900">{{ $registroAmbiental->humedad_max_critica ?? 0 }}%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Riesgo -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl shadow-md border border-gray-200 p-8 h-full flex flex-col">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="bg-amber-100 p-3 rounded-xl">
                                <i class="fas fa-exclamation-triangle text-2xl text-amber-600"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Nivel de Riesgo</h3>
                        </div>

                        <!-- Indicador Circular -->
                        <div class="flex-1 flex flex-col items-center justify-center mb-8">
                            <div class="relative w-40 h-40">
                                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                                    <circle cx="50" cy="50" r="40" fill="none" stroke="#e5e7eb" stroke-width="6"/>
                                    <circle id="riesgoArc" cx="50" cy="50" r="40" fill="none" stroke="#10b981" stroke-width="6"
                                            stroke-dasharray="251.2" stroke-dashoffset="251.2" class="transition-all duration-700"
                                            stroke-linecap="round"/>
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span id="riesgoAmb" class="text-4xl font-bold text-gray-900">--%</span>
                                    <span class="text-xs text-gray-500 mt-2">General</span>
                                </div>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="bg-gradient-to-b from-gray-50 to-white rounded-2xl p-4 border border-gray-100">
                            <p class="text-sm text-gray-600 mb-2 flex items-center gap-2">
                                <i class="fas fa-clock text-gray-400"></i>
                                Última actualización
                            </p>
                            <p id="fechaAmb" class="text-sm font-semibold text-gray-900">--:-- --</p>
                        </div>

                        <!-- Indicador Estado -->
                        <div class="flex items-center gap-2 mt-4 text-sm text-green-700 bg-green-50 px-4 py-3 rounded-xl border border-green-200">
                            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                            En tiempo real
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de Detección de Imágenes -->
            <div class="mt-8 bg-white rounded-3xl shadow-md border border-gray-200 p-8">
                <form method="POST" action="{{ route('detecciones.store') }}" enctype="multipart/form-data" id="deteccionForm">
                    @csrf
                    <input type="hidden" name="sector_id" value="{{ $sector->id }}">

                    <div class="flex flex-col lg:flex-row gap-8">
                        <!-- Panel Izquierdo - Imagen -->
                        <div class="w-full lg:w-2/5">
                            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 p-6 rounded-2xl border border-blue-200">
                                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                    <div class="bg-blue-600 p-3 rounded-xl mr-3">
                                        <i class="fas fa-camera text-white text-lg"></i>
                                    </div>
                                    Análisis de Imagen
                                </h3>

                                <label for="imagenInput" class="flex flex-col items-center justify-center w-full h-80 border-2 border-dashed border-blue-300 rounded-2xl cursor-pointer bg-white hover:border-blue-400 hover:bg-blue-50 transition-all duration-300" id="dropZone">
                                    <div class="flex flex-col items-center justify-center pt-8 pb-8" id="uploadPlaceholder">
                                        <div class="bg-blue-100 p-4 rounded-full mb-4">
                                            <i class="fas fa-cloud-upload-alt text-3xl text-blue-600"></i>
                                        </div>
                                        <p class="mb-2 text-lg font-semibold text-gray-700">Subir imagen</p>
                                        <p class="text-sm text-gray-500 text-center">Arrastra y suelta o haz clic para seleccionar</p>
                                        <p class="text-xs text-gray-400 mt-3">Formatos: JPG, PNG, WEBP (máx. 10MB)</p>
                                    </div>
                                    <div id="imagePreviewContainer" class="hidden w-full h-full p-4">
                                        <div class="relative w-full h-full flex items-center justify-center">
                                            <img id="preview" class="max-w-full max-h-64 rounded-xl object-contain shadow-lg" src="" alt="Vista previa">
                                            <button type="button" id="removeImage" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600 transition-all duration-200 shadow-md">
                                                <i class="fas fa-times text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <input id="imagenInput" name="imagen" type="file" class="hidden" accept="image/jpeg,image/png,image/webp" required />
                                </label>

                                <div class="mt-6">
                                    <button type="button" id="btnDetectar" class="w-full px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:-translate-y-1 shadow-lg flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none" disabled>
                                        <i class="fas fa-robot mr-3 text-lg"></i>
                                        <span id="btnText" class="text-lg">Analizar con IA</span>
                                        <div id="btnSpinner" class="hidden ml-3">
                                            <i class="fas fa-spinner fa-spin text-lg"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Panel Derecho - Resultados -->
                        <div class="w-full lg:w-3/5">
                            <!-- Resultados de la Detección -->
                            <div id="detectionResults" class="hidden bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-2xl border border-green-200 mb-6 shadow-sm">
                                <div class="flex items-center mb-6">
                                    <div class="bg-green-600 p-3 rounded-xl mr-4">
                                        <i class="fas fa-check-circle text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800">Análisis Completado</h3>
                                        <p class="text-gray-600">Resultados del modelo de Machine Learning</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                                        <label class="block text-gray-700 font-bold mb-3 flex items-center">
                                            <i class="fas fa-virus mr-2 text-red-500"></i>
                                            Enfermedad Detectada
                                        </label>
                                        <input type="text" name="enfermedad" id="enfermedadInput" readonly class="w-full border-2 border-gray-300 rounded-xl p-4 bg-gray-50 font-bold text-red-600 text-lg focus:outline-none">
                                    </div>
                                    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                                        <label class="block text-gray-700 font-bold mb-3 flex items-center">
                                            <i class="fas fa-percentage mr-2 text-blue-500"></i>
                                            Nivel de Confianza
                                        </label>
                                        <div class="space-y-3">
                                            <input type="text" name="confianza" id="confianzaInput" readonly class="w-full border-2 border-gray-300 rounded-xl p-4 bg-gray-50 font-bold text-blue-600 text-lg">
                                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                                <div id="confidenceBar" class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all duration-1000 ease-out" style="width:0%"></div>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-sm font-semibold text-gray-600" id="confianzaValue">0%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                                    <label class="block text-gray-700 font-bold mb-3 flex items-center">
                                        <i class="fas fa-clock mr-2 text-indigo-500"></i>
                                        Tiempo de Procesamiento
                                    </label>
                                    <div class="flex items-center space-x-4">
                                        <input type="text" name="tiempo_deteccion" id="tiempoInput" readonly class="flex-1 border-2 border-gray-300 rounded-xl p-4 bg-gray-50 font-bold text-indigo-600 text-lg">
                                        <span class="text-lg font-semibold text-gray-600" id="tiempoValue">0 seg</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Recomendaciones -->
                            <div id="bloqueRecomendaciones" class="hidden bg-gradient-to-br from-amber-50 to-orange-50 p-6 rounded-2xl border border-amber-200 mb-6 shadow-sm">
                                <div class="flex items-center mb-4">
                                    <div class="bg-amber-600 p-3 rounded-xl mr-4">
                                        <i class="fas fa-lightbulb text-white text-xl"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-amber-900">Recomendaciones</h3>
                                </div>
                                <ul id="listaRecomendaciones" class="space-y-3 text-gray-700"></ul>
                            </div>

                            <!-- Información Adicional -->
                            <div class="bg-gradient-to-br from-gray-50 to-blue-50 p-6 rounded-2xl border border-gray-200 shadow-sm">
                                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                    <div class="bg-gray-700 p-3 rounded-xl mr-4">
                                        <i class="fas fa-info-circle text-white text-xl"></i>
                                    </div>
                                    Información Adicional
                                </h3>

                                <div class="bg-white p-5 rounded-xl border border-gray-200">
                                    <label class="block text-gray-700 font-bold mb-3 flex items-center">
                                        <i class="fas fa-comment-alt mr-2 text-gray-500"></i>
                                        Observaciones
                                    </label>
                                    <textarea name="observaciones" class="w-full border-2 border-gray-300 rounded-xl p-4 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 text-lg" rows="4" placeholder="Ingrese observaciones relevantes sobre la muestra analizada..."></textarea>

                                    <!-- Campo hidden para guardar las recomendaciones -->
                                    <input type="hidden" name="recomendacion" id="recomendacionesInput">
                                </div>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="flex flex-col sm:flex-row justify-end gap-4 pt-8">
                                <a href="{{ url()->previous() }}" class="px-8 py-4 bg-gray-600 text-white font-bold rounded-xl hover:bg-gray-700 text-center transition-all duration-300 transform hover:-translate-y-1 shadow-lg flex items-center justify-center">
                                    <i class="fas fa-arrow-left mr-3"></i> Cancelar
                                </a>
                                <button type="submit" id="submitButton" disabled class="px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-300 transform hover:-translate-y-1 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center">
                                    <i class="fas fa-save mr-3"></i> Guardar Detección
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="mt-12 text-center">
                <p class="text-gray-500 text-lg flex items-center justify-center gap-3">
                    <i class="fas fa-sync-alt animate-spin text-blue-600"></i>
                    Sistema de monitoreo activo - Datos actualizados cada 3 segundos
                </p>
            </div>
        </div>
    </div>

    <!-- Overlay de carga -->
    <div id="loadingOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded-2xl shadow-2xl text-center max-w-sm">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Analizando Imagen</h3>
            <p class="text-gray-600">El modelo de IA está procesando la imagen...</p>
        </div>
    </div>

    <!-- Mensaje de error -->
    <div id="errorMessage" class="hidden fixed top-6 right-6 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-xl max-w-md z-50 shadow-lg">
        <div class="flex items-start">
            <i class="fas fa-exclamation-triangle text-red-500 mt-1 mr-3"></i>
            <div class="flex-1">
                <span class="font-semibold" id="errorText"></span>
            </div>
            <button type="button" class="text-red-500 hover:text-red-700 ml-4" onclick="document.getElementById('errorMessage').classList.add('hidden')">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tempSpan = document.getElementById('tempAmb');
            const humSpan = document.getElementById('humAmb');
            const riesgoSpan = document.getElementById('riesgoAmb');
            const riesgoArc = document.getElementById('riesgoArc');
            const fechaSpan = document.getElementById('fechaAmb');
            const tempIndicator = document.getElementById('tempIndicator');
            const humIndicator = document.getElementById('humIndicator');

            const tempMinCrit = {{ $registroAmbiental->temp_min_critica ?? 0 }};
            const tempMaxCrit = {{ $registroAmbiental->temp_max_critica ?? 0 }};
            const humMinCrit = {{ $registroAmbiental->humedad_min_critica ?? 0 }};
            const humMaxCrit = {{ $registroAmbiental->humedad_max_critica ?? 0 }};
            const tempMinIdeal = {{ $registroAmbiental->temp_min_ideal ?? 0 }};
            const tempMaxIdeal = {{ $registroAmbiental->temp_max_ideal ?? 0 }};

            function getColorByRiesgo(riesgo) {
                if (riesgo < 33) return '#10b981'; // Verde
                if (riesgo < 66) return '#f59e0b'; // Amarillo
                return '#ef4444'; // Rojo
            }

            async function fetchFirebaseData() {
                try {
                    const response = await fetch("{{ route('firebase.data') }}");
                    const data = await response.json();

                    const sensores = data.sensores || {};
                    const temp = parseFloat(sensores.temperatura ?? 0);
                    const hum = parseFloat(sensores.humedad ?? 0);
                    const riesgo = calcularRiesgo(temp, hum);

                    tempSpan.textContent = temp.toFixed(1);
                    humSpan.textContent = hum.toFixed(1);
                    riesgoSpan.textContent = riesgo.toFixed(0);
                    fechaSpan.textContent = new Date().toLocaleString('es-PE', {
                        timeStyle: 'short',
                        dateStyle: 'short'
                    });

                    actualizarIndicador(temp, tempIndicator, tempMinCrit, tempMaxCrit);
                    actualizarIndicador(hum, humIndicator, humMinCrit, humMaxCrit);

                    const offset = 251.2 - (riesgo / 100) * 251.2;
                    riesgoArc.style.strokeDashoffset = offset;
                    riesgoArc.style.stroke = getColorByRiesgo(riesgo);
                } catch (error) {
                    console.error("Error obteniendo datos:", error);
                }
            }

            function calcularRiesgo(temp, hum) {
                let riesgoTemp = 0;
                if (temp > tempMaxIdeal) riesgoTemp = ((temp - tempMaxIdeal) / (tempMaxCrit - tempMaxIdeal)) * 100;
                else if (temp < tempMinIdeal) riesgoTemp = ((tempMinIdeal - temp) / (tempMinIdeal - tempMinCrit)) * 100;
                return Math.min(100, Math.max(0, riesgoTemp));
            }

            function actualizarIndicador(valor, indicador, min, max) {
                const pos = Math.min(100, Math.max(0, ((valor - min) / (max - min)) * 100));
                indicador.style.left = `${pos}%`;
            }

            fetchFirebaseData();
            setInterval(fetchFirebaseData, 3000);
        });
    </script>

    <script>
        // Configuración y constantes
        const CONFIG = {
            MAX_FILE_SIZE: 10 * 1024 * 1024, // 10MB
            VALID_FILE_TYPES: ['image/jpeg', 'image/png', 'image/webp'],
            API_ENDPOINT: '{{ route("poultry.process") }}',
            CSRF_TOKEN: '{{ csrf_token() }}'
        };

        // Base de datos de recomendaciones
        const RECOMENDACIONES = {
            "Healthy": ["Todo normal. Mantener higiene y control regular."],
            "Sano": ["Todo normal. Mantener higiene y control regular."],
            "Coccidiosis": [
                "Aplicar coccidiostáticos en el agua y mejorar higiene del galpón.",
                "Aumentar frecuencia de limpieza de bebederos y comederos.",
                "Mantener seco el suelo del galpón.",
                "Revisar mediciones y ventilación.",
                "Evitar sobrepoblación en el sector.",
                "Asegurar buena calidad del agua.",
                "Controlar insectos vectores.",
                "Vacunar aves jóvenes según protocolo.",
                "Revisar estado nutricional.",
                "Separar aves enfermas inmediatamente."
            ]
        };

        // Elementos del DOM
        const DOM_ELEMENTS = {
            imagenInput: document.getElementById('imagenInput'),
            dropZone: document.getElementById('dropZone'),
            uploadPlaceholder: document.getElementById('uploadPlaceholder'),
            imagePreviewContainer: document.getElementById('imagePreviewContainer'),
            preview: document.getElementById('preview'),
            removeImage: document.getElementById('removeImage'),
            btnDetectar: document.getElementById('btnDetectar'),
            btnText: document.getElementById('btnText'),
            btnSpinner: document.getElementById('btnSpinner'),
            detectionResults: document.getElementById('detectionResults'),
            submitButton: document.getElementById('submitButton'),
            confidenceBar: document.getElementById('confidenceBar'),
            confianzaValue: document.getElementById('confianzaValue'),
            loadingOverlay: document.getElementById('loadingOverlay'),
            errorMessage: document.getElementById('errorMessage'),
            errorText: document.getElementById('errorText'),
            tiempoInput: document.getElementById('tiempoInput'),
            tiempoValue: document.getElementById('tiempoValue'),
            listaRecomendaciones: document.getElementById('listaRecomendaciones'),
            bloqueRecomendaciones: document.getElementById('bloqueRecomendaciones'),
            enfermedadInput: document.getElementById('enfermedadInput'),
            confianzaInput: document.getElementById('confianzaInput'),
            recomendacionesInput: document.getElementById('recomendacionesInput')
        };

        // Utilidades
        const Utils = {
            showError: (message) => {
                DOM_ELEMENTS.errorText.textContent = message;
                DOM_ELEMENTS.errorMessage.classList.remove('hidden');
                setTimeout(() => {
                    DOM_ELEMENTS.errorMessage.classList.add('hidden');
                }, 5000);
            },

            validateFile: (file) => {
                if (!CONFIG.VALID_FILE_TYPES.includes(file.type)) {
                    Utils.showError('Por favor, seleccione una imagen válida (JPG, PNG, WEBP).');
                    return false;
                }

                if (file.size > CONFIG.MAX_FILE_SIZE) {
                    Utils.showError('La imagen no debe superar los 10MB.');
                    return false;
                }

                return true;
            },

            updateUIState: (state) => {
                switch(state) {
                    case 'imageUploaded':
                        DOM_ELEMENTS.btnDetectar.disabled = false;
                        DOM_ELEMENTS.btnDetectar.classList.remove('opacity-50');
                        break;
                    case 'imageRemoved':
                        DOM_ELEMENTS.btnDetectar.disabled = true;
                        DOM_ELEMENTS.btnDetectar.classList.add('opacity-50');
                        DOM_ELEMENTS.detectionResults.classList.add('hidden');
                        DOM_ELEMENTS.submitButton.disabled = true;
                        DOM_ELEMENTS.tiempoInput.value = '';
                        DOM_ELEMENTS.tiempoValue.textContent = '0 seg';
                        DOM_ELEMENTS.listaRecomendaciones.innerHTML = "";
                        DOM_ELEMENTS.bloqueRecomendaciones.classList.add('hidden');
                        DOM_ELEMENTS.recomendacionesInput.value = '';
                        break;
                    case 'detectionStarted':
                        DOM_ELEMENTS.btnText.textContent = 'Analizando...';
                        DOM_ELEMENTS.btnSpinner.classList.remove('hidden');
                        DOM_ELEMENTS.btnDetectar.disabled = true;
                        DOM_ELEMENTS.loadingOverlay.classList.remove('hidden');
                        break;
                    case 'detectionCompleted':
                        DOM_ELEMENTS.btnText.textContent = 'Analizar con IA';
                        DOM_ELEMENTS.btnSpinner.classList.add('hidden');
                        DOM_ELEMENTS.btnDetectar.disabled = false;
                        DOM_ELEMENTS.loadingOverlay.classList.add('hidden');
                        break;
                }
            },

            mostrarRecomendaciones: (enfermedad) => {
                DOM_ELEMENTS.listaRecomendaciones.innerHTML = "";

                if (RECOMENDACIONES[enfermedad]) {
                    DOM_ELEMENTS.listaRecomendaciones.innerHTML = RECOMENDACIONES[enfermedad]
                        .map(r => `<li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-3 flex-shrink-0"></i><span>${r}</span></li>`).join("");
                } else {
                    DOM_ELEMENTS.listaRecomendaciones.innerHTML = `<li class="flex items-start"><i class="fas fa-info-circle text-blue-500 mt-1 mr-3 flex-shrink-0"></i><span>No hay recomendaciones disponibles para "${enfermedad}".</span></li>`;
                }

                DOM_ELEMENTS.bloqueRecomendaciones.classList.remove('hidden');
            },

            updateDetectionResults: (data) => {
                DOM_ELEMENTS.enfermedadInput.value = data.prediction.predicted_class;
                const confianza = (data.prediction.max_confidence * 100).toFixed(2);
                DOM_ELEMENTS.confianzaInput.value = confianza;
                DOM_ELEMENTS.confianzaValue.textContent = confianza + '%';
                DOM_ELEMENTS.confidenceBar.style.width = `${confianza}%`;

                DOM_ELEMENTS.detectionResults.classList.remove('hidden');
                DOM_ELEMENTS.submitButton.disabled = false;

                // Guardar las recomendaciones en el campo hidden
                const recomendaciones = RECOMENDACIONES[data.prediction.predicted_class] || ["No hay recomendaciones disponibles para esta enfermedad."];
                DOM_ELEMENTS.recomendacionesInput.value = JSON.stringify(recomendaciones);

                Utils.mostrarRecomendaciones(data.prediction.predicted_class);
                DOM_ELEMENTS.detectionResults.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        };

        // Manejadores de eventos
        const EventHandlers = {
            handleImageUpload: function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];

                    if (!Utils.validateFile(file)) {
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        DOM_ELEMENTS.preview.src = e.target.result;
                        DOM_ELEMENTS.uploadPlaceholder.classList.add('hidden');
                        DOM_ELEMENTS.imagePreviewContainer.classList.remove('hidden');
                        Utils.updateUIState('imageUploaded');
                    }
                    reader.readAsDataURL(file);
                }
            },

            handleDragOver: function(e) {
                e.preventDefault();
                this.classList.add('border-blue-500', 'bg-blue-100');
            },

            handleDragLeave: function(e) {
                e.preventDefault();
                this.classList.remove('border-blue-500', 'bg-blue-100');
            },

            handleDrop: function(e) {
                e.preventDefault();
                this.classList.remove('border-blue-500', 'bg-blue-100');

                if (e.dataTransfer.files.length) {
                    DOM_ELEMENTS.imagenInput.files = e.dataTransfer.files;
                    const event = new Event('change');
                    DOM_ELEMENTS.imagenInput.dispatchEvent(event);
                }
            },

            handleRemoveImage: function() {
                DOM_ELEMENTS.imagenInput.value = '';
                DOM_ELEMENTS.uploadPlaceholder.classList.remove('hidden');
                DOM_ELEMENTS.imagePreviewContainer.classList.add('hidden');
                Utils.updateUIState('imageRemoved');
            },

            handleDetection: async function() {
                if (!DOM_ELEMENTS.imagenInput.files[0]) {
                    Utils.showError('Por favor, seleccione una imagen primero.');
                    return;
                }

                Utils.updateUIState('detectionStarted');

                let tiempo = 0;
                DOM_ELEMENTS.tiempoInput.value = tiempo;
                DOM_ELEMENTS.tiempoValue.textContent = tiempo + ' seg';
                const interval = setInterval(() => {
                    tiempo += 1;
                    DOM_ELEMENTS.tiempoInput.value = tiempo;
                    DOM_ELEMENTS.tiempoValue.textContent = tiempo + ' seg';
                }, 1000);

                try {
                    const formData = new FormData();
                    formData.append('image', DOM_ELEMENTS.imagenInput.files[0]);
                    formData.append('_token', CONFIG.CSRF_TOKEN);

                    const response = await fetch(CONFIG.API_ENDPOINT, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });

                    const data = await response.json();

                    if (data.success) {
                        Utils.updateDetectionResults(data);
                    } else {
                        Utils.showError(data.error || 'Error en el análisis de la imagen');
                    }
                } catch (error) {
                    Utils.showError('Error de conexión: ' + error.message);
                } finally {
                    clearInterval(interval);
                    Utils.updateUIState('detectionCompleted');
                }
            }
        };

        // Inicialización de la aplicación
        document.addEventListener('DOMContentLoaded', function() {
            // Asignar eventos
            DOM_ELEMENTS.imagenInput.addEventListener('change', EventHandlers.handleImageUpload);
            DOM_ELEMENTS.dropZone.addEventListener('dragover', EventHandlers.handleDragOver);
            DOM_ELEMENTS.dropZone.addEventListener('dragleave', EventHandlers.handleDragLeave);
            DOM_ELEMENTS.dropZone.addEventListener('drop', EventHandlers.handleDrop);
            DOM_ELEMENTS.removeImage.addEventListener('click', EventHandlers.handleRemoveImage);
            DOM_ELEMENTS.btnDetectar.addEventListener('click', EventHandlers.handleDetection);
        });
    </script>
@endsection
