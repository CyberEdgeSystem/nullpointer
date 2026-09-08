<x-labs.layout title="Каталог товарів lab" active="products">
    <x-labs.progress-panel :progress="$progress" />

    @if ($solved)
        <x-labs.solved-banner class="mb-8" message="У результатах знайдено хоча б один товар, який ще не випущено." />
        <x-labs.ctf-flag :flag="$flag" />
    @endif

    <div class="grid gap-10 lg:grid-cols-[16rem_1fr]">
        <aside>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Каталог товарів</p>
            <h1 class="mt-3 text-3xl font-semibold tracking-tight">Перегляд за категоріями</h1>
            <p class="mt-3 text-sm leading-6 text-zinc-400">
                Your objective is to force the page to display one or more products that have not yet been released.
            </p>

            <nav class="mt-8 space-y-2" aria-label="Product categories">
                <a href="{{ route('labs.sql-injection') }}" class="block rounded-xl px-4 py-3 text-sm transition {{ $category === '' ? 'bg-white text-zinc-950' : 'bg-white/5 text-zinc-300 hover:bg-white/10' }}">
                    Усі товари
                </a>

                @foreach ($categories as $availableCategory)
                    <a href="{{ route('labs.sql-injection', ['category' => $availableCategory]) }}" class="block rounded-xl px-4 py-3 text-sm transition {{ $category === $availableCategory ? 'bg-white text-zinc-950' : 'bg-white/5 text-zinc-300 hover:bg-white/10' }}">
                        {{ $availableCategory }}
                    </a>
                @endforeach
            </nav>
        </aside>

        <section>
            <div class="flex items-end justify-between gap-4 border-b border-white/10 pb-5">
                <div>
                    <p class="text-sm text-zinc-500">Показано</p>
                    <h2 class="mt-1 text-2xl font-semibold">{{ $category !== '' ? $category : 'Усі товари' }}</h2>
                </div>
                <span class="text-sm text-zinc-500">{{ $products->count() }} товар(ів)</span>
            </div>

            @if ($queryError)
                <div role="alert" class="mt-6 rounded-xl border border-red-400/30 bg-red-400/10 p-4 text-sm text-red-200">
                    {{ $queryError }}
                </div>
            @endif

            <div class="mt-6 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($products as $product)
                    <article data-test="product" data-released="{{ (int) $product->released }}" class="group overflow-hidden rounded-xl border border-white/10 bg-zinc-900">
                        <div class="flex aspect-[4/3] items-center justify-center bg-gradient-to-br from-zinc-800 to-zinc-900">
                            <svg class="h-16 w-16 text-zinc-700 transition group-hover:scale-105 group-hover:text-amber-400/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25" d="M20 7 12 3 4 7m16 0-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div class="p-5">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="font-medium text-white">{{ $product->name }}</h3>
                                <span class="shrink-0 text-sm font-semibold text-amber-300">${{ number_format($product->price, 2) }}</span>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-zinc-400">{{ $product->description }}</p>
                            <p class="mt-4 text-xs font-medium uppercase tracking-wider text-zinc-600">{{ $product->category }}</p>
                        </div>
                    </article>
                @empty
                    @unless ($queryError)
                        <p class="col-span-full rounded-xl border border-dashed border-white/10 py-16 text-center text-zinc-500">
                            No products found.
                        </p>
                    @endunless
                @endforelse
            </div>
        </section>
    </div>
</x-labs.layout>
