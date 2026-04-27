<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Portal dos Conselhos' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-zinc-50 text-zinc-900 min-h-screen">
        <header class="bg-primary text-white shadow">
            <div class="max-w-[80%] mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight">PORTAL DOS CONSELHOS</h1>
            </div>
        </header>

        <main class="max-w-[80%] mx-auto py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </body>
</html>
