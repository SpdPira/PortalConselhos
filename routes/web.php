<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Portal\Index;
use App\Livewire\Portal\Show;
use App\Livewire\AcceptTerms;

Route::get('/', Index::class)->name('home');
Route::get('/conselhos/{conselho}', Show::class)->name('conselhos.show');

Route::middleware('auth')->get('/termo-de-consentimento', AcceptTerms::class)->name('terms.accept');

Route::get('/login', function () {
    return redirect()->route('filament.user.auth.login');
})->name('login');

