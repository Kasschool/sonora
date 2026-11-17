<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;

class SonoraController extends Controller
{
    private function obtenerPlaylists(): array
    {
        return [
            [
                'id' => 1,
                'titulo' => 'Mezcla diaria 1',
                'artista' => 'Para ti · Música',
                'tipo' => 'musica',
                'duracion' => '25:30',
                'descripcion' => 'Selección instrumental y acústica para concentrarte sin interrupciones.',
                'barras' => [40, 70, 55, 90, 35],
                'track_ids' => [1, 2, 3, 4, 5, 7],
            ],
            [
                'id' => 2,
                'titulo' => 'Noches de lluvia',
                'artista' => 'Playlist · Calma',
                'tipo' => 'musica',
                'duracion' => '16:23',
                'descripcion' => 'Melodías suaves pensadas para acompañar el final del día.',
                'barras' => [80, 45, 65, 30, 75],
                'track_ids' => [1, 5, 7, 4],
            ],
            [
                'id' => 3,
                'titulo' => 'Crónicas del puerto',
                'artista' => 'Podcasts · Historias',
                'tipo' => 'podcasts',
                'duracion' => '10:55',
                'descripcion' => 'Conversaciones e historias breves sobre música y territorio.',
                'barras' => [50, 85, 40, 70, 60],
                'track_ids' => [6, 8],
            ],
            [
                'id' => 4,
                'titulo' => 'Caminos abiertos',
                'artista' => 'Mar Abierto · Sesión',
                'tipo' => 'musica',
                'duracion' => '17:19',
                'descripcion' => 'Ritmos constantes para acompañarte en tus trayectos diarios.',
                'barras' => [30, 60, 90, 50, 80],
                'track_ids' => [2, 3, 4, 7],
            ],
        ];
    }

    public function inicio(Request $request)
    {
        $filtro = $request->query('filtro', 'todo');
        $todasPlaylists = $this->obtenerPlaylists();
        $playlists = $filtro === 'todo'
            ? $todasPlaylists
            : array_filter($todasPlaylists, fn($p) => $p['tipo'] === $filtro);

        $pistas = Track::all();

        return view('inicio', compact('pistas', 'playlists', 'filtro'));
    }

    public function playlist(int $id = 1)
    {
        $playlists = $this->obtenerPlaylists();
        $playlistActual = collect($playlists)->firstWhere('id', $id) ?? $playlists[0];
        $pistas = Track::all();
        $pistasPlaylist = Track::whereIn('id', $playlistActual['track_ids'])->get();

        return view('playlist', compact('playlists', 'playlistActual', 'pistasPlaylist', 'pistas'));
    }

    public function reproductor()
    {
        $pistas = Track::all();
        return view('reproductor', compact('pistas'));
    }

    public function buscar(Request $request)
    {
        $q = trim($request->query('q', ''));
        $pistas = Track::all();

        $pistasFiltradas = $q === ''
            ? $pistas
            : Track::where('titulo', 'like', "%{$q}%")
                ->orWhere('artista', 'like', "%{$q}%")
                ->orWhere('album', 'like', "%{$q}%")
                ->get();

        $playlistsFiltradas = array_filter($this->obtenerPlaylists(), function ($pl) use ($q) {
            if ($q === '') return true;
            return str_contains(mb_strtolower($pl['titulo']), mb_strtolower($q))
                || str_contains(mb_strtolower($pl['descripcion']), mb_strtolower($q));
        });

        return view('buscar', compact('pistas', 'pistasFiltradas', 'playlistsFiltradas', 'q'));
    }
}