<x-labs.layout title="Blind SQL conditional guide" active="blind-conditional">
    <section class="max-w-3xl">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">Лаба 11</p>
        <h1 class="mt-3 text-4xl font-semibold tracking-tight">Blind SQL — умовні відповіді</h1>
        <p class="mt-4 text-base leading-7 text-zinc-400">
            Це завдання містить вразливість типу blind SQL injection. Застосунок використовує cookie для аналітики і підставляє його значення у SQL-запит. Результати запиту не повертаються напряму, але сторінка показує повідомлення «Welcome back», якщо запит повернув рядки.
        </p>
    </section>

    <div class="mt-10 rounded-xl border border-white/10 bg-zinc-900 p-6">
        <ol class="space-y-4 text-sm leading-6 text-zinc-300">
            <li><span class="font-semibold text-white">1.</span> Відкрийте лабу і встановіть значення cookie `tracking` у поле на сторінці або змініть cookie в інструменті проксі/браузера.</li>
            <li><span class="font-semibold text-white">2.</span> Сформулюйте умовний payload, що поверне рядок лише якщо певна умова істинна. Наприклад, перевіряйте першу букву паролю адміністратора за допомогою SQLite-функції <code class="text-amber-300">substr(password,1,1) = 'a'</code> всередині підзапиту.</li>
            <li><span class="font-semibold text-white">3.</span> По символу за символом виведіть пароль адміністратора. Коли сторінка показує «Welcome back», значить перевірка істинна для поточного символу.</li>
            <li><span class="font-semibold text-white">4.</span> Після виявлення повного пароля використайте форму для входу на сторінці, щоб залогінитись як <code class="text-amber-300">administrator</code>.</li>
        </ol>

        <p class="mt-6 text-sm text-zinc-400">Порада: для SQLite умовний payload може виглядати як: <code class="text-amber-300">' OR (SELECT CASE WHEN (substr(password,1,1) = 'a') THEN 1 ELSE 0 END) = 1 -- </code></p>
    </div>
</x-labs.layout>
