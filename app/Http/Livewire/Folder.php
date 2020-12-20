<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Folder as FolderModel;

class Folder extends Component
{
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
        return view('livewire.folder', [
            'notecards' => $this->folder->notecards()->orderByDesc('updated_at')->get()
        ]);
    }
}