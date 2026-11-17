@extends('layouts.app')

@section('titulo', 'Buscar · Sonora')

@section('contenido')
<div class="space-y-8">
    <form method="GET" action="{{ route('buscar') }}" class="max-w-xl space-y-4">
        <h1 class="text-[32px] leading-[36px] font-extrabold tracking-[-0.01em]">Buscar en Sonora</h1>
        <label for="q" class="sr-only">Buscar canciones, artistas o playlists</label>
        <div class="flex gap-2">
            <input type="search" id="q" name="q" value="{{ $q }}" placeholder="Escribe una canción, artista o playlist"
                class="w-full rounded-pill border-2 border-line-strong bg-surface-high px-4 py-3 text-sm text-ink placeholder:text-ink-muted focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus">
            <x-button type="submit" variant="secondary">Buscar</x-button>
        </div>
    </form>

    <div>
        <h2 class="mb-4 text-[20px] leading-[26px] font-bold">Canciones encontradas</h2>
        <div class="max-w-2xl rounded-md bg-surface-raised p-2">
            @forelse ($pistasFiltradas as $i => $pista)
                <x-song-row :indice="$i" :pista="$pista" />
            @empty
                <p class="p-4 text-sm text-ink-muted">No encontramos canciones con esa búsqueda.</p>
            @endforelse
        </div>
    </div>

    <div>
        <h2 class="mb-4 text-[20px] leading-[26px] font-bold">Playlists relacionadas</h2>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($playlistsFiltradas as $p)
                <x-media-card
                    :id="$p['id']"
                    :titulo="$p['titulo']"
                    :artista="$p['artista']"
                    :duracion="$p['duracion']"
                    :barras="$p['barras']"
                />
            @empty
                <p class="text-sm text-ink-muted">No hay playlists que coincidan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection