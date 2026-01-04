<?php

namespace App\Livewire\Admin;

use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\WithFileUploads;

class BarangIndex extends Component
{
    use WithFileUploads;
    public $showDeleteModal = false;
    public $deleteId = null;

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
    use WithPagination, WithoutUrlPagination;
    public $paginationTheme = 'bootstrap';
    public $nama_barang, $deskripsi, $harga_jual, $harga_beli, $stok, $foto, $foto_lama;
    public $barangIdEdit = null;
    public $editMode = false;
    public $showForm = false;

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $this->barangIdEdit = $barang->id;
        $this->nama_barang = $barang->nama;
        $this->deskripsi = $barang->deskripsi;
        $this->harga_jual = $barang->harga_jual;
        $this->harga_beli = $barang->harga_beli;
        $this->stok = $barang->stok;
        $this->foto_lama = $barang->foto;
        $this->editMode = true;
        $this->showForm = true;
    }

    public function hapus($id)
    {
        $barang = Barang::findOrFail($id);
        // Hapus file foto jika ada
        if ($barang->foto && \Storage::disk('public')->exists($barang->foto)) {
            \Storage::disk('public')->delete($barang->foto);
        }
        $barang->delete();
        session()->flash('message', 'Barang berhasil dihapus!');
        $this->cancelDelete();
        $this->resetForm();
        $this->resetPage();
    }

    public function resetFormBarang()
    {
        $this->nama_barang = '';
        $this->deskripsi = '';
        $this->harga_jual = '';
        $this->harga_beli = '';
        $this->stok = '';
        $this->foto = null;
        $this->foto_lama = null;
        $this->barangIdEdit = null;
    }

    public function batal()
    {
        $this->resetForm();
    }

    protected function resetForm()
    {
        $this->showForm = false;
        $this->nama_barang = null;
        $this->deskripsi = null;
        $this->harga_jual = null;
        $this->harga_beli = null;
        $this->stok = null;
        $this->foto = null;
        $this->foto_lama = null;
        $this->barangIdEdit = null;
        $this->editMode = false;
    }

    public function showForm()
    {
        $this->resetFormBarang();
        $this->editMode = false;
        $this->showForm = true;
    }
    // duplikasi trait dan property dihapus

    public function showCreateForm()
    {
        $this->showForm();
    }

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();

    }

    public function simpan()
    {
        $rules = [
            'nama_barang' => 'required|string',
            'deskripsi' => 'nullable|string',
            'harga_jual' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto' => $this->barangIdEdit ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];
        $this->validate($rules);

        $fotoPath = $this->foto_lama;
        if ($this->foto) {
            // Hapus foto lama jika ada dan file-nya ada di storage
            if ($this->foto_lama && \Storage::disk('public')->exists($this->foto_lama)) {
                \Storage::disk('public')->delete($this->foto_lama);
            }
            $fotoPath = $this->foto->store('barang', 'public');
        }

        if (isset($this->barangIdEdit) && $this->barangIdEdit) {
            $barang = Barang::findOrFail($this->barangIdEdit);
            $barang->update([
                'nama' => $this->nama_barang,
                'deskripsi' => $this->deskripsi,
                'harga_jual' => $this->harga_jual,
                'harga_beli' => $this->harga_beli,
                'stok' => $this->stok,
                'foto' => $fotoPath,
            ]);
            session()->flash('message', 'Barang berhasil diupdate!');
            $this->resetForm();
            $this->resetPage();
        } else {
            Barang::create([
                'nama' => $this->nama_barang,
                'deskripsi' => $this->deskripsi,
                'harga_jual' => $this->harga_jual,
                'harga_beli' => $this->harga_beli,
                'stok' => $this->stok,
                'foto' => $fotoPath,
            ]);
            session()->flash('message', 'Barang berhasil ditambahkan!');
            $this->resetForm();
            $this->resetPage();
        }
        // Tidak menutup modal/form setelah simpan
    }


    public function render()
    {
        $queryBarang = Barang::query();

        if ($this->search != '') {
            $queryBarang->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
        }

        $dataBarang = $queryBarang->latest()->paginate(10);

        return view('livewire.admin.barang-index', compact(['dataBarang']));
    }
}
