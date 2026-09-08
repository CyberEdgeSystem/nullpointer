<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class TableDataLabController extends Controller
{
    public function show(Request $request): View
    {
        $this->recordLabVisit($request, 'table_data');
        $this->prepareUsersTable();

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

        $userRows = $request->session()->get('table_data_lab.user_rows', []);

        if (empty($userRows) && str_contains(strtolower($category), 'from users')) {
            $userRows = DB::table('users')
                ->select('username', 'lab_password as password')
                ->get()
                ->map(fn ($user) => ['username' => $user->username, 'password' => $user->password])
                ->all();

            $request->session()->put('table_data_lab.user_rows', $userRows);
        }

        $username = $request->session()->get('table_data_lab.username');
        $solved = $request->session()->get('table_data_lab.solved', false);

        if ($solved) {
            $this->recordLabSolved($request, 'table_data');
        }

        return view('labs.sql-injection-table-data', [
            'categories' => $categories,
            'category' => $category,
            'flag' => $solved ? $this->labFlag($request, 'table_data') : null,
            'progress' => $this->labProgress($request, 'table_data'),
            'queryError' => $queryError,
            'rows' => $rows,
            'solved' => $solved,
            'userRows' => $userRows,
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
            $this->recordLabSolved($request, 'table_data');
        }

        $request->session()->put('table_data_lab', [
            'username' => $user->username,
            'solved' => $solved,
            'user_rows' => $request->session()->get('table_data_lab.user_rows', []),
        ]);

        return redirect()->route('labs.sql-injection-table-data');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('table_data_lab');

        return redirect()->route('labs.sql-injection-table-data');
    }

    protected function prepareUsersTable(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        if (! Schema::hasColumn('users', 'username') || ! Schema::hasColumn('users', 'lab_password')) {
            return;
        }

        $createdUsers = [
            [
                'username' => 'administrator',
                'name' => 'Administrator',
                'email' => 'administrator.lab@example.test',
                'password' => bcrypt('not-used-for-this-lab'),
                'lab_password' => 'vault-merge-8139',
            ],
            [
                'username' => 'wiener',
                'name' => 'Wiener',
                'email' => 'wiener.lab@example.test',
                'password' => bcrypt('not-used-for-this-lab'),
                'lab_password' => 'peter',
            ],
            [
                'username' => 'carlos',
                'name' => 'Carlos Montoya',
                'email' => 'carlos.lab@example.test',
                'password' => bcrypt('not-used-for-this-lab'),
                'lab_password' => 'montoya-pass',
            ],
        ];

        foreach ($createdUsers as $user) {
            DB::table('users')->updateOrInsert(
                ['username' => $user['username']],
                [
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => $user['password'],
                    'lab_password' => $user['lab_password'],
                ],
            );
        }
    }
}
