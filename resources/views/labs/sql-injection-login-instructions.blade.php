<x-labs.layout title="Обліковий доступ guide" active="login-instructions">
    <section class="max-w-3xl">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Lab 2</p>
        <h1 class="mt-3 text-4xl font-semibold tracking-tight">Обліковий доступ</h1>
        <p class="mt-4 text-base leading-7 text-zinc-400">
            Objective: sign in as the administrator without knowing the password.
        </p>
    </section>

    <div class="mt-10 grid gap-8 lg:grid-cols-[1fr_18rem]">
        <article class="rounded-xl border border-white/10 bg-zinc-900 p-6">
            <ol class="space-y-4 text-sm leading-6 text-zinc-300">
                <li class="rounded-xl border border-white/10 bg-white/5 p-4"><span class="font-semibold text-white">1. Open the login form.</span> The form accepts a username and password.</li>
                <li class="rounded-xl border border-white/10 bg-white/5 p-4"><span class="font-semibold text-white">2. Enter the payload.</span> Use: <code class="mt-3 block overflow-x-auto rounded-lg border border-white/10 bg-zinc-950 px-3 py-2 text-amber-300">administrator' -- </code></li>
                <li class="rounded-xl border border-white/10 bg-white/5 p-4"><span class="font-semibold text-white">3. Enter any password.</span> For example <code class="rounded bg-zinc-950 px-1.5 py-0.5 text-amber-300">anything</code>. The comment <code class="rounded bg-zinc-950 px-1.5 py-0.5 text-amber-300">--</code> bypasses the password check.</li>
                <li class="rounded-xl border border-white/10 bg-white/5 p-4"><span class="font-semibold text-white">4. Confirm access.</span> The page should show you signed in as administrator.</li>
            </ol>
        </article>

        <aside class="rounded-xl border border-white/10 bg-zinc-900 p-6">
            <p class="text-sm font-semibold text-white">Useful links</p>
            <div class="mt-4 space-y-3">
                <a href="{{ route('labs.sql-injection-login') }}" class="block rounded-xl bg-amber-400 px-4 py-3 text-center text-sm font-semibold text-zinc-950 transition hover:bg-amber-300">Open Lab 2</a>
                <a href="{{ route('labs.sql-injection.instructions') }}" class="block rounded-xl border border-white/10 px-4 py-3 text-center text-sm font-medium text-zinc-300 transition hover:bg-white/5">Open Lab 1 guide</a>
            </div>
        </aside>
    </div>
</x-labs.layout>
