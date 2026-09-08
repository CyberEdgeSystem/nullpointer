<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Мій кабінет</p>
            <div class="mt-2 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <h1 class="text-3xl font-semibold tracking-tight text-zinc-950 dark:text-white">Прогрес лабораторних</h1>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                        Тут фіксуються лаби, які ти відкривав і виконав, разом із таймером проходження.
                    </p>
                </div>
                <div class="rounded-xl border border-amber-400/30 bg-amber-400/10 px-5 py-4 text-amber-700 dark:text-amber-300">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em]">Solved</p>
                    <p class="mt-1 text-2xl font-semibold">{{ $solvedCount }} / {{ $labs->count() }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-4 xl:grid-cols-3">
            @foreach ($labs as $lab)
                <article class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-zinc-900">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-zinc-950 dark:text-white">{{ $lab['title'] }}</h2>
                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $lab['progress']?->started_at ? 'Розпочато '.$lab['progress']->started_at->format('d.m.Y H:i') : 'Ще не відкривалась' }}
                            </p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $lab['solved'] ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-300' : 'bg-amber-500/10 text-amber-700 dark:text-amber-300' }}">
                            {{ $lab['solved'] ? 'Solved' : 'Open' }}
                        </span>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-3 text-sm">
                        <div class="rounded-xl border border-neutral-200 px-4 py-3 dark:border-neutral-700">
                            <p class="text-zinc-500 dark:text-zinc-400">Таймер</p>
                            <p class="mt-1 font-mono font-semibold text-zinc-950 dark:text-white">{{ $lab['elapsed'] }}</p>
                        </div>
                        <div class="rounded-xl border border-neutral-200 px-4 py-3 dark:border-neutral-700">
                            <p class="text-zinc-500 dark:text-zinc-400">Спроби solve</p>
                            <p class="mt-1 font-semibold text-zinc-950 dark:text-white">{{ $lab['progress']?->solve_count ?? 0 }}</p>
                        </div>
                    </div>

                    @if ($lab['progress']?->solved_at)
                        <p class="mt-4 text-sm text-emerald-600 dark:text-emerald-300">
                            Виконано {{ $lab['progress']->solved_at->format('d.m.Y H:i') }}
                        </p>
                    @endif

                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="{{ route($lab['route']) }}" class="rounded-xl bg-amber-400 px-4 py-2 text-sm font-semibold text-zinc-950 transition hover:bg-amber-300">
                            Відкрити лабу
                        </a>
                        <a href="{{ route($lab['instructions_route']) }}" class="rounded-xl border border-neutral-200 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50 dark:border-neutral-700 dark:text-zinc-300 dark:hover:bg-white/5">
                            Інструкція
                        </a>
                        @if ($lab['solved'])
                            <form method="POST" action="{{ route('dashboard.lab.reset', ['labKey' => $lab['key']]) }}" class="inline-block">
                                @csrf
                                <button type="submit" class="rounded-xl border border-red-400/40 bg-red-500/10 px-4 py-2 text-sm font-medium text-red-200 transition hover:bg-red-500/20">
                                    Скинути
                                </button>
                            </form>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</x-layouts::app>
