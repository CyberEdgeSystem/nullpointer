<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Product::query()->create([
        'name' => 'Released Gift',
        'description' => 'Visible catalogue product.',
        'category' => 'Gifts',
        'price' => 10,
        'released' => true,
    ]);

    Product::query()->create([
        'name' => 'Unreleased Gift',
        'description' => 'This product must normally remain hidden.',
        'category' => 'Gifts',
        'price' => 20,
        'released' => false,
    ]);
});

test('the regular category filter only displays released products', function () {
    $this->get(route('labs.sql-injection', ['category' => 'Gifts']))
        ->assertOk()
        ->assertSee('Released Gift')
        ->assertDontSee('Unreleased Gift')
        ->assertDontSee('data-test="lab-solved"', false)
        ->assertDontSee('data-test="ctf-flag"', false);
});

test('a SQL injection can reveal an unreleased product, solve the lab, and show the current port flag', function () {
    $payload = "Gifts' OR 1=1 -- ";

    $this->get(route('labs.sql-injection', ['category' => $payload]))
        ->assertOk()
        ->assertSee('Released Gift')
        ->assertSee('Unreleased Gift')
        ->assertSee('data-test="lab-solved"', false)
        ->assertSee('data-test="ctf-flag"', false)
        ->assertSee('flag{8000_product_filter_unreleased}')
        ->assertSee('data-released="0"', false);
});

test('the product filter flag changes when the lab is served from another configured port', function () {
    $payload = "Gifts' OR 1=1 -- ";

    $this->get('http://nullpointer.test:9001/labs/sql-injection?category='.urlencode($payload))
        ->assertOk()
        ->assertSee('flag{9001_product_filter_unreleased}')
        ->assertDontSee('flag{8000_product_filter_unreleased}');
});

test('an invalid injection is handled without exposing a database error', function () {
    $this->get(route('labs.sql-injection', ['category' => "Gifts'"]))
        ->assertOk()
        ->assertSee('Фільтр товарів сформував некоректний SQL-запит.')
        ->assertDontSee('SQLSTATE');
});
