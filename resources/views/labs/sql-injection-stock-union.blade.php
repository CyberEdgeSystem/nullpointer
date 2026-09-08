<x-labs.layout title="Stock check lab" active="stock-union">
    <x-labs.progress-panel :progress="$progress" />

    @if ($solved)
        <x-labs.solved-banner class="mb-8">You signed in as <strong>{{ $username }}</strong>.</x-labs.solved-banner>
        <x-labs.ctf-flag :flag="$flag" />
    @endif

    <div class="grid gap-10 lg:grid-cols-[1fr_24rem]">
        <section>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Перевірка залишків</p>
            <h1 class="mt-3 text-4xl font-semibold tracking-tight">UNION SQL-ін'єкція у перевірці залишків</h1>
            <p class="mt-4 max-w-2xl text-sm leading-6 text-zinc-400">
                Форма перевірки залишків повертає результат SQL-запиту безпосередньо у відповіді. Використайте UNION, щоб прочитати облікові дані з таблиці users і увійти як адміністратор.
            </p>

            <form method="POST" action="{{ route('labs.sql-injection-stock-union.check') }}" class="mt-8 rounded-xl border border-white/10 bg-zinc-900 p-6">
                @csrf
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-zinc-300">Product ID</span>
                    <select name="product_id" class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-3 text-white outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->id }} - {{ $product->name }}</option>
                        @endforeach
                    </select>
                </label>

                <button class="mt-5 rounded-xl bg-amber-400 px-4 py-3 font-semibold text-zinc-950 transition hover:bg-amber-300">
                    Перевірити залишки
                </button>
            </form>

            @if ($queryError)
                <div role="alert" class="mt-6 rounded-xl border border-red-400/30 bg-red-400/10 p-4 text-sm text-red-200">
                    {{ $message ?? $queryError }}
                </div>
            @endif

            <div class="mt-8 overflow-hidden rounded-xl border border-white/10 bg-zinc-900">
                <div class="border-b border-white/10 px-5 py-4">
                    <h2 class="font-semibold">Результат перевірки складу</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-zinc-500">
                            <tr>
                                <th class="px-5 py-3">Warehouse / username</th>
                                <th class="px-5 py-3">Quantity / password</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse ($results as $row)
                                <tr data-test="stock-row">
                                    <td class="px-5 py-4 text-zinc-200">{{ $row['warehouse'] }}</td>
                                    <td class="px-5 py-4 font-mono text-amber-300">{{ $row['quantity'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-5 py-12 text-center text-zinc-500">
                                        Поки що результатів немає. Запустіть перевірку залишків.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <aside class="rounded-xl border border-white/10 bg-zinc-900 p-6">
            @if ($username && !$solved)
                <div class="mb-6 rounded-xl border border-amber-400/30 bg-amber-400/10 p-4 text-amber-200">
                    <p class="font-semibold">Logged in as {{ $username }}</p>
                    <p class="mt-1 text-sm text-amber-300/80">This lab requires the administrator account.</p>
                </div>
            @endif

            <h2 class="text-2xl font-semibold">Вхід клієнта</h2>
            <p class="mt-2 text-sm leading-6 text-zinc-500">Увійти, використовуючи облікові дані, отримані через атаку UNION.</p>

            @error('login')
                <div role="alert" class="mt-5 rounded-xl border border-red-400/30 bg-red-400/10 p-4 text-sm text-red-200">
                    {{ $message }}
                </div>
            @enderror

            <form method="POST" action="{{ route('labs.sql-injection-stock-union.login') }}" class="mt-6 space-y-5">
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

            @if ($username)
                <form method="POST" action="{{ route('labs.sql-injection-stock-union.logout') }}" class="mt-4">
                    @csrf
                    <button class="w-full rounded-xl border border-white/10 px-4 py-3 text-sm font-medium text-zinc-300 transition hover:bg-white/5">
                        Скинути лабу
                    </button>
                </form>
            @endif
        </aside>
    </div>
</x-labs.layout>
