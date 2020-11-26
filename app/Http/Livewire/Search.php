<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Search extends Component
{
    public $search = '';
    public $results = [];

    public function updatedSearch()
    {
        if(empty($this->search)) {
            return $this->results = [];
        }

        $this->results = auth()->user()->notes()
            ->latestByDate()
            ->where('contents', 'like', '%' . $this->search . '%')
            ->get();
    }
}
