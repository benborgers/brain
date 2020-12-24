<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Search extends Component
{
    public $input = '';
    public $totalResults = 0;

    protected $listeners = ['clear-search' => 'clear'];

    public function clear()
    {
        $this->reset('input');
    }

    public function getResultsProperty()
    {
        $results = auth()->user()->searchNotecards($this->input);
        $this->totalResults = count($results ?? []);
        return $results;
    }
}
