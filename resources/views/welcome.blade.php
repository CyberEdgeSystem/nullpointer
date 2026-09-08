<x-labs.layout title="Лабораторні SQL injection" active="home">
    <section class="max-w-3xl">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Навчальний стенд</p>
        <h1 class="mt-3 text-4xl font-semibold tracking-tight">Лабораторні роботи з SQL injection</h1>
        <p class="mt-4 text-base leading-7 text-zinc-400">
            Це локальний проєкт для відпрацювання базових сценаріїв SQL-ін'єкцій. Для кожної лабораторної є окрема сторінка завдання й окрема сторінка інструкції.
        </p>
    </section>

    <div class="mt-10 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
        <a href="{{ route('labs.sql-injection') }}" class="rounded-xl border border-white/10 bg-zinc-900 p-6 transition hover:bg-white/5">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-400">Лаба 1</p>
            <h2 class="mt-2 text-2xl font-semibold">Фільтр товарів</h2>
            <p class="mt-3 text-sm leading-6 text-zinc-400">Вразливість SQL injection у параметрі категорії.</p>
        </a>

        <a href="{{ route('labs.sql-injection-login') }}" class="rounded-xl border border-white/10 bg-zinc-900 p-6 transition hover:bg-white/5">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-400">Лаба 2</p>
            <h2 class="mt-2 text-2xl font-semibold">Обхід входу</h2>
            <p class="mt-3 text-sm leading-6 text-zinc-400">Вразливість SQL injection у формі входу.</p>
        </a>

        <a href="{{ route('labs.sql-injection-stock-union') }}" class="rounded-xl border border-white/10 bg-zinc-900 p-6 transition hover:bg-white/5">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-400">Лаба 3</p>
            <h2 class="mt-2 text-2xl font-semibold">UNION stock check</h2>
            <p class="mt-3 text-sm leading-6 text-zinc-400">Вразливість UNION SQL injection у перевірці залишків.</p>
        </a>

        <a href="{{ route('labs.sql-injection-oracle-version') }}" class="rounded-xl border border-white/10 bg-zinc-900 p-6 transition hover:bg-white/5">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-400">Лаба 4</p>
            <h2 class="mt-2 text-2xl font-semibold">Oracle version</h2>
            <p class="mt-3 text-sm leading-6 text-zinc-400">UNION атака для отримання рядка версії бази даних.</p>
        </a>
    </div>
</x-labs.layout>
