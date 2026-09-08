@props([
    'progress',
])

@php
    $elapsed = $progress?->elapsedSeconds();
    $minutes = $elapsed === null ? null : intdiv($elapsed, 60);
    $seconds = $elapsed === null ? null : $elapsed % 60;
@endphp

@auth
    <div data-test="lab-progress" class="mb-8 rounded-xl border border-white/10 bg-zinc-900 p-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-400">Мій прогрес</p>
                <p class="mt-2 text-sm text-zinc-400">
                    @if ($progress?->solved_at)
                        Виконано {{ $progress->solved_at->format('d.m.Y H:i') }}
                    @elseif ($progress?->started_at)
                        Лабу розпочато {{ $progress->started_at->format('d.m.Y H:i') }}
                    @else
                        Прогрес ще не зафіксовано.
                    @endif
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3 text-sm sm:min-w-64">
                <div class="rounded-xl border border-white/10 bg-white/5 px-4 py-3">
                    <p class="text-zinc-500">Статус</p>
                    <p class="mt-1 font-semibold {{ $progress?->solved_at ? 'text-emerald-300' : 'text-amber-300' }}">
                        {{ $progress?->solved_at ? 'Solved' : 'In progress' }}
                    </p>
                </div>
                <div class="rounded-xl border border-white/10 bg-white/5 px-4 py-3">
                    <p class="text-zinc-500">Таймер</p>
                    <p class="mt-1 font-mono font-semibold text-white">
                        {{ $elapsed === null ? '00:00' : sprintf('%02d:%02d', $minutes, $seconds) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endauth
