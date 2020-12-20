@props(['folders', 'allFolders', 'level' => 0])

<div style="margin-left: {{ $level * 8 }}px">
    @foreach ($folders->sortBy('order') as $folder)
        <div>
            <a href="{{ route('folder.show', $folder) }}">
                <div class="flex items-center space-x-3 group p-1 hover:bg-white hover:shadow transition-150 transition-colors">
                    <p>{{ $folder->name }}</p>
                    <div class="flex">
                        @unless($loop->first)
                            <x-heroicon-s-arrow-narrow-up class="text-gray-400 hover:text-gray-900 h-3 cursor-pointer duration-150 transition-colors opacity-0 group-hover:opacity-100" wire:click="reorder({{ $folder->id }}, 'up')" />
                        @endunless
                        @unless($loop->last)
                            <x-heroicon-s-arrow-narrow-down class="text-gray-400 hover:text-gray-900 h-3 cursor-pointer duration-150 transition-opacity opacity-0 group-hover:opacity-100" wire:click="reorder({{ $folder->id }}, 'down')" />
                        @endunless
                    </div>
                </div>
            </a>
            @if($allFolders->where('parent', $folder->id)->count() > 0)
                <x-folder-level :folders="$allFolders->where('parent', $folder->id)" :allFolders="$allFolders" :level="$level + 1" />
            @endif
        </div>
    @endforeach
</div>
