<div
    x-data="{ open: false, selectedResult: 0, totalResults: @entangle('totalResults'), input: @entangle('input') }"
    x-cloak
    x-on:keydown.window.cmd.k="open = true"
    x-on:keydown.window.escape="open = false"
    x-init="$watch('open', value => {
        if(value) {
            setTimeout(() => {
                $refs.input.focus()
            }, 100)
        }

        if(!value) {
            setTimeout(() => {
                Livewire.emit('clear-search')
            }, 500)
        }
    });
    $watch('selectedResult', value => {
        if(value < 0) selectedResult = totalResults -1
        if(value > totalResults -1) selectedResult = 0

        document.getElementById(`result-${selectedResult}`)?.scrollIntoView({ behavior: 'smooth' })
    })
    $watch('input', () => selectedResult = 0)"
    x-on:keydown.window.arrow-down="open && $event.preventDefault(); selectedResult++"
    x-on:keydown.window.arrow-up="open && $event.preventDefault(); selectedResult--"
    x-on:keydown.window.enter="open && document.getElementById(`result-${selectedResult}`)?.click()"
>
    <div
        class="h-screen w-screen fixed inset-0 transition-opacity"
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="bg-black opacity-30 h-screen w-screen absolute inset-0"></div>
    </div>

    <div
        class="h-screen w-screen fixed inset-0 flex justify-center items-center transition-all transform"
        x-show="open"
        x-transition:enter="ease-out duration-250"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
    >
        <div
            class="bg-white w-screen-sm mb-24 rounded-lg shadow-lg overflow-hidden"
            style="width: 40rem"
            x-on:click.away="open = false"
        >
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
                        @forelse ($this->results as $i => $notecard)
                            <a href="{{ route('notecard.show', $notecard) }}" class="block">
                                <div class="px-6 py-3 bg-white transition-colors duration-200 hover:bg-gray-100 flex items-center space-x-2" id="result-{{ $i }}">
                                    <x-heroicon-s-arrow-right
                                        class="h-3 text-gray-400 opacity-0 duration-150 transition-colors"
                                        x-bind:class="{ 'opacity-100': selectedResult === {{ $i }} }"
                                    />
                                    <p class="text-lg text-gray-600">{{ $notecard->title }}</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-400 font-medium px-6">No results found. The sadness.</p>
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
