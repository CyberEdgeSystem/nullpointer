@props([
    'message' => null,
])

<div {{ $attributes->merge(['class' => 'rounded-xl border border-emerald-400/30 bg-emerald-400/10 p-5 text-emerald-200']) }} data-test="lab-solved">
    <p class="font-semibold">Вітаємо, лабораторну виконано!</p>
    <p class="mt-1 text-sm text-emerald-300/80">
        @if ($slot->isEmpty())
            {{ $message }}
        @else
            {{ $slot }}
        @endif
    </p>
</div>
