{{-- Header Moderno y Transparente --}}
<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 bg-white/80 backdrop-blur-md border-b border-slate-200/50" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo Section --}}
            <a href="{{ url('/') }}" class="group flex items-center gap-3">
                {{-- Logo Container --}}
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-slate-200 shadow-sm group-hover:shadow-md transition-all duration-300">
                    <img src="{{ asset('img/logo_bn_2.png') }}" alt="PoultryNet" class="w-6 h-6 object-contain">
                </div>

                {{-- Brand Text --}}
                <div class="hidden sm:flex flex-col">
                    <span class="text-xl font-bold text-slate-900 tracking-tight">
                        PoultryNet
                    </span>
                    <span class="text-xs text-slate-500 font-medium tracking-wide mt-0.5">
                        AI Platform
                    </span>
                </div>
            </a>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3">

                {{-- Login Button --}}
                <a href="{{ route('login') }}"
                   class="px-4 py-2 text-slate-700 rounded-lg border border-slate-300 hover:border-slate-400 hover:bg-slate-50 transition-all duration-200 text-sm font-medium">

                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="hidden sm:inline">Acceder</span>
                    </span>
                </a>

                {{-- Register Button --}}
                <a href="{{ route('vista.registro') }}"
                   class="px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition-all duration-200 text-sm font-medium">

                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <span class="hidden sm:inline">Registro</span>
                        <span class="sm:hidden">+</span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- Spacer para el contenido --}}
<div class="h-16"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('navbar');

        // Efecto de scroll para hacer el header más sólido
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 50) {
                navbar.classList.remove('bg-white/80');
                navbar.classList.add('bg-white/95', 'shadow-sm');
            } else {
                navbar.classList.add('bg-white/80');
                navbar.classList.remove('bg-white/95', 'shadow-sm');
            }
        });

        // Animación de entrada suave
        setTimeout(() => {
            navbar.style.opacity = '1';
            navbar.style.transform = 'translateY(0)';
        }, 100);
    });

    // Inicializar estilos de entrada
    const navbar = document.getElementById('navbar');
    navbar.style.opacity = '0';
    navbar.style.transform = 'translateY(-10px)';
    navbar.style.transition = 'all 0.3s ease-out';
</script>
