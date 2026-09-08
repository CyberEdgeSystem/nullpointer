<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ColumnCountLabController extends Controller
{
    public function __invoke(Request $request): View
    {
        $this->recordLabVisit($request, 'column_count');

        $category = $request->string('category')->toString();
        $categories = DB::table('products')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $sql = 'SELECT name, description FROM products WHERE released = 1';

        if ($category !== '') {
            /*
             * INTENTIONALLY VULNERABLE: category is concatenated directly into the SQL
             * so the lab can demonstrate the classic UNION null-column enumeration.
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

        $solved = $rows->contains(fn (object $row): bool => $row->name === null && $row->description === null);

        if ($solved) {
            $this->recordLabSolved($request, 'column_count');
        }

        $progress = $this->labProgress($request, 'column_count');
        $flag = $solved ? $this->labFlag($request, 'column_count') : null;

        return view('labs.sql-injection-column-count', compact(
            'categories',
            'category',
            'flag',
            'progress',
            'queryError',
            'rows',
            'solved',
        ));
    }
}
