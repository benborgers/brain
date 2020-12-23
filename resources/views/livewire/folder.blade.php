@section('title', $folder->name)

<div>
    <div class="flex items-center justify-between space-x-4 border-b border-gray-200 -ml-6 -mr-6 px-6 pb-6 mb-8">
        <input type="text" wire:model="folder.name" class="bg-transparent p-0 border-none focus:ring-0 text-lg font-bold text-gray-900" />

        <div class="flex items-center space-x-4">
            <button
                x-data
                x-on:click="confirm('Are you sure you want to delete your {{ $folder->name }} folder? This will also delete all the notecards inside it.') && $wire.deleteFolder()"
                class="whitespace-nowrap text-gray-500 rounded-lg"
            >
                Delete folder
            </button>
            <x-button as="a" href="{{ route('notecard.create', [ 'folder' => $folder->id ]) }}">New notecard</x-button>
        </div>
    </div>


    <div class="space-y-4">
        @forelse ($notecards as $notecard)
            @livewire('notecard', [ 'notecard' => $notecard, 'embedded' => true ], key($notecard->id))
        @empty
            <p class="text-gray-400 font-medium">No notecards here yet.</p>
        @endforelse
    </div>
</div>
