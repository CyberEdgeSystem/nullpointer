<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserTableUnionLabController extends Controller
{
    public function show(Request $request): View
    {
        $this->recordLabVisit($request, 'user_table_union');
        $this->prepareUserTableUnionMetadata();

        $category = $request->string('category')->toString();
        $categories = DB::table('products')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $sql = 'SELECT name, description FROM products WHERE released = 1';

        if ($category !== '') {
            /*
             * INTENTIONALLY VULNERABLE: category is concatenated directly into the SQL
             * so the lab can demonstrate a PortSwigger-style UNION enumeration flow.
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

        $solved = $request->session()->get('user_table_union_lab.solved', false);
        $progress = $this->labProgress($request, 'user_table_union');

        return view('labs.sql-injection-user-table', [
            'categories' => $categories,
            'category' => $category,
            'flag' => $solved ? $this->labFlag($request, 'user_table_union') : null,
            'progress' => $progress,
            'queryError' => $queryError,
            'rows' => $rows,
            'solved' => $solved,
            'username' => $request->session()->get('user_table_union_lab.username'),
            'userRows' => $request->session()->get('user_table_union_lab.user_rows', []),
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $username = $request->string('username')->toString();
        $password = $request->string('password')->toString();

        $user = DB::table('users_abcdef')
            ->where('username_abcdef', $username)
            ->where('password_abcdef', $password)
            ->first();

        if ($user === null) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['login' => 'Неправильне ім\'я користувача або пароль.']);
        }

        $solved = $user->username_abcdef === 'administrator';

        if ($solved) {
            $this->recordLabSolved($request, 'user_table_union');
        }

        $request->session()->put('user_table_union_lab', [
            'username' => $user->username_abcdef,
            'solved' => $solved,
            'user_rows' => $request->session()->get('user_table_union_lab.user_rows', []),
        ]);

        return redirect()->route('labs.sql-injection-user-table');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('user_table_union_lab');

        return redirect()->route('labs.sql-injection-user-table');
    }

    protected function prepareUserTableUnionMetadata(): void
    {
        try {
            DB::statement('ATTACH DATABASE ":memory:" AS information_schema');
            DB::statement('CREATE TABLE IF NOT EXISTS information_schema.tables (table_name TEXT NOT NULL)');
            DB::statement('CREATE TABLE IF NOT EXISTS information_schema.columns (table_name TEXT NOT NULL, column_name TEXT NOT NULL)');
        } catch (\Throwable) {
            // SQLite may already have this schema attached for the current connection.
        }

        $tableRows = DB::table('information_schema.tables')->where('table_name', 'users_abcdef')->count();
        if ($tableRows === 0) {
            DB::table('information_schema.tables')->insert([
                ['table_name' => 'users_abcdef'],
                ['table_name' => 'products'],
            ]);
        }

        $columnRows = DB::table('information_schema.columns')
            ->where('table_name', 'users_abcdef')
            ->where('column_name', 'username_abcdef')
            ->count();

        if ($columnRows === 0) {
            DB::table('information_schema.columns')->insert([
                ['table_name' => 'users_abcdef', 'column_name' => 'username_abcdef'],
                ['table_name' => 'users_abcdef', 'column_name' => 'password_abcdef'],
            ]);
        }

        DB::statement('CREATE TABLE IF NOT EXISTS users_abcdef (username_abcdef TEXT, password_abcdef TEXT)');

        $existingUsers = DB::table('users_abcdef')->count();
        if ($existingUsers === 0) {
            DB::table('users_abcdef')->insert([
                ['username_abcdef' => 'administrator', 'password_abcdef' => 'union-table-6321'],
                ['username_abcdef' => 'wiener', 'password_abcdef' => 'peter'],
            ]);
        }
    }
}
