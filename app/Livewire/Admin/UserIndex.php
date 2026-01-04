<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Hash;

class UserIndex extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $paginationTheme = 'bootstrap';
    public $showDeleteModal = false;
    public $deleteId = null;
    public $name, $email, $password, $level, $userIdEdit = null;
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
        $user = User::findOrFail($id);
        $this->userIdEdit = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->level = $user->level;
        $this->editMode = true;
        $this->showForm = true;
    }

    public function hapus($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('message', 'User berhasil dihapus!');
        $this->cancelDelete();
        $this->resetForm();
        $this->resetPage();
    }

    public function resetFormUser()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->level = '';
        $this->userIdEdit = null;
    }

    public function batal()
    {
        $this->resetForm();
    }

    protected function resetForm()
    {
        $this->showForm = false;
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->level = null;
        $this->userIdEdit = null;
        $this->editMode = false;
    }

    public function showForm()
    {
        $this->resetFormUser();
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->userIdEdit,
            'level' => 'required|in:admin,kasir,kapster',
        ];
        if (!$this->userIdEdit) {
            $rules['password'] = 'required|string|min:6';
        }
        $this->validate($rules);

        if ($this->userIdEdit) {
            $user = User::findOrFail($this->userIdEdit);
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'level' => $this->level,
            ];
            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }
            $user->update($data);
            session()->flash('message', 'User berhasil diupdate!');
            $this->resetForm();
            $this->resetPage();
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'level' => $this->level,
            ]);
            session()->flash('message', 'User berhasil ditambahkan!');
            $this->resetForm();
            $this->resetPage();
        }
    }

    public function render()
    {
        $queryUser = User::query();

        if ($this->search != '') {
            $queryUser->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('level', 'like', '%' . $this->search . '%');
        }

        $dataUser = $queryUser->latest()->paginate(10);

        return view('livewire.admin.user-index', compact(['dataUser']));
    }
}
