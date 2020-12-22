<?php

namespace App\Http\Livewire\Collections;

use Livewire\Component;

use App\Models\Collection;
use App\Models\Notecard;

class Manage extends Component
{
    public $collections;

    protected $rules = [
        'collections.*.name' => 'required|max:255',
        'collections.*.notecards' => 'array'
    ];

    public function mount()
    {
        $this->refreshCollections();
    }

    private function refreshCollections()
    {
        $this->collections = auth()->user()->collections()->inOrder()->get();
    }

    public function create()
    {
        auth()->user()->collections()->create([ 'name' => 'Untitled Collection' ]);
        $this->refreshCollections();
    }

    public function destroy(Collection $collection)
    {
        $collection->delete();
        $this->refreshCollections();
    }

    public function updatedCollections($_, $property)
    {
        $index = explode('.', $property)[0];
        $editedCollection = $this->collections[$index];

        $allNotecardsBelongToThisUser = true;
        foreach($editedCollection->notecards as $notecardId) {
            $notecard = Notecard::find($notecardId);
            if(! $notecard->folder->owner->is(auth()->user())) {
                $allNotecardsBelongToThisUser = false;
            }
        }

        if($allNotecardsBelongToThisUser) {
            $editedCollection->save();
        }
    }

    public function render()
    {
        return view('livewire.collections.manage', [
            'notecards' => auth()->user()->notecards()->inOrder()->get()
        ]);
    }
}
