<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'Quick',
            'Vegan',
            'Vegetarian',
            'Gluten-free',
            'High-protein',
            'Dessert',
            'Weeknight',
            'Budget',
            'One-pot',
            'Breakfast',
        ];

        foreach ($defaults as $name) {
            Tag::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}

