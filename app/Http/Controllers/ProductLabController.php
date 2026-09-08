<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductLabController extends Controller
{
    public function __invoke(Request $request): View
    {
        $this->recordLabVisit($request, 'product_filter');

        $category = $request->string('category')->toString();
        $categories = DB::table('products')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $sql = 'SELECT * FROM products WHERE released = 1';

        if ($category !== '') {
            /*
             * INTENTIONALLY VULNERABLE: this string concatenation exists only for the
             * SQL injection training lab. Never copy it into production code.
             */
            $sql = "SELECT * FROM products WHERE category = '{$category}' AND released = 1";
        }

        try {
            $products = collect(DB::select($sql));
            $queryError = null;
        } catch (QueryException) {
            $products = collect();
            $queryError = 'Фільтр товарів сформував некоректний SQL-запит.';
        }

        $solved = $products->contains(fn (object $product): bool => ! (bool) $product->released);

        if ($solved) {
            $this->recordLabSolved($request, 'product_filter');
        }

        $progress = $this->labProgress($request, 'product_filter');
        $flag = $solved ? $this->labFlag($request, 'product_filter') : null;

        return view('labs.sql-injection', compact(
            'categories',
            'category',
            'flag',
            'products',
            'progress',
            'queryError',
            'solved',
        ));
    }
}
