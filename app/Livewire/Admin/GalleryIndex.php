<?php

namespace App\Livewire\Admin;

use App\Models\Gallery;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class GalleryIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $paginationTheme = 'bootstrap';

    public $showDeleteModal = false;
    public $deleteId = null;
    public $isFormOpen = false;
    public $editMode = false;

    public $galleryIdEdit = null;
    public $title, $file, $type, $description, $file_lama;

    public function render()
    {
        return view('livewire.admin.gallery-index', [
            'galleries' => Gallery::latest()->paginate(10)
        ]);
    }

    public function showForm()
    {
        $this->resetForm();
        $this->isFormOpen = true;
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        $this->galleryIdEdit = $gallery->id;
        $this->title = $gallery->title;
        $this->type = $gallery->type;
        $this->description = $gallery->description;
        $this->file_lama = $gallery->file;
        $this->editMode = true;
        $this->isFormOpen = true;
    }

    public function save()
    {
        $this->validate([
            'type' => 'required|in:image,video',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file' => ($this->editMode ? 'nullable' : 'required') . '|file|max:20480',
        ]);

        $data = [
            'title' => $this->title,
            'type' => $this->type,
            'description' => $this->description,
        ];

        if ($this->file) {
            // Delete old file if exists
            if ($this->editMode && $this->file_lama) {
                Storage::disk('public')->delete($this->file_lama);
            }
            $data['file'] = $this->file->store('gallery', 'public');
        }

        if ($this->editMode) {
            Gallery::find($this->galleryIdEdit)->update($data);
            session()->flash('message', 'Gallery updated successfully!');
        } else {
            Gallery::create($data);
            session()->flash('message', 'Gallery created successfully!');
        }

        $this->resetForm();
    }

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

    public function hapus()
    {
        $gallery = Gallery::findOrFail($this->deleteId);
        if ($gallery->file && Storage::disk('public')->exists($gallery->file)) {
            Storage::disk('public')->delete($gallery->file);
        }
        $gallery->delete();
        session()->flash('message', 'Gallery deleted successfully!');
        $this->cancelDelete();
    }

    public function resetForm()
    {
        $this->title = '';
        $this->file = null;
        $this->type = 'image';
        $this->description = '';
        $this->file_lama = null;
        $this->galleryIdEdit = null;
        $this->editMode = false;
        $this->isFormOpen = false;
    }

    public function batal()
    {
        $this->resetForm();
    }
}
