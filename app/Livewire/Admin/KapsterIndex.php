<?php

namespace App\Livewire\Admin;

use App\Models\Kapster;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\WithFileUploads;

class KapsterIndex extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads;
    public $paginationTheme = 'bootstrap';
    public $showDeleteModal = false;
    public $deleteId = null;
    public $nama, $nik, $no_wa, $alamat, $foto, $foto_lama;
    public $kapsterIdEdit = null;
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
        $kapster = Kapster::findOrFail($id);
        $this->kapsterIdEdit = $kapster->id;
        $this->nama = $kapster->nama;
        $this->nik = $kapster->nik;
        $this->no_wa = $kapster->no_wa;
        $this->alamat = $kapster->alamat;
        $this->foto_lama = $kapster->foto;
        $this->editMode = true;
        $this->showForm = true;
    }

    public function hapus($id)
    {
        $kapster = Kapster::findOrFail($id);
        if ($kapster->foto && \Storage::disk('public')->exists($kapster->foto)) {
            \Storage::disk('public')->delete($kapster->foto);
        }
        $kapster->delete();
        session()->flash('message', 'Kapster berhasil dihapus!');
        $this->cancelDelete();
        $this->resetForm();
        $this->resetPage();
    }

    public function resetFormKapster()
    {
        $this->nama = '';
        $this->nik = '';
        $this->no_wa = '';
        $this->alamat = '';
        $this->foto = null;
        $this->foto_lama = null;
        $this->kapsterIdEdit = null;
    }

    public function batal()
    {
        $this->resetForm();
    }

    protected function resetForm()
    {
        $this->showForm = false;
        $this->nama = null;
        $this->nik = null;
        $this->no_wa = null;
        $this->alamat = null;
        $this->foto = null;
        $this->foto_lama = null;
        $this->kapsterIdEdit = null;
        $this->editMode = false;
    }

    public function showForm()
    {
        $this->resetFormKapster();
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
            'nik' => 'required|string|unique:kapster,nik,' . $this->kapsterIdEdit,
            'no_wa' => 'required|string',
            'alamat' => 'required|string',
            'foto' => $this->kapsterIdEdit ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];
        $this->validate($rules);

        $fotoPath = $this->foto_lama;
        if ($this->foto) {
            if ($this->foto_lama && \Storage::disk('public')->exists($this->foto_lama)) {
                \Storage::disk('public')->delete($this->foto_lama);
            }
            $fotoPath = $this->foto->store('kapster', 'public');
        }

        if (isset($this->kapsterIdEdit) && $this->kapsterIdEdit) {
            $kapster = Kapster::findOrFail($this->kapsterIdEdit);
            $kapster->update([
                'nama' => $this->nama,
                'nik' => $this->nik,
                'no_wa' => $this->no_wa,
                'alamat' => $this->alamat,
                'foto' => $fotoPath,
            ]);
            session()->flash('message', 'Kapster berhasil diupdate!');
            $this->resetForm();
            $this->resetPage();
        } else {
            Kapster::create([
                'nama' => $this->nama,
                'nik' => $this->nik,
                'no_wa' => $this->no_wa,
                'alamat' => $this->alamat,
                'foto' => $fotoPath,
            ]);
            session()->flash('message', 'Kapster berhasil ditambahkan!');
            $this->resetForm();
            $this->resetPage();
        }
    }

    public function render()
    {
        $queryKapster = Kapster::query();

        if ($this->search != '') {
            $queryKapster->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('nik', 'like', '%' . $this->search . '%')
                ->orWhere('no_wa', 'like', '%' . $this->search . '%')
                ->orWhere('alamat', 'like', '%' . $this->search . '%');
        }

        $dataKapster = $queryKapster->latest()->paginate(10);

        return view('livewire.admin.kapster-index', compact(['dataKapster']));
    }
}
