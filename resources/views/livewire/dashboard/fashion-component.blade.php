<main class="flex-1 overflow-y-auto p-4 no-scrollbar pt-6 ps-8">
    <div class="space-y-4">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-900">Fashions</h1>
                <p class="text-xs text-gray-600">Manage fashion entries (image, logo, url)</p>
            </div>
            <div class="flex flex-col md:flex-row gap-2 mb-2">
                <div class="flex gap-1.5">
                    <!-- Per Page Dropdown -->
                    <div class="relative">
                        <select wire:model.live="perPage"
                            class="h-8 pl-2 pr-6 rounded-md border border-gray-300 bg-white text-gray-700 text-xs focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option value="5">5 per page</option>
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                            <option value="100">100 per page</option>
                        </select>
                    </div>
                    <button wire:click="openModal"
                        class="h-8 px-2.5 bg-blue-600 text-white rounded-md text-xs font-medium transition-colors flex items-center gap-1">
                        <i class="fas fa-plus" style="font-size: 9px;"></i>
                        Add New
                    </button>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-sm">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Card / Table -->
        <div class="bg-white shadow rounded border border-gray-200 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-xs text-gray-600 uppercase">
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Image</th>
                        <th class="px-4 py-3 text-left">Logo</th>
                        <th class="px-4 py-3 text-left">URL</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fashions as $fashion)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $fashion->id }}</td>
                            <td class="px-4 py-3">
                                @if ($fashion->image)
                                    <img src="{{ asset($fashion->image) }}" alt="image"
                                        class="h-10 w-16 object-cover rounded">
                                @else
                                    <span class="text-xs text-gray-500">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($fashion->logo)
                                    <img src="{{ asset($fashion->logo) }}" alt="logo"
                                        class="h-10 w-10 object-contain rounded">
                                @else
                                    <span class="text-xs text-gray-500">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 break-words max-w-xs">
                                @if ($fashion->url)
                                    <a href="{{ $fashion->url }}" target="_blank"
                                        class="text-blue-600 hover:underline text-sm">
                                        {{ Str::limit($fashion->url, 60) }}
                                    </a>
                                @else
                                    <span class="text-xs text-gray-500">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex gap-2">
                                    <button wire:click="openModal({{ $fashion->id }})"
                                        class="px-2 py-1 text-xs bg-blue-50 text-blue-700 rounded">Edit</button>

                                    <button onclick="confirmDelete({{ $fashion->id }})"
                                        class="px-2 py-1 text-xs bg-red-50 text-red-700 rounded">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">
                                No fashions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-4 py-3">
                {{ $fashions->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium">
                        {{ $fashionId ? 'Edit Fashion' : 'Add New Fashion' }}
                    </h3>
                    <button type="button" wire:click="closeModal" class="text-gray-500 text-sm">Close</button>
                </div>

                <form wire:submit.prevent="{{ $fashionId ? 'update' : 'store' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Image --}}
                        <div>
                            <label class="block text-xs text-gray-700 mb-1">Image (recommended 800x600)</label>

                            <div class="mb-2">
                                @if ($image)
                                    <div class="mb-2">
                                        <p class="text-xs text-gray-500 mb-1">Preview (new):</p>
                                        <img src="{{ $image->temporaryUrl() }}"
                                            class="h-28 w-full object-cover rounded">
                                    </div>
                                @elseif ($existingImage)
                                    <p class="text-xs text-gray-500 mb-1">Current:</p>
                                    <img src="{{ asset($existingImage) }}"
                                        class="h-28 w-full object-cover rounded mb-2">
                                @endif
                            </div>

                            <input type="file" wire:model="image" accept="image/*" />
                            @error('image')
                                <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Logo --}}
                        <div>
                            <label class="block text-xs text-gray-700 mb-1">Logo (square recommended)</label>

                            <div class="mb-2">
                                @if ($logo)
                                    <div class="mb-2">
                                        <p class="text-xs text-gray-500 mb-1">Preview (new):</p>
                                        <img src="{{ $logo->temporaryUrl() }}"
                                            class="h-24 w-24 object-contain rounded">
                                    </div>
                                @elseif ($existingLogo)
                                    <p class="text-xs text-gray-500 mb-1">Current:</p>
                                    <img src="{{ asset($existingLogo) }}"
                                        class="h-24 w-24 object-contain rounded mb-2">
                                @endif
                            </div>

                            <input type="file" wire:model="logo" accept="image/*" />
                            @error('logo')
                                <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- URL --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs text-gray-700 mb-1">URL</label>
                            <input type="url" wire:model="url"
                                class="w-full h-10 px-3 rounded border border-gray-200 text-sm"
                                placeholder="https://example.com" />
                            @error('url')
                                <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" wire:click="closeModal"
                            class="px-3 py-1.5 bg-gray-100 rounded text-sm">Cancel</button>
                        <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded text-sm">
                            {{ $fashionId ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</main>

<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this item?')) {
            @this.delete(id);
        }
    }
    // Listen for Livewire event to reload page
    document.addEventListener('livewire:init', () => {
        Livewire.on('reloadPage', () => {
            setTimeout(() => {
                window.location.reload();
            }, 100);
        });
    });
</script>
