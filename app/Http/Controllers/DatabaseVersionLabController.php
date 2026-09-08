<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DatabaseVersionLabController extends Controller
{
    public function __invoke(Request $request): View
    {
        $this->recordLabVisit($request, 'database_version');

        $category = $request->string('category')->toString();
        $categories = DB::table('products')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $sql = 'SELECT name, description FROM products WHERE released = 1';

        if ($category !== '') {
            $category = $this->normalizeUnionPayload($category);

            /*
             * INTENTIONALLY VULNERABLE: the category parameter is concatenated to the
             * SQL string so users can practice UNION-based version enumeration.
             */
            $sql = "SELECT name, description FROM products WHERE category = '{$category}' AND released = 1";
        }

        try {
            $rows = collect(DB::select($sql));
            $queryError = null;
        } catch (QueryException) {
            $rows = collect();
            $queryError = 'Фільтр категорій сформував некоректний SQL-запит.';
        }

        $versionString = (string) (DB::selectOne('SELECT sqlite_version() AS version')?->version ?? '');
        $solved = $rows->contains(fn (object $row): bool => str_contains((string) $row->name, $versionString)
            || str_contains((string) $row->description, $versionString));

        if ($solved) {
            $this->recordLabSolved($request, 'database_version');
        }

        return view('labs.sql-injection-version', [
            'categories' => $categories,
            'category' => $request->string('category')->toString(),
            'flag' => $solved ? $this->labFlag($request, 'database_version') : null,
            'progress' => $this->labProgress($request, 'database_version'),
            'queryError' => $queryError,
            'rows' => $rows,
            'solved' => $solved,
            'versionString' => $versionString,
        ]);
    }

    protected function normalizeUnionPayload(string $value): string
    {
        $value = str_replace('#', '--', $value);

        return str_ireplace('@@version', 'sqlite_version()', $value);
    }
}
