@section('title', $note->fullHumanDate())

<div>
    @push('head')
        <script src="https://unpkg.com/trix@1.3.0/dist/trix.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/trix@1.3.0/dist/trix.css" />
    @endpush

    <div x-data="{ lastTyped: 0 }" wire:ignore>
        <input id="input" type="hidden" value="{{ $note->contents }}" x-ref="input" />
        <trix-editor
            class="prose max-w-none border-none"
            input="input"
            x-on:trix-change="lastTyped = new Date().getTime();
                const debounce = 1000
                setTimeout(() => {
                    const delta = new Date().getTime() - lastTyped
                    if(delta > debounce - 10) {
                        $wire.saveContents($refs.input.value)
                    }
                }, debounce)"
        ></trix-editor>
    </div>

    <x-loading-bar />
</div>
