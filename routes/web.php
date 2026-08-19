<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Portal\Index;
use App\Livewire\Portal\Show;
use App\Livewire\AcceptTerms;
use App\Http\Controllers\SsoClientController;

Route::get('/', Index::class)->name('home');
Route::get('/conselhos/{conselho}', Show::class)->name('conselhos.show');

Route::middleware('auth')->get('/termo-de-consentimento', AcceptTerms::class)->name('terms.accept');

// Interceptadores de Login para redirecionar ao OIDC (SSO)
Route::get('/admin/login', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->to('/admin');
        }
        if ($user->conselhos()->exists()) {
            return redirect()->to('/user');
        }

        // Logado, mas sem nenhum acesso a painel
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return response('<div style="font-family: sans-serif; text-align: center; margin-top: 100px; color: #333;">
            <h2>Acesso Negado</h2>
            <p>Seu usuário não possui permissão de administrador e não está vinculado a nenhum conselho municipal.</p>
            <a href="/" style="color: #4668b9; text-decoration: none; font-weight: bold;">Voltar para o início</a>
        </div>', 403);
    }
    return redirect()->to('/auth/redirect');
})->name('login');

Route::get('/user/login', function () {
    if (auth()->check()) {
        $role = session('sso_role');
        return $role === 'admin' ? redirect()->to('/admin') : redirect()->to('/user');
    }
    return redirect()->to('/auth/redirect');
});

// Rota de sucesso pós-login SSO (verificação de autenticação interna para evitar loops)
Route::get('/sso/success', [SsoClientController::class, 'success'])
    ->name('sso.success');
