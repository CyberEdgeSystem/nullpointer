<?php

namespace App\Http\Controllers;

use App\Models\LabProgress;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $progress = LabProgress::query()
            ->where('user_id', $request->user()->id)
            ->get()
            ->keyBy('lab_key');

        $labs = collect($this->labs())
            ->map(function (array $lab, string $key) use ($progress): array {
                $labProgress = $progress->get($key);

                return [
                    ...$lab,
                    'key' => $key,
                    'progress' => $labProgress,
                    'elapsed' => $this->formatDuration($labProgress?->elapsedSeconds()),
                    'solved' => $labProgress?->solved_at !== null,
                ];
            })
            ->values();

        return view('dashboard', [
            'labs' => $labs,
            'solvedCount' => $labs->where('solved', true)->count(),
        ]);
    }

    public function resetLab(Request $request, string $labKey): \Illuminate\Http\RedirectResponse
    {
        abort_unless(in_array($labKey, array_keys($this->labs()), true), 404);

        $this->resetLabProgress($request, $labKey);

        return redirect()->route('dashboard');
    }
}
