@once
    @push('head')
        <link rel="stylesheet" href="https://unpkg.com/katex@0.12.0/dist/katex.min.css" />
        <script src="https://unpkg.com/katex@0.12.0/dist/katex.min.js"></script>
    @endpush
@endonce

@unless($embedded)
    @section('hide-sidebar', true)
@endunless

<div>
    @unless($embedded)
        <a href="{{ route('folder.show', $folder) }}" class="mb-8 flex space-x-2 items-center duration-100">
            <x-heroicon-s-arrow-narrow-left class="h-4 text-gray-400" />
            <span class="text-gray-500 hover:text-gray-900 transition-colors">{{ $folder->name }}</span>
        </a>
    @endunless

    <div class="bg-white rounded-lg p-6 border border-gray-200 max-w-screen-sm mx-auto">
        @if($create === false && $mode === 'read')
            <div class="flex justify-end">
                <button
                    class="text-gray-500 hover:text-gray-800 duration-150 transition-colors focus:outline-none"
                    wire:click="toggleMode"
                >
                    <x-heroicon-o-pencil class="h-4" />
                </button>
            </div>
        @endif

        @if($mode === 'read')
            <div
                x-data
                x-init="$refs.markdown.innerHTML = $refs.markdown.innerHTML.replace(/\$\$(.*?)\$\$/g, (_, equation) =>
                    katex.renderToString(equation, { throwOnError: false }))"
            >
                <h1 class="text-2xl font-extrabold text-gray-900 mb-4">{{ $notecard->title }}</h1>
                <div class="prose" x-ref="markdown">
                    {!! $notecard->toHtml() !!}
                </div>
            </div>
        @elseif($mode === 'edit')
            <form wire:submit.prevent="save" class="space-y-4">
                <input type="text" wire:model.defer="notecard.title" placeholder="Notecard title" class="w-full p-0 border-none focus:ring-0 text-2xl font-extrabold text-gray-900" />
                <textarea wire:model.defer="notecard.markdown" placeholder="# Markdown content" class="w-full p-0 border-none focus:ring-0 resize-none h-64 font-mono text-gray-900"></textarea>
                <input type="submit" value="{{ $this->notecard->exists ? 'Save' : 'Create' }}" class="cursor-pointer bg-rose-200 text-rose-700 py-1 px-3 rounded-lg font-semibold focus:outline-none">
            </form>
        @endif

        @if($embedded)
            <div class="flex justify-end mt-4">
                <a href="{{ route('notecard.show', $notecard) }}" class="block">
                    <x-heroicon-o-arrows-expand class="h-4 text-gray-400 hover:text-gray-800 duration-100 transition-colors" />
                </a>
            </div>
        @endif
    </div>
</div>