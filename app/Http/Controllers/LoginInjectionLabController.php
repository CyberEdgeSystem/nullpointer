<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LoginInjectionLabController extends Controller
{
    public function show(Request $request): View
    {
        $this->recordLabVisit($request, 'login_bypass');

        $solved = $request->session()->get('login_lab.solved', false);
        $progress = $this->labProgress($request, 'login_bypass');

        return view('labs.sql-injection-login', [
            'flag' => $solved ? $this->labFlag($request, 'login_bypass') : null,
            'progress' => $progress,
            'username' => $request->session()->get('login_lab.username'),
            'solved' => $solved,
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $username = $request->string('username')->toString();
        $password = $request->string('password')->toString();

        /*
         * INTENTIONALLY VULNERABLE: raw credentials are concatenated for this
         * training lab. Production authentication must use bound parameters
         * and Laravel's password hashing/authentication services.
         */
        $sql = "SELECT * FROM lab_users WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";

        try {
            $user = DB::selectOne($sql);
        } catch (QueryException) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['login' => 'Запит входу сформував некоректний SQL-запит.']);
        }

        if ($user === null) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['login' => 'Неправильне ім\'я користувача або пароль.']);
        }

        $solved = $user->username === 'administrator';

        if ($solved) {
            $this->recordLabSolved($request, 'login_bypass');
        }

        $request->session()->put('login_lab', [
            'username' => $user->username,
            'solved' => $solved,
        ]);

        return redirect()->route('labs.sql-injection-login');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('login_lab');

        return redirect()->route('labs.sql-injection-login');
    }
}
