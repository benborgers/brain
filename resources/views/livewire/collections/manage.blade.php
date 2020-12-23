@section('title', 'Collections')

<div>
    <div class="mb-12 flex items-center justify-between">
        <p class="text-gray-400 font-medium">Collections allow you to publicly share a group of notecards with a link that anyone can access.</p>
        <x-button as="button" wire:click="create">New collection</x-button>
    </div>

    <div class="space-y-4">
        @forelse ($collections as $i => $collection)
        @php($notecardsCount = count($collection->notecards))
            <div class="bg-white rounded-lg p-6 border border-gray-200 max-w-screen-sm mx-auto overflow-hidden">
                <div class="mb-4 flex items-center justify-between">
                    <input type="text" wire:model="collections.{{ $i }}.name" class="p-0 border-none text-gray-900 font-bold text-xl focus:ring-0" />
                    <p class="text-gray-400">{{ $notecardsCount }} {{ Str::plural('notecard', $notecardsCount) }}</p>
                </div>

                <div class="space-y-1 mb-3">
                    @foreach($collection->notecards as $notecardId)
                        <x-notecard-checkbox :notecard="App\Models\Notecard::find($notecardId)" :i="$i" appendToId="existing" />
                    @endforeach
                </div>

                <div>
                    <input type="text" wire:model="search.{{ $i }}" class="border-gray-200 focus:border-gray-200 bg-gray-100 focus:ring-0 py-1 px-2 rounded w-full mb-2" placeholder="Search for notecards to add..." />
                    <div class="space-y-1">
                        @foreach(auth()->user()->searchNotecards($search[$i]) ?? [] as $notecard)
                            <x-notecard-checkbox :notecard="$notecard" :i="$i" />
                        @endforeach
                    </div>
                </div>

                <div class="mt-2 flex justify-end">
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('collections.show', $collection) }}" target="_blank">
                            <x-small-icon icon="o-external-link" />
                        </a>
                        <button
                            x-data x-on:click="confirm('Are you sure you want to delete {{ $collection->name }}?') && $wire.destroy({{ $collection->id }})"
                            wire:key="destroy-{{ $collection->id }}"
                        >
                            <x-small-icon icon="o-trash" />
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 font-medium">You haven’t created any collections yet.</p>
        @endforelse
    </div>
</div>
