<div
    x-data="{ open: false }"
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
    });"
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
            @livewire('search')
        </div>
    </div>
</div>
