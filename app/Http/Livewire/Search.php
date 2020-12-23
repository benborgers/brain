<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Search extends Component
{
    public $input = '';

    protected $listeners = ['clear-search' => 'clear'];

    public function clear()
    {
        $this->reset('input');
    }

    public function getResultsProperty()
    {
        return auth()->user()->searchNotecards($this->input);
    }
}
