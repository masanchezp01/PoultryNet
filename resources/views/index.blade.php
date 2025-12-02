@extends('layouts.invitado')

@section('title', 'PoultryNet - Plataforma Inteligencia Avícola')

@section('content')
    @php
        // Leer una sola vez el SVG del logo y prepararlo para inyección inline
        $logoPath = public_path('img/Logo_svg.svg');
        $logoSvgContent = null;
        if (file_exists($logoPath)) {
            $logoSvgContent = file_get_contents($logoPath);
            // Eliminar rects de fondo que puedan tapar el diseño
            $logoSvgContent = preg_replace('/<rect[^>]*\/\>/i', '', $logoSvgContent);
            // Normalizar la etiqueta svg para que sea responsivo y tenga clases utilitarias
            $logoSvgContent = preg_replace('/<svg[^>]*viewBox="([^"]+)"[^>]*>/i', '<svg viewBox="$1" class="w-full h-full" role="img" aria-hidden="true">', $logoSvgContent);
            // Forzar fills/strokes a currentColor para colorear con clases text-*
            $logoSvgContent = preg_replace('/(fill|stroke)="(?!currentColor)[^"]*"/i', '$1="currentColor"', $logoSvgContent);
        }
    @endphp
    {{-- Hero principal con más vida visual --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-white to-emerald-50 min-h-screen flex items-center justify-center">
        {{-- Fondos decorativos con pollitos --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-10 right-10 w-24 h-24 opacity-20 text-amber-400">
                @if($logoSvgContent)
                    {!! $logoSvgContent !!}
                @else
                    <svg viewBox="0 0 100 100" class="w-full h-full" aria-hidden="true">
                        <path fill="currentColor" d="M50 15c-15 0-25 15-25 30 0 10 5 20 15 25-5 5-10 10-10 15 0 10 10 15 20 15 10 0 20-5 20-15 0-5-5-10-10-15 10-5 15-15 15-25 0-15-10-30-25-30z"/>
                    </svg>
                @endif
            </div>


            
            <div class="absolute bottom-20 left-10 w-20 h-20 opacity-15 text-amber-300">
                @if($logoSvgContent)
                    {!! $logoSvgContent !!}
                @else
                    <svg viewBox="0 0 100 100" class="w-full h-full" aria-hidden="true">
                        <path fill="currentColor" d="M50 15c-15 0-25 15-25 30 0 10 5 20 15 25-5 5-10 10-10 15 0 10 10 15 20 15 10 0 20-5 20-15 0-5-5-10-10-15 10-5 15-15 15-25 0-15-10-30-25-30z"/>
                    </svg>
                @endif
            </div>
            <div class="absolute top-1/3 left-1/4 w-16 h-16 opacity-10 text-amber-500">
                @if($logoSvgContent)
                    {!! $logoSvgContent !!}
                @else
                    <svg viewBox="0 0 100 100" class="w-full h-full" aria-hidden="true">
                        <path fill="currentColor" d="M50 20c-12 0-22 12-22 25 0 8 4 16 12 20-4 4-8 8-8 12 0 8 8 13 16 13 8 0 16-4 16-13 0-4-4-8-8-12 8-4 12-12 12-20 0-13-10-25-22-25z"/>
                    </svg>
                @endif
            </div>

            {{-- Formas geométricas de fondo --}}
            <div class="absolute top-0 left-0 w-72 h-72 bg-amber-100 rounded-full blur-3xl opacity-20"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-emerald-100 rounded-full blur-3xl opacity-30"></div>
        </div>

        <div class="w-full px-6 md:px-12 relative z-10 py-16">
            <div class="text-center max-w-4xl mx-auto">
                {{-- Logo grande y llamativo --}}
                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <div class="w-32 h-32 rounded-2xl shadow-lg mb-4 mx-auto overflow-hidden">
                            {{-- Imagen ocupa todo el contenedor y se recorta con esquinas redondeadas --}}
                            <img src="{{ asset('img/logo_principal.png') }}" alt="PoultryNet" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                {{-- Badge mejorado --}}
                <div class="inline-flex items-center gap-2 px-4 py-2 mb-8 bg-white/80 backdrop-blur-sm border border-amber-200 rounded-full text-sm font-semibold text-amber-700 uppercase tracking-wide shadow-sm">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    Plataforma Avícola Inteligente
                </div>

                {{-- Título principal más destacado --}}
                <h1 class="text-7xl md:text-8xl font-black text-slate-900 mb-6 tracking-tight bg-gradient-to-r from-amber-600 to-emerald-600 bg-clip-text text-transparent">
                    PoultryNet
                </h1>

                {{-- Línea decorativa con color --}}
                <div class="w-32 h-1 bg-gradient-to-r from-amber-400 to-emerald-400 mx-auto mb-8 rounded-full"></div>

                {{-- Subtítulo mejorado --}}
                <p class="text-2xl text-slate-700 mb-12 max-w-2xl mx-auto leading-relaxed font-medium">
                    Revolucionando la industria avícola con
                    <span class="text-emerald-600 font-bold">inteligencia artificial predictiva</span>
                </p>

                {{-- Métricas en tarjetas --}}
                <div class="grid grid-cols-3 gap-6 mb-12 max-w-lg mx-auto">
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-amber-100 shadow-sm text-center">
                        <div class="text-2xl font-black text-slate-900 mb-1">98.7%</div>
                        <div class="text-xs text-slate-600 font-semibold">Precisión IA</div>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-emerald-100 shadow-sm text-center">
                        <div class="text-2xl font-black text-slate-900 mb-1">0.8s</div>
                        <div class="text-xs text-slate-600 font-semibold">Diagnóstico</div>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-amber-100 shadow-sm text-center">
                        <div class="text-2xl font-black text-slate-900 mb-1">750+</div>
                        <div class="text-xs text-slate-600 font-semibold">Granjas</div>
                    </div>
                </div>

                {{-- Botones de acción mejorados --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                    <a href="{{ route('login')}}" class="px-8 py-4 bg-gradient-to-r from-slate-900 to-slate-700 text-white rounded-xl font-bold hover:from-slate-800 hover:to-slate-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('vista.registro') }}" class="px-8 py-4 bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-xl font-bold hover:from-amber-600 hover:to-amber-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Registrarse Gratis
                    </a>
                </div>

                {{-- Scroll indicator mejorado --}}
                <div class="flex flex-col items-center gap-3">
                    <div class="text-sm text-slate-500 font-medium">Descubre más</div>
                    <svg class="w-5 h-5 text-amber-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección de características mejorada --}}
    <div id="features" class="py-24 bg-gradient-to-b from-slate-50 to-white relative overflow-hidden">
        {{-- Pollito decorativo --}}
        <div class="absolute top-10 right-20 w-16 h-16 opacity-10 text-amber-400">
            @if($logoSvgContent)
                {!! $logoSvgContent !!}
            @else
                <svg viewBox="0 0 100 100" class="w-full h-full" aria-hidden="true">
                    <path fill="currentColor" d="M50 15c-15 0-25 15-25 30 0 10 5 20 15 25-5 5-10 10-10 15 0 10 10 15 20 15 10 0 20-5 20-15 0-5-5-10-10-15 10-5 15-15 15-25 0-15-10-30-25-30z"/>
                </svg>
            @endif
        </div>

        <div class="w-full px-6 md:px-12 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-black text-slate-900 mb-6">Tecnología Avanzada para Avicultura</h2>
                <p class="text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed">Soluciones inteligentes que transforman la gestión avícola con IA de última generación</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-7xl mx-auto">
                {{-- Card 1 mejorada --}}
                <div class="bg-white p-8 rounded-2xl border border-slate-200 hover:border-amber-200 transition-all duration-300 shadow-sm hover:shadow-lg group">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">IA Predictiva Avanzada</h3>
                    <p class="text-slate-600 leading-relaxed">Algoritmos de machine learning especializados en diagnóstico temprano y preciso de enfermedades aviares con 98.7% de efectividad.</p>
                </div>

                {{-- Card 2 mejorada --}}
                <div class="bg-white p-8 rounded-2xl border border-slate-200 hover:border-blue-200 transition-all duration-300 shadow-sm hover:shadow-lg group">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Monitoreo en Tiempo Real</h3>
                    <p class="text-slate-600 leading-relaxed">Sistema de vigilancia continua con análisis instantáneo y latencia inferior a 800ms para decisiones inmediatas.</p>
                </div>

                {{-- Card 3 mejorada --}}
                <div class="bg-white p-8 rounded-2xl border border-slate-200 hover:border-amber-200 transition-all duration-300 shadow-sm hover:shadow-lg group">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-100 to-amber-200 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Dashboard Inteligente</h3>
                    <p class="text-slate-600 leading-relaxed">Interfaz intuitiva con visualización avanzada de datos, reportes automatizados y alertas predictivas integradas.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Demo en vivo mejorada --}}
    <div class="py-24 bg-gradient-to-b from-white to-slate-50 relative overflow-hidden">
        {{-- Pollito decorativo --}}
        <div class="absolute bottom-10 left-20 w-20 h-20 opacity-10 text-amber-300">
            @if($logoSvgContent)
                {!! $logoSvgContent !!}
            @else
                <svg viewBox="0 0 100 100" class="w-full h-full" aria-hidden="true">
                    <path fill="currentColor" d="M50 15c-15 0-25 15-25 30 0 10 5 20 15 25-5 5-10 10-10 15 0 10 10 15 20 15 10 0 20-5 20-15 0-5-5-10-10-15 10-5 15-15 15-25 0-15-10-30-25-30z"/>
                </svg>
            @endif
        </div>

        <div class="w-full px-6 md:px-12 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-black text-slate-900 mb-6">Demo en Vivo</h2>
                <p class="text-xl text-slate-600 max-w-2xl mx-auto">Sistema de monitoreo inteligente en tiempo real</p>
            </div>

            <div class="grid lg:grid-cols-2 gap-8 max-w-5xl mx-auto">
                {{-- Panel de control mejorado --}}
                <div class="bg-gradient-to-br from-white to-amber-50 p-8 rounded-2xl border border-amber-100 shadow-lg">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-100 to-amber-200 rounded-xl flex items-center justify-center shadow-sm">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1m-16 0H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-lg">Control de Iluminación</h3>
                                <p class="text-sm text-slate-500">Gestión ambiental inteligente</p>
                            </div>
                        </div>
                        @if($luz)
                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold shadow-sm">
                                <span class="w-2 h-2 bg-emerald-600 rounded-full animate-pulse"></span>
                                Activa
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-600 rounded-full text-sm font-semibold">
                                <span class="w-2 h-2 bg-slate-400 rounded-full"></span>
                                Inactiva
                            </span>
                        @endif
                    </div>

                    <form action="{{ route('firebase.toggleLuz') }}" method="POST" id="form-luz">
                        @csrf
                        <label class="flex items-center justify-between cursor-pointer p-6 bg-white rounded-xl border border-amber-200 hover:border-amber-300 transition-all duration-200 shadow-sm hover:shadow-md">
                            <span class="font-bold text-slate-900 text-lg">{{ $luz ? 'Apagar Iluminación' : 'Encender Iluminación' }}</span>
                            <div class="relative">
                                <input type="checkbox" name="luz" id="luz-switch" class="sr-only peer"
                                       onchange="document.getElementById('form-luz').submit();"
                                       @if($luz) checked @endif>
                                <div class="w-14 h-7 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-7 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-600 shadow-inner"></div>
                            </div>
                        </label>
                    </form>
                </div>

                {{-- Sensores mejorados --}}
                <div class="bg-gradient-to-br from-white to-emerald-50 p-8 rounded-2xl border border-emerald-100 shadow-lg">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-lg">Monitoreo Ambiental</h3>
                            <p class="text-sm text-slate-500">Sensores en tiempo real</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-xl border border-emerald-200 shadow-sm">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                    </svg>
                                </div>
                                <div class="text-xs text-slate-500 font-semibold">Humedad</div>
                            </div>
                            <div class="text-3xl font-black text-slate-900">
                                <span id="humedad">{{ $sensores['humedad'] ?? 'N/A' }}</span>%
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-xl border border-amber-200 shadow-sm">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <div class="text-xs text-slate-500 font-semibold">Temperatura</div>
                            </div>
                            <div class="text-3xl font-black text-slate-900">
                                <span id="temperatura">{{ $sensores['mediciones'] ?? 'N/A' }}</span>°C
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CTA Final mejorado --}}
    <div class="py-24 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden">
        {{-- Pollitos decorativos: inyectamos `Logo_svg.svg` como SVG inline para poder colorearlo con clases `text-*`. --}}

    <div class="absolute top-10 left-10 w-64 h-64 opacity-10 text-amber-300 transform -translate-x-19 -translate-y-10">
            @if($logoSvgContent)
                {!! $logoSvgContent !!}
            @else
                {{-- Placeholder si no se encuentra el archivo --}}
                <svg viewBox="0 0 100 100" class="w-full h-full" aria-hidden="true">
                    <path fill="currentColor" d="M50 15c-15 0-25 15-25 30 0 10 5 20 15 25-5 5-10 10-10 15 0 10 10 15 20 15 10 0 20-5 20-15 0-5-5-10-10-15 10-5 15-15 15-25 0-15-10-30-25-30z"/>
                </svg>
            @endif
        </div>

    <div class="absolute bottom-10 right-10 w-64 h-64 opacity-10 text-amber-400 transform translate-x-12 translate-y-16 md:translate-x-18"> 
            @if($logoSvgContent)
                {!! $logoSvgContent !!}
            @else
                <svg viewBox="0 0 100 100" class="w-full h-full" aria-hidden="true">
                    <path fill="currentColor" d="M50 15c-15 0-25 15-25 30 0 10 5 20 15 25-5 5-10 10-10 15 0 10 10 15 20 15 10 0 20-5 20-15 0-5-5-10-10-15 10-5 15-15 15-25 0-15-10-30-25-30z"/>
                </svg>
            @endif
        </div>

        <div class="w-full px-6 md:px-12 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-5xl font-black text-white mb-8">Transforma tu Avicultura Hoy</h2>
                <p class="text-xl text-slate-300 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Únete a la plataforma de inteligencia avícola más avanzada y comienza a optimizar tu producción
                </p>

                <div class="flex flex-col sm:flex-row gap-6 justify-center mb-16">
                    <a href="{{ route('vista.registro') }}" class="px-10 py-4 bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-xl font-bold hover:from-amber-600 hover:to-amber-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-lg">
                        Comenzar Gratis
                    </a>
                    <a href="{{ route('login') }}" class="px-10 py-4 bg-slate-700 text-white rounded-xl font-bold border border-slate-600 hover:bg-slate-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-lg">
                        Acceder al Sistema
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-20 pt-20 border-t border-slate-700">
                    <div class="text-center">
                        <div class="text-3xl font-black text-amber-400 mb-2">4.9/5</div>
                        <div class="text-sm text-slate-400 font-semibold">Valoración Clientes</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-amber-400 mb-2">750+</div>
                        <div class="text-sm text-slate-400 font-semibold">Granjas Activas</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-amber-400 mb-2">99.9%</div>
                        <div class="text-sm text-slate-400 font-semibold">Tiempo Activo</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-amber-400 mb-2">24/7</div>
                        <div class="text-sm text-slate-400 font-semibold">Soporte Técnico</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        * {
            scroll-behavior: smooth;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #f59e0b, #d97706);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #d97706, #b45309);
        }

        body {
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden;
        }

        main.container {
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Animaciones suaves para las tarjetas */
        .feature-card {
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll mejorado
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Efectos de hover para botones
            const buttons = document.querySelectorAll('a[href*="login"], a[href*="registro"]');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
@endpush
