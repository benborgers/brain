@section('title', $folder->name)

<div>
    <div class="flex items-center justify-between space-x-4 border-b border-gray-200 -ml-6 -mr-6 px-6 pb-6 mb-8">
        <input type="text" wire:model="folder.name" class="bg-transparent p-0 border-none focus:ring-0 text-lg font-bold text-gray-900" />

        <div class="flex items-center space-x-4">
            <button
                x-data
                x-on:click="confirm('Are you sure? This will also delete all the notecards in {{ $folder->name }}.') && $wire.deleteFolder()"
                class="whitespace-nowrap text-gray-500 rounded-lg focus:outline-none"
            >
                Delete folder
            </button>
            <a
                href="{{ route('notecard.create', [ 'folder' => $folder->id ]) }}"
                class="whitespace-nowrap bg-rose-200 text-rose-700 py-1 px-3 rounded-lg font-semibold"
            >
                Create a notecard
            </a>
        </div>
    </div>


    <div class="space-y-4">
        @forelse ($notecards as $notecard)
            @livewire('notecard', [ 'notecard' => $notecard, 'embedded' => true ], key($notecard->id))
        @empty
            <p class="text-gray-400 font-medium mt-12">No notecards here yet.</p>
        @endforelse
    </div>
</div>
