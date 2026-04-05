<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Kursi;
use Livewire\WithPagination;

class KursiCrud extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $showForm = false;
    public $editId = null;
    public $form = [
        'nama' => '',
        'lokasi' => '',
        'deskripsi' => '',
        'status' => 'aktif',
    ];
    public $deleteNama = '';
    public $deleteId = null;
    public $confirmingDelete = false;

    protected $rules = [
        'form.nama' => 'required',
        'form.lokasi' => 'nullable',
        'form.deskripsi' => 'nullable',
        'form.status' => 'required|in:aktif,nonaktif',
    ];

    public function render()
    {
        $query = Kursi::query();
        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%');
        }
        $kursis = $query->orderBy('created_at', 'asc')->paginate(10);
        return view('livewire.admin.kursi-crud', compact('kursis'));
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editId = null;
    }

    public function edit($id)
    {
        $kursi = Kursi::findOrFail($id);
        $this->form = [
            'nama' => $kursi->nama,
            'lokasi' => $kursi->lokasi,
            'deskripsi' => $kursi->deskripsi,
            'status' => $kursi->status,
        ];
        $this->editId = $id;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();
        if ($this->editId) {
            Kursi::findOrFail($this->editId)->update($this->form);
        } else {
            Kursi::create($this->form);
        }
        $this->showForm = false;
        $this->resetForm();
    }

    public function confirmDelete($id)
    {
        $kursi = Kursi::find($id);
        if ($kursi) {
            $this->deleteId = $id;
            $this->deleteNama = $kursi->nama;
            $this->confirmingDelete = true;
        }
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->deleteId = null;
        $this->deleteNama = '';
    }

    public function hapus()
    {
        Kursi::findOrFail($this->deleteId)->delete();
        $this->cancelDelete();
    }

    public function resetForm()
    {
        $this->form = [
            'nama' => '',
            'lokasi' => '',
            'deskripsi' => '',
            'status' => 'aktif',
        ];
    }
}
