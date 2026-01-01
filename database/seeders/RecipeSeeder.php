<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $tags = Tag::all();

        // Copy images from public/images/seeder to storage/app/public/recipes
        $sourceDir = public_path('images/seeder');
        $destDir = storage_path('app/public/recipes');

        // Create destination directory if it doesn't exist
        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        // Copy all images from source to destination
        if (File::exists($sourceDir)) {
            $files = File::files($sourceDir);

            foreach ($files as $file) {
                $fileName = $file->getFilename();
                $destFile = $destDir . '/' . $fileName;

                if (!File::exists($destFile)) {
                    File::copy($file->getPathname(), $destFile);
                }
            }
        }

        $indonesianRecipes = [
            [
                'title' => 'Nasi Goreng Kampung',
                'description' => 'Nasi goreng sederhana dengan bumbu terasi yang gurih, disajikan dengan telur mata sapi, acar, dan kerupuk.',
                'ingredients' => "2 piring nasi putih dingin\n5 butir bawang merah\n3 siung bawang putih\n5 buah cabai rawit merah\n1 sdt terasi bakar\n2 sdm kecap manis\n1 sdt garam\n2 butir telur\nMinyak goreng secukupnya",
                'steps' => "1. Ulek halus bawang merah, bawang putih, cabai rawit, dan terasi.\n2. Panaskan minyak, tumis bumbu halus hingga harum matang.\n3. Masukkan telur, buat orak-arik, lalu sisihkan di pinggir wajan.\n4. Masukkan nasi putih, aduk rata dengan bumbu dan telur.\n5. Tambahkan kecap manis dan garam. Aduk terus dengan api besar hingga nasi berasap dan bumbu meresap.\n6. Sajikan hangat dengan pelengkap.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/goreng.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 10, 'servings' => 2, 'cuisine' => 'Indonesia']
            ],
            [
                'title' => 'Rendang Daging Sapi',
                'description' => 'Masakan daging sapi asli Minangkabau dengan rempah-rempah yang kaya dan santan kental, dimasak perlahan hingga kering dan berminyak.',
                'ingredients' => "1 kg daging sapi, potong-potong\n1 liter santan kental\n2 batang serai, memarkan\n3 lembar daun jeruk\n2 lembar daun kunyit\nBumbu Halus:\n100g cabai merah\n15 butir bawang merah\n8 siung bawang putih\n3 cm jahe\n3 cm lengkuas\n2 cm kunyit",
                'steps' => "1. Masukkan santan, serai, daun jeruk, daun kunyit, dan bumbu halus ke dalam wajan. Masak sambil diaduk hingga mendidih.\n2. Masukkan daging sapi. Masak dengan api sedang sambil sesekali diaduk agar santan tidak pecah.\n3. Lanjutkan memasak hingga santan menyusut dan mengeluarkan minyak (menjadi kalio).\n4. Kecilkan api, masak terus sambil diaduk perlahan hingga bumbu kering dan berwarna cokelat gelap.\n5. Angkat dan siap disajikan.",
                'difficulty' => 'sulit',
                'hero_image' => 'recipes/rendang.jpg',
                'other_attributes' => ['prep_time' => 45, 'cook_time' => 240, 'servings' => 8, 'cuisine' => 'Minang']
            ],
            [
                'title' => 'Sate Ayam Madura',
                'description' => 'Sate ayam empuk dengan siraman bumbu kacang yang legit dan kecap manis, khas Madura.',
                'ingredients' => "500g fillet dada ayam, potong dadu\nTusuk sate secukupnya\nBumbu Kacang:\n200g kacang tanah goreng, haluskan\n3 siung bawang putih goreng\n3 buah kemiri sangrai\n50g gula merah\nKecap manis, garam, air secukupnya",
                'steps' => "1. Tusuk potongan ayam dengan tusuk sate.\n2. Campur semua bahan bumbu kacang, masak hingga mengental dan berminyak.\n3. Ambil sedikit bumbu kacang, campur dengan kecap manis dan sedikit minyak untuk olesan.\n4. Lumuri sate dengan bumbu olesan, bakar di atas arang hingga matang dan kecokelatan.\n5. Sajikan sate dengan siraman bumbu kacang kental, kecap manis, dan irisan bawang merah.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/sate.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 20, 'servings' => 4, 'cuisine' => 'Madura']
            ],
            [
                'title' => 'Gado-Gado Jakarta',
                'description' => 'Salad sayuran rebus khas Indonesia disiram saus kacang gurih, lengkap dengan lontong dan kerupuk.',
                'ingredients' => "Sayuran (rebus): Kangkung, bayam, tauge, kacang panjang, labu siam\nPelengkap: Lontong, tahu goreng, tempe goreng, telur rebus, kerupuk\nBumbu Kacang:\n200g kacang tanah goreng\n2 buah cabai merah\n2 siung bawang putih\n1 sdt terasi\n50g gula merah\nAir asam jawa, garam, air matang",
                'steps' => "1. Haluskan cabai, bawang putih, terasi, gula merah, dan garam.\n2. Tambahkan kacang tanah, ulek hingga halus. Beri air asam jawa dan air matang secukupnya hingga kekentalan pas.\n3. Tata potongan lontong, sayuran rebus, tahu, tempe, dan telur di piring.\n4. Siram dengan saus kacang melimpah.\n5. Taburi bawang goreng dan kerupuk.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/gado.jpg',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 15, 'servings' => 4, 'cuisine' => 'Betawi']
            ],
            [
                'title' => 'Soto Ayam Lamongan',
                'description' => 'Soto ayam berkuah kuning bening dengan koya udang yang gurih khas Lamongan.',
                'ingredients' => "1/2 ekor ayam kampung\n2 liter air\nBumbu Halus (Bawang merah, putih, kunyit, jahe, kemiri)\nSerai, daun jeruk, lengkuas\nPelengkap: Soun, kol iris, tauge, telur rebus, seledri, koya udang",
                'steps' => "1. Rebus ayam hingga empuk, angkat dan suwir-suwir dagingnya. Sisihkan air kaldu.\n2. Tumis bumbu halus bersama serai, daun jeruk, dan lengkuas hingga harum.\n3. Masukkan tumisan bumbu ke dalam air kaldu ayam. Tambahkan garam dan gula, masak hingga mendidih.\n4. Tata soun, kol, tauge, dan ayam suwir di mangkuk.\n5. Siram kuah soto panas. Taburi bubuk koya dan seledri.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/Soto Ayam Lamongan.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 60, 'servings' => 5, 'cuisine' => 'Lamongan']
            ],
            [
                'title' => 'Ayam Taliwang Lombok',
                'description' => 'Ayam Taliwang makanan khas dari Nusa Tenggara Barat yang rasanya dominan pedas gurih.',
                'ingredients' => "1 ekor ayam kampung atau ayam broiler\n1 buah jeruk nipis\n1 sendok teh garam \n1 bungkus Kobe Bumbu Kalasan \n1 bungkus Kobe Bumbu Nasi Goreng Poll Pedas \nminyak goreng secukupnya \nBahan Bumbu Halus: 5 siung bawang putih (cincang halus), 4 siung bawang merah (cincang halus), 1 buah tomat (cincang kasar), gula merah secukupnya, 1 sendok teh terasi, 4 sendok makan air, 1 sendok teh kencur halus",
                'steps' => "Belah ayam sampai bagian belakang dan tidak terputus. Tekan hingga terbuka lebar. Lipat sayapnya ke arah belakang.\n Lumuri ayam dengan air jeruk nipis dan garam. Diamkan 15 menit.\n Panaskan minyak goreng. Tumis bumbu halus hingga matang dan harum. Tambahkan Kobe Bumbu Kalasan dan Kobe Bumbu Nasi Goreng Poll Pedas. Aduk rata.\n Panggang ayam hingga setengah matang dan sambil dibolak balik hingga ayam kaku.\nOlesi ayam dengan bumbu tumisan dan sambil di panggang hingga matang dan bumbu meresap. \nOlesi loyang dengan minyak sayur. Letakkan ayam dalam loyang. Olesi ayam dengan bumbu sisa. Panggang ayam dalam oven panas selama 20 menit.\nKeluarkan ayam dari oven jika sudah matang. Pindahkan ke piring dan sajikan",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/ayam-taliwang.jpg',
                'other_attributes' => ['prep_time' => 25, 'cook_time' => 90, 'servings' => 4, 'cuisine' => 'Lombok']
            ],
            [
                'title' => 'Sate Rembiga Lombok',
                'description' => 'Sate Rembiga merupakan salah satu nama kuliner di Lombok yang berada di sekitaran Kota Mataram..',
                'ingredients' => "500 g daging sapi has dalam, potong dadu\n125 ml Bango Kecap Manis\n¼ sdt garam, \n10 buah tusuk satai kambing,\nBahan Bumbu Halus: 5 buah cabai merah keriting, 3 buah cabai rawit merah, 8 siung bawang putih, 4 butir bawang merah, 4 sdm air asam jawa, 1 sdt ketumbar bubuk, 3 sdm minyak, untuk memanggang",
                'steps' => "Aduk rata bumbu halus, tambahkan garam dan Bango Kecap Manis.\n Aduk rata bersama daging sapi. Diamkan dalam kulkas selama 1 jam hingga meresap.\n Tusukkan daging ke dalam tusuk satai.\n Panaskan wajan pemanggang, panggang satai sambil sesekali dibolak balik hingga matang. Angkat.\nSajikan sate rembiga. ",
                'difficulty' => 'Mudah',
                'hero_image' => 'recipes/sate-rembiga.jpg',
                'other_attributes' => ['prep_time' => 35, 'cook_time' => 120, 'servings' => 2, 'cuisine' => 'Lombok']
            ], 
            [
                'title' => 'Nasi Balap Puyung Lombok',
                'description' => 'Nasi Balap Puyung adalah makanan khas yang berasal dari Desa Puyung, Kec. Lombok Tengah, NTB.',
                'ingredients' => "300 gr nasi putih\n200 gr daging ayam suwir \n3 siung bawang putih \n4 siung bawang merah \n2 butir kemiri \n3 cabe merah \n1 batang sereh \n1 ruas laos, geprek \n1 sdt ketumbar \n1sdm ebi \n3 kentang \n200 gr kacang goreng\n10 lonjor kacang panjang",
                'steps' => "Siapkan bahan. Haluskan bawang merah dan putih, sisihkan.\n Kupas dan cuci bersih kentang, kemudian parut menggunakan parutan panjang ukuran korek api.\n Rendam dengan air garam selama 30 menit.\n Siapkan ayam sisit: rebus ayam, suwir kecil kecil. \nHaluskan bumbu dan tumis hingga harum. \nTambahkan sereh, lengkuas dan jahe, aduk rata. Masukkan ayam, tambahkan minyak wijen. \nAduk dan masak hingga matang Tambahkan kacang panjang, aduk rata.\nTaburkan kacang tanah goreng di atasnya. Sajikan dengan nasi putih. ",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/nasi-balap.jpg',
                'other_attributes' => ['prep_time' => 38, 'cook_time' => 70, 'servings' => 2, 'cuisine' => 'Lombok Tengah']
            ], 
            [
                'title' => 'Sate Pusut Ayam',
                'description' => 'kuliner khas Lombok yang terbuat dari daging ayam cincang yang dicampur dengan parutan kelapa dan bumbu rempah khas, menawarkan tekstur lembut dan cita rasa gurih.',
                'ingredients' => "450 gr daging ayam\n100 gr kelapa yg agak muda, parut \n3 lembar daun jeruk purut \nTusuk sate pusut\nMinyak kelapa untuk olesan saat dibakar \n 8 butir bawang mer8 btr bawang merah \n4 siung bawang putih\n 5 buah cabe merah besar \n 5 buah cabe rawit \n1 sdt terasi\n1 sdt ketumbar, sangrai \n1 sdt lada putih\nGram, gula, penyedap rasa",
                'steps' => "Cincang ayam dan tulang muda hingga halus. Lalu, haluskan bumbu + 1 sdm bawang goreng.\n Campur bumbu halus, ayam cincang, kelapa parut dan irisan daun jeruk.\n Lilitkan adonan sate pada tusuk sate.\n Bakar sate sambil dioles minyak kelapa sesekali. \nSate siap disajikan ",
                'difficulty' => 'Mudah',
                'hero_image' => 'recipes/sate-pusut.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 45, 'servings' => 2, 'cuisine' => 'Lombok']
            ],
            [
                'title' => 'Beberuk Terong Lombok',
                'description' => 'hidangan sambal sayuran mentah khas Lombok, Nusa Tenggara Barat, yang biasanya disajikan sebagai pendamping ayam taliwang',
                'ingredients' => "4 terong hijau bulat\n3 lunjur kacang panjang\n1 bawang merah yang iris halus\n1 buah jeruk limo\nMinyak goreng secukupnya \n Bumbu halus :8 buah cabe merah keriting, 5 buah cabe rawit, 1 siung bawang putih, 5 siung bawang merah,  1 buah tomat, 3 cm kencur, 1 sdt terasi bakar, Secukupnya Garam dan Gula. ",
                'steps' => "Siapkan bahan-bahan yang diperlukan. Cuci terlebih dahulu bahan-bahan yang akan digunakan agar tetap  higienis dan sehat.\n Potong terong menjadi dadu atau kubus. Jangan terlalu besar atau  terlalu kecil. Jangan terlalu tebal atau  terlalu tipis. Iris terong agar tidak pahit saat dimakan\n Setelah dipotong kotak-kotak, masukkan terong ke dalam air agar tidak berubah warna.\n  Iris kacang hijau sesuai selera. Bisa sedikit tebal atau bahkan sedikit tipis, rasanya tetap enak \nCampur kacang hijau dengan terong yang direndam dalam air. Diamkan dalam air sambil membuat saus\nSiapkan lesung dan bahan untuk membuat sambal garam dan gula secukupnya, lalu giling hingga halus \nCukup tambahkan sedikit terasi dan aduk. Tambahkan  tomat dan tumbuk serta sambal cabai yang ditumbuk halus. \nSaat cabai sudah jadi, cicipi rasanya. Apakah rasanya enak atau tidak. Jika terlalu pedas tambahkan sedikit gula atau bisa juga tambahkan tomat  \nMasukkan irisan terong dan kacang hijau ke dalam cobek yang berisi sambal  \nSajikan dengan beberuq dicampur sambal ",
                'difficulty' => 'Mudah',
                'hero_image' => 'recipes/beberuk.jpg',
                'other_attributes' => ['prep_time' => 5, 'cook_time' => 13, 'servings' => 3, 'cuisine' => 'Lombok']
            ], 
            [
                'title' => 'Plecing Kangkung Dompu',
                'description' => 'hidangan khas dari Dompu, Nusa Tenggara Barat, yang terkenal dengan rasa pedas dan segar',
                'ingredients' => "1 ikat kangkung\n1 bks Tauge panjang\n1 buah jeruk limau\n1 buah jeruk limo\n50 ml Air\n Bahan sambal :6 siung bawang merah, 2 siung bawang putih, seruas kencur, 1 buah tomat,  6 buah cabe merah besar, 5 buah cabe rawit merah, 1 bks terasi, 1/2 sdt garam, 1 sdt gula pasir. ",
                'steps' => "Siapkan bahan-bahan dan bumbu yang diperlukan. Cuci terlebih dahulu bahan-bahan yang akan digunakan agar tetap  higienis.\n Potong kangkung panjang - panjang, kemudian cuci bersih bersama taugenya\n Didihkan air & garam (ini agar supaya warna kangkung tetep hijau) lalu masukkan kangkung...masak sampai layu, angkat & tiriskan\n  Haluskan semua bahan sambal\nTumis bahan sambal hingga harum\nLalu tuangi sedikit air & perasan air jeruk limau... aduk rata \nSajikan kangkung & tauge rebus bersama tumisan sambal  \n campur dan siap di sajikan ",
                'difficulty' => 'Mudah',
                'hero_image' => 'recipes/plecing.jpg',
                'other_attributes' => ['prep_time' => 10 , 'cook_time' => 30, 'servings' => 2, 'cuisine' => 'Dompu NTB']
            ], 
            [
                'title' => 'Ayam Rarang Lombok',
                'description' => 'Ayam Rarang menawarkan perpaduan rasa pedas, gurih, dan aromatik rempah yang kuat',
                'ingredients' => "6 potong ayam bagian paha\n Bumbu halus :10 bawang merah, 5 bawang putih, 10 cabe rawit, 3 cabe merah/keriting,  1/2 sdm terasi bakar/terasi instan, 5 butir kemiri , 1 bks terasi \nBumbu pelengkap : 1/2 sdt garam, 1 sdt gula pasir, Secukupnya penyedap. ",
                'steps' => "Siapkan dan cuci bersih semua bahan. Potong-potong ayam sesuai dengan jumlah selera.\n Ulek bumbu halus. Sisihkan. Siapkan pan utk memanggang ayam. Beri minyak goreng secukupnya, sebagai olesan di pan. Panggang ayam selama 3-4 menit atau hingga agak berwarna agak kecoklatan. Pastikan ayam dibolak-balik untuk memastikan agar tidak gosong\n Tumis bumbu halus hingga agak asat/kering. Lalu beri air secukupnya. Jika sudah mendidih, masukkan garam, gula dan penyedap serta ayam. Koreksi rasa. Jika sudah terasa pas, aduk-aduk dan diamkan hingga air agak menyusut. Terakhir, siapkan pan lagi. Olesi ayam dengan bumbu yg sudah matang, lalu panggang kembali selama 2 menit atau hingga berwarna kecoklatan.\n  Selesai dan siap disajikan.",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/ayam-rarang.jpg',
                'other_attributes' => ['prep_time' => 30 , 'cook_time' => 90, 'servings' => 4, 'cuisine' => 'Lombok']
            ], 
    

            

        ];

        foreach ($indonesianRecipes as $data) {
            $slug = \Illuminate\Support\Str::slug($data['title']);

            // Check if recipe exists
            $recipe = Recipe::where('slug', $slug)->first();

            if (! $recipe) {
                $recipe = Recipe::create(array_merge([
                    'user_id' => $users->random()->id,
                    'title' => $data['title'],
                    'slug' => $slug,
                    'description' => $data['description'],
                    'ingredients' => $data['ingredients'],
                    'steps' => $data['steps'],
                    'difficulty' => $data['difficulty'],
                    'hero_image' => $data['hero_image'],
                ], $data['other_attributes'] ?? []));

                // Only attach tags if new recipe
                $recipe->tags()->sync(
                    $tags->random(rand(2, 3))->pluck('id')->all()
                );
            }
        }
    }
}
