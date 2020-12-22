@props(['folders', 'allFolders', 'level' => 0, 'currentUrl'])

<div style="margin-left: {{ $level * 8 }}px">
    @foreach ($folders->sortBy('order') as $folder)
        @php($hasChildren = $allFolders->where('parent', $folder->id)->count() > 0)

        <div
            x-data="{ expandChildren: localStorage.getItem('brain-sidebar-expand-{{ $folder->id }}') === 'true' ? true : false }"
            x-init="$watch('expandChildren', value => localStorage.setItem('brain-sidebar-expand-{{ $folder->id }}', value))"
            class="my-1"
        >
            @php($url = route('folder.show', $folder))
            <div
                class="flex items-center space-x-3 group px-2 py-1 rounded-lg border border-transparent text-gray-500
                    hover:bg-white hover:border-gray-200 hover:text-gray-900 transition-150 transition-colors
                    @if($currentUrl === $url) bg-white border-gray-200 text-gray-900 @endif"
            >
                <div class="flex space-x-2">
                    @if($hasChildren)
                        <button class="cursor-pointer focus:outline-none" x-on:click="expandChildren = !expandChildren">
                            @php($showIconClass = 'w-4 text-gray-400')
                            <x-heroicon-s-chevron-right :class="$showIconClass" x-show="expandChildren === false" />
                            <x-heroicon-s-chevron-down :class="$showIconClass" x-show="expandChildren === true" x-cloak />
                        </button>
                    @else
                        {{-- Spacer to make space on the left --}}
                        <div class="w-4"></div>
                    @endif
                    <a class="block" href="{{ $url }}">
                        {{ $folder->name }}
                        @if($folder->notecards()->exists())
                            <span class="text-gray-300 inline-block ml-1">{{ $folder->notecards()->count() }}</span>
                        @endif
                    </a>
                </div>
                <div class="flex space-x-1">
                    @php($actionIconClass = 'text-gray-400 hover:text-gray-900 h-3 cursor-pointer duration-150 transition-opacity opacity-0 group-hover:opacity-100')
                    @unless($loop->first)
                        <x-heroicon-s-arrow-narrow-up :class="$actionIconClass" wire:click="reorder({{ $folder->id }}, 'up')" />
                    @endunless
                    @unless($loop->last)
                        <x-heroicon-s-arrow-narrow-down :class="$actionIconClass" wire:click="reorder({{ $folder->id }}, 'down')" />
                    @endunless
                    @unless($folder->parent === null)
                        <x-heroicon-s-arrow-narrow-left :class="$actionIconClass" wire:click="indent({{ $folder->id }}, 'out')" />
                    @endunless
                    @unless($loop->first)
                        <x-heroicon-s-arrow-narrow-right :class="$actionIconClass" wire:click="indent({{ $folder->id }}, 'in')" />
                    @endunless
                </div>
            </div>
            @if($hasChildren)
                <div x-show="expandChildren" x-cloak>
                    <x-folder-level :folders="$allFolders->where('parent', $folder->id)" :allFolders="$allFolders" :currentUrl="$currentUrl" :level="$level + 1" />
                </div>
            @endif
        </div>
    @endforeach
</div>
