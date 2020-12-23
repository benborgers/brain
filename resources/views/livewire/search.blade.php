<div>
    <input
        type="text"
        wire:model="input"
        x-ref="input"
        class="w-full text-lg border-none focus:ring-0 px-6 pt-6 pb-3 text-gray-900 font-semibold"
        placeholder="Search your notecards..."
    />

    <div class="overflow-scroll h-72">
        @if($this->results !== null)
            @forelse ($this->results as $notecard)
                <a href="{{ route('notecard.show', $notecard) }}" class="block">
                    <div class="px-6 py-3 bg-white transition-colors duration-200 hover:bg-gray-100">
                        <p class="text-lg text-gray-600">{{ $notecard->title }}</p>
                    </div>
                </a>
            @empty
                <p class="text-gray-400 font-medium px-6">No results found. The sadness.</p>
            @endforelse
        @endif
    </div>
</div>
