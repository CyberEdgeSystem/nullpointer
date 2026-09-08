<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockUnionLabController extends Controller
{
    public function show(Request $request): View
    {
        $this->recordLabVisit($request, 'stock_union');

        $solved = $request->session()->get('stock_union_lab.solved', false);
        $progress = $this->labProgress($request, 'stock_union');

        return view('labs.sql-injection-stock-union', [
            'flag' => $solved ? $this->labFlag($request, 'stock_union') : null,
            'products' => DB::table('products')->where('released', true)->orderBy('name')->get(),
            'progress' => $progress,
            'results' => $request->session()->pull('stock_union_lab.results', []),
            'queryError' => $request->session()->pull('stock_union_lab.query_error'),
            'username' => $request->session()->get('stock_union_lab.username'),
            'solved' => $solved,
        ]);
    }

    public function check(Request $request): RedirectResponse
    {
        $productId = $request->string('product_id')->toString();

        /*
         * INTENTIONALLY VULNERABLE: product_id is concatenated into a stock query
         * so the lab can demonstrate UNION-based SQL injection.
         */
        $sql = "SELECT warehouse, quantity FROM stock_records WHERE product_id = {$productId}";

        try {
            $results = DB::select($sql);

            $request->session()->put('stock_union_lab.results', array_map(
                fn (object $row): array => [
                    'warehouse' => (string) $row->warehouse,
                    'quantity' => (string) $row->quantity,
                ],
                $results,
            ));
        } catch (QueryException) {
            $request->session()->put('stock_union_lab.results', []);
            $request->session()->put('stock_union_lab.query_error', 'Перевірка залишків сформувала некоректний SQL-запит.');
        }

        return redirect()->route('labs.sql-injection-stock-union');
    }

    public function login(Request $request): RedirectResponse
    {
        $username = $request->string('username')->toString();
        $password = $request->string('password')->toString();

        $user = DB::table('users')
            ->where('username', $username)
            ->where('lab_password', $password)
            ->first();

        if ($user === null) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['login' => 'Неправильне ім\'я користувача або пароль.']);
        }

        $solved = $user->username === 'administrator';

        if ($solved) {
            $this->recordLabSolved($request, 'stock_union');
        }

        $request->session()->put('stock_union_lab', [
            'username' => $user->username,
            'solved' => $solved,
        ]);

        return redirect()->route('labs.sql-injection-stock-union');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('stock_union_lab');

        return redirect()->route('labs.sql-injection-stock-union');
    }
}
