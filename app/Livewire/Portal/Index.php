<?php

namespace App\Livewire\Portal;

use Livewire\Component;
use App\Models\Conselho;

class Index extends Component
{
    public function render()
    {
        $conselhos = Conselho::orderBy('nome')->get();
        return view('livewire.portal.index', compact('conselhos'))
            ->layout('components.layouts.app');
    }
}
