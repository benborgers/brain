@section('hide-sidebar', true)

@push('head')
    <link rel="stylesheet" href="https://unpkg.com/katex@0.12.0/dist/katex.min.css" />
    <script src="https://unpkg.com/katex@0.12.0/dist/katex.min.js"></script>
@endpush

<div>
    <a href="{{ route('folder.show', $folder) }}">Back to {{ $folder->name }}</a>

    @unless($create)
        <button
            class="bg-gray-200 rounded-full p-2 text-gray-600 hover:bg-gray-300 hover:text-gray-900 duration-150 transition-colors focus:outline-none"
            wire:click="toggleMode"
        >
            <x-heroicon-o-pencil class="h-4" />
        </button>
    @endunless

    @if($mode === 'read')
        <div
            x-data
            x-init="$refs.markdown.innerHTML = $refs.markdown.innerHTML.replace(/\$\$(.*?)\$\$/g, (_, equation) =>
                katex.renderToString(equation, { throwOnError: false }))"
        >
            <h1>{{ $notecard->title }}</h1>
            <div class="prose" x-ref="markdown">
                {!! $notecard->toHtml() !!}
            </div>
        </div>
    @elseif($mode === 'edit')
        <form wire:submit.prevent="save">
            <input type="text" wire:model.defer="notecard.title" placeholder="Title" />
            <textarea wire:model.defer="notecard.markdown"></textarea>
            <input type="submit" value="{{ $this->notecard->exists ? 'Save' : 'Create' }}">
        </form>
    @endif
</div>
