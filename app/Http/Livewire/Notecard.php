<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Notecard as NotecardModel;
use App\Models\Folder as Folder;

class Notecard extends Component
{
    public NotecardModel $notecard;
    public Folder $folder;
    public $mode = 'read'; // 'read' or 'edit'
    public $create = false; // are we on create route?
    public $embedded = false;

    protected $rules = [
        'notecard.title' => 'nullable|max:255',
        'notecard.markdown' => 'nullable'
    ];

    public function mount(NotecardModel $notecard)
    {
        // If this is create route.
        if(! $notecard->exists) {
            $this->notecard = $notecard;
            $folder = auth()->user()->folders()->findOrFail(request('folder'));
            $this->folder = $folder;

            $this->mode = 'edit';

            $this->create = true;
        } else {
            $this->folder = Folder::find($this->notecard->folder_id);
        }
    }

    public function save()
    {
        $this->validate();
        if(! $this->notecard->folder_id) {
            $this->notecard->folder_id = $this->folder->id;
        }
        $this->notecard->save();

        if($this->create) {
            return redirect()->route('notecard.show', $this->notecard);
        } else {
            $this->mode = 'read';
        }
    }

    public function toggleMode()
    {
        if($this->mode === 'read') $this->mode = 'edit';
        else if($this->mode === 'edit') $this->mode = 'read';
    }

    public function destroy()
    {
        $this->notecard->delete();
        return redirect()->route('folder.show', $this->folder);
    }
}
