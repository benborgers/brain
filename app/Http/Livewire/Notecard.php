<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Notecard as NotecardModel;
use App\Models\Folder as Folder;

class Notecard extends Component
{
    use AuthorizesRequests;

    public NotecardModel $notecard;
    public Folder $folder;
    public $mode = 'read'; // 'read' or 'edit'
    public $create = false; // are we on create route?
    public $embedded = false;
    public $currentUrl;

    protected $rules = [
        'notecard.title' => 'required|max:255',
        'notecard.markdown' => 'required',
        'notecard.folder_id' => 'integer'
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

        $this->currentUrl = url()->current();
    }

    public function save()
    {
        $this->authorize('edit-notecard', $this->notecard);
        $this->validate();

        if(! $this->notecard->folder_id) {
            $this->notecard->folder_id = $this->folder->id;
        }
        $this->notecard->save();

        if($this->create) {
            return redirect()->route('notecard.show', $this->notecard);
        } else {
            $this->mode = 'read';

            if($this->notecard->folder_id !== $this->folder->id) {
                return redirect($this->currentUrl);
            }
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

    public function render()
    {
        $this->authorize('see-notecard', $this->notecard);

        return view('livewire.notecard');
    }
}
