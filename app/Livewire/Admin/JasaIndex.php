<?php

namespace App\Livewire\Admin;

use App\Models\Jasa;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\WithFileUploads;

class JasaIndex extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads;
    public $paginationTheme = 'bootstrap';
    public $showDeleteModal = false;
    public $deleteId = null;
    public $nama, $deskripsi, $harga, $foto, $foto_lama;
    public $jasaIdEdit = null;
    public $editMode = false;
    public $showForm = false;
    public $search = '';

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->deleteId = null;
        $this->showDeleteModal = false;
    }

    public function edit($id)
    {
        $jasa = Jasa::findOrFail($id);
        $this->jasaIdEdit = $jasa->id;
        $this->nama = $jasa->nama;
        $this->deskripsi = $jasa->deskripsi;
        $this->harga = $jasa->harga;
        $this->foto_lama = $jasa->foto;
        $this->editMode = true;
        $this->showForm = true;
    }

    public function hapus($id)
    {
        $jasa = Jasa::findOrFail($id);
        // Hapus file foto jika ada
        if ($jasa->foto && \Storage::disk('public')->exists($jasa->foto)) {
            \Storage::disk('public')->delete($jasa->foto);
        }
        $jasa->delete();
        session()->flash('message', 'Jasa berhasil dihapus!');
        $this->cancelDelete();
        $this->resetForm();
        $this->resetPage();
    }

    public function resetFormJasa()
    {
        $this->nama = '';
        $this->deskripsi = '';
        $this->harga = '';
        $this->foto = null;
        $this->foto_lama = null;
        $this->jasaIdEdit = null;
    }

    public function batal()
    {
        $this->resetForm();
    }

    protected function resetForm()
    {
        $this->showForm = false;
        $this->nama = null;
        $this->deskripsi = null;
        $this->harga = null;
        $this->foto = null;
        $this->foto_lama = null;
        $this->jasaIdEdit = null;
        $this->editMode = false;
    }

    public function showForm()
    {
        $this->resetFormJasa();
        $this->editMode = false;
        $this->showForm = true;
    }

    public function showCreateForm()
    {
        $this->showForm();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function simpan()
    {
        $rules = [
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'foto' => $this->jasaIdEdit ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];
        $this->validate($rules);

        $fotoPath = $this->foto_lama;
        if ($this->foto) {
            // Hapus foto lama jika ada dan file-nya ada di storage
            if ($this->foto_lama && \Storage::disk('public')->exists($this->foto_lama)) {
                \Storage::disk('public')->delete($this->foto_lama);
            }
            $fotoPath = $this->foto->store('jasa', 'public');
        }

        if (isset($this->jasaIdEdit) && $this->jasaIdEdit) {
            $jasa = Jasa::findOrFail($this->jasaIdEdit);
            $jasa->update([
                'nama' => $this->nama,
                'deskripsi' => $this->deskripsi,
                'harga' => $this->harga,
                'foto' => $fotoPath,
            ]);
            session()->flash('message', 'Jasa berhasil diupdate!');
            $this->resetForm();
            $this->resetPage();
        } else {
            Jasa::create([
                'nama' => $this->nama,
                'deskripsi' => $this->deskripsi,
                'harga' => $this->harga,
                'foto' => $fotoPath,
            ]);
            session()->flash('message', 'Jasa berhasil ditambahkan!');
            $this->resetForm();
            $this->resetPage();
        }
    }

    public function render()
    {
        $queryJasa = Jasa::query();

        if ($this->search != '') {
            $queryJasa->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
        }

        $dataJasa = $queryJasa->latest()->paginate(10);

        return view('livewire.admin.jasa-index', compact(['dataJasa']));
    }
}
