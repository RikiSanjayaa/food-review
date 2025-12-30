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

        $replyComments = [
            'Sama-sama! Senang resepnya bermanfaat.',
            'Boleh juga idenya tambah cabai!',
            'Semoga suka ya kalau dicoba.',
            'Betul banget, di pasar lokal banyak yang jual bahannya.',
            'Wah terima kasih sudah recook berkali-kali!',
            'Siap, nanti saya coba tambahkan garam sedikit lagi di deskripsi.',
            'Senang dengar anak-anak suka.',
            'Terima kasih dukungannya!',
            'Boleh banget dicoba weekend ini.',
            'Semoga hasilnya memuaskan ya!'
        ];

        // Create random reviews
        foreach ($recipes as $recipe) {
            // Create 3-5 reviews per recipe
            $reviewCount = rand(3, 5);
            $createdReviews = [];

            for ($i = 0; $i < $reviewCount; $i++) {
                $createdReviews[] = $recipe->reviews()->create([
                    'user_id' => $users->random()->id,
                    'rating' => rand(4, 5), // Mostly positive ratings
                    'comment' => $comments[array_rand($comments)],
                ]);
            }

            // Add replies to some reviews (approx 40% chance per review)
            foreach ($createdReviews as $review) {
                if (rand(1, 10) <= 4) {
                    $replyCount = rand(1, 2);
                    for ($j = 0; $j < $replyCount; $j++) {
                        Review::create([
                            'recipe_id' => $recipe->id,
                            'user_id' => $users->random()->id,
                            'parent_id' => $review->id,
                            'rating' => 5, // Replies usually don't need ratings but DB might require it or default it
                            'comment' => $replyComments[array_rand($replyComments)],
                        ]);
                    }
                }
            }

            $recipe->recalculateRatings();
        }
    }
}

