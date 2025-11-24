<?php

namespace App\Livewire\Dashboard;

use App\Helpers\Helper;
use App\Models\Fashion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class FashionComponent extends Component
{
    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'tailwind';

    public $perPage = 10;

    // Modal state & form fields
    public $showModal = false;

    public $fashionId = null;

    public $url = '';

    public $existingImage = null; // stores existing image path

    public $existingLogo = null;  // stores existing logo path

    public $image;

    public $logo;

    // Validation rules
    protected function rules()
    {
        return [
            'url' => 'nullable|url|max:255',
            // max is in kilobytes; 20480 KB = 20 MB
            'image' => 'nullable|image|max:20480',
            'logo' => 'nullable|image|max:20480',
        ];
    }

    // Add browser event listener for reload
    protected $listeners = ['reloadPage' => 'reloadPage'];

    public function reloadPage()
    {
        // This method will be called from JavaScript
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->resetUploadState();

        if ($id) {
            $this->edit($id);
        } else {
            $this->resetForm();
            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->resetUploadState();
        $this->resetValidation();
    }

    protected function resetForm()
    {
        $this->fashionId = null;
        $this->url = '';
        $this->existingImage = null;
        $this->existingLogo = null;
    }

    protected function resetUploadState()
    {
        $this->image = null;
        $this->logo = null;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'url' => $this->url,
        ];

        // handle image upload
        if ($this->image) {
            $data['image'] = Helper::uploadFile('fashions/images', $this->image);
        }

        if ($this->logo) {
            $data['logo'] = Helper::uploadFile('fashions/logos', $this->logo);
        }

        Fashion::create($data);

        session()->flash('message', 'Fashion created successfully.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $fashion = Fashion::findOrFail($id);

        $this->fashionId = $fashion->id;
        $this->url = $fashion->url;
        $this->existingImage = $fashion->image;
        $this->existingLogo = $fashion->logo;
        $this->resetUploadState();
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $fashion = Fashion::findOrFail($this->fashionId);

        $data = [
            'url' => $this->url,
        ];

        if ($this->image) {
            // delete old image if exists
            if ($fashion->image) {
                Helper::deleteFile($fashion->image);
            }
            $data['image'] = Helper::uploadFile('fashions/images', $this->image);
        }

        if ($this->logo) {
            // delete old logo if exists
            if ($fashion->logo) {
                Helper::deleteFile($fashion->logo);
            }
            $data['logo'] = Helper::uploadFile('fashions/logos', $this->logo);
        }

        $fashion->update($data);

        session()->flash('message', 'Fashion updated successfully.');
        $this->closeModal();
    }

    public function delete($id)
    {
        try {
            $fashion = Fashion::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Item not found.');

            return;
        }

        try {
            if ($fashion->image) {
                Helper::deleteFile($fashion->image);
            }
            if ($fashion->logo) {
                Helper::deleteFile($fashion->logo);
            }
        } catch (\Throwable $ex) {
            Log::error('File delete error: '.$ex->getMessage());
        }

        $fashion->delete();

        // Dispatch event to reload page
        $this->dispatch('reloadPage');

        session()->flash('message', 'Fashion deleted successfully.');
    }

    public function render()
    {
        $query = Fashion::query();

        $fashions = $query->paginate($this->perPage);

        return view('livewire.dashboard.fashion-component', [
            'fashions' => $fashions,
        ])->layout('layouts.app');
    }
}
