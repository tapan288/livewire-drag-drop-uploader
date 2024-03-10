<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class Uploader extends Component
{
    use WithFileUploads;

    public $files = [];

    public function updatedFiles($value)
    {
        dd($value);
    }

    public function render()
    {
        return view('livewire.uploader');
    }
}
