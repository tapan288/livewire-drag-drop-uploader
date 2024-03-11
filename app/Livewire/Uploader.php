<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Uploader extends Component
{
    use WithFileUploads;

    public $files = [];

    public function updatedFiles($value)
    {
        $this->validate([
            'files.*' => ['required', 'file', 'max:102400', 'mimes:mp4'],
        ]);

        $post = Post::find(1);

        collect($this->files)->each(function ($file) use ($post) {
            $post->addMedia($file)->toMediaCollection('attachments');
        });
    }

    public function getUploadedFilesProperty()
    {
        $post = Post::first();

        return $post->getMedia('attachments');
    }

    public function download(Media $file)
    {
        return $file;
    }

    public function messages()
    {
        return [
            'files.*.required' => 'Please select a file to upload',
            'files.*.file' => 'The file must be a valid file',
            'files.*.max' => 'The file may not be greater than 100MB',
            'files.*.mimes' => 'The file must be a file of type: mp4',
        ];
    }

    public function render()
    {
        return view('livewire.uploader');
    }
}
