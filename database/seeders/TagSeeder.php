<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Sarapan',
            'Makan Siang',
            'Makan Malam',
            'Camilan',
            'Pedas',
            'Sehat',
            'Tradisional',
            'Minuman',
            'Vegetarian'
        ];

        foreach ($tags as $name) {
            Tag::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}

