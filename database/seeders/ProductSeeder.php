<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Дерев\'яна головоломка з кедра',
                'description' => 'Тактильна дерев\'яна головоломка для спокійного недільного дня.',
                'category' => 'Подарунки',
                'price' => 24.90,
                'released' => true,
            ],
            [
                'name' => 'Лампа Північне сяйво',
                'description' => 'Невипущена атмосферна лампа із зимової колекції.',
                'category' => 'Подарунки',
                'price' => 79.00,
                'released' => false,
            ],
            [
                'name' => 'Пляшка Trailblazer',
                'description' => 'Термопляшка з нержавної сталі для довгих походів.',
                'category' => 'Туризм',
                'price' => 32.50,
                'released' => true,
            ],
            [
                'name' => 'Сонячний зарядний пристрій Summit',
                'description' => 'Компактний прототип зарядного пристрою, який ще не доступний у продажу.',
                'category' => 'Туризм',
                'price' => 109.00,
                'released' => false,
            ],
            [
                'name' => 'Керамічний набір для pour-over',
                'description' => 'Мінімалістичний набір для заварювання від локальних керамістів.',
                'category' => 'Дім',
                'price' => 44.00,
                'released' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::query()->updateOrCreate(
                ['name' => $product['name']],
                $product,
            );
        }
    }
}
