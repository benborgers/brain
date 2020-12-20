<div>
    <a href="{{ route('home') }}">
        <p class="mb-4 inline-block text-2xl">🧠</p>
    </a>

    <x-folder-level :folders="$allFolders->whereNull('parent')" :allFolders="$allFolders" />

    {{-- Create new folder --}}
    <form wire:submit.prevent="createFolder" class="mt-12 flex space-x-2 w-full bg-white border border-gray-200 p-3 rounded-lg">
        <input type="text" placeholder="New Folder" wire:model.defer="newFolderName" class="w-full bg-transparent border-none p-0 focus:ring-0" />
        @error('newFolderName')
            <p>{{ $message }}</p>
        @enderror
        <input type="submit" value="Create" class="cursor-pointer bg-gray-200 text-gray-700 py-1 px-2 rounded text-sm font-semibold" />
    </form>
</div>
