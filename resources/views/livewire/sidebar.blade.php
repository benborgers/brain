<div>
    <p class="text-gray-900 font-bold">Folders</p>

    <x-folder-level :folders="$allFolders->whereNull('parent')" :allFolders="$allFolders" />

    {{-- Create new folder --}}
    <form wire:submit.prevent="createFolder">
        <input type="text" placeholder="New Folder" wire:model.defer="newFolderName" />
        @error('newFolderName')
            <p>{{ $message }}</p>
        @enderror
        <input type="submit" value="Create" />
    </form>
</div>
