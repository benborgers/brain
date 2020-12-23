@props(['notecard', 'i', 'appendToId' => ''])

<div class="flex items-center space-x-2">
    <input
        type="checkbox"
        value="{{ $notecard->id }}"
        id="{{ $i }}-{{ $notecard->id }}{{ $appendToId }}"
        wire:model="collections.{{ $i }}.notecards"
        class="rounded border border-gray-300 text-rose-500 bg-gray-100 focus:ring-0 focus:ring-offset-0"
    />
    <label for="{{ $i }}-{{ $notecard->id }}{{ $appendToId }}" class="select-none">{{ $notecard->title }}</label>
</div>
