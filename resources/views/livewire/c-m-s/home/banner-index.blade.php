<main class="flex-1 overflow-y-auto p-4 no-scrollbar pt-6 ps-8">
    <div class="space-y-4 max-w-lg mx-auto">

        <h1 class="text-xl font-bold text-gray-900">Home Banner</h1>
        <p class="text-xs text-gray-600 mt-0.5">Create or update the home banner</p>

        @if (session()->has('success'))
            <div class="px-4 py-2 bg-green-50 text-green-700 text-sm rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">

            <form wire:submit.prevent="save" class="space-y-4">

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" wire:model="title"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter banner title">
                    @error('title')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                    <textarea wire:model="content" rows="4"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter banner content"></textarea>
                    @error('content')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image (optional)</label>
                    <input type="file" wire:model="image"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @if ($existingImage && !$image)
                        <img src="{{ asset('storage/' . $existingImage) }}" class="mt-2 h-20 w-20 object-cover rounded"
                            alt="">
                    @elseif($image)
                        <img src="{{ $image->temporaryUrl() }}" class="mt-2 h-20 w-20 object-cover rounded"
                            alt="">
                    @endif
                    @error('image')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Background Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Background Image (optional)</label>
                    <input type="file" wire:model="background_image"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @if ($existingBackgroundImage && !$background_image)
                        <img src="{{ asset('storage/' . $existingBackgroundImage) }}"
                            class="mt-2 h-20 w-20 object-cover rounded" alt="">
                    @elseif($background_image)
                        <img src="{{ $background_image->temporaryUrl() }}" class="mt-2 h-20 w-20 object-cover rounded"
                            alt="">
                    @endif
                    @error('background_image')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hidden page/section -->
                <input type="hidden" value="home_page">
                <input type="hidden" value="home_banner">

                <!-- Submit -->
                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Save
                    </button>
                </div>

            </form>
        </div>
    </div>
</main>
