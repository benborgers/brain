<div>
    <div class="grid grid-cols-7 gap-x-4 gap-y-6">
        @foreach ($dates as $date)
            @php( $note = $notes->where('date', $date->format('Y-m-d'))->first() )
            @if($note)
                <a href="{{ route('note.edit', $note->date) }}">
                    <div class="bg-gray-100 shadow py-2 px-3 rounded duration-150 hover:bg-rose-100 group">
                        <p class="text-gray-800 font-bold text-center duration-150 group-hover:text-rose-700">{{ $date->format('jS')}}</p>
                        <p class="text-gray-500 text-sm text-center duration-150 group-hover:text-rose-700">{{ $date->format('F') }}</p>
                    </div>
                </a>
            @else
                <div></div>
            @endif
        @endforeach
    </div>
</div>
