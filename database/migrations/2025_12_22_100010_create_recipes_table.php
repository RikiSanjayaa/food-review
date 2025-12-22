<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('hero_image')->nullable();
            $table->text('description')->nullable();
            $table->longText('ingredients');
            $table->longText('steps');
            $table->unsignedSmallInteger('prep_time')->nullable();
            $table->unsignedSmallInteger('cook_time')->nullable();
            $table->unsignedSmallInteger('servings')->nullable();
            $table->string('difficulty')->nullable();
            $table->string('diet')->nullable();
            $table->string('cuisine')->nullable();
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->unsignedInteger('rating_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['diet', 'difficulty']);
            $table->index('rating_avg');
            $table->index('cook_time');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};

