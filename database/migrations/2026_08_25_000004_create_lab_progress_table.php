<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('lab_key');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamp('solved_at')->nullable();
            $table->unsignedInteger('solve_count')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'lab_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_progress');
    }
};
