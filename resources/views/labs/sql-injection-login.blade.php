<x-labs.layout title="Обліковий доступ lab" active="login">
    <x-labs.progress-panel :progress="$progress" />

    <div class="grid min-h-[calc(100vh-160px)] items-center gap-12 lg:grid-cols-2">
        <section>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Обліковий доступ</p>
            <h1 class="mt-4 max-w-xl text-4xl font-semibold tracking-tight sm:text-5xl">Увійдіть до свого акаунту</h1>
            <p class="mt-5 max-w-lg text-base leading-7 text-zinc-400">
                The storefront login panel is connected to a legacy customer database. Review the login flow and determine the correct administrator record before continuing.
            </p>

            <div class="mt-10 grid max-w-lg grid-cols-3 gap-3 text-center text-xs text-zinc-500">
                <div class="rounded-xl border border-white/10 bg-white/5 px-3 py-4">01<br><span class="mt-1 block text-zinc-300">Review</span></div>
                <div class="rounded-xl border border-white/10 bg-white/5 px-3 py-4">02<br><span class="mt-1 block text-zinc-300">Attack</span></div>
                <div class="rounded-xl border border-white/10 bg-white/5 px-3 py-4">03<br><span class="mt-1 block text-zinc-300">Admin</span></div>
            </div>
        </section>

        <section class="mx-auto w-full max-w-md rounded-xl border border-white/10 bg-zinc-900 p-7 shadow-2xl shadow-black/30 sm:p-9">
            @if ($solved)
                <x-labs.solved-banner>You signed in as <strong>{{ $username }}</strong>.</x-labs.solved-banner>
                <x-labs.ctf-flag class="mt-6 mb-0" :flag="$flag" />

                <form method="POST" action="{{ route('labs.sql-injection-login.logout') }}" class="mt-6">
                    @csrf
                    <button class="w-full rounded-xl border border-white/10 px-4 py-3 text-sm font-medium text-zinc-300 transition hover:bg-white/5">
                        Скинути лабу
                    </button>
                </form>
            @elseif ($username)
                <div class="rounded-xl border border-amber-400/30 bg-amber-400/10 p-5 text-amber-200">
                    <p class="font-semibold">Logged in as {{ $username }}</p>
                    <p class="mt-1 text-sm text-amber-300/80">This is a valid user, but this lab requires the administrator account.</p>
                </div>

                <form method="POST" action="{{ route('labs.sql-injection-login.logout') }}" class="mt-6">
                    @csrf
                    <button class="w-full rounded-xl border border-white/10 px-4 py-3 text-sm font-medium text-zinc-300 transition hover:bg-white/5">
                        Спробувати ще раз
                    </button>
                </form>
            @else
                <div class="mb-7">
                    <h2 class="text-2xl font-semibold">Вхід до акаунту</h2>
                    <p class="mt-2 text-sm text-zinc-500">Enter your credentials to continue.</p>
                </div>

                @error('login')
                    <div role="alert" class="mb-5 rounded-xl border border-red-400/30 bg-red-400/10 p-4 text-sm text-red-200">
                        {{ $message }}
                    </div>
                @enderror

                <form method="POST" action="{{ route('labs.sql-injection-login.attempt') }}" class="space-y-5">
                    @csrf
                    <label class="block">
                        <span class="mb-2 block text-sm font-medium text-zinc-300">Ім'я користувача</span>
                        <input name="username" value="{{ old('username') }}" autocomplete="username" required autofocus class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-3 text-white outline-none transition placeholder:text-zinc-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20" placeholder="username">
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-medium text-zinc-300">Пароль</span>
                        <input type="password" name="password" autocomplete="current-password" required class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-3 text-white outline-none transition placeholder:text-zinc-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20" placeholder="password">
                    </label>

                    <button class="w-full rounded-xl bg-amber-400 px-4 py-3 font-semibold text-zinc-950 transition hover:bg-amber-300">
                        Увійти
                    </button>
                </form>
            @endif
        </section>
    </div>
</x-labs.layout>
