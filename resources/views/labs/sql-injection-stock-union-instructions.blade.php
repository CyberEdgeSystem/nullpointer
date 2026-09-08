<x-labs.layout title="Stock check guide" active="stock-union">
    <section class="max-w-3xl">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Лаба 3</p>
        <h1 class="mt-3 text-4xl font-semibold tracking-tight">UNION — перевірка залишків</h1>
        <p class="mt-4 text-base leading-7 text-zinc-400">
            Мета: використати UNION для отримання облікових даних з таблиці users та входу як адміністратор.
        </p>
    </section>
    <div class="mt-10 rounded-xl border border-white/10 bg-zinc-900 p-6">
        <div class="mb-4 text-sm text-zinc-300">
            Приклад корисного навантаження (payload):
            <pre class="mt-2 rounded bg-zinc-950 p-3 text-sm font-mono">1 UNION SELECT username, lab_password FROM users -- </pre>
        </div>
        <ol class="space-y-4 text-sm leading-6 text-zinc-300">
            <li><span class="font-semibold text-white">1. Відкрийте форму перевірки залишків.</span> Виберіть продукт зі списку.</li>
            <li><span class="font-semibold text-white">2. Інжектуйте payload з UNION.</span> Підберіть кількість колонок та текстову колонку.</li>
            <li><span class="font-semibold text-white">3. Отримайте значення username і password.</span> Використайте їх для входу як адміністратор.</li>
        </ol>
    </div>
</x-labs.layout>
