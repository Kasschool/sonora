@extends('layouts.app')

@section('titulo', 'Reproductor · Sonora')

@section('contenido')
<div class="mx-auto flex max-w-2xl flex-col items-center rounded-lg bg-surface-raised p-6 text-center md:p-8">
    <p class="mb-4 text-xs font-bold uppercase tracking-wider text-ink-muted">Sonando ahora</p>

    <div class="mb-6 flex aspect-square w-60 items-end gap-2 rounded-md bg-surface-high p-6 sm:w-72">
        <i class="flex-1 rounded-pill bg-accent" style="height: 45%"></i>
        <i class="flex-1 rounded-pill bg-accent" style="height: 85%"></i>
        <i class="flex-1 rounded-pill bg-accent" style="height: 60%"></i>
        <i class="flex-1 rounded-pill bg-accent" style="height: 95%"></i>
        <i class="flex-1 rounded-pill bg-accent" style="height: 50%"></i>
    </div>

    <h1 id="rep-titulo" class="text-[32px] leading-[36px] font-extrabold tracking-[-0.01em]"></h1>
    <p id="rep-artista" class="mt-1 text-base text-ink-muted"></p>
    <p class="mt-2 font-mono text-xs text-ink-muted">128 kbps · Estéreo</p>

    <div class="mt-6 w-full space-y-2">
        <div id="rep-barra" role="slider" tabindex="0" aria-label="Progreso de reproducción" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"
             class="h-2 w-full cursor-pointer rounded-pill bg-surface-high focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
            <div id="rep-relleno" class="h-2 rounded-pill bg-accent" style="width: 0%"></div>
        </div>
        <div class="flex justify-between font-mono text-sm text-ink-muted">
            <span id="rep-tiempo">00:00</span>
            <span id="rep-duracion">00:00</span>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-center gap-4 sm:gap-6">
        <button type="button" id="btn-shuffle" aria-pressed="false" aria-label="Modo aleatorio"
            class="rounded-pill p-3 text-ink-muted transition duration-120 hover:bg-surface-high hover:text-ink aria-pressed:text-accent focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
            <x-icon name="shuffle" />
        </button>

        <button type="button" data-accion="anterior" aria-label="Pista anterior"
            class="rounded-pill p-3 text-ink transition duration-120 hover:bg-surface-high focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
            <x-icon name="prev" />
        </button>

        <button type="button" data-accion="alternar" aria-label="Reproducir"
            class="flex size-14 items-center justify-center rounded-pill bg-accent text-on-accent transition duration-120 hover:bg-accent-hover focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
            <x-icon name="play" id="rep-icono-play" class="size-7" />
            <x-icon name="pause" id="rep-icono-pausa" class="hidden size-7" />
        </button>

        <button type="button" data-accion="siguiente" aria-label="Pista siguiente"
            class="rounded-pill p-3 text-ink transition duration-120 hover:bg-surface-high focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
            <x-icon name="next" />
        </button>

        <button type="button" id="btn-like" aria-pressed="false" aria-label="Guardar canción en favoritos"
            class="rounded-pill p-3 text-ink-muted transition duration-120 hover:bg-surface-high hover:text-ink aria-pressed:text-success focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
            <x-icon name="heart" />
        </button>
    </div>

    <div class="mt-6 flex w-full max-w-xs items-center gap-3">
        <x-icon name="volume" class="size-5 text-ink-muted" />
        <input type="range" id="control-volumen" min="0" max="100" value="80" aria-label="Volumen"
            class="h-1 flex-1 cursor-pointer accent-accent focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
        <span id="txt-volumen" class="w-10 text-right font-mono text-xs text-ink-muted">80%</span>
    </div>

    <p id="feedback-rep" class="mt-4 hidden items-center gap-1 text-sm font-bold text-success" role="status">
        <x-icon name="heart" class="size-4" />
        <span>Añadida a tus canciones favoritas</span>
    </p>
</div>
@endsection