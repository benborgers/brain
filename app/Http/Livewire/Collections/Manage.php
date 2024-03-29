<?php

namespace App\Http\Livewire\Collections;

use Livewire\Component;

use App\Models\Collection;
use App\Models\Notecard;

class Manage extends Component
{
    public $collections;
    public $search = [];

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

        foreach($this->collections as $i => $collection) {
            $this->search[$i] = '';
        }
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
        $this->collections[$index]->save();
    }

    public function render()
    {
        return view('livewire.collections.manage', [
            'notecards' => auth()->user()->notecards()->inOrder()->get()
        ]);
    }
}
