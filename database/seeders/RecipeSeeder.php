<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $tags = Tag::all();

        $recipes = Recipe::factory(12)
            ->recycle($users)
            ->create();

        foreach ($recipes as $recipe) {
            $recipe->tags()->sync(
                $tags->random(rand(2, 4))->pluck('id')->all()
            );
        }
    }
}

