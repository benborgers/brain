@section('title', $notecard->title ?? 'New Notecard')

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
                x-data="{ collapsed: false }"
                x-init="(() => {
                    $refs.markdown.innerHTML = $refs.markdown.innerHTML.replace(/\$\$(.*?)\$\$/g, (_, equation) =>
                        katex.renderToString(equation, { throwOnError: false }))
                    if($el.getBoundingClientRect().height > 400 && {{ $embedded ? 'true' : 'false' }}) {
                        collapsed = true
                    }
                })()"
                class="relative"
            >
                @if($embedded) <a href="{{ route('notecard.show', $notecard) }}"> @endif
                    <h1 class="text-2xl font-extrabold text-gray-900 mb-4 inline-block">{{ $notecard->title }}</h1>
                @if($embedded) </a> @endif
                <div class="prose" x-ref="markdown" :class="{ 'max-h-96 overflow-hidden': collapsed }">
                    {!! $notecard->toHtml() !!}
                </div>

                {{-- Overlay for when collapsed --}}
                <div x-show="collapsed">
                    <div class="h-24 bg-gradient-to-t from-gray-900 to-transparent opacity-30 absolute bottom-0 inset-x-0 -mb-6 -mx-6 rounded-b-lg z-0"></div>
                    <button class="absolute rounded-full py-1 px-3 bg-white bottom-0 focus:outline-none text-gray-400 transition-colors duration-150 hover:text-rose-600" x-on:click="collapsed = false">
                        <x-heroicon-s-chevron-down class="h-4" />
                    </button>
                </div>
            </div>
        @elseif($mode === 'edit')
            <form wire:submit.prevent="save" class="space-y-4">
                <input
                    type="text"
                    autofocus
                    wire:model.defer="notecard.title"
                    placeholder="Title"
                    class="w-full p-0 border-none focus:ring-0 text-2xl font-extrabold text-gray-900"
                />
                <textarea
                    wire:model.defer="notecard.markdown"
                    placeholder="# Markdown content"
                    class="w-full p-0 border-none focus:ring-0 resize-none h-64 font-mono text-gray-900"
                    x-data="{ resize: () => { $el.style.height = '5px'; $el.style.height = $el.scrollHeight + 'px' } }"
                    x-on:keydown.tab.prevent="$el.setRangeText('  ', $el.selectionStart, $el.selectionStart, 'end')"
                    x-init="resize()"
                    x-on:input="resize()"
                ></textarea>
                <input type="submit" value="{{ $this->notecard->exists ? 'Save' : 'Create' }}" class="cursor-pointer bg-rose-200 text-rose-700 py-1 px-3 rounded-lg font-semibold focus:outline-none">
            </form>
        @endif
    </div>
</div>
