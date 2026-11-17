<!doctype html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Sonora')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400&family=Manrope:wght@400;500;700;800&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="overflow-hidden">
    <script>window.pistas = @json($pistas ?? []);</script>

    <div class="grid h-dvh grid-cols-1 grid-rows-[1fr_auto_auto] md:grid-cols-[220px_1fr] md:grid-rows-[1fr_84px]">

        {{-- Navegación lateral (Escritorio) --}}
        <nav class="hidden flex-col gap-2 border-r border-line bg-surface-raised px-4 py-6 md:flex" aria-label="Navegación principal">
            <a href="{{ route('inicio') }}" class="mb-6 flex items-center gap-2 px-2 text-xl font-extrabold tracking-tight focus-visible:outline-[3px] focus-visible:outline-focus">
                <svg class="size-7 text-accent" viewBox="0 0 64 64" aria-hidden="true">
                    <g fill="currentColor">
                        <rect x="4" y="32" width="8" height="28" rx="4"/>
                        <rect x="16" y="12" width="8" height="48" rx="4"/>
                        <rect x="28" y="24" width="8" height="36" rx="4"/>
                        <rect x="40" y="4" width="8" height="56" rx="4"/>
                        <rect x="52" y="36" width="8" height="24" rx="4"/>
                    </g>
                </svg>
                <span>Sonora</span>
            </a>

            <a href="{{ route('inicio') }}" @if(request()->routeIs('inicio')) aria-current="page" @endif
               class="flex items-center gap-3 rounded-md p-3 text-sm font-bold transition duration-120 hover:bg-surface-high focus-visible:outline-[3px] focus-visible:outline-focus {{ request()->routeIs('inicio') ? 'bg-surface-high text-ink' : 'text-ink-muted' }}">
                <x-icon name="home" /> <span>Inicio</span>
            </a>

            <a href="{{ route('buscar') }}" @if(request()->routeIs('buscar')) aria-current="page" @endif
               class="flex items-center gap-3 rounded-md p-3 text-sm font-bold transition duration-120 hover:bg-surface-high focus-visible:outline-[3px] focus-visible:outline-focus {{ request()->routeIs('buscar') ? 'bg-surface-high text-ink' : 'text-ink-muted' }}">
                <x-icon name="search" /> <span>Buscar</span>
            </a>

            <a href="{{ route('playlist') }}" @if(request()->routeIs('playlist')) aria-current="page" @endif
               class="flex items-center gap-3 rounded-md p-3 text-sm font-bold transition duration-120 hover:bg-surface-high focus-visible:outline-[3px] focus-visible:outline-focus {{ request()->routeIs('playlist') ? 'bg-surface-high text-ink' : 'text-ink-muted' }}">
                <x-icon name="library" /> <span>Tu biblioteca</span>
            </a>

            <a href="{{ route('reproductor') }}" @if(request()->routeIs('reproductor')) aria-current="page" @endif
               class="flex items-center gap-3 rounded-md p-3 text-sm font-bold transition duration-120 hover:bg-surface-high focus-visible:outline-[3px] focus-visible:outline-focus {{ request()->routeIs('reproductor') ? 'bg-surface-high text-ink' : 'text-ink-muted' }}">
                <x-icon name="play" /> <span>Reproductor</span>
            </a>

            <div class="mt-auto border-t border-line pt-4">
                <x-button variant="secondary" id="tema" class="w-full py-2">Cambiar tema</x-button>
            </div>
        </nav>

        {{-- Área principal --}}
        <main class="overflow-y-auto px-4 py-6 md:px-8">
            <header class="mb-6 flex items-center justify-between md:hidden">
                <a href="{{ route('inicio') }}" class="flex items-center gap-2 text-xl font-extrabold tracking-tight">
                    <svg class="size-6 text-accent" viewBox="0 0 64 64" aria-hidden="true">
                        <g fill="currentColor">
                            <rect x="4" y="32" width="8" height="28" rx="4"/>
                            <rect x="16" y="12" width="8" height="48" rx="4"/>
                            <rect x="28" y="24" width="8" height="36" rx="4"/>
                            <rect x="40" y="4" width="8" height="56" rx="4"/>
                            <rect x="52" y="36" width="8" height="24" rx="4"/>
                        </g>
                    </svg>
                    <span>Sonora</span>
                </a>
                <x-button variant="secondary" id="tema-movil" class="px-4 py-2 text-xs">Tema</x-button>
            </header>

            @yield('contenido')
        </main>

        {{-- Barra persistente del reproductor --}}
        @php
            $tienePrimarioEnVista = request()->routeIs('playlist') || request()->routeIs('reproductor');
        @endphp
        <footer class="col-span-1 grid grid-cols-[1fr_auto] items-center gap-4 border-t border-line bg-surface-raised px-4 py-3 md:col-span-2 md:grid-cols-[1fr_2fr_1fr]" aria-label="Reproductor">
            <a href="{{ route('reproductor') }}" class="flex items-center gap-3 rounded-md p-1 transition duration-120 hover:bg-surface-high focus-visible:outline-[3px] focus-visible:outline-focus">
                <div class="flex size-10 shrink-0 items-end gap-0.5 rounded-sm bg-surface-high p-2">
                    <i class="flex-1 rounded-pill bg-accent" style="height: 50%"></i>
                    <i class="flex-1 rounded-pill bg-accent" style="height: 90%"></i>
                    <i class="flex-1 rounded-pill bg-accent" style="height: 65%"></i>
                </div>
                <div class="min-w-0">
                    <p id="titulo" class="truncate text-sm font-bold text-ink"></p>
                    <p id="artista" class="truncate text-xs font-medium text-ink-muted"></p>
                </div>
            </a>

            <div class="flex flex-col items-center gap-1">
                <div class="flex items-center gap-4 md:gap-6">
                    <button type="button" data-accion="anterior" aria-label="Anterior" class="rounded-pill p-1 text-ink hover:bg-surface-high focus-visible:outline-[3px] focus-visible:outline-focus">
                        <x-icon name="prev" />
                    </button>

                    <button type="button" data-accion="alternar" aria-label="Reproducir"
                        class="flex size-10 items-center justify-center rounded-pill transition duration-120 focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus {{ $tienePrimarioEnVista ? 'border-2 border-line-strong text-ink hover:bg-surface-high' : 'bg-accent text-on-accent hover:bg-accent-hover' }}">
                        <x-icon name="play" id="icono-play" />
                        <x-icon name="pause" id="icono-pausa" class="hidden" />
                    </button>

                    <button type="button" data-accion="siguiente" aria-label="Siguiente" class="rounded-pill p-1 text-ink hover:bg-surface-high focus-visible:outline-[3px] focus-visible:outline-focus">
                        <x-icon name="next" />
                    </button>
                </div>

                <div class="hidden w-full items-center gap-2 font-mono text-xs text-ink-muted md:flex">
                    <span id="tiempo">00:00</span>
                    <div id="barra" role="slider" tabindex="0" aria-label="Progreso" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"
                         class="h-1 flex-1 cursor-pointer rounded-pill bg-surface-high focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
                        <div id="relleno" class="h-1 rounded-pill bg-accent" style="width: 0%"></div>
                    </div>
                    <span id="duracion">00:00</span>
                </div>
            </div>

            <div class="hidden justify-end md:flex">
                <a href="{{ route('reproductor') }}" class="rounded-pill border-2 border-line-strong px-4 py-2 text-xs font-bold text-ink transition duration-120 hover:bg-surface-high focus-visible:outline-[3px] focus-visible:outline-focus">
                    Abrir vista completa
                </a>
            </div>
        </footer>

        {{-- Navegación móvil (390px) --}}
        <nav class="grid grid-cols-4 border-t border-line bg-surface-raised py-2 md:hidden" aria-label="Navegación móvil">
            <a href="{{ route('inicio') }}" class="flex flex-col items-center gap-1 py-1 text-xs font-bold {{ request()->routeIs('inicio') ? 'text-ink' : 'text-ink-muted' }}">
                <x-icon name="home" class="size-5" /> <span>Inicio</span>
            </a>
            <a href="{{ route('buscar') }}" class="flex flex-col items-center gap-1 py-1 text-xs font-bold {{ request()->routeIs('buscar') ? 'text-ink' : 'text-ink-muted' }}">
                <x-icon name="search" class="size-5" /> <span>Buscar</span>
            </a>
            <a href="{{ route('playlist') }}" class="flex flex-col items-center gap-1 py-1 text-xs font-bold {{ request()->routeIs('playlist') ? 'text-ink' : 'text-ink-muted' }}">
                <x-icon name="library" class="size-5" /> <span>Playlist</span>
            </a>
            <a href="{{ route('reproductor') }}" class="flex flex-col items-center gap-1 py-1 text-xs font-bold {{ request()->routeIs('reproductor') ? 'text-ink' : 'text-ink-muted' }}">
                <x-icon name="play" class="size-5" /> <span>Sonar</span>
            </a>
        </nav>
    </div>
</body>
</html>