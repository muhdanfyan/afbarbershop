<?php

namespace App\Livewire\Admin;

use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class BarangIndex extends Component
{
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
    public $nama_barang, $deskripsi, $harga_jual, $harga_beli, $stok;
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
        $this->editMode = true;
        $this->showForm = true;
    }

    public function hapus($id)
    {
        $barang = Barang::findOrFail($id);
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
        $this->barangIdEdit = null;
    }

    public function batal()
    {
        $this->resetForm();
    }

    protected function resetForm()
    {
        $this->showForm = false;
        $this->pegawaiId = null;
        $this->nip = null;
        $this->nama = null;
        $this->jabatan = null;
        $this->skpd = null;
        $this->status = 'active';
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
        $this->validate([
            'nama_barang' => 'required|string',
            'deskripsi' => 'nullable|string',
            'harga_jual' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        if (isset($this->barangIdEdit) && $this->barangIdEdit) {
            $barang = Barang::findOrFail($this->barangIdEdit);
            $barang->update([
                'nama' => $this->nama_barang,
                'deskripsi' => $this->deskripsi,
                'harga_jual' => $this->harga_jual,
                'harga_beli' => $this->harga_beli,
                'stok' => $this->stok,
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
