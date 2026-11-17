<?php

namespace Database\Seeders;

use App\Models\Track;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $pistas = [
            ['titulo' => 'Noches de lluvia',   'artista' => 'Mar Abierto',   'album' => 'Horizonte Sur',  'dur' => 258, 'tipo' => 'musica'],
            ['titulo' => 'Hora azul',          'artista' => 'Luz de Norte',  'album' => 'Primer Alba',    'dur' => 232, 'tipo' => 'musica'],
            ['titulo' => 'Cuerdas al viento',  'artista' => 'Estudio Cinco', 'album' => 'Sesiones Vivas', 'dur' => 307, 'tipo' => 'musica'],
            ['titulo' => 'Caminos de tierra',  'artista' => 'Mar Abierto',   'album' => 'Horizonte Sur',  'dur' => 209, 'tipo' => 'musica'],
            ['titulo' => 'Sin prisa',          'artista' => 'Luz de Norte',  'album' => 'Calma Interior', 'dur' => 284, 'tipo' => 'musica'],
            ['titulo' => 'Relatos del puerto', 'artista' => 'Voces del Sur', 'album' => 'Crónicas',       'dur' => 340, 'tipo' => 'podcasts'],
            ['titulo' => 'Eco de madera',      'artista' => 'Taller Sonoro', 'album' => 'Acústica',       'dur' => 196, 'tipo' => 'musica'],
            ['titulo' => 'Cuaderno de viaje',  'artista' => 'Voces del Sur', 'album' => 'Crónicas',       'dur' => 315, 'tipo' => 'podcasts'],
        ];

        foreach ($pistas as $pista) {
            Track::create($pista);
        }
    }
}