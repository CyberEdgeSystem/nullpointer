@props([
    'title',
    'active',
])

<!DOCTYPE html>
<html lang="uk">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased">
        <header class="border-b border-white/10 bg-zinc-900/90 backdrop-blur">
            <div class="mx-auto flex max-w-6xl flex-col gap-4 px-6 py-4 xl:flex-row xl:items-center xl:justify-between">
                <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight">
                    NullPointer
                </a>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <nav class="flex flex-wrap items-center gap-2 text-sm" aria-label="Tasks">
                        <a href="{{ route('labs.sql-injection') }}" class="rounded-full px-3 py-1.5 transition {{ $active === 'products' ? 'border border-amber-400/30 bg-amber-400/10 text-amber-300' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                            Task 1
                        </a>
                        <a href="{{ route('labs.sql-injection-login') }}" class="rounded-full px-3 py-1.5 transition {{ $active === 'login' ? 'border border-amber-400/30 bg-amber-400/10 text-amber-300' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                            Task 2
                        </a>
                        <a href="{{ route('labs.sql-injection-stock-union') }}" class="rounded-full px-3 py-1.5 transition {{ $active === 'stock-union' ? 'border border-amber-400/30 bg-amber-400/10 text-amber-300' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                            Task 3
                        </a>
                        <a href="{{ route('labs.sql-injection-oracle-version') }}" class="rounded-full px-3 py-1.5 transition {{ $active === 'oracle-version' ? 'border border-amber-400/30 bg-amber-400/10 text-amber-300' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                            Task 4
                        </a>
                        <a href="{{ route('labs.sql-injection-version') }}" class="rounded-full px-3 py-1.5 transition {{ $active === 'db-version' || $active === 'database-version' ? 'border border-amber-400/30 bg-amber-400/10 text-amber-300' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                            Task 5
                        </a>
                        <a href="{{ route('labs.sql-injection-user-table') }}" class="rounded-full px-3 py-1.5 transition {{ $active === 'user-table-union' ? 'border border-amber-400/30 bg-amber-400/10 text-amber-300' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                            Task 6
                        </a>
                        <a href="{{ route('labs.sql-injection-column-count') }}" class="rounded-full px-3 py-1.5 transition {{ $active === 'column-count' ? 'border border-amber-400/30 bg-amber-400/10 text-amber-300' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                            Task 7
                        </a>
                        <a href="{{ route('labs.sql-injection-column-text') }}" class="rounded-full px-3 py-1.5 transition {{ $active === 'column-text' ? 'border border-amber-400/30 bg-amber-400/10 text-amber-300' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                            Task 8
                        </a>
                        <a href="{{ route('labs.sql-injection-table-data') }}" class="rounded-full px-3 py-1.5 transition {{ $active === 'table-data' ? 'border border-amber-400/30 bg-amber-400/10 text-amber-300' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                            Task 9
                        </a>
                        <a href="{{ route('labs.sql-injection-multiple-values') }}" class="rounded-full px-3 py-1.5 transition {{ $active === 'multiple-values' ? 'border border-amber-400/30 bg-amber-400/10 text-amber-300' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                            Task 10
                        </a>
                        <a href="{{ route('labs.sql-injection-blind-conditional') }}" class="rounded-full px-3 py-1.5 transition {{ $active === 'blind-conditional' ? 'border border-amber-400/30 bg-amber-400/10 text-amber-300' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                            Task 11
                        </a>
                    </nav>

                    <div class="flex items-center gap-2 border-white/10 text-sm sm:border-l sm:pl-3">
                        @auth
                            @if (Auth::id() === 1)
                                <a href="{{ route('labs.solutions') }}" class="rounded-full border border-amber-500/40 bg-amber-500/10 px-3 py-1.5 text-amber-200 transition hover:bg-amber-500/20">
                                    Lab solutions
                                </a>
                            @endif
                            <a href="{{ route('dashboard') }}" class="rounded-full border border-white/10 px-3 py-1.5 text-zinc-300 transition hover:bg-white/5 hover:text-white">
                                Account
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-full border border-white/10 px-3 py-1.5 text-zinc-300 transition hover:bg-white/5 hover:text-white">
                                Увійти
                            </a>
                            <a href="{{ route('register') }}" class="rounded-full bg-amber-400 px-3 py-1.5 font-semibold text-zinc-950 transition hover:bg-amber-300">
                                Реєстрація
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-6 py-12">
            {{ $slot }}
        </main>
    </body>
</html>
