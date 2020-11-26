<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class Tags extends Component
{
    public $allTags;
    public $tagSearch = '';
    public $tagResults = [];
    public $selectedTag = '';
    public $noteResults = [];

    protected $queryString = [
        'selectedTag' => ['except' => '']
    ];

    public function mount()
    {
        $this->allTags = auth()->user()->notes()
            ->latestByDate()
            ->pluck('tags')
            ->flatten()
            ->unique();
        
        $this->updatedTagSearch();

        if(! empty($this->selectedTag)) {
            // If query string is populated
            $this->updatedSelectedTag();
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

    public function updatedSelectedTag()
    {
        $this->noteResults = auth()->user()->notes()
            ->latestByDate()
            ->whereJsonContains('tags', $this->selectedTag)
            ->get();
    }
}
