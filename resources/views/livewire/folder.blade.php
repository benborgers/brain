<div>
    <input type="text" wire:model="folder.name" />

    <a href="{{ route('notecard.create', [ 'folder' => $folder->id ]) }}">Create a notecard</a>
</div>
