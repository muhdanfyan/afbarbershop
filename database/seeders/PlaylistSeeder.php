<?php

namespace Database\Seeders;

use App\Models\Playlist;
use Illuminate\Database\Seeder;

class PlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate existing data to start fresh
        Playlist::truncate();

        $playlists = [
            [
                'judul' => 'Barber Music & LoFi Vibe',
                'jenis' => 'spotify_playlist',
                'url_id' => '37i9dQZF1DXcBWIGoYBM3M',
                'urutan' => 1,
                'status' => true,
            ],
            [
                'judul' => 'Classic Jazz Lounge',
                'jenis' => 'spotify_playlist',
                'url_id' => '37i9dQZF1DXbITWG1ZNRno',
                'urutan' => 2,
                'status' => true,
            ],
            [
                'judul' => 'Barbershop Hip Hop',
                'jenis' => 'spotify_playlist',
                'url_id' => '37i9dQZF1DX0p9H93V8mUn',
                'urutan' => 3,
                'status' => true,
            ],
            [
                'judul' => 'Relaxing Lofi Beats (YT)',
                'jenis' => 'youtube_video',
                'url_id' => 'jfKfPfyJRdk',
                'urutan' => 4,
                'status' => true,
            ],
            [
                'judul' => 'Smooth Jazz Lounge (YT)',
                'jenis' => 'youtube_video',
                'url_id' => '5qap5aO4i9A',
                'urutan' => 5,
                'status' => true,
            ],
        ];

        foreach ($playlists as $data) {
            Playlist::create($data);
        }
    }
}
