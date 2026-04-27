<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Portal\Index;
use App\Livewire\Portal\Show;

Route::get('/', Index::class)->name('home');
Route::get('/conselhos/{conselho}', Show::class)->name('conselhos.show');
