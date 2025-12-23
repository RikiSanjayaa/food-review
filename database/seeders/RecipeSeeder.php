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

        $indonesianRecipes = [
            [
                'title' => 'Nasi Goreng Kampung',
                'description' => 'Nasi goreng sederhana dengan bumbu terasi yang gurih, disajikan dengan telur mata sapi, acar, dan kerupuk.',
                'ingredients' => "2 piring nasi putih dingin\n5 butir bawang merah\n3 siung bawang putih\n5 buah cabai rawit merah\n1 sdt terasi bakar\n2 sdm kecap manis\n1 sdt garam\n2 butir telur\nMinyak goreng secukupnya",
                'steps' => "1. Ulek halus bawang merah, bawang putih, cabai rawit, dan terasi.\n2. Panaskan minyak, tumis bumbu halus hingga harum matang.\n3. Masukkan telur, buat orak-arik, lalu sisihkan di pinggir wajan.\n4. Masukkan nasi putih, aduk rata dengan bumbu dan telur.\n5. Tambahkan kecap manis dan garam. Aduk terus dengan api besar hingga nasi berasap dan bumbu meresap.\n6. Sajikan hangat dengan pelengkap.",
                'difficulty' => 'mudah',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 10, 'servings' => 2, 'cuisine' => 'Indonesia']
            ],
            [
                'title' => 'Rendang Daging Sapi',
                'description' => 'Masakan daging sapi asli Minangkabau dengan rempah-rempah yang kaya dan santan kental, dimasak perlahan hingga kering dan berminyak.',
                'ingredients' => "1 kg daging sapi, potong-potong\n1 liter santan kental\n2 batang serai, memarkan\n3 lembar daun jeruk\n2 lembar daun kunyit\nBumbu Halus:\n100g cabai merah\n15 butir bawang merah\n8 siung bawang putih\n3 cm jahe\n3 cm lengkuas\n2 cm kunyit",
                'steps' => "1. Masukkan santan, serai, daun jeruk, daun kunyit, dan bumbu halus ke dalam wajan. Masak sambil diaduk hingga mendidih.\n2. Masukkan daging sapi. Masak dengan api sedang sambil sesekali diaduk agar santan tidak pecah.\n3. Lanjutkan memasak hingga santan menyusut dan mengeluarkan minyak (menjadi kalio).\n4. Kecilkan api, masak terus sambil diaduk perlahan hingga bumbu kering dan berwarna cokelat gelap.\n5. Angkat dan siap disajikan.",
                'difficulty' => 'sulit',
                'other_attributes' => ['prep_time' => 45, 'cook_time' => 240, 'servings' => 8, 'cuisine' => 'Minang']
            ],
            [
                'title' => 'Sate Ayam Madura',
                'description' => 'Sate ayam empuk dengan siraman bumbu kacang yang legit dan kecap manis, khas Madura.',
                'ingredients' => "500g fillet dada ayam, potong dadu\nTusuk sate secukupnya\nBumbu Kacang:\n200g kacang tanah goreng, haluskan\n3 siung bawang putih goreng\n3 buah kemiri sangrai\n50g gula merah\nKecap manis, garam, air secukupnya",
                'steps' => "1. Tusuk potongan ayam dengan tusuk sate.\n2. Campur semua bahan bumbu kacang, masak hingga mengental dan berminyak.\n3. Ambil sedikit bumbu kacang, campur dengan kecap manis dan sedikit minyak untuk olesan.\n4. Lumuri sate dengan bumbu olesan, bakar di atas arang hingga matang dan kecokelatan.\n5. Sajikan sate dengan siraman bumbu kacang kental, kecap manis, dan irisan bawang merah.",
                'difficulty' => 'sedang',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 20, 'servings' => 4, 'cuisine' => 'Madura']
            ],
            [
                'title' => 'Gado-Gado Jakarta',
                'description' => 'Salad sayuran rebus khas Indonesia disiram saus kacang gurih, lengkap dengan lontong dan kerupuk.',
                'ingredients' => "Sayuran (rebus): Kangkung, bayam, tauge, kacang panjang, labu siam\nPelengkap: Lontong, tahu goreng, tempe goreng, telur rebus, kerupuk\nBumbu Kacang:\n200g kacang tanah goreng\n2 buah cabai merah\n2 siung bawang putih\n1 sdt terasi\n50g gula merah\nAir asam jawa, garam, air matang",
                'steps' => "1. Haluskan cabai, bawang putih, terasi, gula merah, dan garam.\n2. Tambahkan kacang tanah, ulek hingga halus. Beri air asam jawa dan air matang secukupnya hingga kekentalan pas.\n3. Tata potongan lontong, sayuran rebus, tahu, tempe, dan telur di piring.\n4. Siram dengan saus kacang melimpah.\n5. Taburi bawang goreng dan kerupuk.",
                'difficulty' => 'mudah',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 15, 'servings' => 4, 'cuisine' => 'Betawi']
            ],
            [
                'title' => 'Soto Ayam Lamongan',
                'description' => 'Soto ayam berkuah kuning bening dengan koya udang yang gurih khas Lamongan.',
                'ingredients' => "1/2 ekor ayam kampung\n2 liter air\nBumbu Halus (Bawang merah, putih, kunyit, jahe, kemiri)\nSerai, daun jeruk, lengkuas\nPelengkap: Soun, kol iris, tauge, telur rebus, seledri, koya udang",
                'steps' => "1. Rebus ayam hingga empuk, angkat dan suwir-suwir dagingnya. Sisihkan air kaldu.\n2. Tumis bumbu halus bersama serai, daun jeruk, dan lengkuas hingga harum.\n3. Masukkan tumisan bumbu ke dalam air kaldu ayam. Tambahkan garam dan gula, masak hingga mendidih.\n4. Tata soun, kol, tauge, dan ayam suwir di mangkuk.\n5. Siram kuah soto panas. Taburi bubuk koya dan seledri.",
                'difficulty' => 'sedang',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 60, 'servings' => 5, 'cuisine' => 'Lamongan']
            ]
        ];

        foreach ($indonesianRecipes as $data) {
            $recipe = Recipe::create(array_merge([
                'user_id' => $users->random()->id,
                'title' => $data['title'],
                'slug' => \Illuminate\Support\Str::slug($data['title']),
                'description' => $data['description'],
                'ingredients' => $data['ingredients'],
                'steps' => $data['steps'],
                'difficulty' => $data['difficulty'],
            ], $data['other_attributes'] ?? []));

            $recipe->tags()->sync(
                $tags->random(rand(2, 3))->pluck('id')->all()
            );
        }
    }
}

