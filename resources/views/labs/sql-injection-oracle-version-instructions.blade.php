<x-labs.layout title="Oracle version guide" active="oracle-version">
    <section class="max-w-3xl">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Lab 4</p>
        <h1 class="mt-3 text-4xl font-semibold tracking-tight">Oracle version</h1>
        <p class="mt-4 text-base leading-7 text-zinc-400">
            Objective: use a UNION attack to display the Oracle database version string.
        </p>
    </section>
    <div class="mt-10 rounded-xl border border-white/10 bg-zinc-900 p-6">
        <p class="text-sm text-zinc-300">Use the same UNION pattern as the product filter, but replace the injected column values with version data, such as <code class="text-amber-300">Gifts' UNION SELECT banner, NULL FROM v$version --</code>.</p>
    </div>
</x-labs.layout>
