<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabUserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('lab_users')->upsert([
            [
                'username' => 'administrator',
                'password' => 'cobalt-vault-7319',
                'display_name' => 'Administrator',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'wiener',
                'password' => 'peter',
                'display_name' => 'Wiener',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['username'], ['password', 'display_name', 'updated_at']);
    }
}
