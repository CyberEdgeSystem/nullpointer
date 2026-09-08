<x-labs.layout title="Blind SQL conditional lab" active="blind-conditional">
    <x-labs.progress-panel :progress="$progress" />

    @if ($solved)
        <x-labs.solved-banner class="mb-8">You signed in as <strong>{{ session('blind_conditional_lab.username') }}</strong>.</x-labs.solved-banner>
        <x-labs.ctf-flag :flag="$flag" />
    @endif

    <div class="grid gap-10 lg:grid-cols-[1fr_24rem]">
        <section>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Перевірка трекера</p>
            <h1 class="mt-3 text-4xl font-semibold tracking-tight">Blind SQL — умовні відповіді</h1>
            <p class="mt-4 max-w-2xl text-sm leading-6 text-zinc-400">
                Заявка використовує значення cookie для аналітики у SQL-запиті. Результат не повертається напряму, але сторінка показує повідомлення «Welcome back», якщо запит повертає рядки. Скористайтеся умовною ін’єкцією, щоб відгадати пароль адміністратора.
            </p>

            <form method="POST" action="{{ route('labs.sql-injection-blind-conditional.set_tracking') }}" class="mt-8 rounded-xl border border-white/10 bg-zinc-900 p-6">
                @csrf
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-zinc-300">Tracking cookie value</span>
                    <input name="tracking" value="{{ old('tracking', $tracking) }}" class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-3 text-white outline-none transition placeholder:text-zinc-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20" placeholder="Enter tracking cookie payload">
                </label>

                <button class="mt-5 rounded-xl bg-amber-400 px-4 py-3 font-semibold text-zinc-950 transition hover:bg-amber-300">
                    Set tracking cookie
                </button>
            </form>

            @if ($queryError)
                <div role="alert" class="mt-6 rounded-xl border border-red-400/30 bg-red-400/10 p-4 text-sm text-red-200">
                    {{ $queryError }}
                </div>
            @endif

            <div class="mt-8 overflow-hidden rounded-xl border border-white/10 bg-zinc-900 p-6">
                <h2 class="font-semibold">Response</h2>

                <div class="mt-4 text-sm text-zinc-300">
                    @if ($welcome)
                        <p class="text-amber-300 font-semibold">Welcome back — the injected query returned rows.</p>
                    @else
                        <p class="text-zinc-400">No conditional match detected. The query returned no rows.</p>
                    @endif
                </div>
            </div>
        </section>

        <aside class="rounded-xl border border-white/10 bg-zinc-900 p-6">
            @if (session('blind_conditional_lab.username') && ! $solved)
                <div class="mb-6 rounded-xl border border-amber-400/30 bg-amber-400/10 p-4 text-amber-200">
                    <p class="font-semibold">Logged in as {{ session('blind_conditional_lab.username') }}</p>
                    <p class="mt-1 text-sm text-amber-300/80">This lab requires the administrator account.</p>
                </div>
            @endif

            <h2 class="text-2xl font-semibold">Вхід клієнта</h2>
            <p class="mt-2 text-sm leading-6 text-zinc-500">Увійдіть, використовуючи облікові дані, які ви отримали шляхом сліпої ін’єкції.</p>

            @error('login')
                <div role="alert" class="mt-5 rounded-xl border border-red-400/30 bg-red-400/10 p-4 text-sm text-red-200">
                    {{ $message }}
                </div>
            @enderror

            <form method="POST" action="{{ route('labs.sql-injection-blind-conditional.login') }}" class="mt-6 space-y-5">
                @csrf
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-zinc-300">Ім'я користувача</span>
                    <input name="username" value="{{ old('username') }}" required class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-3 text-white outline-none transition placeholder:text-zinc-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20" placeholder="administrator">
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-zinc-300">Пароль</span>
                    <input type="password" name="password" required class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-3 text-white outline-none transition placeholder:text-zinc-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20" placeholder="password">
                </label>

                <button class="w-full rounded-xl bg-amber-400 px-4 py-3 font-semibold text-zinc-950 transition hover:bg-amber-300">
                    Увійти
                </button>
            </form>

            @if (session('blind_conditional_lab.username'))
                <form method="POST" action="{{ route('labs.sql-injection-blind-conditional.logout') }}" class="mt-4">
                    @csrf
                    <button class="w-full rounded-xl border border-white/10 px-4 py-3 text-sm font-medium text-zinc-300 transition hover:bg-white/5">
                        Скинути лабу
                    </button>
                </form>
            @endif
        </aside>
    </div>
</x-labs.layout>
