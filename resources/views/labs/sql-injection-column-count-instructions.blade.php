<x-labs.layout title="Column count guide" active="column-count">
    <section class="max-w-3xl">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Lab 7</p>
        <h1 class="mt-3 text-4xl font-semibold tracking-tight">Determine column count</h1>
        <p class="mt-4 text-base leading-7 text-zinc-400">
            Objective: determine how many columns the SELECT query returns by adding NULL values in a UNION payload.
        </p>
    </section>
    <div class="mt-10 rounded-xl border border-white/10 bg-zinc-900 p-6">
        <p class="text-sm text-zinc-300">Try payloads like <code class="text-amber-300">' UNION SELECT NULL --</code> and then add more NULL values until the error disappears.</p>
    </div>
</x-labs.layout>
