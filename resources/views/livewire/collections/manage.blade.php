@section('title', 'Collections')

<div>
    <div class="mb-12 flex items-center justify-between">
        <p class="text-gray-400 font-medium">Collections allow you to publicly share a group of notecards with a link that anyone can access.</p>
        <button wire:click="create" class="bg-rose-200 text-rose-700 leading-none py-2 px-3 rounded-lg font-semibold focus:outline-none">New Collection</button>
    </div>

    <div class="space-y-4">
        @forelse ($collections as $i => $collection)
        @php($notecardsCount = count($collection->notecards))
            <div class="bg-white rounded-lg p-6 border border-gray-200 max-w-screen-sm mx-auto overflow-hidden">
                <div class="mb-4 flex items-center justify-between">
                    <input type="text" wire:model="collections.{{ $i }}.name" class="p-0 border-none text-gray-900 font-bold text-xl focus:ring-0" />
                    <p class="text-gray-400">{{ $notecardsCount }} {{ Str::plural('notecard', $notecardsCount) }}</p>
                </div>

                <div x-data="{ show: false }" x-cloak wire:key="select-notecards-for-{{ $collection->id }}">
                    <button class="focus:outline-none bg-gray-200 leading-none py-1 px-3 text-gray-800 text-sm font-bold rounded-full" x-on:click="show = !show">
                        <span x-show="!show">Select notecards</span>
                        <span x-show="show">Hide notecards</span>
                    </button>
                    <div x-show="show" class="mt-2">
                        @foreach ($notecards as $notecard)
                            <div class="inline-block mb-1 mr-4">
                            	<div class="flex items-center space-x-2">
                            	    <input
                            	        type="checkbox"
                                        value="{{ $notecard->id }}"
                                        id="collection-{{ $collection->id }}-notecard-{{ $notecard->id }}"
                            	        wire:model="collections.{{ $i }}.notecards"
                            	        class="rounded border border-gray-300 text-rose-500 bg-gray-100 focus:ring-0 focus:ring-offset-0"
                            	    />
                            	    <label for="collection-{{ $collection->id }}-notecard-{{ $notecard->id }}" class="select-none">{{ $notecard->title }}</label>
                            	</div>
                            </div>
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
