<?php

namespace App\Livewire\CMS\Home;

use App\Models\CMS;
use Livewire\Component;
use Livewire\WithFileUploads;

class BannerIndex extends Component
{
    use WithFileUploads;

    public $cmsId;

    public $title;

    public $content;

    public $image;

    public $background_image;

    public $existingImage;

    public $existingBackgroundImage;

    public function mount()
    {
        // Load existing banner if exists
        $banner = CMS::where('page', 'home_page')
            ->where('section', 'home_banner')
            ->first();

        if ($banner) {
            $this->cmsId = $banner->id;
            $this->title = $banner->title;
            $this->content = $banner->content;
            $this->existingImage = $banner->image;
            $this->existingBackgroundImage = $banner->background_image;
        }
    }

    public function save()
    {
        $data = $this->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:1024',
            'background_image' => 'nullable|image|max:1024',
        ]);

        if ($this->image) {
            $data['image'] = $this->image->store('cms/images', 'public');
        } elseif ($this->existingImage) {
            $data['image'] = $this->existingImage;
        }

        if ($this->background_image) {
            $data['background_image'] = $this->background_image->store('cms/backgrounds', 'public');
        } elseif ($this->existingBackgroundImage) {
            $data['background_image'] = $this->existingBackgroundImage;
        }

        if ($this->cmsId) {
            // Update existing banner
            $banner = CMS::find($this->cmsId);
            $banner->update(array_merge($data, [
                'page' => 'home_page',
                'section' => 'home_banner',
            ]));
        } else {
            // Create new banner
            CMS::create(array_merge($data, [
                'page' => 'home_page',
                'section' => 'home_banner',
            ]));
        }

        session()->flash('success', 'Banner saved successfully!');
    }

    public function render()
    {
        return view('livewire.c-m-s.home.banner-index')->layout('layouts.app');
    }
}
