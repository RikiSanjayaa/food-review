<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('rating')->unsigned();
            $table->text('comment')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_reported')->default(false);
            $table->timestamps();

            $table->index(['recipe_id', 'user_id']);
            $table->index('is_reported');
            $table->index('is_hidden');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

