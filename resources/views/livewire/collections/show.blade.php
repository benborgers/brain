@section('title', $collection->name)
@section('hide-sidebar', true)

<div>
    <div class="max-w-screen-sm mx-auto">
        <h1 class="text-center font-extrabold text-gray-900 text-2xl mb-8 mt-4">{{ $collection->name }}</h1>

        <div class="space-y-4">
            @foreach ($notecards as $notecard)
                @livewire('notecard', [ 'notecard' => $notecard, 'embedded' => true ], key($notecard->id))
            @endforeach
        </div>
    </div>
</div>
