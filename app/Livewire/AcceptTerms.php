<?php

namespace App\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

class AcceptTerms extends Component
{
    public bool $accepted = false;

    public function mount()
    {
        // Se o usuário já aceitou os termos, redireciona imediatamente
        if (Auth::check() && Auth::user()->terms_accepted_at) {
            $this->redirectToIntended();
        }
    }

    public function accept()
    {
        $this->validate([
            'accepted' => 'accepted',
        ], [
            'accepted.accepted' => 'Você precisa selecionar "Li e Aceito este Termo" para continuar.',
        ]);

        $user = Auth::user();
        if ($user) {
            $user->terms_accepted_at = now();
            $user->save();
        }

        $this->redirectToIntended();
    }

    protected function redirectToIntended()
    {
        $panel = session()->pull('terms_redirect_panel');

        if ($panel === 'admin') {
            return redirect()->to('/admin');
        }

        if ($panel === 'user') {
            return redirect()->to('/user');
        }

        // Fallback baseado na role do usuário ou redirecionando para /admin ou /user
        $user = Auth::user();
        if ($user && $user->role === 'admin') {
            return redirect()->to('/admin');
        }

        return redirect()->to('/user');
    }

    public function logout()
    {
        $panel = session()->get('terms_redirect_panel');

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        if ($panel === 'admin') {
            return redirect()->to('/admin/login');
        }
        
        if ($panel === 'user') {
            return redirect()->to('/user/login');
        }

        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.accept-terms')
            ->layout('components.layouts.app', ['title' => 'Termo de Consentimento']);
    }
}
