<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Member;

class MemberIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $nama, $nomor_wa, $alamat, $memberIdEdit;
    public $showForm = false;

    protected $rules = [
        'nama' => 'required',
        'nomor_wa' => 'required',
        'alamat' => 'nullable',
    ];

    public function render()
    {
        $query = Member::query();
        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('nomor_wa', 'like', '%' . $this->search . '%');
        }
        $members = $query->orderByDesc('id')->paginate(10);
        return view('livewire.admin.member-index', compact('members'));
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();
        if ($this->memberIdEdit) {
            Member::find($this->memberIdEdit)->update([
                'nama' => $this->nama,
                'nomor_wa' => $this->nomor_wa,
                'alamat' => $this->alamat,
            ]);
        } else {
            Member::create([
                'nama' => $this->nama,
                'nomor_wa' => $this->nomor_wa,
                'alamat' => $this->alamat,
            ]);
        }
        $this->resetForm();
        $this->showForm = false;
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        $this->memberIdEdit = $member->id;
        $this->nama = $member->nama;
        $this->nomor_wa = $member->nomor_wa;
        $this->alamat = $member->alamat;
        $this->showForm = true;
    }

    public function confirmDelete($id)
    {
        $this->dispatch('confirm-delete', id: $id);
    }

    public function delete($id)
    {
        Member::destroy($id);
    }

    public function resetForm()
    {
        $this->nama = '';
        $this->nomor_wa = '';
        $this->alamat = '';
        $this->memberIdEdit = null;
    }
}
