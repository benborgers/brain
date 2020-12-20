<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Sidebar extends Component
{
    public $newFolderName = '';

    protected $listeners = ['refresh' => '$refresh'];

    public function createFolder()
    {
        $this->validate(
            [ 'newFolderName' => 'required|max:255' ],
            [ 'newFolderName.required' => 'Your new folder needs a name.' ]
        );

        auth()->user()->folders()->create([
            'name' => $this->newFolderName
        ]);

        $this->reset('newFolderName');
    }

    // Direction is either 'up' or 'down'.
    public function reorder($folderId, $direction)
    {
        $folder = auth()->user()->folders()->findOrFail($folderId);

        // Get all folders in the same level.
        $foldersAtLevel = auth()->user()->folders()
            ->where('parent', $folder->parent)
            ->orderBy('order')
            ->get();

        // Start by assigning them the existing order.
        foreach($foldersAtLevel as $i => $folder) {
            $folder->order = $i;
        }

        foreach($foldersAtLevel as $i => $folder) {
            if($folder->id === $folderId) {
                // This is the folder we are trying to move.

                if($direction === 'up') {
                    $folder->order = $folder->order - 1;
                    $folderAbove = $foldersAtLevel[$i - 1];
                    $folderAbove->order = $folderAbove->order + 1;
                } else if($direction === 'down') {
                    $folder->order = $folder->order + 1;
                    $folderBelow = $foldersAtLevel[$i + 1];
                    $folderBelow->order = $folderBelow->order - 1;
                }
            }
        }

        $foldersAtLevel->each(fn ($folder) => $folder->save());
    }

    public function render()
    {
        return view('livewire.sidebar', [
            'allFolders' => auth()->user()->folders()->orderBy('order')->get()
        ]);
    }
}
