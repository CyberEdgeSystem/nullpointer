<x-labs.layout title="Інструкції" active="instructions">
    <section class="max-w-3xl">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Хаб інструкцій</p>
        <h1 class="mt-3 text-4xl font-semibold tracking-tight">Інструкції</h1>
        <p class="mt-4 text-base leading-7 text-zinc-400">
            Select the guide for the lab you want to complete. Each page contains a step-by-step walkthrough for a single lab only.
        </p>
    </section>

    <div class="mt-10 grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
        <a href="{{ route('labs.sql-injection.instructions') }}" class="rounded-xl border border-amber-400/30 bg-amber-400/10 p-6 transition hover:bg-amber-400/15">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-300">Посібник 1</p>
            <h2 class="mt-2 text-2xl font-semibold">Каталог товарів</h2>
            <p class="mt-3 text-sm leading-6 text-zinc-400">Step-by-step walkthrough for the category filter lab.</p>
        </a>

        <a href="{{ route('labs.sql-injection-login.instructions') }}" class="rounded-xl border border-amber-400/30 bg-amber-400/10 p-6 transition hover:bg-amber-400/15">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-300">Посібник 2</p>
            <h2 class="mt-2 text-2xl font-semibold">Обліковий доступ</h2>
            <p class="mt-3 text-sm leading-6 text-zinc-400">Bypass the login flow and access the admin account.</p>
        </a>

        <a href="{{ route('labs.sql-injection-stock-union.instructions') }}" class="rounded-xl border border-amber-400/30 bg-amber-400/10 p-6 transition hover:bg-amber-400/15">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-300">Посібник 3</p>
            <h2 class="mt-2 text-2xl font-semibold">UNION stock check</h2>
            <p class="mt-3 text-sm leading-6 text-zinc-400">Extract credentials with a UNION-based stock query.</p>
        </a>

        <a href="{{ route('labs.sql-injection-oracle-version.instructions') }}" class="rounded-xl border border-amber-400/30 bg-amber-400/10 p-6 transition hover:bg-amber-400/15">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-300">Посібник 4</p>
            <h2 class="mt-2 text-2xl font-semibold">Oracle version</h2>
            <p class="mt-3 text-sm leading-6 text-zinc-400">Display the database version using UNION SELECT.</p>
        </a>

        <a href="{{ route('labs.sql-injection-version.instructions') }}" class="rounded-xl border border-amber-400/30 bg-amber-400/10 p-6 transition hover:bg-amber-400/15">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-300">Посібник 5</p>
            <h2 class="mt-2 text-2xl font-semibold">Database version</h2>
            <p class="mt-3 text-sm leading-6 text-zinc-400">Отримайте рядок версії бази даних через фільтр категорії.</p>
        </a>

        <a href="{{ route('labs.sql-injection-user-table.instructions') }}" class="rounded-xl border border-amber-400/30 bg-amber-400/10 p-6 transition hover:bg-amber-400/15">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-300">Посібник 6</p>
            <h2 class="mt-2 text-2xl font-semibold">User table union</h2>
            <p class="mt-3 text-sm leading-6 text-zinc-400">Pull user records and sign in as the admin account.</p>
        </a>

        <a href="{{ route('labs.sql-injection-column-count.instructions') }}" class="rounded-xl border border-amber-400/30 bg-amber-400/10 p-6 transition hover:bg-amber-400/15">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-300">Посібник 7</p>
            <h2 class="mt-2 text-2xl font-semibold">Determine column count</h2>
            <p class="mt-3 text-sm leading-6 text-zinc-400">Визначте кількість колонок, додаючи NULL у UNION.</p>
        </a>

        <a href="{{ route('labs.sql-injection-column-text.instructions') }}" class="rounded-xl border border-amber-400/30 bg-amber-400/10 p-6 transition hover:bg-amber-400/15">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-300">Посібник 8</p>
            <h2 class="mt-2 text-2xl font-semibold">Find text column</h2>
            <p class="mt-3 text-sm leading-6 text-zinc-400">Знайдіть текстову колонку і поверніть маркер сесії.</p>
        </a>

        <a href="{{ route('labs.sql-injection-table-data.instructions') }}" class="rounded-xl border border-amber-400/30 bg-amber-400/10 p-6 transition hover:bg-amber-400/15">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-300">Посібник 9</p>
            <h2 class="mt-2 text-2xl font-semibold">Retrieve data from other tables</h2>
            <p class="mt-3 text-sm leading-6 text-zinc-400">Отримайте username і password з таблиці users.</p>
        </a>

        <a href="{{ route('labs.sql-injection-multiple-values.instructions') }}" class="rounded-xl border border-amber-400/30 bg-amber-400/10 p-6 transition hover:bg-amber-400/15">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-300">Посібник 10</p>
            <h2 class="mt-2 text-2xl font-semibold">Single-column data</h2>
            <p class="mt-3 text-sm leading-6 text-zinc-400">Об’єднайте кілька значень в одному текстовому стовпці за допомогою конкатенації.</p>
        </a>
    </div>
</x-labs.layout>
