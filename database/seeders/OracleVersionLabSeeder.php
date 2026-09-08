<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OracleVersionLabSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('oracle_lab_products')->upsert([
            [
                'name' => 'Oracle Gift Card',
                'description' => 'Released gift product used by the Oracle UNION lab.',
                'category' => 'Gifts',
                'released' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Database Desk Lamp',
                'description' => 'Released home product used by the Oracle UNION lab.',
                'category' => 'Home',
                'released' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['name'], ['description', 'category', 'released', 'updated_at']);

        DB::table('v$version')->delete();
        DB::table('v$version')->insert([
            'banner' => 'Oracle Database 19c Enterprise Edition Release 19.0.0.0.0 - Production',
        ]);
    }
};
