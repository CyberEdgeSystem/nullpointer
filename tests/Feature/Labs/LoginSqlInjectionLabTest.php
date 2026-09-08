<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    DB::table('lab_users')->insert([
        [
            'username' => 'administrator',
            'password' => 'unknown-secret',
            'display_name' => 'Administrator',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'username' => 'wiener',
            'password' => 'peter',
            'display_name' => 'Wiener',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
});

test('invalid credentials do not authenticate a user', function () {
    $this->post(route('labs.sql-injection-login.attempt'), [
        'username' => 'administrator',
        'password' => 'wrong-password',
    ])
        ->assertRedirect()
        ->assertSessionHasErrors('login')
        ->assertSessionMissing('login_lab');
});

test('valid non administrator credentials do not solve the lab', function () {
    $this->post(route('labs.sql-injection-login.attempt'), [
        'username' => 'wiener',
        'password' => 'peter',
    ])->assertRedirect(route('labs.sql-injection-login'));

    $this->get(route('labs.sql-injection-login'))
        ->assertOk()
        ->assertSee('Вхід виконано як wiener')
        ->assertDontSee('data-test="lab-solved"', false)
        ->assertDontSee('data-test="ctf-flag"', false);
});

test('a SQL injection logs in as administrator, solves the lab, and shows the current port flag', function () {
    $this->post(route('labs.sql-injection-login.attempt'), [
        'username' => "administrator' -- ",
        'password' => 'anything',
    ])->assertRedirect(route('labs.sql-injection-login'));

    $this->get(route('labs.sql-injection-login'))
        ->assertOk()
        ->assertSee('Ти увійшов як')
        ->assertSee('<strong>administrator</strong>', false)
        ->assertSee('data-test="lab-solved"', false)
        ->assertSee('data-test="ctf-flag"', false)
        ->assertSee('flag{8000_login_admin_bypass}');
});

test('the login bypass flag changes when the lab is served from another configured port', function () {
    $this
        ->withSession([
            'login_lab' => [
                'username' => 'administrator',
                'solved' => true,
            ],
        ])
        ->get('http://nullpointer.test:9001/labs/sql-injection-login')
        ->assertOk()
        ->assertSee('flag{9001_login_admin_bypass}')
        ->assertDontSee('flag{8000_login_admin_bypass}');
});

test('a malformed injection does not expose the database error', function () {
    $this->post(route('labs.sql-injection-login.attempt'), [
        'username' => "administrator'",
        'password' => 'anything',
    ])
        ->assertRedirect()
        ->assertSessionHasErrors('login')
        ->assertSessionMissing('login_lab');
});
