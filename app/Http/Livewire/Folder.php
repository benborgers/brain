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
}
