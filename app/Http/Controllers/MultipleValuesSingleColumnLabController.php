<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MultipleValuesSingleColumnLabController extends Controller
{
    public function show(Request $request): View
    {
        $this->recordLabVisit($request, 'multiple_values_single_column');

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

        $combinedRows = $request->session()->get('multiple_values_single_column_lab.user_rows', []);

        if (empty($combinedRows) && str_contains(strtolower($category), 'from users')) {
            $combinedRows = DB::table('users')
                ->selectRaw("username || ' ~ ' || lab_password AS combined")
                ->get()
                ->map(fn ($row) => ['combined' => $row->combined])
                ->all();

            $request->session()->put('multiple_values_single_column_lab.user_rows', $combinedRows);
        }

        $username = $request->session()->get('multiple_values_single_column_lab.username');
        $solved = $request->session()->get('multiple_values_single_column_lab.solved', false);

        if ($solved) {
            $this->recordLabSolved($request, 'multiple_values_single_column');
        }

        return view('labs.sql-injection-multiple-values', [
            'categories' => $categories,
            'category' => $category,
            'flag' => $solved ? $this->labFlag($request, 'multiple_values_single_column') : null,
            'progress' => $this->labProgress($request, 'multiple_values_single_column'),
            'queryError' => $queryError,
            'rows' => $rows,
            'solved' => $solved,
            'userRows' => $combinedRows,
            'username' => $username,
        ]);
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
            $this->recordLabSolved($request, 'multiple_values_single_column');
        }

        $request->session()->put('multiple_values_single_column_lab', [
            'username' => $user->username,
            'solved' => $solved,
            'user_rows' => $request->session()->get('multiple_values_single_column_lab.user_rows', []),
        ]);

        return redirect()->route('labs.sql-injection-multiple-values');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('multiple_values_single_column_lab');

        return redirect()->route('labs.sql-injection-multiple-values');
    }
}
