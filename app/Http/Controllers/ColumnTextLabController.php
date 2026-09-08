<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ColumnTextLabController extends Controller
{
    public function __invoke(Request $request): View
    {
        $this->recordLabVisit($request, 'column_text');

        $targetValue = $request->session()->get('column_text_lab.random_value');
        if ($targetValue === null) {
            $targetValue = 'MARK_' . Str::random(8);
            $request->session()->put('column_text_lab.random_value', $targetValue);
        }

        $category = $request->string('category')->toString();
        $categories = DB::table('products')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $sql = 'SELECT name, description FROM products WHERE released = 1';

        if ($category !== '') {
            $sql = "SELECT name, description FROM products WHERE category = '{$category}' AND released = 1";
        }

        try {
            $rows = collect(DB::select($sql));
            $queryError = null;
        } catch (QueryException) {
            $rows = collect();
            $queryError = 'Фільтр категорій сформував некоректний SQL-запит.';
        }

        $solved = $rows->contains(function ($row) use ($targetValue): bool {
            $values = [
                $row->name ?? '',
                $row->description ?? '',
            ];

            foreach ($values as $value) {
                if (is_string($value) && stripos($value, $targetValue) !== false) {
                    return true;
                }
            }

            return false;
        });

        if ($solved) {
            $this->recordLabSolved($request, 'column_text');
        }

        $progress = $this->labProgress($request, 'column_text');
        $flag = $solved ? $this->labFlag($request, 'column_text') : null;

        return view('labs.sql-injection-column-text', compact(
            'categories',
            'category',
            'flag',
            'progress',
            'queryError',
            'rows',
            'solved',
            'targetValue',
        ));
    }
}
