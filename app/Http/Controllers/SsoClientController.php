<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SsoClientController extends Controller
{
    /**
     * Redireciona o usuário após autenticação bem-sucedida via SSO.
     */
    public function success(Request $request)
    {
        // Se houver um erro de autenticação vindo do OIDC
        if ($request->session()->has('oidc_error')) {
            $error = $request->session()->get('oidc_error');
            $desc = $request->session()->get('oidc_error_description');

            return response("<div style='font-family: sans-serif; text-align: center; margin-top: 100px; color: #333;'>
                <h2 style='color: #880000;'>Falha na Autenticação SSO</h2>
                <p>Ocorreu um erro ao tentar conectar ao servidor central de credenciais.</p>
                <p><strong>Erro:</strong> {$error} - {$desc}</p>
                <a href='/' style='color: #4668b9; text-decoration: none; font-weight: bold;'>Voltar para o início</a>
            </div>", 400);
        }

        // Se o usuário não estiver de fato autenticado
        if (!auth()->check()) {
            return redirect()->to('/admin/login');
        }

        $role = session('sso_role');

        if ($role === 'admin') {
            return redirect()->to('/admin');
        }

        return redirect()->to('/user');
    }
}
