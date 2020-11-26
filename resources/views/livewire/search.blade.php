@section('title', 'Search notes')

<div>
    <x-big-input wire:model="search" placeholder="Search your notes..." />

    <div class="space-y-4 ml-2">
        @forelse ($results as $note)
            <x-note-search-result :note="$note" :highlight="$search" />
        @empty
            @unless (empty($search))
                <p class="text-lg text-gray-400 ml-2">No results found.</p>
            @endunless
        @endforelse
    </div>

    <x-loading-bar />
</div>
