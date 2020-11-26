<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class Tags extends Component
{
    public $allTags;
    public $tagSearch = '';
    public $tagResults = [];
    public $selected = '';
    public $noteResults = [];

    protected $queryString = [
        'selected' => ['except' => '']
    ];

    public function mount()
    {
        $this->allTags = auth()->user()->notes()
            ->latestByDate()
            ->pluck('tags')
            ->flatten()
            ->unique();
        
        $this->updatedTagSearch();

        if(! empty($this->selected)) {
            // If query string is populated
            $this->updatedSelected();
        }
    }

    public function updatedTagSearch()
    {
        if(empty($this->tagSearch)) {
            $this->tagResults = $this->allTags;
        } else {
            $this->tagResults = $this->allTags->filter(function ($tag) {
                if(Str::of($tag)->contains(strtolower($this->tagSearch))) {
                    return true;
                }

                return false;
            });
        }
    }

    public function updatedSelected()
    {
        $this->noteResults = auth()->user()->notes()
            ->latestByDate()
            ->whereJsonContains('tags', $this->selected)
            ->get();
    }
}
