<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StockRecordSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        User::query()->updateOrCreate(
            ['email' => 'administrator@example.test'],
            [
                'name' => 'Administrator',
                'username' => 'administrator',
                'password' => Hash::make('not-used-by-this-lab'),
                'lab_password' => 'stock-bridge-7412',
                'updated_at' => $now,
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'carlos@example.test'],
            [
                'name' => 'Carlos Montoya',
                'username' => 'carlos',
                'password' => Hash::make('not-used-by-this-lab'),
                'lab_password' => 'montoya-pass',
                'updated_at' => $now,
            ],
        );

        $products = Product::query()->orderBy('id')->get();

        foreach ($products as $product) {
            DB::table('stock_records')->updateOrInsert(
                [
                    'product_id' => $product->id,
                    'warehouse' => 'north',
                ],
                [
                    'quantity' => $product->released ? 18 : 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );

            DB::table('stock_records')->updateOrInsert(
                [
                    'product_id' => $product->id,
                    'warehouse' => 'south',
                ],
                [
                    'quantity' => $product->released ? 7 : 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );
        }
    }
};
