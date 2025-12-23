<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $recipes = Recipe::all();
        $users = User::all();

        if ($recipes->isEmpty() || $users->isEmpty()) {
            return;
        }

        $comments = [
            'Resepnya sangat enak, keluarga saya suka!',
            'Mudah diikuti, hasilnya memuaskan.',
            'Bumbunya pas, mantap!',
            'Saya tambahkan sedikit cabai, makin jos.',
            'Terima kasih resepnya, sangat membantu.',
            'Kurang asin dikit bagi saya, tapi oke.',
            'Wajib coba nih!',
            'Anak-anak suka sekali menu ini.',
            'Cocok untuk menu makan siang.',
            'Rasanya otentik banget!',
            'Saya sudah recook 3 kali, tidak pernah bosan.',
            'Sangat recommended!',
            'Bahannya mudah didapat di pasar.',
            'Enak banget, mirip masakan ibu saya.',
            'Porsinya pas untuk keluarga kecil.'
        ];

        // Create random reviews
        foreach ($recipes as $recipe) {
            // Create 3-5 reviews per recipe
            $reviewCount = rand(3, 5);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                $recipe->reviews()->create([
                    'user_id' => $users->random()->id,
                    'rating' => rand(4, 5), // Mostly positive ratings
                    'comment' => $comments[array_rand($comments)],
                ]);
            }

            $recipe->recalculateRatings();
        }
    }
}

