<x-labs.layout title="Database version guide" active="db-version">
    <section class="max-w-3xl">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Lab 5</p>
        <h1 class="mt-3 text-4xl font-semibold tracking-tight">Database version</h1>
        <p class="mt-4 text-base leading-7 text-zinc-400">
            Objective: display the database version string via an injected UNION query.
        </p>
    </section>
    <div class="mt-10 rounded-xl border border-white/10 bg-zinc-900 p-6">
        <p class="text-sm text-zinc-300">For SQLite, use a payload like <code class="text-amber-300">Gifts' UNION SELECT sqlite_version(), NULL --</code>.</p>
    </div>
</x-labs.layout>
