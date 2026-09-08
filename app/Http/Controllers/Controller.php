<?php

namespace App\Http\Controllers;

use App\Models\LabProgress;
use Illuminate\Http\Request;

abstract class Controller
{
    protected function labs(): array
    {
        return [
            'product_filter' => [
                'title' => 'Лаба 1: Фільтр товарів',
                'route' => 'labs.sql-injection',
                'instructions_route' => 'labs.sql-injection.instructions',
            ],
            'login_bypass' => [
                'title' => 'Лаба 2: Обхід входу',
                'route' => 'labs.sql-injection-login',
                'instructions_route' => 'labs.sql-injection-login.instructions',
            ],
            'stock_union' => [
                'title' => 'Лаба 3: UNION stock check',
                'route' => 'labs.sql-injection-stock-union',
                'instructions_route' => 'labs.sql-injection-stock-union.instructions',
            ],
            'oracle_version' => [
                'title' => 'Лаба 4: Oracle version',
                'route' => 'labs.sql-injection-oracle-version',
                'instructions_route' => 'labs.sql-injection-oracle-version.instructions',
            ],
            'database_version' => [
                'title' => 'Лаба 5: Database version',
                'route' => 'labs.sql-injection-version',
                'instructions_route' => 'labs.sql-injection-version.instructions',
            ],
            'user_table_union' => [
                'title' => 'Лаба 6: User table union',
                'route' => 'labs.sql-injection-user-table',
                'instructions_route' => 'labs.sql-injection-user-table.instructions',
            ],
            'column_count' => [
                'title' => 'Лаба 7: Determine column count',
                'route' => 'labs.sql-injection-column-count',
                'instructions_route' => 'labs.sql-injection-column-count.instructions',
            ],
            'column_text' => [
                'title' => 'Лаба 8: Find column with text',
                'route' => 'labs.sql-injection-column-text',
                'instructions_route' => 'labs.sql-injection-column-text.instructions',
            ],
            'table_data' => [
                'title' => 'Лаба 9: Retrieve data from other tables',
                'route' => 'labs.sql-injection-table-data',
                'instructions_route' => 'labs.sql-injection-table-data.instructions',
            ],
            'multiple_values_single_column' => [
                'title' => 'Лаба 10: Retrieve multiple values in a single column',
                'route' => 'labs.sql-injection-multiple-values',
                'instructions_route' => 'labs.sql-injection-multiple-values.instructions',
            ],
            'blind_conditional' => [
                'title' => 'Лаба 11: Blind SQL — умовні відповіді',
                'route' => 'labs.sql-injection-blind-conditional',
                'instructions_route' => 'labs.sql-injection-blind-conditional.instructions',
            ],
        ];
    }

    protected function labFlag(Request $request, string $lab): ?string
    {
        $port = (string) $request->getPort();
        $groups = config('labs.flag_groups', []);
        $defaultGroup = config('labs.default_flag_group', 'default');
        $flags = $groups[$port] ?? $groups[$defaultGroup] ?? [];

        return $flags[$lab] ?? null;
    }

    protected function recordLabVisit(Request $request, string $lab): ?LabProgress
    {
        $user = $request->user();

        if ($user === null) {
            return null;
        }

        $progress = LabProgress::query()->firstOrCreate(
            [
                'user_id' => $user->id,
                'lab_key' => $lab,
            ],
            [
                'started_at' => now(),
            ],
        );

        if ($progress->started_at === null) {
            $progress->started_at = now();
        }

        $progress->last_seen_at = now();
        $progress->save();

        return $progress->fresh();
    }

    protected function recordLabSolved(Request $request, string $lab): void
    {
        $user = $request->user();

        if ($user === null) {
            return;
        }

        $progress = LabProgress::query()->firstOrCreate(
            [
                'user_id' => $user->id,
                'lab_key' => $lab,
            ],
            [
                'started_at' => now(),
            ],
        );

        if ($progress->solved_at === null) {
            $progress->solved_at = now();
        }

        $progress->last_seen_at = now();
        $progress->solve_count++;
        $progress->save();
    }

    protected function labProgress(Request $request, string $lab): ?LabProgress
    {
        $user = $request->user();

        if ($user === null) {
            return null;
        }

        return LabProgress::query()
            ->where('user_id', $user->id)
            ->where('lab_key', $lab)
            ->first();
    }

    protected function resetLabProgress(Request $request, string $lab): void
    {
        $user = $request->user();

        if ($user === null) {
            return;
        }

        LabProgress::query()
            ->where('user_id', $user->id)
            ->where('lab_key', $lab)
            ->update([
                'started_at' => null,
                'last_seen_at' => null,
                'solved_at' => null,
                'solve_count' => 0,
            ]);

        $sessionKeyMap = [
            'login_bypass' => 'login_lab',
            'stock_union' => 'stock_union_lab',
            'user_table_union' => 'user_table_union_lab',
            'column_text' => 'column_text_lab',
            'table_data' => 'table_data_lab',
            'multiple_values_single_column' => 'multiple_values_single_column_lab',
            'blind_conditional' => 'blind_conditional_lab',
        ];

        if (isset($sessionKeyMap[$lab])) {
            $request->session()->forget($sessionKeyMap[$lab]);
        }
    }

    protected function formatDuration(?int $seconds): string
    {
        if ($seconds === null) {
            return 'ще не почато';
        }

        $minutes = intdiv($seconds, 60);
        $remainingSeconds = $seconds % 60;

        return sprintf('%02d:%02d', $minutes, $remainingSeconds);
    }
}
