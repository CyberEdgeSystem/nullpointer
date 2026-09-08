<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oracle_lab_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('category');
            $table->boolean('released')->default(true);
            $table->timestamps();
        });

        DB::statement('CREATE TABLE "v$version" (banner TEXT NOT NULL)');
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS "v$version"');
        Schema::dropIfExists('oracle_lab_products');
    }
};
