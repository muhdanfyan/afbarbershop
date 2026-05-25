<?php

namespace App\Livewire\Admin;

use App\Models\Voucher;
use Livewire\Component;
use Livewire\WithPagination;

class VoucherIndex extends Component
{
    use WithPagination;

    public $paginationTheme = 'bootstrap';
    
    // Form fields
    public $code, $type = 'fixed', $reward, $min_spend = 0, $quota = 0, $valid_from, $valid_until, $is_active = true;
    public $voucherIdEdit = null;
    
    // UI States
    public $showForm = false;
    public $showDeleteModal = false;
    public $deleteId = null;
    public $deleteNama = null;
    public $search = '';

    protected $rules = [
        'code' => 'required|string|unique:vouchers,code',
        'type' => 'required|in:fixed,percent',
        'reward' => 'required|numeric|min:0',
        'min_spend' => 'required|numeric|min:0',
        'quota' => 'required|integer|min:0',
        'valid_from' => 'nullable|date',
        'valid_until' => 'nullable|date|after_or_equal:valid_from',
        'is_active' => 'boolean',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        $this->voucherIdEdit = $voucher->id;
        $this->code = $voucher->code;
        $this->type = $voucher->type;
        $this->reward = $voucher->reward;
        $this->min_spend = $voucher->min_spend;
        $this->quota = $voucher->quota;
        $this->valid_from = $voucher->valid_from;
        $this->valid_until = $voucher->valid_until;
        $this->is_active = $voucher->is_active;
        $this->showForm = true;
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->voucherIdEdit) {
            $rules['code'] = 'required|string|unique:vouchers,code,' . $this->voucherIdEdit;
        }

        $this->validate($rules);

        $data = [
            'code' => strtoupper($this->code),
            'type' => $this->type,
            'reward' => $this->reward,
            'min_spend' => $this->min_spend,
            'quota' => $this->quota,
            'valid_from' => $this->valid_from ?: null,
            'valid_until' => $this->valid_until ?: null,
            'is_active' => $this->is_active,
        ];

        if ($this->voucherIdEdit) {
            Voucher::find($this->voucherIdEdit)->update($data);
            session()->flash('message', 'Voucher berhasil diperbarui!');
        } else {
            Voucher::create($data);
            session()->flash('message', 'Voucher baru berhasil ditambahkan!');
        }

        $this->resetForm();
    }

    public function confirmDelete($id)
    {
        $voucher = Voucher::findOrFail($id);
        $this->deleteId = $id;
        $this->deleteNama = $voucher->code;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Voucher::find($this->deleteId)->delete();
        session()->flash('message', 'Voucher berhasil dihapus!');
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function resetForm()
    {
        $this->code = '';
        $this->type = 'fixed';
        $this->reward = '';
        $this->min_spend = 0;
        $this->quota = 0;
        $this->valid_from = null;
        $this->valid_until = null;
        $this->is_active = true;
        $this->voucherIdEdit = null;
        $this->showForm = false;
    }

    public function render()
    {
        $vouchers = Voucher::where('code', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.voucher-index', compact('vouchers'));
    }
}
