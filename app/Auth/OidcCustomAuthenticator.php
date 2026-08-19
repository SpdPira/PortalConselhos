<?php

namespace App\Auth;

use Admin9\OidcClient\Contracts\OidcAuthenticator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OidcCustomAuthenticator implements OidcAuthenticator
{
    public function authenticate(Request $request, mixed $user, array $tokens, array $userInfo): Response
    {
        // O $user recebido já é a instância local do modelo User mapeada via e-mail pelo OidcService
        
        // Sincroniza o papel (role)
        $role = $userInfo['role'] ?? 'user';
        if (isset($userInfo['groups']) && is_array($userInfo['groups'])) {
            if (in_array('Administrador', $userInfo['groups'])) {
                $role = 'admin';
            }
        }
        $user->role = $role;
        $user->save();

        // Faz login no guard web
        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        // Salva papel na sessão para verificação fácil
        session([
            'sso_role' => $role,
        ]);

        $request->session()->forget('url.intended');

        // Redireciona para a rota de sucesso pós-SSO
        return redirect()->to(config('oidc-client.redirect_url', '/sso/success'));
    }
}
