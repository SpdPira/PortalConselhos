<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Portal dos Conselhos' }}</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-zinc-150 text-zinc-900 min-h-screen">
        <header class="bg-[#2f4b86] text-white shadow">
            <div class="max-w-[80%] mx-auto py-2 px-4 sm:px-6 lg:px-8">
                <table>
                    <tr>
                        <td style="width: 6%;">
                            <a href="{{ route('home') }}" style="display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('/assets/images/logo_pirassununga.png') }}" alt="Página Inicial" style="height: 58px;">
                            </a>
                        </td>
                        <td style="width: 80%;">
                            <h1 class="text-3xl font-bold tracking-tight text-center">Portal dos Conselhos - Prefeitura de Pirassununga</h1>
                        </td>
                        <td style="width: 12%;">
                            <a href="{{ route('login') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 65" width="100%" height="100%" style="font-family: Instrument Sans;">
                                <!-- Fundo com cantos arredondados -->
                                <rect width="150" height="65" rx="8" fill="#3B82F6" />

                                <!-- Ícone com o path exato fornecido -->
                                <g transform="translate(12, 8) scale(2)" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </g>

                                <!-- Texto alinhado em duas linhas -->
                                <text x="66" y="30" fill="#FFFFFF" font-size="18" font-weight="700" letter-spacing="-0.3">Acessar</text>
                                <text x="66" y="48" fill="#FFFFFF" font-size="18" font-weight="700" letter-spacing="-0.3">Portal</text>
                                </svg>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </header>
        <main class="max-w-[80%] mx-auto py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </body>
</html>
