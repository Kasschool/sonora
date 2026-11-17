@extends('layouts.app')

@section('titulo', $playlistActual['titulo'] . ' · Sonora')

@section('contenido')
<div class="space-y-8">
    <div class="flex flex-wrap gap-2" role="group" aria-label="Seleccionar playlist">
        @foreach ($playlists as $item)
            <x-chip :href="route('playlist', $item['id'])" :activo="$item['id'] === $playlistActual['id']">
                {{ $item['titulo'] }}
            </x-chip>
        @endforeach
    </div>

    <div class="flex flex-col gap-6 rounded-lg bg-surface-raised p-6 sm:flex-row sm:items-end">
        <div class="flex size-40 shrink-0 items-end gap-2 rounded-md bg-surface-high p-4">
            @foreach ($playlistActual['barras'] as $h)
                <i class="flex-1 rounded-pill bg-accent" style="height: {{ $h }}%"></i>
            @endforeach
        </div>

        <div class="flex-1 space-y-2">
            <p class="text-xs font-bold uppercase tracking-wider text-ink-muted">
                {{ $playlistActual['tipo'] === 'podcasts' ? 'Podcast' : 'Playlist' }}
            </p>
            <h1 class="text-[32px] leading-[36px] font-extrabold tracking-[-0.01em] md:text-[56px] md:leading-[58px] md:tracking-[-0.02em]">
                {{ $playlistActual['titulo'] }}
            </h1>
            <p class="text-base text-ink-muted">{{ $playlistActual['descripcion'] }}</p>
            <p class="font-mono text-sm text-ink-muted">{{ $pistasPlaylist->count() }} canciones · {{ $playlistActual['duracion'] }}</p>

            <div class="flex flex-wrap items-center gap-3 pt-2">
                <x-button variant="primary" id="btn-pl-reproducir" data-primer-track="{{ $playlistActual['track_ids'][0] ?? 1 }}">
                    <x-icon name="play" class="size-5" />
                    <span>Reproducir todo</span>
                </x-button>

                <x-button variant="secondary" id="btn-pl-guardar" aria-pressed="false">
                    <x-icon name="heart" class="size-5" />
                    <span id="txt-pl-guardar">Guardar en tu biblioteca</span>
                </x-button>

                <span id="estado-pl-guardado" class="hidden items-center gap-1 text-sm font-bold text-success" role="status">
                    <x-icon name="heart" class="size-5" />
                    <span>Guardada en tu biblioteca</span>
                </span>
            </div>
        </div>
    </div>

    <div class="rounded-md bg-surface-raised p-2">
        @foreach ($pistasPlaylist as $i => $pista)
            <x-song-row :indice="$i" :pista="$pista" />
        @endforeach
    </div>
</div>
@endsection