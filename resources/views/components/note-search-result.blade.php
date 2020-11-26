@props(['note', 'highlight'])

<div class="transitions-colors duration-200 hover:bg-gray-50 p-3 rounded">
    <a href="{{ route('note.edit', $note->date) }}">
        <div>
            <p class="text-gray-900 text-lg font-bold mb-1">{{ $note->fullHumanDate() }}</p>
            <ul class="list-disc ml-8 space-y-1">
                @foreach ($note->highlightedContents($highlight) as $instance)
                    <li class="text-gray-600">
                        <span class="text-gray-400">&hellip;</span>{!! $instance !!}<span class="text-gray-400">&hellip;</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </a>
</div>
