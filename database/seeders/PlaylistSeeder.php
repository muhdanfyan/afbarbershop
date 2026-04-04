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
                'judul' => 'Relaxing Lofi Beats (Barber Vibes)',
                'jenis' => 'youtube_video',
                'url_id' => 'jfKfPfyJRdk',
                'urutan' => 1,
                'status' => true,
            ],
            [
                'judul' => 'Smooth Jazz Lounge',
                'jenis' => 'youtube_video',
                'url_id' => '5qap5aO4i9A',
                'urutan' => 2,
                'status' => true,
            ],
            [
                'judul' => 'Barber ASMR Ambience',
                'jenis' => 'youtube_video',
                'url_id' => 'qRTVg8HHzUo',
                'urutan' => 3,
                'status' => true,
            ],
            [
                'judul' => 'Master Barber Techniques',
                'jenis' => 'youtube_video',
                'url_id' => 'A-GvK-bEwos',
                'urutan' => 4,
                'status' => true,
            ],
        ];

        foreach ($playlists as $data) {
            Playlist::create($data);
        }
    }
}
