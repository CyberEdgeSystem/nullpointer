<x-labs.layout title="Database version lab" active="db-version">
    <x-labs.progress-panel :progress="$progress" />

    @if ($solved)
        <x-labs.solved-banner class="mb-8" message="Рядок версії бази даних відображено у відповіді." />
        <x-labs.ctf-flag :flag="$flag" />
    @endif

    <div class="grid gap-10 lg:grid-cols-[16rem_1fr]">
        <aside>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Store catalog</p>
            <h1 class="mt-3 text-3xl font-semibold tracking-tight">Current selection</h1>
            <p class="mt-3 text-sm leading-6 text-zinc-400">
                Review the current category view and compare the product records shown in the storefront list.
            </p>

            <nav class="mt-8 space-y-2" aria-label="Product categories">
                <a href="{{ route('labs.sql-injection-version') }}" class="block rounded-xl px-4 py-3 text-sm transition {{ $category === '' ? 'bg-white text-zinc-950' : 'bg-white/5 text-zinc-300 hover:bg-white/10' }}">
                    Усі товари
                </a>

                @foreach ($categories as $availableCategory)
                    <a href="{{ route('labs.sql-injection-version', ['category' => $availableCategory]) }}" class="block rounded-xl px-4 py-3 text-sm transition {{ $category === $availableCategory ? 'bg-white text-zinc-950' : 'bg-white/5 text-zinc-300 hover:bg-white/10' }}">
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
                            <th class="px-5 py-3">Name / version</th>
                            <th class="px-5 py-3">Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse ($rows as $row)
                            <tr data-test="db-version-row">
                                <td class="px-5 py-4 font-medium text-white">{{ $row->name }}</td>
                                <td class="px-5 py-4 text-zinc-400">{{ $row->description }}</td>
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

            @if ($versionString)
                <div class="mt-6 rounded-xl border border-amber-400/30 bg-amber-400/10 p-4 text-sm text-amber-200">
                    Database version: <code class="text-amber-100">{{ $versionString }}</code>
                </div>
            @endif
        </section>
    </div>
</x-labs.layout>
