<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/home', Livewire\Home::class);
});
