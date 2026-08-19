<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\LogoutResponse as Responsable;
use Symfony\Component\HttpFoundation\Response;

class LogoutResponse implements Responsable
{
    public function toResponse($request): Response
    {
        $providerUrl = env('SSO_PROVIDER_URL', 'http://127.0.0.1:8000');
        $logoutUrl = $providerUrl . '/sso/logout?redirect_uri=' . urlencode(url('/admin/login'));
        return redirect()->away($logoutUrl);
    }
}
