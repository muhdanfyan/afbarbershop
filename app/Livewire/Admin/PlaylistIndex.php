<?php

namespace App\Livewire\Admin;

use App\Models\Playlist;
use Livewire\Component;

class PlaylistIndex extends Component
{
    public $playlists;
    public $judul, $jenis, $url_id, $urutan, $status, $playlist_id;
    public $isModalOpen = 0;

    public function render()
    {
        $this->playlists = Playlist::orderBy('urutan', 'asc')->get();
        return view('livewire.admin.playlist-index');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->judul = '';
        $this->jenis = 'youtube_video';
        $this->url_id = '';
        $this->urutan = 0;
        $this->status = true;
        $this->playlist_id = null;
    }

    public function store()
    {
        $this->validate([
            'judul' => 'required',
            'jenis' => 'required|in:youtube_video,youtube_playlist',
            'url_id' => 'required',
            'urutan' => 'integer',
        ]);

        Playlist::updateOrCreate(['id' => $this->playlist_id], [
            'judul' => $this->judul,
            'jenis' => $this->jenis,
            'url_id' => $this->url_id,
            'urutan' => $this->urutan ?? 0,
            'status' => $this->status ?? true,
        ]);

        session()->flash('message', $this->playlist_id ? 'Playlist Update Successfully.' : 'Playlist Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $playlist = Playlist::findOrFail($id);
        $this->playlist_id = $id;
        $this->judul = $playlist->judul;
        $this->jenis = $playlist->jenis;
        $this->url_id = $playlist->url_id;
        $this->urutan = $playlist->urutan;
        $this->status = $playlist->status;

        $this->openModal();
    }

    public function delete($id)
    {
        Playlist::find($id)->delete();
        session()->flash('message', 'Playlist Deleted Successfully.');
    }

    public function toggleStatus($id)
    {
        $playlist = Playlist::findOrFail($id);
        $playlist->status = !$playlist->status;
        $playlist->save();
        session()->flash('message', 'Status Playlist Berhasil Diubah.');
    }
}
