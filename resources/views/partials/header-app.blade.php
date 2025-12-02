@php
    $isAdminEmail = session('is_admin_email', false);
    $userEmail = Auth::user()->email ?? '';
    $isSpecificAdmin = $userEmail === 'admin@gmail.com';
@endphp

{{-- Header Dashboard Ultra Moderno --}}
<nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-b border-gray-200/50 shadow-sm transition-all duration-500" x-data="{ drawerOpen: false }" id="dashboard-navbar">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">

            {{-- Logo + Menú alineados a la izquierda --}}
            <div class="flex items-center gap-4 lg:gap-8">
                {{-- Logo Premium --}}
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 relative">
                    {{-- Logo Container con Efectos --}}
                    <div class="relative">
                        {{-- Glow Effect: colocarlo detrás y desactivar pointer events para que no interfiera visualmente con el logo --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl blur-md opacity-0 group-hover:opacity-40 transition-all duration-500 scale-110 pointer-events-none z-[-10]"></div>

                        {{-- Logo Box: overflow-visible y z-10 para que la sombra/ring aparezcan hacia afuera (no interior) --}}

                        <div class="relative z-10 w-10 h-10 lg:w-12 lg:h-12 rounded-2xl flex items-center justify-center border border-slate-400 shadow-sm group-hover:shadow-2xl group-hover:ring-4 group-hover:ring-emerald-300/30 transition-all duration-300 overflow-visible">
                            <img src="{{ asset('img/logo_bn_2-sinfondo.png') }}" alt="PoultryNet" class="w-6 h-6 object-contain">
                        </div>
                    </div>

                    {{-- Brand Text --}}
                    <div class="hidden sm:flex flex-col">
                        <span class="text-xl lg:text-2xl font-black bg-gradient-to-r from-green-600 via-emerald-600 to-green-700 bg-clip-text text-transparent leading-none tracking-tight">
                            Poultry Net
                        </span>
                        <span class="text-[10px] text-emerald-600/60 font-semibold tracking-wider uppercase">
                            Dashboard
                        </span>
                    </div>
                </a>

                {{-- Menú PC con Diseño Mejorado --}}
                <div class="hidden lg:flex items-center gap-1">
                    @if($isSpecificAdmin)
                        {{-- Solo Dashboard, Gráficos y Mediciones para admin@gmail.com --}}
                        {{-- Dashboard --}}
                        <a href="{{ route('dashboardAdmin') }}"
                           class="group relative flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300
                           {{ request()->routeIs('dashboardAdmin')
                              ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50 shadow-sm'
                              : 'text-gray-600 hover:text-emerald-700 hover:bg-emerald-50/50' }}">

                            <svg class="w-4 h-4 {{ request()->routeIs('dashboardAdmin') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>

                            <span>Dashboard</span>

                            @if(request()->routeIs('dashboard'))
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full"></div>
                            @endif
                        </a>

                        {{-- Gráficos de Satisfacción --}}
                        <a href="{{ route('grafico.satisfaccion') }}"
                           class="group relative flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300
                           {{ request()->routeIs('grafico.satisfaccion')
                              ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50 shadow-sm'
                              : 'text-gray-600 hover:text-emerald-700 hover:bg-emerald-50/50' }}">

                            <svg class="w-4 h-4 {{ request()->routeIs('grafico.satisfaccion') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3v18m-4-4h8"></path>
                            </svg>

                            <span>Gráficos</span>

                            @if(request()->routeIs('grafico.satisfaccion'))
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full"></div>
                            @endif
                        </a>

                        {{-- Mediciones --}}
                        <a href="{{ route('mediciones.index') }}"
                           class="group relative flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300
                           {{ request()->routeIs('mediciones.*')
                              ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50 shadow-sm'
                              : 'text-gray-600 hover:text-emerald-700 hover:bg-emerald-50/50' }}">

                            <svg class="w-4 h-4 {{ request()->routeIs('mediciones.*') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>

                            <span>Mediciones</span>

                            @if(request()->routeIs('mediciones.*'))
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full"></div>
                            @endif
                        </a>

                    @else
                        {{-- Para otros usuarios: TODO excepto Gráficos y Mediciones --}}

                        {{-- Dashboard --}}
                        <a href="{{ route('dashboard') }}"
                           class="group relative flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300
                           {{ request()->routeIs('dashboard')
                              ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50 shadow-sm'
                              : 'text-gray-600 hover:text-emerald-700 hover:bg-emerald-50/50' }}">

                            <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>

                            <span>Dashboard</span>

                            @if(request()->routeIs('dashboard'))
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full"></div>
                            @endif
                        </a>

                        {{-- Gestión de Sectores --}}
                        <a href="{{ route('sectores.index') }}"
                           class="group relative flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300
                           {{ request()->routeIs('sectores.*')
                              ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50 shadow-sm'
                              : 'text-gray-600 hover:text-emerald-700 hover:bg-emerald-50/50' }}">

                            <svg class="w-4 h-4 {{ request()->routeIs('sectores.*') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>

                            <span>Sectores</span>

                            @if(request()->routeIs('sectores.*'))
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full"></div>
                            @endif
                        </a>

                        {{-- Gestión de Lotes --}}
                        <a href="{{ route('lotes.index') }}"
                           class="group relative flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300
                           {{ request()->routeIs('lotes.*')
                              ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50 shadow-sm'
                              : 'text-gray-600 hover:text-emerald-700 hover:bg-emerald-50/50' }}">

                            <svg class="w-4 h-4 {{ request()->routeIs('lotes.*') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>

                            <span>Lotes</span>

                            @if(request()->routeIs('lotes.*'))
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full"></div>
                            @endif
                        </a>

                        {{-- Historial --}}
                        <a href="{{ route('historial.index') }}"
                           class="group relative flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300
                           {{ request()->routeIs('historial.*')
                              ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50 shadow-sm'
                              : 'text-gray-600 hover:text-emerald-700 hover:bg-emerald-50/50' }}">

                            <svg class="w-4 h-4 {{ request()->routeIs('historial.*') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>

                            <span>Historial</span>

                            @if(request()->routeIs('historial.*'))
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full"></div>
                            @endif
                        </a>

                        {{-- Costos --}}
                        <a href="{{ route('costos.index') }}"
                           class="group relative flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300
                           {{ request()->routeIs('costos.*')
                              ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50 shadow-sm'
                              : 'text-gray-600 hover:text-emerald-700 hover:bg-emerald-50/50' }}">

                            <svg class="w-4 h-4 {{ request()->routeIs('costos.*') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>

                            <span>Costos</span>

                            @if(request()->routeIs('costos.*'))
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full"></div>
                            @endif
                        </a>

                        {{-- Configuración Ambiental --}}
                        <a href="{{ route('registros_ambientales.index') }}"
                           class="group relative flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300
                           {{ request()->routeIs('registros_ambientales.*')
                              ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50 shadow-sm'
                              : 'text-gray-600 hover:text-emerald-700 hover:bg-emerald-50/50' }}">

                            <svg class="w-4 h-4 {{ request()->routeIs('registros_ambientales.*') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }} transition-colors"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 12a9 9 0 1118 0 9 9 0 01-18 0zm9-6v6l4 2" />
                            </svg>

                            <span>Ambiente</span>

                            @if(request()->routeIs('registros_ambientales.*'))
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full"></div>
                            @endif
                        </a>

                    @endif
                </div>
            </div>

            {{-- Resto del código permanece igual... --}}
            {{-- Botón hamburguesa: solo en móvil --}}
            <button @click="drawerOpen = !drawerOpen"
                    class="lg:hidden relative p-2 rounded-xl text-gray-600 hover:text-emerald-700 hover:bg-emerald-50 transition-all duration-300">
                <svg x-show="!drawerOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg x-show="drawerOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            {{-- Usuario a la derecha --}}
            @auth
                @php
                    $firstInitial = strtoupper(substr(Auth::user()->nombres ?? '', 0, 1));
                    $lastInitial  = strtoupper(substr(Auth::user()->apellidos ?? '', 0, 1));
                    $initials = $firstInitial . $lastInitial;
                @endphp

                <div class="hidden lg:block relative" x-data="{ open: false }">
                    {{-- Avatar Button --}}
                    <button @click="open = !open"
                            class="relative w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 text-white font-bold shadow-lg shadow-green-500/30 hover:shadow-xl hover:shadow-green-500/40 hover:scale-110 transition-all duration-300 flex items-center justify-center overflow-hidden group">
                        <span class="relative z-10">{{ $initials ?: 'U' }}</span>

                        {{-- Shine Effect --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>

                        {{-- Online Indicator --}}
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></div>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="open"
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-xl border border-gray-200/50 overflow-hidden z-50"
                         style="display: none;">

                        {{-- User Info --}}
                        <div class="px-4 py-4 bg-gradient-to-br from-emerald-50 to-green-50 border-b border-gray-200/50">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 text-white font-bold flex items-center justify-center shadow-lg">
                                    {{ $initials ?: 'U' }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}</p>
                                    <p class="text-xs text-emerald-600 truncate">{{ Auth::user()->email }}</p>
                                    @if($isSpecificAdmin)
                                        <span class="inline-block mt-1 px-2 py-0.5 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full">
                                            Admin Especial
                                        </span>
                                    @elseif($isAdminEmail)
                                        <span class="inline-block mt-1 px-2 py-0.5 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full">
                                            Admin
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Menu Items --}}
                        <div class="py-2">
                            <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-emerald-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-medium">Mi Perfil</span>
                            </a>

                            <a href="{{route('vista.ajustes')}}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-emerald-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="font-medium">Ajustes</span>
                            </a>
                        </div>

                        {{-- Logout --}}
                        <div class="border-t border-gray-200/50">
                            <form method="POST" action="{{ route('cerrar.sesion') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 transition-colors group">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span class="font-semibold">Cerrar sesión</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    {{-- Drawer para móvil/tablet mejorado --}}
    <div x-show="drawerOpen"
         @click.away="drawerOpen = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden absolute top-full left-0 right-0 bg-white shadow-xl border-b border-gray-200/50 z-40 backdrop-blur-xl"
         style="display: none;">

        <div class="px-4 py-4 space-y-1 max-h-[calc(100vh-5rem)] overflow-y-auto">
            @if($isSpecificAdmin)
                {{-- Solo Dashboard, Gráficos y Mediciones para admin@gmail.com en móvil --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-300
                   {{ request()->routeIs('dashboard')
                      ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50'
                      : 'text-gray-600 hover:bg-emerald-50/50 hover:text-emerald-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('grafico.satisfaccion') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-300
                   {{ request()->routeIs('grafico.satisfaccion')
                      ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50'
                      : 'text-gray-600 hover:bg-emerald-50/50 hover:text-emerald-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3v18m-4-4h8"></path>
                    </svg>
                    Gráficos
                </a>

                <a href="{{ route('mediciones.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-300
                   {{ request()->routeIs('mediciones.*')
                      ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50'
                      : 'text-gray-600 hover:bg-emerald-50/50 hover:text-emerald-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Mediciones
                </a>

            @else
                {{-- Para otros usuarios: TODO excepto Gráficos y Mediciones en móvil --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-300
                   {{ request()->routeIs('dashboard')
                      ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50'
                      : 'text-gray-600 hover:bg-emerald-50/50 hover:text-emerald-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('sectores.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-300
                   {{ request()->routeIs('sectores.*')
                      ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50'
                      : 'text-gray-600 hover:bg-emerald-50/50 hover:text-emerald-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Gestión de Sectores
                </a>

                <a href="{{ route('lotes.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-300
                   {{ request()->routeIs('lotes.*')
                      ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50'
                      : 'text-gray-600 hover:bg-emerald-50/50 hover:text-emerald-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Gestión de Lotes
                </a>

                <a href="{{ route('historial.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-300
                   {{ request()->routeIs('historial.*')
                      ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50'
                      : 'text-gray-600 hover:bg-emerald-50/50 hover:text-emerald-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Historial
                </a>

                <a href="{{ route('costos.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-300
                   {{ request()->routeIs('costos.*')
                      ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50'
                      : 'text-gray-600 hover:bg-emerald-50/50 hover:text-emerald-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Costos
                </a>

                <a href="{{ route('registros_ambientales.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-300
                   {{ request()->routeIs('registros_ambientales.*')
                      ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50'
                      : 'text-gray-600 hover:bg-emerald-50/50 hover:text-emerald-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 1118 0 9 9 0 01-18 0zm9-6v6l4 2" />
                    </svg>
                    Ambiente
                </a>
            @endif

            @auth
                {{-- User info en mobile --}}
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 text-white font-bold flex items-center justify-center shadow-lg">
                            {{ $initials ?: 'U' }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->nombres }}</p>
                            <p class="text-xs text-emerald-600 truncate">{{ Auth::user()->email }}</p>
                            @if($isSpecificAdmin)
                                <span class="inline-block mt-1 px-2 py-0.5 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full">
                                    Admin Especial
                                </span>
                            @elseif($isAdminEmail)
                                <span class="inline-block mt-1 px-2 py-0.5 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full">
                                    Admin
                                </span>
                            @endif
                        </div>
                    </div>

                    <form method="POST" action="{{ route('cerrar.sesion') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-colors font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>

{{-- Spacer para el fixed navbar --}}
<div class="h-16 lg:h-20"></div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('dashboard-navbar');
        let lastScroll = 0;

        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 50) {
                // Navbar con más opacidad al hacer scroll
                navbar.classList.add('bg-white');
                navbar.classList.remove('bg-white/95');
                navbar.classList.add('shadow-lg');
            } else {
                // Restaurar estado original
                navbar.classList.remove('bg-white');
                navbar.classList.add('bg-white/95');
                navbar.classList.remove('shadow-lg');
            }

            lastScroll = currentScroll;
        });
    });
</script>
