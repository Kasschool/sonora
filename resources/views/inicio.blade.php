@extends('layouts.app')

@section('titulo', 'Inicio · Sonora')

@section('contenido')
<div class="space-y-8">
    <div>
        <div class="mb-6 flex flex-wrap gap-2" role="group" aria-label="Filtrar contenido">
            <x-chip :href="route('inicio', ['filtro' => 'todo'])" :activo="$filtro === 'todo'">Todo</x-chip>
            <x-chip :href="route('inicio', ['filtro' => 'musica'])" :activo="$filtro === 'musica'">Música</x-chip>
            <x-chip :href="route('inicio', ['filtro' => 'podcasts'])" :activo="$filtro === 'podcasts'">Podcasts</x-chip>
        </div>

        <p class="mb-1 text-xs font-bold uppercase tracking-wider text-ink-muted">Para ti</p>
        <h1 class="mb-4 text-[32px] leading-[36px] font-extrabold tracking-[-0.01em]">Tu música, sin ruido</h1>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($playlists as $p)
                <x-media-card
                    :id="$p['id']"
                    :titulo="$p['titulo']"
                    :artista="$p['artista']"
                    :duracion="$p['duracion']"
                    :barras="$p['barras']"
                />
            @endforeach
        </div>
    </div>

    <div>
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-[20px] leading-[26px] font-bold">En cola</h2>
            <span class="font-mono text-xs text-ink-muted">{{ $pistas->count() }} pistas</span>
        </div>
        <div class="max-w-2xl rounded-md bg-surface-raised p-2">
            @foreach ($pistas as $i => $pista)
                <x-song-row :indice="$i" :pista="$pista" />
            @endforeach
        </div>
    </div>
</div>
@endsection