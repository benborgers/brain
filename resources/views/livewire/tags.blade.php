@section('title', 'Tags')

<div>
    @if (empty($selected))
        <x-big-input wire:model="tagSearch" placeholder="Search for a tag..." autofocus />

        <div class="space-y-3 ml-4">
            @forelse ($tagResults as $tag)
                <div class="cursor-pointer flex items-center space-x-2" wire:click="$set('selected', '{{ $tag }}')">
                    <x-heroicon-o-tag class="h-5 text-gray-400" />
                    <span class="text-gray-800 text-lg">{{ $tag }}</span>
                </div>
            @empty
                <p class="text-lg text-gray-400">No tags found.</p>
            @endforelse
        </div>
    @else
        <div class="flex justify-start">
            <div wire:click="$set('selected', '')" class="flex space-x-1 items-center mb-4 cursor-pointer">
                <x-heroicon-s-chevron-left class="h-4 text-gray-400" />
                <span class="text-gray-500">Back</span>
            </div>
        </div>

        <div class="space-y-4 ml-2">
            @foreach ($noteResults as $note)
                <x-note-search-result :note="$note" :highlight="'[[' . $selected . ']]'" />
            @endforeach
        </div>
    @endif

    <x-loading-bar />
</div>
