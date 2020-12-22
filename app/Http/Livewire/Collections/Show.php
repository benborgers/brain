<?php

namespace App\Http\Livewire\Collections;

use Livewire\Component;

use App\Models\Collection;
use App\Models\Notecard;

class Show extends Component
{
    public Collection $collection;

    public function render()
    {
        return view('livewire.collections.show', [
            'notecards' => Notecard::whereIn('id', $this->collection->notecards)->inOrder()->get()
        ]);
    }
}
