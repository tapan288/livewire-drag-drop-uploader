<div x-data="uploader" class="space-y-3">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div x-on:dragover.prevent="dropping = true" x-on:dragleave.prevent="dropping = false"
                x-on:drop="dropping = false"
                x-bind:class="{
                    'border-gray-300': !dropping,
                    'border-indigo-600': dropping
                }"
                x-on:drop.prevent="handleUpload($event)"
                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-md border-gray-300">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                        viewBox="0 0 48 48" aria-hidden="true">
                        <path
                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="file-upload"
                            class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                            <span>Upload a file</span>
                            <input @change="handleUpload" id="file-upload" name="file-upload" type="file"
                                class="sr-only" multiple>
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">
                        PNG, JPG, GIF up to 10MB
                    </p>
                </div>
            </div>

            @error('files.*')
                <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <div class="mt-6 space-y-3" x-show="progress" x-cloak>
                <div class="space-y-2">
                    <p class="text-sm font-medium text-gray-900">Uploading files</p>
                    <div class="bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-2 bg-indigo-600 rounded-full" x-bind:style="`width: ${progress}%`"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            @foreach ($this->uploaded_files as $file)
                <div>
                    <button wire:click="download({{ $file->id }})"
                        class="text-sm font-medium text-indigo-600">{{ $file->file_name }}</button>
                </div>
            @endforeach
        </div>
    </div>

</div>

@script
    <script>
        Alpine.data('uploader', () => ({
            dropping: false,
            progress: 0,
            handleUpload(e) {
                this.$wire.uploadMultiple(
                    'files',
                    Array.from(e.dataTransfer?.files ?? e.target.files),
                    (uploadedFileName) => {
                        this.progress = 0;
                    },
                    (error) => {
                        console.log(error);
                    },
                    (progress) => {
                        this.progress = progress.detail.progress;
                    }
                );
            }
        }))
    </script>
@endscript
