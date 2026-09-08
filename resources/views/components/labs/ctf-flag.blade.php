@props([
    'flag',
])

<div {{ $attributes->merge(['class' => 'mb-8 rounded-xl border border-amber-400/30 bg-amber-400/10 p-5 text-amber-100']) }} data-test="ctf-flag">
    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-300">CTF flag</p>
    <code class="mt-3 block overflow-x-auto rounded-lg border border-white/10 bg-zinc-950 px-3 py-2 text-amber-300">{{ $flag }}</code>
</div>
