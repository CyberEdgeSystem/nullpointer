<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_users', function (Blueprint $table): void {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('display_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_users');
    }
};
