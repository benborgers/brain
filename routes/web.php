<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire;

Route::get('/', fn() => redirect()->route('home'));

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/home', Livewire\Home::class)->name('home');
    Route::get('/folder/{folder}', Livewire\Folder::class)->name('folder.show');
    Route::get('/notecard/create', Livewire\Notecard::class)->name('notecard.create');
    Route::get('/collections', Livewire\Collections\Manage::class)->name('collections.manage');
});

Route::get('/collection/{collection:key}', Livewire\Collections\Show::class)->name('collections.show');
Route::get('/notecard/{notecard}', Livewire\Notecard::class)->name('notecard.show');
