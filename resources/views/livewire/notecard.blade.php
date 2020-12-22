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
        @can('see-folder', $folder)
            <a href="{{ route('folder.show', $folder) }}" class="mb-8 flex space-x-2 items-center duration-100">
                <x-heroicon-s-arrow-narrow-left class="h-4 text-gray-400" />
                <span class="text-gray-500 hover:text-gray-900 transition-colors">{{ $folder->name }}</span>
            </a>
        @endcan
    @endunless

    <section class="bg-white rounded-lg p-6 border border-gray-200 max-w-screen-sm mx-auto overflow-hidden">
        @if(Gate::allows('edit-notecard', $notecard) && $create === false && $mode === 'read')
            <div class="flex justify-end">
                <button wire:click="toggleMode" wire:key="toggle-mode-{{ $notecard->id }}">
                    <x-small-icon icon="o-pencil" />
                </button>
            </div>
        @endif

        @if($mode === 'read')
            <div
                x-data="{ collapsed: false }"
                x-init="(() => {
                    $refs.markdown.innerHTML = $refs.markdown.innerHTML.replace(/\$\$(.*?)\$\$/g, (_, equation) =>
                        katex.renderToString(equation, { throwOnError: false }))
                    if($refs.markdown.getBoundingClientRect().height > 288 && {{ $embedded ? 'true' : 'false' }}) {
                        collapsed = true
                    }
                })()"
                class="relative"
            >
                @if($embedded) <a href="{{ route('notecard.show', $notecard) }}"> @endif
                    <h1 class="text-2xl font-extrabold text-gray-900 mb-4 inline-block">{{ $notecard->title }}</h1>
                @if($embedded) </a> @endif
                <div class="prose" x-ref="markdown" :class="{ 'max-h-72 overflow-hidden': collapsed }">
                    {!! $notecard->toHtml() !!}
                </div>

                {{-- Overlay for when collapsed --}}
                <div x-show="collapsed">
                    <div class="h-48 bg-gradient-to-t from-white to-transparent absolute bottom-0 inset-x-0 pointer-events-none"></div>
                    <div class="absolute bottom-0 inset-x-0 flex justify-center">
                        <button class="rounded-full py-1 px-3 bg-gray-200 focus:outline-none text-gray-900" x-on:click="collapsed = false">
                            <x-heroicon-o-chevron-down class="h-4" />
                        </button>
                    </div>
                </div>
            </div>
        @elseif($mode === 'edit')
            <form wire:submit.prevent="save">
                <x-autosize-textarea
                    autofocus
                    wire:model.defer="notecard.title"
                    placeholder="Title"
                    class="w-full p-0 border-none focus:ring-0 resize-none text-2xl font-extrabold text-gray-900 mb-4"
                />
                <x-autosize-textarea
                    wire:model.defer="notecard.markdown"
                    placeholder="# Markdown content"
                    class="w-full p-0 border-none focus:ring-0 resize-none font-mono text-gray-900"
                    x-on:keydown.tab.prevent="$el.setRangeText('  ', $el.selectionStart, $el.selectionStart, 'end')"
                />

                {{-- Bottom editing bar --}}
                <div class="mt-6 flex items-center justify-between bg-gray-100 -mb-6 -mx-6 px-6 py-3">
                    <div class="flex items-center space-x-2">
                        @unless($create)
                            <p class="text-gray-500">Folder:</p>
                            <select wire:model.defer="notecard.folder_id" class="bg-transparent py-2 leading-none bg-white rounded-lg border-gray-300 focus:ring-0 focus:border-gray-300">
                                @foreach (auth()->user()->folders()->orderBy('name')->get() as $folder)
                                    <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                                @endforeach
                            </select>
                        @endunless
                    </div>

                    <div class="flex items-center space-x-4">
                        @unless($create)
                            <button
                                x-data x-on:click="confirm('Are you sure you want to delete this notecard?') && $wire.destroy()"
                                wire:key="delete-{{ $notecard->id }}"
                                type="button" {{-- To stop form from submitting --}}
                            >
                                <x-small-icon icon="o-trash" />
                            </button>
                        @endunless
                        <input type="submit" value="{{ $this->notecard->exists ? 'Save' : 'Create' }}" class="cursor-pointer bg-rose-200 text-rose-700 leading-none py-2 px-3 rounded-lg font-semibold focus:outline-none">
                    </div>
                </div>
            </form>
        @endif
    </section>
</div>
