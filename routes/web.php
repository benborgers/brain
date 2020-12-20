<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire;

Route::get('/', fn() => redirect()->route('home'));

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/home', Livewire\Home::class)->name('home');
    Route::get('/folder/{folder}', Livewire\Folder::class)
        ->middleware('can:see-folder,folder')
        ->name('folder.show');
    Route::get('/notecard/create', Livewire\Notecard::class)->name('notecard.create');
    Route::get('/notecard/{notecard}', Livewire\Notecard::class)
        ->middleware('can:see-notecard,notecard')
        ->name('notecard.show');
});
