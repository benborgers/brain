<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Folder as FolderModel;

class Folder extends Component
{
    use AuthorizesRequests;

    public FolderModel $folder;

    protected $rules = [
        'folder.name' => 'required|max:255'
    ];

    public function updatedFolder()
    {
        $this->folder->save();
        $this->emitTo('sidebar', 'refresh');
    }

    public function deleteFolder()
    {
        $this->folder->delete();
        return redirect()->route('home');
    }

    public function render()
    {
        $this->authorize('see-folder', $this->folder);

        return view('livewire.folder', [
            'notecards' => $this->folder->notecards()->inOrder()->get()
        ]);
    }
}
