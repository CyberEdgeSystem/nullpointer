<?php

test('the instructions hub links to each lab instruction page', function () {
    $this->get(route('labs.instructions'))
        ->assertOk()
        ->assertSee(route('labs.sql-injection.instructions'))
        ->assertSee(route('labs.sql-injection-login.instructions'))
        ->assertSee(route('labs.sql-injection-stock-union.instructions'))
        ->assertSee(route('labs.sql-injection-oracle-version.instructions'));
});

test('the product filter instructions page explains the first SQL injection lab', function () {
    $this->get(route('labs.sql-injection.instructions'))
        ->assertOk()
        ->assertSee(route('labs.sql-injection'));
});

test('the login instructions page explains the second SQL injection lab', function () {
    $this->get(route('labs.sql-injection-login.instructions'))
        ->assertOk()
        ->assertSee("administrator' -- ", false)
        ->assertSee(route('labs.sql-injection-login'));
});

test('the stock UNION instructions page explains the third SQL injection lab', function () {
    $this->get(route('labs.sql-injection-stock-union.instructions'))
        ->assertOk()
        ->assertSee('1 UNION SELECT username, lab_password FROM users -- ');
});

test('the Oracle version instructions page explains the fourth SQL injection lab', function () {
    $this->get(route('labs.sql-injection-oracle-version.instructions'))
        ->assertOk()
        ->assertSee('Gifts\' UNION SELECT banner, NULL FROM v$version --', false);
});
