<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\Jasa;
use App\Models\Kapster;
use Livewire\WithPagination;

class TransaksiCrud extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $status = 'menunggu';
    public $showForm = false;
    public $editId = null;
    public $form = [
        'nama' => '',
        'kapster_id' => '',
        'kursi_id' => '',
        'jasa' => [],
        'status' => 'menunggu',
        'catatan' => '',
    ];
    public $deleteNama = '';
    public $deleteId = null;
    public $detailId = null;
    public $confirmingDelete = false;

    protected $queryString = ['status'];
    protected $rules = [
        'form.nama' => 'required',
        'form.kapster_id' => 'nullable|exists:kapster,id',
        'form.kursi_id' => 'nullable|exists:kursis,id',
        'form.jasa' => 'required|array|min:1',
        'form.status' => 'required',
    ];

    public function render()
    {
        $query = Transaksi::with(['jasa', 'kapster', 'kursi'])
            ->where('status', $this->status);
        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%');
        }
        $transaksis = $query->orderBy('created_at', 'desc')->paginate(10);
        $allJasa = Jasa::all();
        $allKapster = Kapster::all();
        $allKursi = \App\Models\Kursi::all();
        return view('livewire.admin.transaksi-crud', compact('transaksis', 'allJasa', 'allKapster', 'allKursi'));
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editId = null;
    }

    public function edit($id)
    {
        $trx = Transaksi::with('jasa')->findOrFail($id);
        $this->form = [
            'nama' => $trx->nama,
            'kapster_id' => $trx->kapster_id,
            'kursi_id' => $trx->kursi_id,
            'jasa' => $trx->jasa->pluck('id')->toArray(),
            'status' => $trx->status,
            'catatan' => $trx->catatan,
        ];
        $this->editId = $id;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();
        
        // Validation: Kursi availability
        if ($this->form['kursi_id']) {
            $trx_temp = Transaksi::find($this->editId);
            $exists = Transaksi::where('kursi_id', $this->form['kursi_id'])
                ->where('tanggal', $trx_temp ? $trx_temp->tanggal : now()->toDateString())
                ->where('waktu', $trx_temp ? $trx_temp->waktu : now()->format('H:i'))
                ->where('id', '!=', $this->editId)
                ->where('status', '!=', 'batal')
                ->exists();
            if ($exists) {
                session()->flash('error', 'Kursi sudah dipesan untuk waktu tersebut!');
                return;
            }
        }

        if ($this->editId) {
            $trx = Transaksi::findOrFail($this->editId);
            $trx->update([
                'nama' => $this->form['nama'],
                'kapster_id' => $this->form['kapster_id'],
                'kursi_id' => $this->form['kursi_id'],
                'status' => $this->form['status'],
                'catatan' => $this->form['catatan'],
            ]);
            $trx->jasa()->sync($this->form['jasa']);
        } else {
            $trx = Transaksi::create([
                'nama' => $this->form['nama'],
                'kapster_id' => $this->form['kapster_id'],
                'kursi_id' => $this->form['kursi_id'],
                'status' => $this->form['status'],
                'catatan' => $this->form['catatan'],
                'tanggal' => now()->toDateString(),
                'waktu' => now()->format('H:i'),
            ]);
            $trx->jasa()->sync($this->form['jasa']);
        }
        $this->showForm = false;
        $this->resetForm();
    }

    public function confirmDelete($id)
    {
        $trx = Transaksi::find($id);
        if ($trx) {
            $this->deleteId = $id;
            $this->deleteNama = $trx->invoice ?? 'Transaksi #' . $trx->id;
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
        Transaksi::findOrFail($this->deleteId)->delete();
        $this->cancelDelete();
    }

    public function resetForm()
    {
        $this->form = [
            'nama' => '',
            'kapster_id' => '',
            'kursi_id' => '',
            'jasa' => [],
            'status' => 'menunggu',
            'catatan' => '',
        ];
    }
}
