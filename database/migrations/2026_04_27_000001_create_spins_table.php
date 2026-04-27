<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('result');
            $table->unsignedSmallInteger('points')->default(0);
            $table->unsignedSmallInteger('random_number');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spins');
    }
};
