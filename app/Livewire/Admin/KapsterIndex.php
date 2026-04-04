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
    public $nama, $status, $nik, $no_wa, $alamat, $foto, $foto_lama, $sertifikat, $sertifikat_lama;
    public $kapsterIdEdit = null;
    public $editMode = false;
    public $showForm = false;
    public $search = '';
    public $deleteNama = '';

    public function confirmDelete($id)
    {
        $kapster = Kapster::find($id);
        if ($kapster) {
            $this->deleteId = $id;
            $this->deleteNama = $kapster->nama;
            $this->showDeleteModal = true;
        }
    }

    public function cancelDelete()
    {
        $this->deleteId = null;
        $this->deleteNama = null;
        $this->showDeleteModal = false;
    }

    public function edit($id)
    {
        $kapster = Kapster::findOrFail($id);
        $this->kapsterIdEdit = $kapster->id;
        $this->nama = $kapster->nama;
        $this->status = $kapster->status;
        $this->nik = $kapster->nik;
        $this->no_wa = $kapster->no_wa;
        $this->alamat = $kapster->alamat;
        $this->foto_lama = $kapster->foto;
        $this->sertifikat_lama = $kapster->sertifikat;
        $this->editMode = true;
        $this->showForm = true;
    }

    public function hapus($id)
    {
        $kapster = Kapster::findOrFail($id);
        if ($kapster->foto && \Storage::disk('public')->exists($kapster->foto)) {
            \Storage::disk('public')->delete($kapster->foto);
        }
        if ($kapster->sertifikat && \Storage::disk('public')->exists($kapster->sertifikat)) {
            \Storage::disk('public')->delete($kapster->sertifikat);
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
        $this->status = 'bekerja';
        $this->nik = '';
        $this->no_wa = '';
        $this->alamat = '';
        $this->foto = null;
        $this->foto_lama = null;
        $this->sertifikat = null;
        $this->sertifikat_lama = null;
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
        $this->status = null;
        $this->nik = null;
        $this->no_wa = null;
        $this->alamat = null;
        $this->foto = null;
        $this->foto_lama = null;
        $this->sertifikat = null;
        $this->sertifikat_lama = null;
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
            'status' => 'required|in:bekerja,libur',
            'nik' => 'required|string|unique:kapster,nik,' . $this->kapsterIdEdit,
            'no_wa' => 'required|string',
            'alamat' => 'required|string',
            'foto' => $this->kapsterIdEdit ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:5120',
        ];
        $this->validate($rules);

        $fotoPath = $this->foto_lama;
        if ($this->foto) {
            if ($this->foto_lama && \Storage::disk('public')->exists($this->foto_lama)) {
                \Storage::disk('public')->delete($this->foto_lama);
            }
            $fotoPath = $this->foto->store('kapster', 'public');
        }

        $sertifikatPath = $this->sertifikat_lama;
        if ($this->sertifikat) {
            if ($this->sertifikat_lama && \Storage::disk('public')->exists($this->sertifikat_lama)) {
                \Storage::disk('public')->delete($this->sertifikat_lama);
            }
            $sertifikatPath = $this->sertifikat->store('sertifikat_kapster', 'public');
        }

        if (isset($this->kapsterIdEdit) && $this->kapsterIdEdit) {
            $kapster = Kapster::findOrFail($this->kapsterIdEdit);
            $kapster->update([
                'nama' => $this->nama,
                'status' => $this->status,
                'nik' => $this->nik,
                'no_wa' => $this->no_wa,
                'alamat' => $this->alamat,
                'foto' => $fotoPath,
                'sertifikat' => $sertifikatPath,
            ]);
            session()->flash('message', 'Kapster berhasil diupdate!');
            $this->resetForm();
            $this->resetPage();
        } else {
            Kapster::create([
                'nama' => $this->nama,
                'status' => $this->status,
                'nik' => $this->nik,
                'no_wa' => $this->no_wa,
                'alamat' => $this->alamat,
                'foto' => $fotoPath,
                'sertifikat' => $sertifikatPath,
            ]);
            session()->flash('message', 'Kapster berhasil ditambahkan!');
            $this->resetForm();
            $this->resetPage();
        }
    }

    public function toggleStatus($id)
    {
        $kapster = Kapster::findOrFail($id);
        $kapster->status = $kapster->status == 'bekerja' ? 'libur' : 'bekerja';
        $kapster->save();

        session()->flash('message', 'Status ' . $kapster->nama . ' berhasil diubah menjadi ' . strtoupper($kapster->status));
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
