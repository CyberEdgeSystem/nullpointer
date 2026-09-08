<x-labs.layout title="Determine column count lab" active="column-count">
    <x-labs.progress-panel :progress="$progress" />

    @if ($solved)
        <x-labs.solved-banner class="mb-8" message="Повернено рядок лише з NULL — кількість колонок визначено." />
        <x-labs.ctf-flag :flag="$flag" />
    @endif

    <div class="grid gap-10 lg:grid-cols-[16rem_1fr]">
        <aside>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Catalog filter</p>
            <h1 class="mt-3 text-3xl font-semibold tracking-tight">Перегляд категорії</h1>
            <p class="mt-3 text-sm leading-6 text-zinc-400">
                Review the storefront view and compare the product records returned for each category.
            </p>

            <nav class="mt-8 space-y-2" aria-label="Product categories">
                <a href="{{ route('labs.sql-injection-column-count') }}" class="block rounded-xl px-4 py-3 text-sm transition {{ $category === '' ? 'bg-white text-zinc-950' : 'bg-white/5 text-zinc-300 hover:bg-white/10' }}">
                    Усі товари
                </a>

                @foreach ($categories as $availableCategory)
                    <a href="{{ route('labs.sql-injection-column-count', ['category' => $availableCategory]) }}" class="block rounded-xl px-4 py-3 text-sm transition {{ $category === $availableCategory ? 'bg-white text-zinc-950' : 'bg-white/5 text-zinc-300 hover:bg-white/10' }}">
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
                            <tr data-test="column-count-row">
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
        </section>
    </div>
</x-labs.layout>
