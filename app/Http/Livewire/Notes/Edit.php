<?php

namespace App\Http\Livewire\Notes;

use Livewire\Component;
use Illuminate\Support\Str;

class Edit extends Component
{
    public $note;

    protected $rules = [
        'note.contents' => 'nullable',
        'note.user_id' => 'required',
        'note.date' => 'required'
    ];

    public function mount($date)
    {
        $this->note = auth()->user()->notes()
            ->firstOrNew(['date' => $date], [
                'contents' => '<ul><li><br></li></ul>'
            ]);
    }

    public function saveContents($text)
    {
        $this->note->contents = $text;

        $tags = Str::of($text)->matchAll('/\[\[(.*?)\]\]/');
        $this->note->setTags($tags);

        $this->note->save();
    }
}
