<?php

use App\Auth\OidcCustomAuthenticator;

return [
    /*
    |--------------------------------------------------------------------------
    | Auth Server Configuration
    |--------------------------------------------------------------------------
    |
    | Configure your OIDC provider (Auth Server) settings here.
    |
    */

    'auth_server' => [
        'host' => env('OIDC_AUTH_SERVER_HOST'),
        'client_id' => env('OIDC_CLIENT_ID'),
        'client_secret' => env('OIDC_CLIENT_SECRET'),
        'redirect_uri' => env('OIDC_REDIRECT_URI'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Redirect URL
    |--------------------------------------------------------------------------
    |
    | Where to redirect after successful OIDC authentication.
    |
    */

    'redirect_url' => env('OIDC_REDIRECT_URL', '/sso/success'),

    /*
    |--------------------------------------------------------------------------
    | Post-Logout Redirect URL
    |--------------------------------------------------------------------------
    |
    | Where the Auth Server should redirect after SSO logout.
    |
    */

    'post_logout_redirect_url' => env('OIDC_POST_LOGOUT_REDIRECT_URL', '/'),

    /*
    |--------------------------------------------------------------------------
    | Authenticator
    |--------------------------------------------------------------------------
    |
    | The class that handles login after OIDC callback.
    |
    */

    'authenticator' => OidcCustomAuthenticator::class,

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    |
    | The OIDC scopes to request during authorization.
    |
    */

    'scopes' => env('OIDC_SCOPES', 'openid profile email'),

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | The Eloquent model class to use for users.
    |
    */

    'user_model' => env('OIDC_USER_MODEL', 'App\\Models\\User'),

    /*
    |--------------------------------------------------------------------------
    | User Mapping
    |--------------------------------------------------------------------------
    |
    | Configure how OIDC userinfo claims map to your local User model.
    |
    */

    'user_mapping' => [
        'identifier_column' => 'email',
        'identifier_claim' => 'email',
        'refresh_token_column' => 'auth_server_refresh_token',
        'attributes' => [
            'name' => fn ($userinfo) => $userinfo['name'] ?? $userinfo['email'],
            'oidc_sub' => fn ($userinfo) => $userinfo['sub'] ?? null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the route prefixes and middleware for OIDC routes.
    |
    */

    'routes' => [
        'web' => [
            'prefix' => 'auth',
            'middleware' => ['web'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    */

    'rate_limits' => [
        'redirect' => env('OIDC_RATE_LIMIT_REDIRECT', '60,1'),
        'callback' => env('OIDC_RATE_LIMIT_CALLBACK', '100,1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP Timeouts
    |--------------------------------------------------------------------------
    |
    */

    'http' => [
        'timeout' => env('OIDC_HTTP_TIMEOUT', 15),
        'retry_times' => env('OIDC_HTTP_RETRY_TIMES', 2),
        'retry_delay' => env('OIDC_HTTP_RETRY_DELAY', 200),
    ],

    /*
    |--------------------------------------------------------------------------
    | Auth Server Endpoints
    |--------------------------------------------------------------------------
    |
    */

    'endpoints' => [
        'authorize' => '/oauth/authorize',
        'token' => '/oauth/token',
        'userinfo' => '/oauth/userinfo',
        'revoke' => '/oauth/revoke',
        'logout' => '/oauth/logout',
    ],

];
