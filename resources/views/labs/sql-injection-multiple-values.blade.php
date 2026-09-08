<x-labs.layout title="Single-column data lab" active="multiple-values">
    <x-labs.progress-panel :progress="$progress" />

    @if ($solved)
        <x-labs.solved-banner class="mb-8" message="Об’єднані username і password відображено в одному текстовому стовпці." />
        <x-labs.ctf-flag :flag="$flag" />
    @endif

    <div class="grid gap-10 lg:grid-cols-[16rem_1fr]">
        <aside>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Featured collection</p>
            <h1 class="mt-3 text-3xl font-semibold tracking-tight">Catalog filters</h1>
            <p class="mt-3 text-sm leading-6 text-zinc-400">
                Browse the active product selection and review the catalog output for any matching account records.
            </p>

            <nav class="mt-8 space-y-2" aria-label="Product categories">
                <a href="{{ route('labs.sql-injection-multiple-values') }}" class="block rounded-xl px-4 py-3 text-sm transition {{ $category === '' ? 'bg-white text-zinc-950' : 'bg-white/5 text-zinc-300 hover:bg-white/10' }}">
                    Усі товари
                </a>

                @foreach ($categories as $availableCategory)
                    <a href="{{ route('labs.sql-injection-multiple-values', ['category' => $availableCategory]) }}" class="block rounded-xl px-4 py-3 text-sm transition {{ $category === $availableCategory ? 'bg-white text-zinc-950' : 'bg-white/5 text-zinc-300 hover:bg-white/10' }}">
                        {{ $availableCategory }}
                    </a>
                @endforeach
            </nav>
        </aside>

        <section>
            <div class="flex items-end justify-between gap-4 border-b border-white/10 pb-5">
                <div>
                    <p class="text-sm text-zinc-500">Поточна категорія</p>
                    <h2 class="mt-1 text-2xl font-semibold">{{ $category !== '' ? $category : 'Усі товари' }}</h2>
                </div>
                <span class="text-sm text-zinc-500">{{ $rows->count() }} товар(ів)</span>
            </div>

            @if ($queryError)
                <div role="alert" class="mt-6 rounded-xl border border-red-400/30 bg-red-400/10 p-4 text-sm text-red-200">
                    {{ $queryError }}
                </div>
            @endif

            <div class="mt-6 overflow-hidden rounded-xl border border-white/10 bg-zinc-900">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-zinc-500">
                        <tr>
                            <th class="px-5 py-3">Name</th>
                            <th class="px-5 py-3">Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse ($rows as $row)
                            <tr data-test="multiple-values-row">
                                <td class="px-5 py-4 font-medium text-white">{{ $row->name ?? 'NULL' }}</td>
                                <td class="px-5 py-4 text-zinc-400">{{ $row->description ?? 'NULL' }}</td>
                            </tr>
                        @empty
                            @unless ($queryError)
                                <tr>
                                    <td colspan="2" class="px-5 py-12 text-center text-zinc-500">
                                        Нічого не знайдено.
                                    </td>
                                </tr>
                            @endunless
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (!empty($userRows))
                <div class="mt-8 rounded-xl border border-emerald-400/30 bg-emerald-400/10 p-5">
                    <p class="text-sm font-semibold text-emerald-200">Збіги облікових записів:</p>
                    <div class="mt-4 overflow-hidden rounded-xl border border-white/10 bg-zinc-950">
                        <table class="w-full text-left text-sm">
                            <thead class="border-b border-white/10 text-xs uppercase tracking-wider text-zinc-500">
                                <tr>
                                    <th class="px-4 py-3">Combined value</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @foreach ($userRows as $row)
                                    <tr>
                                        <td class="px-4 py-4 font-mono text-zinc-200">{{ $row['combined'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="mt-10 rounded-xl border border-white/10 bg-zinc-900 p-6">
                @if ($username)
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <p class="text-sm text-zinc-300">Увійшли як <span class="font-semibold text-white">{{ $username }}</span></p>
                        <form method="POST" action="{{ route('labs.sql-injection-multiple-values.logout') }}">
                            @csrf
                            <button type="submit" class="rounded-lg border border-white/10 px-3 py-2 text-sm text-zinc-300 hover:bg-white/5">
                                Log out
                            </button>
                        </form>
                    </div>
                @endif

                <form method="POST" action="{{ route('labs.sql-injection-multiple-values.login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="username" class="mb-2 block text-sm font-medium text-zinc-300">Ім'я користувача</label>
                        <input id="username" name="username" type="text" value="{{ old('username') }}" class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-3 text-white outline-none ring-0 placeholder:text-zinc-500 focus:border-amber-400/60" placeholder="administrator" />
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-zinc-300">Пароль</label>
                        <input id="password" name="password" type="password" class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-3 text-white outline-none ring-0 placeholder:text-zinc-500 focus:border-amber-400/60" placeholder="Пароль" />
                    </div>

                    @error('login')
                        <p class="rounded-lg border border-red-400/30 bg-red-400/10 px-3 py-2 text-sm text-red-200">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="rounded-xl bg-amber-400 px-5 py-3 text-sm font-semibold text-zinc-950 transition hover:bg-amber-300">
                        Увійти as administrator
                    </button>
                </form>
            </div>
        </section>
    </div>
</x-labs.layout>
