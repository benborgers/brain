<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire;

Route::get('/', function () {
    if(auth()->check()) {
        return redirect()->route('today');
    }

    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/n/{date}', Livewire\Notes\Edit::class)->name('note.edit');
    Route::view('/today', 'today')->name('today');
    Route::get('/tags', Livewire\Tags::class)->name('tags');
    Route::get('/search', Livewire\Search::class)->name('search');
});
