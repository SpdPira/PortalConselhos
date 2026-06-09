<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class EnsureTermsAccepted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Se o usuário estiver autenticado e não tiver aceitado os termos ainda
        if (Auth::check() && is_null(Auth::user()->terms_accepted_at)) {
            
            // Permitir acesso à rota do termo de consentimento, rotas de logout e arquivos do Livewire/Vite
            if ($request->is('termo-de-consentimento*') ||
                $request->routeIs('terms.accept') ||
                $request->is('*/logout') ||
                $request->routeIs('*.auth.logout') ||
                $request->is('livewire/*') ||
                $request->is('_debugbar*')
            ) {
                return $next($request);
            }

            // Armazenar qual painel o usuário tentou acessar antes do redirecionamento
            if ($request->is('admin*') && !session()->has('terms_redirect_panel')) {
                session(['terms_redirect_panel' => 'admin']);
            } elseif ($request->is('user*') && !session()->has('terms_redirect_panel')) {
                session(['terms_redirect_panel' => 'user']);
            }

            return redirect()->route('terms.accept');
        }

        return $next($request);
    }
}
