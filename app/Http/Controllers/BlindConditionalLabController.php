<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BlindConditionalLabController extends Controller
{
    public function show(Request $request): View
    {
        $this->recordLabVisit($request, 'blind_conditional');

        $progress = $this->labProgress($request, 'blind_conditional');
        $solved = $request->session()->get('blind_conditional_lab.solved', false);

        $tracking = (string) $request->cookie('tracking', '');

        /*
         * INTENTIONALLY VULNERABLE: the cookie value is concatenated directly into
         * the WHERE clause so learners can inject conditional expressions. The cookie
         * is expected to contain a boolean expression such as "substr(password,1,1) = 'a'".
         * If no tracking value is present, the query defaults to a false condition so
         * the page does not show a welcome message by default.
         */
        $condition = $tracking !== '' ? $tracking : '0=1';
        $sql = "SELECT username FROM users WHERE username = 'administrator' AND ({$condition})";

        try {
            $rows = DB::select($sql);
            $queryError = null;
        } catch (QueryException $e) {
            $rows = [];
            // Expose a friendly message while keeping the app stable.
            $queryError = 'Фільтр трекера сформував некоректний SQL-запит.';
        }

        $welcome = count($rows) > 0;

        return view('labs.sql-injection-blind-conditional', [
            'progress' => $progress,
            'flag' => $solved ? $this->labFlag($request, 'blind_conditional') : null,
            'welcome' => $welcome,
            'tracking' => $tracking,
            'queryError' => $queryError,
            'solved' => $solved,
        ]);
    }

    public function setTracking(Request $request): RedirectResponse
    {
        $tracking = $request->string('tracking')->toString();

        // Set the cookie value submitted by the user
        return redirect()->route('labs.sql-injection-blind-conditional')
            ->cookie('tracking', $tracking, 60);
    }

    public function login(Request $request): RedirectResponse
    {
        $username = $request->string('username')->toString();
        $password = $request->string('password')->toString();

        $user = DB::table('users')
            ->where('username', $username)
            ->where(function ($q) use ($password) {
                $q->where('password', $password)
                  ->orWhere('lab_password', $password);
            })
            ->first();

        if ($user === null) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['login' => 'Неправильне ім\'я користувача або пароль.']);
        }

        $solved = $user->username === 'administrator';

        if ($solved) {
            $this->recordLabSolved($request, 'blind_conditional');
        }

        $request->session()->put('blind_conditional_lab', [
            'username' => $user->username,
            'solved' => $solved,
        ]);

        return redirect()->route('labs.sql-injection-blind-conditional');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('blind_conditional_lab');

        return redirect()->route('labs.sql-injection-blind-conditional');
    }
}
