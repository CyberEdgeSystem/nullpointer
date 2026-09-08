<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasIndex('oracle_lab_products', 'oracle_lab_products_name_unique')) {
            return;
        }

        Schema::table('oracle_lab_products', function (Blueprint $table): void {
            $table->unique('name', 'oracle_lab_products_name_unique');
        });
    }

    public function down(): void
    {
        Schema::table('oracle_lab_products', function (Blueprint $table): void {
            $table->dropUnique('oracle_lab_products_name_unique');
        });
    }
};
