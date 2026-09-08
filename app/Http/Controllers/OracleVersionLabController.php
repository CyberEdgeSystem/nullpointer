<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OracleVersionLabController extends Controller
{
    public function __invoke(Request $request): View
    {
        $this->recordLabVisit($request, 'oracle_version');

        $category = $request->string('category')->toString();
        $categories = DB::table('oracle_lab_products')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $sql = 'SELECT name, description FROM oracle_lab_products WHERE released = 1';

        if ($category !== '') {
            /*
             * INTENTIONALLY VULNERABLE: category is concatenated so this Oracle-style
             * training lab can demonstrate UNION-based version enumeration.
             */
            $sql = "SELECT name, description FROM oracle_lab_products WHERE category = '{$category}' AND released = 1";
        }

        try {
            $rows = collect(DB::select($sql));
            $queryError = null;
        } catch (QueryException) {
            $rows = collect();
            $queryError = 'Фільтр категорій сформував некоректний SQL-запит.';
        }

        $versionString = 'Oracle Database 19c Enterprise Edition Release 19.0.0.0.0 - Production';
        $solved = $rows->contains(fn (object $row): bool => str_contains((string) $row->name, $versionString)
            || str_contains((string) $row->description, $versionString));

        if ($solved) {
            $this->recordLabSolved($request, 'oracle_version');
        }

        return view('labs.sql-injection-oracle-version', [
            'categories' => $categories,
            'category' => $category,
            'flag' => $solved ? $this->labFlag($request, 'oracle_version') : null,
            'progress' => $this->labProgress($request, 'oracle_version'),
            'queryError' => $queryError,
            'rows' => $rows,
            'solved' => $solved,
            'versionString' => $versionString,
        ]);
    }
}
