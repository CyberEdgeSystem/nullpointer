<x-labs.layout title="Lab solutions" active="solutions">
    <section class="max-w-4xl">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Private solutions</p>
        <h1 class="mt-3 text-4xl font-semibold tracking-tight">Lab solutions</h1>
        <p class="mt-4 text-base leading-7 text-zinc-400">
            This page is available only to the authenticated user with ID 1. Below is the documentation URL with the lab walkthroughs.
        </p>
    </section>

    <div class="mt-10 rounded-2xl border border-amber-500/30 bg-amber-500/10 p-6">
        <p class="text-sm font-medium text-amber-200">Documentation URL:</p>
        <a href="{{ url('/labs/solutions') }}" class="mt-3 block break-all text-lg font-semibold text-amber-100 underline decoration-amber-400/80 underline-offset-4">
            {{ url('/labs/solutions') }}
        </a>
    </div>

    <div class="mt-10 grid gap-6">
        <article class="rounded-xl border border-white/10 bg-zinc-900 p-6">
            <h2 class="text-2xl font-semibold">Lab 1</h2>
            <p class="mt-3 text-zinc-300">Hint: use the <code class="text-amber-300">category</code> parameter and close the query with <code class="text-amber-300">' OR 1=1 --</code>.</p>
        </article>

        <article class="rounded-xl border border-white/10 bg-zinc-900 p-6">
            <h2 class="text-2xl font-semibold">Lab 2</h2>
            <p class="mt-3 text-zinc-300">Hint: bypass the login check with SQL injection in username/password, such as <code class="text-amber-300">admin' --</code>.</p>
        </article>

        <article class="rounded-xl border border-white/10 bg-zinc-900 p-6">
            <h2 class="text-2xl font-semibold">Lab 3</h2>
            <p class="mt-3 text-zinc-300">Hint: use UNION SELECT to inject alternate columns and display admin credentials.</p>
        </article>

        <article class="rounded-xl border border-white/10 bg-zinc-900 p-6">
            <h2 class="text-2xl font-semibold">Lab 4</h2>
            <p class="mt-3 text-zinc-300">Hint: payload <code class="text-amber-300">Gifts' UNION SELECT banner, NULL FROM v$version --</code>.</p>
        </article>

        <article class="rounded-xl border border-white/10 bg-zinc-900 p-6">
            <h2 class="text-2xl font-semibold">Lab 5</h2>
            <p class="mt-3 text-zinc-300">Hint: for SQLite, use <code class="text-amber-300">Gifts' UNION SELECT sqlite_version(), NULL --</code>.</p>
        </article>
    </div>
</x-labs.layout>
