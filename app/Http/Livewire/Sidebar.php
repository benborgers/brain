<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Sidebar extends Component
{
    public $newFolderName = '';
    public $currentUrl;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->currentUrl = url()->current();
    }

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

    private function getFoldersWithParent($parent)
    {
        return auth()->user()->folders()
            ->where('parent', $parent)
            ->orderBy('order')
            ->get();
    }

    // Direction is either 'up' or 'down'.
    public function reorder($folderId, $direction)
    {
        $folder = auth()->user()->folders()->findOrFail($folderId);

        // Get all folders in the same level.
        $foldersAtLevel = $this->getFoldersWithParent($folder->parent);

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

    public function indent($folderId, $direction)
    {
        $folder = auth()->user()->folders()->findOrFail($folderId);

        $foldersAtLevel = $this->getFoldersWithParent($folder->parent);

        foreach($foldersAtLevel as $i => $folder) {
            if($folder->id === $folderId) {
                if($direction === 'in') {
                    $folder->parent = $foldersAtLevel[$i - 1]->id;
                } else if($direction === 'out') {
                    $folder->parent = auth()->user()->folders()->find($folder->parent)->parent;
                }
                $folder->save();
            }
        }
    }

    public function render()
    {
        return view('livewire.sidebar', [
            'allFolders' => auth()->user()->folders()->orderBy('order')->get()
        ]);
    }
}
