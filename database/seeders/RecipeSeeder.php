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
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 10, 'servings' => 2, 'cuisine' => 'Indonesia'],
                'tags' => ['Sarapan', 'Makan Siang', 'Tradisional']
            ],
            [
                'title' => 'Rendang Daging Sapi',
                'description' => 'Masakan daging sapi asli Minangkabau dengan rempah-rempah yang kaya dan santan kental, dimasak perlahan hingga kering dan berminyak.',
                'ingredients' => "1 kg daging sapi, potong-potong\n1 liter santan kental\n2 batang serai, memarkan\n3 lembar daun jeruk\n2 lembar daun kunyit\nBumbu Halus:\n100g cabai merah\n15 butir bawang merah\n8 siung bawang putih\n3 cm jahe\n3 cm lengkuas\n2 cm kunyit",
                'steps' => "1. Masukkan santan, serai, daun jeruk, daun kunyit, dan bumbu halus ke dalam wajan. Masak sambil diaduk hingga mendidih.\n2. Masukkan daging sapi. Masak dengan api sedang sambil sesekali diaduk agar santan tidak pecah.\n3. Lanjutkan memasak hingga santan menyusut dan mengeluarkan minyak (menjadi kalio).\n4. Kecilkan api, masak terus sambil diaduk perlahan hingga bumbu kering dan berwarna cokelat gelap.\n5. Angkat dan siap disajikan.",
                'difficulty' => 'sulit',
                'hero_image' => 'recipes/rendang.jpg',
                'other_attributes' => ['prep_time' => 45, 'cook_time' => 240, 'servings' => 8, 'cuisine' => 'Minang'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Sate Ayam Madura',
                'description' => 'Sate ayam empuk dengan siraman bumbu kacang yang legit dan kecap manis, khas Madura.',
                'ingredients' => "500g fillet dada ayam, potong dadu\nTusuk sate secukupnya\nBumbu Kacang:\n200g kacang tanah goreng, haluskan\n3 siung bawang putih goreng\n3 buah kemiri sangrai\n50g gula merah\nKecap manis, garam, air secukupnya",
                'steps' => "1. Tusuk potongan ayam dengan tusuk sate.\n2. Campur semua bahan bumbu kacang, masak hingga mengental dan berminyak.\n3. Ambil sedikit bumbu kacang, campur dengan kecap manis dan sedikit minyak untuk olesan.\n4. Lumuri sate dengan bumbu olesan, bakar di atas arang hingga matang dan kecokelatan.\n5. Sajikan sate dengan siraman bumbu kacang kental, kecap manis, dan irisan bawang merah.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/sate.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 10, 'servings' => 4, 'cuisine' => 'Madura'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Gado-Gado Jakarta',
                'description' => 'Salad sayuran rebus khas Indonesia disiram saus kacang gurih, lengkap dengan lontong dan kerupuk.',
                'ingredients' => "Sayuran (rebus): Kangkung, bayam, tauge, kacang panjang, labu siam\nPelengkap: Lontong, tahu goreng, tempe goreng, telur rebus, kerupuk\nBumbu Kacang:\n200g kacang tanah goreng\n2 buah cabai merah\n2 siung bawang putih\n1 sdt terasi\n50g gula merah\nAir asam jawa, garam, air matang",
                'steps' => "1. Haluskan cabai, bawang putih, terasi, gula merah, dan garam.\n2. Tambahkan kacang tanah, ulek hingga halus. Beri air asam jawa dan air matang secukupnya hingga kekentalan pas.\n3. Tata potongan lontong, sayuran rebus, tahu, tempe, dan telur di piring.\n4. Siram dengan saus kacang melimpah.\n5. Taburi bawang goreng dan kerupuk.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/gado.jpg',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 15, 'servings' => 4, 'cuisine' => 'Betawi'],
                'tags' => ['Makan Siang', 'Sehat', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Soto Ayam Lamongan',
                'description' => 'Soto ayam berkuah kuning bening dengan koya udang yang gurih khas Lamongan.',
                'ingredients' => "1/2 ekor ayam kampung\n2 liter air\nBumbu Halus (Bawang merah, putih, kunyit, jahe, kemiri)\nSerai, daun jeruk, lengkuas\nPelengkap: Soun, kol iris, tauge, telur rebus, seledri, koya udang",
                'steps' => "1. Rebus ayam hingga empuk, angkat dan suwir-suwir dagingnya. Sisihkan air kaldu.\n2. Tumis bumbu halus bersama serai, daun jeruk, dan lengkuas hingga harum.\n3. Masukkan tumisan bumbu ke dalam air kaldu ayam. Tambahkan garam dan gula, masak hingga mendidih.\n4. Tata soun, kol, tauge, dan ayam suwir di mangkuk.\n5. Siram kuah soto panas. Taburi bubuk koya dan seledri.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/Soto Ayam Lamongan.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 60, 'servings' => 5, 'cuisine' => 'Lamongan'],
                'tags' => ['Sarapan', 'Makan Siang', 'Tradisional']
            ],
            [
                'title' => 'Ayam Taliwang Lombok',
                'description' => 'Ayam Taliwang makanan khas dari Nusa Tenggara Barat yang rasanya dominan pedas gurih.',
                'ingredients' => "1 ekor ayam kampung atau ayam broiler\n1 buah jeruk nipis\n1 sendok teh garam \n1 bungkus Kobe Bumbu Kalasan \n1 bungkus Kobe Bumbu Nasi Goreng Poll Pedas \nminyak goreng secukupnya \nBahan Bumbu Halus: 5 siung bawang putih (cincang halus), 4 siung bawang merah (cincang halus), 1 buah tomat (cincang kasar), gula merah secukupnya, 1 sendok teh terasi, 4 sendok makan air, 1 sendok teh kencur halus",
                'steps' => "Belah ayam sampai bagian belakang dan tidak terputus. Tekan hingga terbuka lebar. Lipat sayapnya ke arah belakang.\n Lumuri ayam dengan air jeruk nipis dan garam. Diamkan 15 menit.\n Panaskan minyak goreng. Tumis bumbu halus hingga matang dan harum. Tambahkan Kobe Bumbu Kalasan dan Kobe Bumbu Nasi Goreng Poll Pedas. Aduk rata.\n Panggang ayam hingga setengah matang dan sambil dibolak balik hingga ayam kaku.\nOlesi ayam dengan bumbu tumisan dan sambil di panggang hingga matang dan bumbu meresap. \nOlesi loyang dengan minyak sayur. Letakkan ayam dalam loyang. Olesi ayam dengan bumbu sisa. Panggang ayam dalam oven panas selama 20 menit.\nKeluarkan ayam dari oven jika sudah matang. Pindahkan ke piring dan sajikan",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/ayam-taliwang.jpg',
                'other_attributes' => ['prep_time' => 25, 'cook_time' => 90, 'servings' => 4, 'cuisine' => 'Lombok'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Sate Rembiga Lombok',
                'description' => 'Sate Rembiga merupakan salah satu nama kuliner di Lombok yang berada di sekitaran Kota Mataram..',
                'ingredients' => "500 g daging sapi has dalam, potong dadu\n125 ml Bango Kecap Manis\n¼ sdt garam, \n10 buah tusuk satai kambing,\nBahan Bumbu Halus: 5 buah cabai merah keriting, 3 buah cabai rawit merah, 8 siung bawang putih, 4 butir bawang merah, 4 sdm air asam jawa, 1 sdt ketumbar bubuk, 3 sdm minyak, untuk memanggang",
                'steps' => "Aduk rata bumbu halus, tambahkan garam dan Bango Kecap Manis.\n Aduk rata bersama daging sapi. Diamkan dalam kulkas selama 1 jam hingga meresap.\n Tusukkan daging ke dalam tusuk satai.\n Panaskan wajan pemanggang, panggang satai sambil sesekali dibolak balik hingga matang. Angkat.\nSajikan sate rembiga. ",
                'difficulty' => 'Mudah',
                'hero_image' => 'recipes/sate-rembiga.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 13, 'servings' => 2, 'cuisine' => 'Lombok'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Nasi Balap Puyung Lombok',
                'description' => 'Nasi Balap Puyung adalah makanan khas yang berasal dari Desa Puyung, Kec. Lombok Tengah, NTB.',
                'ingredients' => "300 gr nasi putih\n200 gr daging ayam suwir \n3 siung bawang putih \n4 siung bawang merah \n2 butir kemiri \n3 cabe merah \n1 batang sereh \n1 ruas laos, geprek \n1 sdt ketumbar \n1sdm ebi \n3 kentang \n200 gr kacang goreng\n10 lonjor kacang panjang",
                'steps' => "Siapkan bahan. Haluskan bawang merah dan putih, sisihkan.\n Kupas dan cuci bersih kentang, kemudian parut menggunakan parutan panjang ukuran korek api.\n Rendam dengan air garam selama 30 menit.\n Siapkan ayam sisit: rebus ayam, suwir kecil kecil. \nHaluskan bumbu dan tumis hingga harum. \nTambahkan sereh, lengkuas dan jahe, aduk rata. Masukkan ayam, tambahkan minyak wijen. \nAduk dan masak hingga matang Tambahkan kacang panjang, aduk rata.\nTaburkan kacang tanah goreng di atasnya. Sajikan dengan nasi putih. ",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/nasi-balap.jpg',
                'other_attributes' => ['prep_time' => 38, 'cook_time' => 70, 'servings' => 2, 'cuisine' => 'Lombok Tengah'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Sate Pusut Ayam',
                'description' => 'kuliner khas Lombok yang terbuat dari daging ayam cincang yang dicampur dengan parutan kelapa dan bumbu rempah khas, menawarkan tekstur lembut dan cita rasa gurih.',
                'ingredients' => "450 gr daging ayam\n100 gr kelapa yg agak muda, parut \n3 lembar daun jeruk purut \nTusuk sate pusut\nMinyak kelapa untuk olesan saat dibakar \n 8 butir bawang mer8 btr bawang merah \n4 siung bawang putih\n 5 buah cabe merah besar \n 5 buah cabe rawit \n1 sdt terasi\n1 sdt ketumbar, sangrai \n1 sdt lada putih\nGram, gula, penyedap rasa",
                'steps' => "Cincang ayam dan tulang muda hingga halus. Lalu, haluskan bumbu + 1 sdm bawang goreng.\n Campur bumbu halus, ayam cincang, kelapa parut dan irisan daun jeruk.\n Lilitkan adonan sate pada tusuk sate.\n Bakar sate sambil dioles minyak kelapa sesekali. \nSate siap disajikan ",
                'difficulty' => 'Mudah',
                'hero_image' => 'recipes/sate-pusut.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 15, 'servings' => 2, 'cuisine' => 'Lombok'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Beberuk Terong Lombok',
                'description' => 'hidangan sambal sayuran mentah khas Lombok, Nusa Tenggara Barat, yang biasanya disajikan sebagai pendamping ayam taliwang',
                'ingredients' => "4 terong hijau bulat\n3 lunjur kacang panjang\n1 bawang merah yang iris halus\n1 buah jeruk limo\nMinyak goreng secukupnya \n Bumbu halus :8 buah cabe merah keriting, 5 buah cabe rawit, 1 siung bawang putih, 5 siung bawang merah,  1 buah tomat, 3 cm kencur, 1 sdt terasi bakar, Secukupnya Garam dan Gula. ",
                'steps' => "Siapkan bahan-bahan yang diperlukan. Cuci terlebih dahulu bahan-bahan yang akan digunakan agar tetap  higienis dan sehat.\n Potong terong menjadi dadu atau kubus. Jangan terlalu besar atau  terlalu kecil. Jangan terlalu tebal atau  terlalu tipis. Iris terong agar tidak pahit saat dimakan\n Setelah dipotong kotak-kotak, masukkan terong ke dalam air agar tidak berubah warna.\n  Iris kacang hijau sesuai selera. Bisa sedikit tebal atau bahkan sedikit tipis, rasanya tetap enak \nCampur kacang hijau dengan terong yang direndam dalam air. Diamkan dalam air sambil membuat saus\nSiapkan lesung dan bahan untuk membuat sambal garam dan gula secukupnya, lalu giling hingga halus \nCukup tambahkan sedikit terasi dan aduk. Tambahkan  tomat dan tumbuk serta sambal cabai yang ditumbuk halus. \nSaat cabai sudah jadi, cicipi rasanya. Apakah rasanya enak atau tidak. Jika terlalu pedas tambahkan sedikit gula atau bisa juga tambahkan tomat  \nMasukkan irisan terong dan kacang hijau ke dalam cobek yang berisi sambal  \nSajikan dengan beberuq dicampur sambal ",
                'difficulty' => 'Mudah',
                'hero_image' => 'recipes/beberuk.jpg',
                'other_attributes' => ['prep_time' => 5, 'cook_time' => 12, 'servings' => 3, 'cuisine' => 'Lombok'],
                'tags' => ['Makan Siang', 'Pedas', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Plecing Kangkung Dompu',
                'description' => 'hidangan khas dari Dompu, Nusa Tenggara Barat, yang terkenal dengan rasa pedas dan segar',
                'ingredients' => "1 ikat kangkung\n1 bks Tauge panjang\n1 buah jeruk limau\n1 buah jeruk limo\n50 ml Air\n Bahan sambal :6 siung bawang merah, 2 siung bawang putih, seruas kencur, 1 buah tomat,  6 buah cabe merah besar, 5 buah cabe rawit merah, 1 bks terasi, 1/2 sdt garam, 1 sdt gula pasir. ",
                'steps' => "Siapkan bahan-bahan dan bumbu yang diperlukan. Cuci terlebih dahulu bahan-bahan yang akan digunakan agar tetap  higienis.\n Potong kangkung panjang - panjang, kemudian cuci bersih bersama taugenya\n Didihkan air & garam (ini agar supaya warna kangkung tetep hijau) lalu masukkan kangkung...masak sampai layu, angkat & tiriskan\n  Haluskan semua bahan sambal\nTumis bahan sambal hingga harum\nLalu tuangi sedikit air & perasan air jeruk limau... aduk rata \nSajikan kangkung & tauge rebus bersama tumisan sambal  \n campur dan siap di sajikan ",
                'difficulty' => 'Mudah',
                'hero_image' => 'recipes/plecing.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 25, 'servings' => 2, 'cuisine' => 'Dompu NTB'],
                'tags' => ['Makan Siang', 'Pedas', 'Sehat', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Ayam Rarang Lombok',
                'description' => 'Ayam Rarang menawarkan perpaduan rasa pedas, gurih, dan aromatik rempah yang kuat',
                'ingredients' => "6 potong ayam bagian paha\n Bumbu halus :10 bawang merah, 5 bawang putih, 10 cabe rawit, 3 cabe merah/keriting,  1/2 sdm terasi bakar/terasi instan, 5 butir kemiri , 1 bks terasi \nBumbu pelengkap : 1/2 sdt garam, 1 sdt gula pasir, Secukupnya penyedap. ",
                'steps' => "Siapkan dan cuci bersih semua bahan. Potong-potong ayam sesuai dengan jumlah selera.\n Ulek bumbu halus. Sisihkan. Siapkan pan utk memanggang ayam. Beri minyak goreng secukupnya, sebagai olesan di pan. Panggang ayam selama 3-4 menit atau hingga agak berwarna agak kecoklatan. Pastikan ayam dibolak-balik untuk memastikan agar tidak gosong\n Tumis bumbu halus hingga agak asat/kering. Lalu beri air secukupnya. Jika sudah mendidih, masukkan garam, gula dan penyedap serta ayam. Koreksi rasa. Jika sudah terasa pas, aduk-aduk dan diamkan hingga air agak menyusut. Terakhir, siapkan pan lagi. Olesi ayam dengan bumbu yg sudah matang, lalu panggang kembali selama 2 menit atau hingga berwarna kecoklatan.\n  Selesai dan siap disajikan.",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/ayam-rarang.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 80, 'servings' => 4, 'cuisine' => 'Lombok'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Bebalung',
                'description' => 'Bebalung adalah hidangan tradisional khas suku Sasak, Lombok, Nusa Tenggara Barat, berupa sup tulang iga sapi atau kerbau.',
                'ingredients' => "1 kg tulang iga sapi\n 4 sdm air asam jawa \n50 gram daun asam jawa \n2 buah belimbing wuluh \n5 buah cabe rawit utuh \nair asam jawa secukupnya \nGaram, gula, kaldu bubuk \nBumbu Halus : 8 siung bawang merah, 4 siung bawang putih, 3 buah cabe merah, 1 ruas jahe, 1 sdt ketumbar, 1 ruas kencur \nBumbu Aromatik : 2 batang serai, 5 lembar daun salam, 3 lembar daun jeruk, 1 ruas lengkuas.  ",
                'steps' => "Cuci tulang sapi sampai bersih lalu presto sampai lunak\n Tumis bumbu halus dan masukan bumbu aromatik. Sisihkan, Setelah lapisan lemak dibuang, panaskan lagi, setelah mendidih masukan bumbu yang sudah ditumis.\n Beri garam, kaldu bubuk dan gula, Rebus sampai bumbu meresap.\n  Siap dihidangkan bersama nasi.",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/bebalung.jpg',
                'other_attributes' => ['prep_time' => 35, 'cook_time' => 95, 'servings' => 5, 'cuisine' => 'Lombok'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Poteng Jaje Tujak',
                'description' => 'Poteng Jaje Tujak merupakan jajanan khas Lombok yang sering disajikan pada acara-acara keagamaan.',
                'ingredients' => "Bahan Poteng :\n 1kg beras ketan putih\n 800 ml air  \n¼ bagian ragi tape \nDaun saga \ngula secukupnya\nDaun pisang untuk membungkus \n Bahan Jaje:\n 1 kg beras ketan putih \nKelapa parut dari 1 butir kelapa + garam secukupnya. ",
                'steps' => " Berikut beberapa langkah pembuatan poteng:\nRendam beras ketan putih dalam 2 liter air selama semalam, lalu tiriskan\n Kukus beras ketan putih hingga mengeluarkan uap yang banyak, setelah itu siram menggunakan air saga 800ml\n Kemudian dikukus lagi selama kurang lebih 15 menit, angkat dan biarkan dingin.\n  Ambil ½ beras ketan putih taruh dalam wadah kemudian, lalu taburi gula dan ragi \nTutupi ketan yang sudah ditaburi ragi dengan sisa setengah ketan \nBungkus ketan dengan kain lap, kemudian tutup wadah ketan dengan rapat \nBiarkan berfermentasi selama 2-3 hari. \nSementara untuk Jaje Tujak dibuat dengan cara : \nPertama cuci beras ketan putih, dan kemudian rendam kurang lebih 2 jam \nKukus beras ketan sampai matang kira-kira 30 menit. Siram dengan air garam, lalu angkat \nCampur ketan dengan kelapa parut, aduk rata \nKukus lagi ketan yang sudah dicampur kelapa parut hingga matang sempurna \nAngkat ketan, ratakan dan haluskan panas-panas. \nBungkus jaje tujak dengan daun pisang sisihkan \n Siap disajikan ",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/poteng-jaje.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 85, 'servings' => 6, 'cuisine' => 'Lombok'],
                'tags' => ['Cemilan', 'Tradisional']
            ],
            [
                'title' => 'Sate Bulayak',
                'description' => 'Sate khas Lombok yang disajikan dengan kuah santan kaya rasa, bukan bumbu kacang, dan dinikmati bersama lontong khas bernama "bulayak.',
                'ingredients' => "Daging sapi sepanyak 400 gram, potong bentuk dadu\n Kelapa setengah tua sebanyak 100 gram, diparut\n Kacang tanah goreng sebanyak 75 gram, ditumbuk  \nSantan kental sebanyak 200 ml \nJeruk nipis sebanyak 1 sdm \nGula merah sebanyak 2 sdm\nTusuk sate sebanyak 25 buah\n Bulayak sebanyak 10 buah\n cabe rawit merah sebanyak 12 buah \nBawang merah sebanyak 6 siung \nBawang putih sebanyak 4 siung \nMerica sebanyak 1 sdt \nGaram secukupnya ",
                'steps' => " Daging yang sudah dipotong dadu kemudian dibaluri dengan air jeruk nipis dan diamkan selama 15 menit. Setelah itu campur daging dengan setengah bumbu halus dan kasih kelapa parut, kemudian aduk dengan rata.\nTusuklah sate ke dalam tusukan sate, kemudian kukus selama 20 menit atau sampai matang.\n Siapkan alat untuk membakar, kemudian bakar sate sampai warnanya kecokelatan.\n Panaskan minyak goreng, tumis bumbu hingga halus dan hingga mengeluarkan aroma yang sedap. Kemudian masukkan kacang tanah yang sudah ditumbuk, gula merah dan santan, kemudian aduk merata hingga kental.\n  Siapkan piring dan letakkan sate bulayak diatas piring tersebut dan baluri dengan sambal kacang. \nSate bulayak siap disajikan. ",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/sate-bulayak.jpg',
                'other_attributes' => ['prep_time' => 25, 'cook_time' => 10, 'servings' => 4, 'cuisine' => 'Lombok'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Nasi Cumi',
                'description' => 'Nasi Cumi adalah hidangan ikonik dari Surabaya yang menggabungkan keunikan dan kekayaan rasa laut dalam satu piring.',
                'ingredients' => "Nasi putih hangat\n Serundeng (kelapa sangrai berbumbu)\n Peyek teri  \nTelor pindang hitam \n Bahan Cumi : 250 gram cumi segar, 2 buah daun salam, 200 mL air, 6 buah cabe keriting merah, 5 buah bawang merah, 2 buah bawang putih, 1/2 buah tomat, 1/2 sdt garam , 1 sdm gula merah. ",
                'steps' => " Cuci bersih cumi tapi harus hati-hati jangan sampai tinta cumi terbung\nHaluskan cabe, bawang merah, bawang putih, tomat. Lalu tumis bumbu tersebut dan daun salam hingga matang dan harum.\n Masukan cumi, garam dan gula lalu aduk rata. Biarkan sampai tinta cumi keluar dan bumbu meresap\n Kemudian, tuang air dan masak hingga air menyusut tapi tidak sampai kering. Jangan lupa koreksi rasa terlebih dahulu\n  Siapkan piring dan letakkan sate bulayak diatas piring tersebut dan baluri dengan sambal kacang. \nTuk penyajian, siapkan nasi dalam piring. Letakan semua bahan pelengkap di sisi nasi, lalu siramkan cumi hitam di atas nasi. ",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/nasi-cumii.jpg',
                'other_attributes' => ['prep_time' => 25, 'cook_time' => 40, 'servings' => 5, 'cuisine' => 'Surabaya'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Kare Ayam',
                'description' => 'Kare Ayam khas Jawa Timur dikenal dengan kuah santan berwarna kuning yang gurih, "medok" (kental dan berani bumbu), serta sedikit sentuhan manis.',
                'ingredients' => "1 kg ayam \n 15 siung bawang merah\n 8 siung bawang putih  \n4 biji cabe merah \n1 ruas jahe \n1 sdt ketumbar \n1 sdt merica (opsional)\n Bahan Pelengkap : 1 ruas lengkuas yg di geprek, 3 ruas serai, 5 helai daun jeruk, 2-2.5 bungkus santan instan kara, 1 sdm garam, 1 sdm gula, Bawang goreng utk taburan.",
                'steps' => " Ulek/blender bumbu halus. lalu, masukkan ke dalam wajan yg berisi minyak panas lalu tambahkan serai, lengkuas dan daun jeruk. tumis hingga aromanya tidak langu lagi. sisihkan.\nSiapkan panci yg berisi air. lalu, rebus ayam. masukkan juga bumbu halus yg sebelumnya sudah ditumis. rebus hingga ayam empuk dan matang. jika sudah agak mendidih, masukkan garam dan gula. cek rasa.\n Jika rasa sudah sesuai selera, kecilkan api kompor, lalu tambahkan santan. segera aduk, agar santan tidak pecah/menggumpal. jika dirasa masih kurang kental, silakan ditambah lagi yaa santannya. cek rasa kembali, jika masih kurang garam dan gula. segera tambahkan. lalu, sajikan dengan taburan bawang goreng dan perasan jeruk nipis serta sambal sebagai pelengkap.",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/karee-ayam.jpg',
                'other_attributes' => ['prep_time' => 25, 'cook_time' => 55, 'servings' => 7, 'cuisine' => 'Jawa Timur'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Tahu Telur',
                'description' => 'Tahu Telur adalah kuliner khas Surabaya yang terdiri dari tahu dan telur yang digoreng bersamaan, disajikan dengan lontong, kentang goreng, tauge, kerupuk, dan disiram dengan saus kacang yang kental berbumbu petis.',
                'ingredients' => "3 buah tahu putih \n 3 butir telur ayam\n garam secukupnya  \nmerica bubuk secukupnya \nkaldu ayam bubuk \n1 batang daun bawang \nBahan Pelengkap : Secukupnya tauge, Secukupnya krupuk kanji, Secukupnya bawang goreng \nBumbu Kcang: 100 gram kacang tanah goreng / sangrai, 2 siung bawang putih, goreng, 3 cabai rawit merah, goreng (sesuai selera pedasnya).",
                'steps' => " Ulek semua bahan sambal kacang, campur dgn air matang, dan kecap aduk rata.\nPotong tahu putih kotak kecil. Kocok lepas telur, tambahkan garam dan merica, masukkan tahu.\n Buat dadar tahu telur ( jadi 2 atau 3 ). Sajikan dengan disiram sambal kacang, tauge, daun bawang dan bawang merah goreng.",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/tahu-telur.jpg',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 30, 'servings' => 2, 'cuisine' => 'Surabaya'],
                'tags' => ['Makan Siang', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Nasi Bebek Goreng',
                'description' => 'Nasi bebek goreng Surabaya adalah hidangan ikonik yang terdiri dari potongan bebek berbumbu rempah yang digoreng hingga garing, disajikan bersama nasi hangat, sambal pedas, dan lalapan.',
                'ingredients' => "1 ekor bebek yg dipotong \n 1 buah jeruk nipis \n 2 batang serai  \n6 lembar daun jeruk \n500 ml Air \nBumbu halus : 8 siung bawang merah, 6 siung bawang putih, 6 butir kemiri, 2 sdt ketumbar,1 1/2 ruas kunyit, 1 ruas jahe, 1 ruas lengkuas, 1/2 sdt lada bubuk, 1/2 sdt jintan, 1 batang serai, garam & royco sapi secukupnya. \nSambal Bawang: 3 siung bawang putih, 6 buah cabe merah, Secukupnya garam, Minyak panas (tuang setelah bahan diatas dihaluskan).",
                'steps' => " Lumuri potongan bebek dengan air jeruk nipis diamkan selama 30 menit di lemari es setelah itu cuci bersih. Masukan potongan bebek dengan semua bumbu halus, serai, daun jeruk dan air, rebus selama 25menit\nPisahkan potongan bebek dengan sisa bumbu hasil rebusan, kemudian goreng bebek hingga kecoklatan.\n Siapkan wajan dengan sedikit minyak, ambil secukupnya sisa bumbu hasil rebusan, masak hingga kental. Siap dihidangkan bersama bebek goreng, aku coba pake sambal matah dan sambal bawang rasanya enak .",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/nasi-bebek.jpg',
                'other_attributes' => ['prep_time' => 25, 'cook_time' => 35, 'servings' => 5, 'cuisine' => 'Surabaya'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Ote-Ote Udang',
                'description' => 'Ote-ote udang adalah varian gorengan khas Surabaya dan sekitarnya (Sidoarjo, Gresik) yang di daerah lain lebih dikenal sebagai bakwan sayur atau bala-bala.',
                'ingredients' => "1/4 kg Udang Segar \n 2 Buah Wortel \n 2 bungkus kecambah  \n4 bungkus tepung bakwan kobe \nbawang prai dan seledri secukupnya \nBumbu halus : 5 siung bawang merah, 3 siung bawang putih, 2 buah ketumbar, Garam secukupnya, merica bubuk merica.",
                'steps' => " Cuci sampai bersih udang\nHaluskan semua bumbu halus dan tambahkan sedikit air.\n Campurkan semua bahan dan cuci bersih, Masukkan bumbu halus ke adonan sayuran, kemudian tambahkan tepung bumbu serta air dan aduk adonan hingga mengental, Setelah adonan tercampur, cetak adonan dgn menggunakan sendok sayur, tambahkan udang di atasnya, Panaskan minyak di atas wajan, Goreng Adonan di atas minyak panas, gunakan api kecil agar tdk gosong, Setelah matang, angkat,tiriskan dan siap dihidangkan bersama teman atau keluarga  ",
                'difficulty' => 'Mudah',
                'hero_image' => 'recipes/ote-ote.jpg',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 30, 'servings' => 9, 'cuisine' => 'Surabaya'],
                'tags' => ['Cemilan', 'Tradisional']
            ],
            [
                'title' => 'Bakso Sapi',
                'description' => 'Bakso sapi kenyal dengan kuah kaldu gurih, favorit semua kalangan.',
                'ingredients' => "500 gram daging sapi giling\n100 gram tepung tapioka\n4 siung bawang putih\n1 sdt merica\n1 sdt garam\nAir secukupnya",
                'steps' => "1. Haluskan bawang putih.\n2. Campur daging, bawang, tepung, garam, dan merica.\n3. Bentuk bulat-bulat.\n4. Rebus hingga bakso mengapung.\n5. Sajikan dengan kuah panas.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/bakso.jpg',
                'other_attributes' => ['prep_time' => 25, 'cook_time' => 20, 'servings' => 4, 'cuisine' => 'Indonesia'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Ayam Goreng Lengkuas',
                'description' => 'Ayam goreng dengan taburan serundeng lengkuas yang gurih dan renyah.',
                'ingredients' => "1 ekor ayam\n3 siung bawang putih\n2 cm lengkuas\n1 sdt ketumbar\nGaram secukupnya\nAir secukupnya",
                'steps' => "1. Haluskan bumbu dan lengkuas.\n2. Rebus ayam dengan bumbu hingga meresap.\n3. Goreng ayam hingga kecokelatan.\n4. Sajikan dengan serundeng.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/ayam-lengkuas.jpg',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 30, 'servings' => 4, 'cuisine' => 'Indonesia'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Rawon',
                'description' => 'Sup daging sapi khas Jawa Timur dengan kuah hitam dari kluwek.',
                'ingredients' => "500 gram daging sapi\n3 buah kluwek\n6 siung bawang merah\n3 siung bawang putih\n2 lembar daun jeruk\nGaram secukupnya",
                'steps' => "1. Haluskan bumbu dan kluwek.\n2. Tumis bumbu hingga harum.\n3. Masukkan daging dan air.\n4. Masak hingga daging empuk.\n5. Sajikan hangat.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/rawon.jpg',
                'other_attributes' => ['prep_time' => 25, 'cook_time' => 90, 'servings' => 4, 'cuisine' => 'Indonesia'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Pempek Palembang',
                'description' => 'Olahan ikan khas Palembang yang disajikan dengan kuah cuko asam manis.',
                'ingredients' => "500 gram ikan tenggiri\n250 gram tepung sagu\n2 siung bawang putih\nGaram secukupnya\nAir secukupnya",
                'steps' => "1. Campur ikan, bawang, dan garam.\n2. Tambahkan tepung sagu.\n3. Bentuk pempek.\n4. Rebus hingga mengapung.\n5. Sajikan dengan cuko.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/pempek.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 30, 'servings' => 4, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Makan Siang', 'Tradisional']
            ],
            [
                'title' => 'Gudeg Jogja',
                'description' => 'Masakan manis khas Yogyakarta berbahan nangka muda dan santan.',
                'ingredients' => "1 kg nangka muda\n1 liter santan\n5 siung bawang merah\n3 siung bawang putih\nGula aren\nGaram",
                'steps' => "1. Rebus nangka hingga empuk.\n2. Tumis bumbu halus.\n3. Masukkan nangka dan santan.\n4. Masak lama hingga meresap.\n5. Sajikan dengan pelengkap.",
                'difficulty' => 'sulit',
                'hero_image' => 'recipes/gudeg.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 180, 'servings' => 5, 'cuisine' => 'Indonesia'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Nasi Uduk',
                'description' => 'Nasi gurih yang dimasak dengan santan dan rempah, disajikan dengan lauk sederhana.',
                'ingredients' => "500 gram beras\n400 ml santan\n2 lembar daun salam\n1 batang serai\nGaram secukupnya",
                'steps' => "1. Cuci beras hingga bersih.\n2. Masak beras dengan santan dan bumbu.\n3. Aduk hingga matang.\n4. Sajikan hangat.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/nasi-uduk.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 25, 'servings' => 3, 'cuisine' => 'Indonesia'],
                'tags' => ['Sarapan', 'Makan Siang', 'Tradisional']
            ],
            [
                'title' => 'Ayam Penyet',
                'description' => 'Ayam goreng yang dipenyet dengan sambal pedas dan lalapan.',
                'ingredients' => "1 ekor ayam\n5 buah cabai rawit\n2 siung bawang putih\nGaram secukupnya\nMinyak goreng",
                'steps' => "1. Goreng ayam hingga matang.\n2. Haluskan sambal.\n3. Penyet ayam di atas sambal.\n4. Sajikan dengan lalapan.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/ayam-penyet.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 20, 'servings' => 2, 'cuisine' => 'Indonesia'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Sayur Asem',
                'description' => 'Sayur berkuah segar dengan cita rasa asam.',
                'ingredients' => "Jagung manis\nKacang panjang\nAsam jawa\nBawang merah\nGaram",
                'steps' => "1. Rebus air hingga mendidih.\n2. Masukkan sayuran.\n3. Tambahkan asam dan garam.\n4. Masak hingga matang.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/sayur-asem.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 20, 'servings' => 4, 'cuisine' => 'Indonesia'],
                'tags' => ['Makan Siang', 'Sehat', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Perkedel Kentang',
                'description' => 'Gorengan kentang lembut dengan rasa gurih.',
                'ingredients' => "500 gram kentang\n1 butir telur\nBawang goreng\nGaram",
                'steps' => "1. Goreng kentang lalu haluskan.\n2. Campur telur dan bumbu.\n3. Bentuk bulat.\n4. Goreng hingga keemasan.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/perkedel.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 15, 'servings' => 3, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Capcay Goreng',
                'description' => 'Tumis sayuran dengan rasa gurih.',
                'ingredients' => "Wortel\nSawi\nKembang kol\nBawang putih\nKecap asin",
                'steps' => "1. Tumis bawang putih.\n2. Masukkan sayuran.\n3. Tambahkan kecap.\n4. Masak hingga matang.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/capcay.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 10, 'servings' => 2, 'cuisine' => 'Indonesia'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Sehat', 'Vegetarian']
            ],
            [
                'title' => 'Oseng Kangkung',
                'description' => 'Tumis kangkung sederhana dengan bawang.',
                'ingredients' => "Kangkung\nBawang putih\nCabai\nGaram",
                'steps' => "1. Tumis bawang dan cabai.\n2. Masukkan kangkung.\n3. Aduk cepat.\n4. Sajikan.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/oseng-kangkung.jpg',
                'other_attributes' => ['prep_time' => 5, 'cook_time' => 5, 'servings' => 2, 'cuisine' => 'Indonesia'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Sehat', 'Vegetarian']
            ],
            [
                'title' => 'Ikan Bakar Kecap',
                'description' => 'Ikan bakar dengan olesan kecap manis.',
                'ingredients' => "Ikan laut\nKecap manis\nBawang putih\nJeruk nipis",
                'steps' => "1. Lumuri ikan dengan bumbu.\n2. Diamkan 15 menit.\n3. Bakar hingga matang.\n4. Sajikan.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/ikan-bakar.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 20, 'servings' => 2, 'cuisine' => 'Indonesia'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Sambal Goreng Kentang',
                'description' => 'Kentang goreng pedas manis.',
                'ingredients' => "Kentang\nCabai merah\nBawang merah\nGula\nGaram",
                'steps' => "1. Goreng kentang.\n2. Tumis bumbu.\n3. Masukkan kentang.\n4. Aduk rata.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/sambal-kentang.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 20, 'servings' => 3, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Pedas', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Nasi Liwet Solo',
                'description' => 'Nasi gurih khas Solo yang dimasak dengan santan dan disajikan dengan lauk sederhana.',
                'ingredients' => "500 gram beras\n500 ml santan\n2 lembar daun salam\n1 batang serai\nGaram secukupnya",
                'steps' => "1. Cuci beras hingga bersih.\n2. Masak beras bersama santan dan bumbu.\n3. Aduk hingga matang dan pulen.\n4. Sajikan hangat.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/nasi-liwet.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 30, 'servings' => 4, 'cuisine' => 'Solo'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Ayam Betutu Bali',
                'description' => 'Ayam utuh berbumbu rempah Bali yang dimasak perlahan hingga empuk dan meresap.',
                'ingredients' => "1 ekor ayam\nBumbu betutu lengkap\nDaun pisang\nGaram secukupnya",
                'steps' => "1. Lumuri ayam dengan bumbu.\n2. Bungkus dengan daun pisang.\n3. Panggang atau kukus hingga empuk.\n4. Sajikan hangat.",
                'difficulty' => 'sulit',
                'hero_image' => 'recipes/ayam-betutu.jpg',
                'other_attributes' => ['prep_time' => 40, 'cook_time' => 180, 'servings' => 4, 'cuisine' => 'Bali'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Tinutuan Manado',
                'description' => 'Bubur Manado dengan campuran sayuran yang sehat dan mengenyangkan.',
                'ingredients' => "Beras\nBayam\nLabu kuning\nJagung\nGaram",
                'steps' => "1. Masak beras hingga menjadi bubur.\n2. Masukkan sayuran.\n3. Aduk hingga matang.\n4. Sajikan hangat.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/tinutuan.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 45, 'servings' => 4, 'cuisine' => 'Manado'],
                'tags' => ['Sarapan', 'Sehat', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Ikan Kuah Asam',
                'description' => 'Masakan ikan segar dengan kuah asam pedas khas Maluku.',
                'ingredients' => "Ikan laut segar\nBelimbing wuluh\nCabai\nBawang merah\nAir",
                'steps' => "1. Rebus air dengan bumbu.\n2. Masukkan ikan.\n3. Masak hingga matang.\n4. Sajikan panas.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/ikan-kuah-asam.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 25, 'servings' => 3, 'cuisine' => 'Maluku'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Lontong Sayur Padang',
                'description' => 'Lontong dengan kuah santan sayur khas Padang.',
                'ingredients' => "Lontong\nNangka muda\nSantan\nCabai merah\nGaram",
                'steps' => "1. Masak sayur dengan santan.\n2. Potong lontong.\n3. Siram kuah sayur.\n4. Sajikan.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/lontong-sayur.jpg',
                'other_attributes' => ['prep_time' => 25, 'cook_time' => 40, 'servings' => 4, 'cuisine' => 'Padang'],
                'tags' => ['Sarapan', 'Makan Siang', 'Tradisional']
            ],
            [
                'title' => 'Kerak Telor Betawi',
                'description' => 'Makanan tradisional Betawi berbahan telur dan beras ketan.',
                'ingredients' => "Beras ketan\nTelur bebek\nKelapa parut\nBawang goreng",
                'steps' => "1. Masak ketan setengah matang.\n2. Tambahkan telur.\n3. Panggang hingga kering.\n4. Taburi kelapa.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/kerak-telor.jpg',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 20, 'servings' => 2, 'cuisine' => 'Betawi'],
                'tags' => ['Cemilan', 'Tradisional']
            ],
            [
                'title' => 'Bubur Ayam Cianjur',
                'description' => 'Bubur ayam lembut dengan kuah kaldu ringan.',
                'ingredients' => "Beras\nAyam\nBawang putih\nGaram\nAir",
                'steps' => "1. Masak beras hingga menjadi bubur.\n2. Rebus ayam dan suwir.\n3. Sajikan bubur dengan ayam.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/bubur-ayam.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 40, 'servings' => 3, 'cuisine' => 'Cianjur'],
                'tags' => ['Sarapan', 'Tradisional']
            ],
            [
                'title' => 'Sup Konro Makassar',
                'description' => 'Sup iga sapi khas Makassar dengan kuah rempah berwarna gelap.',
                'ingredients' => "1 kg iga sapi\nKetumbar\nKluwek\nKayu manis\nGaram\nAir",
                'steps' => "1. Rebus iga hingga empuk.\n2. Tumis bumbu halus.\n3. Masukkan ke dalam kaldu.\n4. Masak hingga meresap.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/sup-konro.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 90, 'servings' => 4, 'cuisine' => 'Makassar'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Pecel Madiun',
                'description' => 'Sayuran rebus dengan siraman sambal kacang pedas khas Madiun.',
                'ingredients' => "Bayam\nKacang panjang\nTauge\nKacang tanah\nCabai\nGula merah",
                'steps' => "1. Rebus semua sayuran.\n2. Haluskan bumbu kacang.\n3. Siram bumbu di atas sayur.\n4. Sajikan.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/pecel-madiun.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 15, 'servings' => 2, 'cuisine' => 'Madiun'],
                'tags' => ['Makan Siang', 'Pedas', 'Sehat', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Karedok Sunda',
                'description' => 'Hidangan khas Sunda dari sayuran mentah dengan saus kacang segar.',
                'ingredients' => "Kacang panjang\nTimun\nTauge\nTerong\nBumbu kacang",
                'steps' => "1. Potong semua sayuran.\n2. Haluskan bumbu kacang.\n3. Campur sayur dengan bumbu.\n4. Sajikan segar.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/karedok.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 0, 'servings' => 2, 'cuisine' => 'Sunda'],
                'tags' => ['Makan Siang', 'Sehat', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Opor Ayam',
                'description' => 'Masakan ayam berkuah santan dengan rasa gurih dan aroma rempah.',
                'ingredients' => "1 ekor ayam\nSantan\nBawang putih\nKetumbar\nDaun salam\nGaram",
                'steps' => "1. Tumis bumbu hingga harum.\n2. Masukkan ayam.\n3. Tuang santan.\n4. Masak hingga matang.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/opor-ayam.jpg',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 50, 'servings' => 4, 'cuisine' => 'Jawa'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Dendeng Balado',
                'description' => 'Irisan daging sapi tipis goreng dengan sambal balado pedas.',
                'ingredients' => "500 gram daging sapi\nCabai merah\nBawang merah\nGaram\nMinyak",
                'steps' => "1. Rebus daging hingga empuk.\n2. Iris tipis dan goreng.\n3. Tumis sambal balado.\n4. Campur dendeng dengan sambal.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/dendeng-balado.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 40, 'servings' => 4, 'cuisine' => 'Minang'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Ikan Woku',
                'description' => 'Masakan ikan khas Manado dengan bumbu rempah segar dan daun aromatik.',
                'ingredients' => "Ikan laut\nDaun kemangi\nCabai\nJahe\nKunyit\nSerai",
                'steps' => "1. Tumis bumbu hingga harum.\n2. Masukkan ikan.\n3. Tambahkan daun aromatik.\n4. Masak hingga matang.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/ikan-woku.jpg',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 30, 'servings' => 3, 'cuisine' => 'Manado'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Laksa Betawi',
                'description' => 'Hidangan berkuah santan dengan mie dan topping khas Betawi.',
                'ingredients' => "Mie\nSantan\nUdang\nBawang putih\nKetumbar",
                'steps' => "1. Masak kuah santan berbumbu.\n2. Rebus mie.\n3. Tata mie dan siram kuah.\n4. Sajikan.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/laksa-betawi.jpg',
                'other_attributes' => ['prep_time' => 25, 'cook_time' => 35, 'servings' => 3, 'cuisine' => 'Betawi'],
                'tags' => ['Makan Siang', 'Tradisional']
            ],
            [
                'title' => 'Sayur Lodeh',
                'description' => 'Sayur berkuah santan dengan aneka sayuran tradisional.',
                'ingredients' => "Labu siam\nTerong\nKacang panjang\nSantan\nBawang putih",
                'steps' => "1. Tumis bumbu hingga harum.\n2. Masukkan sayuran.\n3. Tuang santan.\n4. Masak hingga matang.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/sayur-lodeh.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 30, 'servings' => 4, 'cuisine' => 'Jawa'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Sop Buntut',
                'description' => 'Sup buntut sapi dengan kuah bening gurih dan aroma rempah.',
                'ingredients' => "1 kg buntut sapi\nWortel\nKentang\nBawang putih\nMerica\nGaram",
                'steps' => "1. Rebus buntut hingga empuk.\n2. Tumis bawang putih.\n3. Masukkan ke dalam kaldu.\n4. Tambahkan sayuran dan masak hingga matang.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/sop-buntut.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 120, 'servings' => 4, 'cuisine' => 'Indonesia'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Coto Makassar',
                'description' => 'Sup daging dan jeroan sapi khas Makassar dengan kuah kacang yang kaya rasa.',
                'ingredients' => "500 gram daging sapi\nJeroan sapi\nKacang tanah sangrai\nBawang merah\nKetumbar",
                'steps' => "1. Rebus daging dan jeroan hingga empuk.\n2. Tumis bumbu halus.\n3. Masukkan kacang dan kaldu.\n4. Sajikan panas.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/coto-makassar.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 90, 'servings' => 4, 'cuisine' => 'Makassar'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Sate Lilit Bali',
                'description' => 'Sate khas Bali berbahan ikan cincang dengan rempah dan kelapa.',
                'ingredients' => "Ikan tenggiri\nKelapa parut\nSerai\nBawang putih\nKetumbar",
                'steps' => "1. Campur ikan dengan bumbu.\n2. Lilitkan pada batang serai.\n3. Panggang hingga matang.\n4. Sajikan.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/sate-lilit.jpg',
                'other_attributes' => ['prep_time' => 25, 'cook_time' => 20, 'servings' => 3, 'cuisine' => 'Bali'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Urap Sayur',
                'description' => 'Sayuran rebus dengan kelapa parut berbumbu gurih.',
                'ingredients' => "Bayam\nKacang panjang\nTauge\nKelapa parut\nCabai",
                'steps' => "1. Rebus sayuran.\n2. Kukus kelapa berbumbu.\n3. Campur sayur dan kelapa.\n4. Sajikan.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/urap.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 10, 'servings' => 3, 'cuisine' => 'Jawa'],
                'tags' => ['Makan Siang', 'Sehat', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Nasi Megono',
                'description' => 'Nasi khas Pekalongan dengan cacahan nangka muda berbumbu kelapa.',
                'ingredients' => "Nangka muda\nKelapa parut\nCabai\nNasi putih",
                'steps' => "1. Masak nangka dengan bumbu.\n2. Campur dengan kelapa.\n3. Sajikan di atas nasi.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/nasi-megono.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 25, 'servings' => 3, 'cuisine' => 'Pekalongan'],
                'tags' => ['Makan Siang', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Tumis Genjer',
                'description' => 'Tumis sayur genjer dengan bumbu sederhana khas rumahan.',
                'ingredients' => "Genjer\nBawang merah\nCabai\nGaram",
                'steps' => "1. Tumis bawang dan cabai.\n2. Masukkan genjer.\n3. Aduk hingga layu.\n4. Sajikan.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/tumis-genjer.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 10, 'servings' => 2, 'cuisine' => 'Indonesia'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Sehat', 'Vegetarian']
            ],
            [
                'title' => 'Gulai Ikan Patin',
                'description' => 'Masakan ikan patin berkuah santan kuning dengan rempah.',
                'ingredients' => "Ikan patin\nSantan\nKunyit\nSerai\nDaun jeruk",
                'steps' => "1. Tumis bumbu hingga harum.\n2. Masukkan ikan.\n3. Tuang santan.\n4. Masak hingga matang.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/gulai-patin.jpg',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 35, 'servings' => 3, 'cuisine' => 'Sumatera'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Nasi Timbel Sunda',
                'description' => 'Nasi hangat yang dibungkus daun pisang khas Sunda dengan aroma alami.',
                'ingredients' => "Beras putih\nDaun pisang\nAir\nGaram secukupnya",
                'steps' => "1. Cuci beras hingga bersih.\n2. Masak nasi hingga matang.\n3. Bungkus nasi dengan daun pisang.\n4. Sajikan hangat.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/nasi-timbel.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 25, 'servings' => 3, 'cuisine' => 'Sunda'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Ayam Woku Belanga',
                'description' => 'Ayam berbumbu woku khas Manado yang dimasak dalam belanga.',
                'ingredients' => "1 ekor ayam\nDaun kemangi\nCabai\nJahe\nSerai\nDaun jeruk",
                'steps' => "1. Tumis bumbu hingga harum.\n2. Masukkan ayam dan aduk rata.\n3. Tambahkan air secukupnya.\n4. Masak hingga ayam empuk.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/ayam-woku.jpg',
                'other_attributes' => ['prep_time' => 25, 'cook_time' => 45, 'servings' => 4, 'cuisine' => 'Manado'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Gulai Kambing',
                'description' => 'Masakan daging kambing berkuah santan dengan rempah kuat.',
                'ingredients' => "Daging kambing\nSantan\nKetumbar\nJahe\nKunyit\nSerai",
                'steps' => "1. Rebus daging kambing.\n2. Tumis bumbu hingga harum.\n3. Masukkan santan dan daging.\n4. Masak hingga empuk.",
                'difficulty' => 'sulit',
                'hero_image' => 'recipes/gulai-kambing.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 120, 'servings' => 4, 'cuisine' => 'Indonesia'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional']
            ],
            [
                'title' => 'Pepes Tahu',
                'description' => 'Tahu berbumbu rempah yang dikukus dalam daun pisang.',
                'ingredients' => "Tahu\nDaun pisang\nCabai\nBawang merah\nKemangi",
                'steps' => "1. Haluskan tahu dan bumbu.\n2. Bungkus dengan daun pisang.\n3. Kukus hingga matang.\n4. Sajikan.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/pepes-tahu.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 25, 'servings' => 3, 'cuisine' => 'Jawa'],
                'tags' => ['Makan Siang', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Nasi Kuning Banjar',
                'description' => 'Nasi kuning khas Banjar dengan aroma rempah dan santan.',
                'ingredients' => "Beras\nSantan\nKunyit\nDaun salam\nSerai",
                'steps' => "1. Cuci beras.\n2. Masak dengan santan dan kunyit.\n3. Aduk hingga matang.\n4. Sajikan.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/nasi-kuning.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 30, 'servings' => 4, 'cuisine' => 'Banjar'],
                'tags' => ['Sarapan', 'Makan Siang', 'Tradisional']
            ],
            [
                'title' => 'Ikan Rica-Rica',
                'description' => 'Masakan ikan dengan sambal rica pedas khas Sulawesi.',
                'ingredients' => "Ikan laut\nCabai rawit\nBawang merah\nJahe\nJeruk nipis",
                'steps' => "1. Goreng ikan setengah matang.\n2. Tumis bumbu rica.\n3. Masukkan ikan.\n4. Masak hingga meresap.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/ikan-rica.jpg',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 25, 'servings' => 3, 'cuisine' => 'Sulawesi'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Sayur Ares',
                'description' => 'Sayur khas Lombok berbahan batang pisang dengan santan.',
                'ingredients' => "Batang pisang\nSantan\nCabai\nBawang merah\nLengkuas",
                'steps' => "1. Iris batang pisang.\n2. Rebus hingga lunak.\n3. Masak dengan bumbu dan santan.\n4. Sajikan.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/sayur-ares.jpg',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 35, 'servings' => 4, 'cuisine' => 'Lombok'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Oseng Mercon',
                'description' => 'Masakan pedas ekstrem berbahan daging sapi dan cabai rawit.',
                'ingredients' => "Daging sapi\nCabai rawit\nBawang merah\nBawang putih",
                'steps' => "1. Rebus daging hingga empuk.\n2. Tumis bumbu.\n3. Masukkan daging.\n4. Masak hingga pedas meresap.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/oseng-mercon.jpg',
                'other_attributes' => ['prep_time' => 25, 'cook_time' => 40, 'servings' => 3, 'cuisine' => 'Yogyakarta'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Bakwan Jagung',
                'description' => 'Gorengan renyah dari jagung manis dan tepung.',
                'ingredients' => "Jagung manis\nTepung terigu\nDaun bawang\nGaram",
                'steps' => "1. Campur semua bahan.\n2. Panaskan minyak.\n3. Goreng hingga kuning keemasan.\n4. Angkat dan sajikan.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/bakwan-jagung.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 15, 'servings' => 4, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Seblak Bandung',
                'description' => 'Seblak khas Bandung dengan kerupuk basah, kuah pedas gurih, dan aroma kencur yang kuat.',
                'ingredients' => "100g kerupuk bawang mentah\n1 butir telur\n2 siung bawang putih\n3 buah cabai rawit\n1/2 sdt kencur\nGaram dan kaldu bubuk secukupnya\nAir secukupnya",
                'steps' => "1. Rebus kerupuk hingga lunak, tiriskan.\n2. Haluskan bawang putih, cabai, dan kencur.\n3. Tumis bumbu halus hingga harum.\n4. Masukkan telur, orak-arik hingga matang.\n5. Masukkan kerupuk dan air, bumbui.\n6. Masak hingga kuah mengental, sajikan panas.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/seblak.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 10, 'servings' => 1, 'cuisine' => 'Bandung'],
                'tags' => ['Cemilan', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Batagor Bandung',
                'description' => 'Bakso tahu goreng renyah dengan siraman saus kacang yang gurih manis.',
                'ingredients' => "5 buah tahu putih\n200g ikan tenggiri halus\n2 siung bawang putih\n1 butir telur\nGaram dan lada secukupnya\nBumbu kacang secukupnya",
                'steps' => "1. Campur ikan, bawang putih, telur, dan bumbu.\n2. Isi adonan ke dalam tahu.\n3. Goreng hingga kuning keemasan.\n4. Sajikan dengan saus kacang dan kecap manis.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/batagor.jpg',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 15, 'servings' => 3, 'cuisine' => 'Bandung'],
                'tags' => ['Cemilan', 'Tradisional']
            ],
            [
                'title' => 'Tahu Gejrot',
                'description' => 'Tahu goreng dengan siraman kuah asam manis pedas khas Cirebon.',
                'ingredients' => "5 buah tahu pong\n2 siung bawang putih\n3 buah cabai rawit\n2 sdm gula merah\n2 sdm air asam jawa\nGaram secukupnya",
                'steps' => "1. Goreng tahu hingga garing, potong-potong.\n2. Haluskan bawang putih dan cabai.\n3. Campur gula merah, air asam, dan garam.\n4. Siram kuah ke atas tahu, aduk rata.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/tahu-gejrot.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 10, 'servings' => 2, 'cuisine' => 'Cirebon'],
                'tags' => ['Cemilan', 'Pedas', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Sate Taichan',
                'description' => 'Sate ayam tanpa kecap dengan sambal pedas segar dan perasan jeruk nipis.',
                'ingredients' => "500g dada ayam fillet\nTusuk sate\nCabai rawit\nBawang putih\nGaram dan jeruk nipis",
                'steps' => "1. Tusuk potongan ayam.\n2. Bakar hingga matang dan sedikit gosong.\n3. Haluskan cabai dan bawang putih, beri garam dan jeruk nipis.\n4. Sajikan sate dengan sambal pedas.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/taichan.jpg',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 15, 'servings' => 3, 'cuisine' => 'Indonesia'],
                'tags' => ['Makan Siang', 'Makan Malam', 'Pedas', 'Tradisional']
            ],
            [
                'title' => 'Martabak Telur Mini',
                'description' => 'Martabak telur ukuran mini dengan isian daging dan telur yang gurih.',
                'ingredients' => "Kulit lumpia\n2 butir telur\n100g daging cincang\nDaun bawang\nGaram dan lada",
                'steps' => "1. Campur telur, daging, daun bawang, dan bumbu.\n2. Isi adonan ke kulit lumpia.\n3. Lipat dan goreng hingga kecokelatan.\n4. Sajikan dengan acar dan cabai.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/martabak-mini.jpg',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 15, 'servings' => 4, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional']
            ],
            [
                'title' => 'Onde-Onde',
                'description' => 'Kue tradisional berlapis wijen dengan isian kacang hijau manis.',
                'ingredients' => "200g tepung ketan\n100g kacang hijau kupas\nGula\nWijen\nMinyak goreng",
                'steps' => "1. Kukus kacang hijau, haluskan dan beri gula.\n2. Campur tepung ketan dengan air, uleni.\n3. Isi adonan dengan kacang hijau.\n4. Balur wijen, goreng hingga mengembang dan matang.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/onde-onde.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 15, 'servings' => 5, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Klepon Gula Merah',
                'description' => 'Kue tradisional berbentuk bulat dengan isian gula merah cair dan balutan kelapa parut.',
                'ingredients' => "200g tepung ketan\n100g gula merah sisir\nKelapa parut kukus\nAir daun pandan secukupnya\nSejumput garam",
                'steps' => "1. Campur tepung ketan dengan air pandan.\n2. Bentuk bulat, isi gula merah.\n3. Rebus hingga mengapung.\n4. Gulingkan ke kelapa parut, sajikan.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/klepon.jpg',
                'other_attributes' => ['prep_time' => 20, 'cook_time' => 10, 'servings' => 4, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Dadar Gulung',
                'description' => 'Pancake hijau pandan dengan isian kelapa parut manis khas jajanan pasar.',
                'ingredients' => "150g tepung terigu\n200ml santan\nKelapa parut\nGula merah\nDaun pandan",
                'steps' => "1. Buat adonan kulit dadar.\n2. Masak tipis di teflon.\n3. Isi kelapa gula.\n4. Gulung dan sajikan.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/dadar-gulung.jpg',
                'other_attributes' => ['prep_time' => 25, 'cook_time' => 15, 'servings' => 5, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Serabi Solo',
                'description' => 'Serabi lembut berbahan santan dengan kuah kinca gula merah.',
                'ingredients' => "200g tepung beras\n400ml santan\nRagi instan\nGula merah cair",
                'steps' => "1. Campur adonan serabi.\n2. Diamkan hingga mengembang.\n3. Masak di wajan kecil.\n4. Sajikan dengan kuah gula.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/serabi.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 20, 'servings' => 6, 'cuisine' => 'Solo'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Lupis Ketan',
                'description' => 'Ketan kukus berbentuk segitiga disajikan dengan gula merah cair dan kelapa parut.',
                'ingredients' => "300g beras ketan\nKelapa parut\nGula merah cair\nDaun pisang",
                'steps' => "1. Bungkus ketan dengan daun pisang.\n2. Rebus hingga matang.\n3. Sajikan dengan gula dan kelapa.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/lupis.jpg',
                'other_attributes' => ['prep_time' => 40, 'cook_time' => 60, 'servings' => 6, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Es Cendol',
                'description' => 'Minuman manis segar dari cendol hijau, santan, dan gula aren.',
                'ingredients' => "Cendol\nSantan\nGula aren cair\nEs batu",
                'steps' => "1. Siapkan gelas.\n2. Masukkan cendol dan es.\n3. Tuang santan dan gula aren.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/cendol.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 5, 'servings' => 2, 'cuisine' => 'Indonesia'],
                'tags' => ['Minuman', 'Tradisional']
            ],
            [
                'title' => 'Bubur Sumsum',
                'description' => 'Bubur lembut dari tepung beras dengan kuah gula merah.',
                'ingredients' => "100g tepung beras\n500ml santan\nGula merah cair\nGaram",
                'steps' => "1. Masak tepung dan santan hingga kental.\n2. Sajikan dengan gula merah.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/bubur-sumsum.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 15, 'servings' => 3, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Kolak Pisang',
                'description' => 'Hidangan manis dari pisang dan santan dengan gula aren.',
                'ingredients' => "Pisang kepok\nSantan\nGula aren\nDaun pandan",
                'steps' => "1. Rebus santan dan gula.\n2. Masukkan pisang.\n3. Masak hingga matang.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/kolak.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 20, 'servings' => 4, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Es Pisang Ijo',
                'description' => 'Pisang dibalut adonan hijau, disajikan dengan sirup dan santan dingin.',
                'ingredients' => "Pisang raja\nTepung beras\nDaun pandan\nSantan\nSirup merah",
                'steps' => "1. Bungkus pisang dengan adonan.\n2. Kukus hingga matang.\n3. Sajikan dengan es dan sirup.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/pisang-ijo.jpg',
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 20, 'servings' => 5, 'cuisine' => 'Makassar'],
                'tags' => ['Cemilan', 'Minuman', 'Tradisional']
            ],
            [
                'title' => 'Es Teh Manis',
                'description' => 'Minuman sederhana dan menyegarkan dari teh hitam dan gula, disajikan dengan es batu.',
                'ingredients' => "2 kantong teh hitam\n2 sdm gula pasir\n300 ml air panas\nEs batu secukupnya",
                'steps' => "1. Seduh teh dengan air panas.\n2. Tambahkan gula, aduk hingga larut.\n3. Tuang ke gelas berisi es batu.\n4. Sajikan dingin.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/es-teh.jpg',
                'other_attributes' => ['prep_time' => 5, 'cook_time' => 5, 'servings' => 1, 'cuisine' => 'Indonesia'],
                'tags' => ['Minuman']
            ],
            [
                'title' => 'Es Jeruk Peras',
                'description' => 'Minuman segar dari perasan jeruk asli dengan rasa manis dan asam seimbang.',
                'ingredients' => "3 buah jeruk manis\n2 sdm gula cair\nEs batu secukupnya\nAir matang secukupnya",
                'steps' => "1. Peras jeruk, saring bijinya.\n2. Campur dengan gula dan air.\n3. Tambahkan es batu.\n4. Sajikan dingin.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/es-jeruk.jpg',
                'other_attributes' => ['prep_time' => 5, 'cook_time' => 0, 'servings' => 1, 'cuisine' => 'Indonesia'],
                'tags' => ['Minuman', 'Sehat']
            ],
            [
                'title' => 'Wedang Jahe',
                'description' => 'Minuman tradisional hangat dari jahe dengan aroma rempah yang menenangkan.',
                'ingredients' => "2 ruas jahe, bakar dan memarkan\n2 sdm gula merah\n400 ml air\nDaun pandan",
                'steps' => "1. Rebus air bersama jahe dan pandan.\n2. Tambahkan gula merah.\n3. Masak hingga harum.\n4. Sajikan hangat.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/wedang-jahe.jpg',
                'other_attributes' => ['prep_time' => 5, 'cook_time' => 15, 'servings' => 2, 'cuisine' => 'Jawa'],
                'tags' => ['Minuman', 'Sehat', 'Tradisional']
            ],
            [
                'title' => 'Es Kopi Susu Gula Aren',
                'description' => 'Minuman kopi dingin dengan perpaduan susu dan manis alami gula aren.',
                'ingredients' => "1 shot kopi hitam\n100 ml susu cair\n2 sdm gula aren cair\nEs batu secukupnya",
                'steps' => "1. Siapkan gelas berisi es batu.\n2. Tuang gula aren dan susu.\n3. Tambahkan kopi hitam.\n4. Aduk dan sajikan.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/kopi-susu-aren.jpg',
                'other_attributes' => ['prep_time' => 5, 'cook_time' => 5, 'servings' => 1, 'cuisine' => 'Indonesia'],
                'tags' => ['Minuman']
            ],
            [
                'title' => 'Bajigur',
                'description' => 'Minuman hangat khas Sunda berbahan santan, gula aren, dan jahe.',
                'ingredients' => "500 ml santan\n2 sdm gula aren\n1 ruas jahe\nSejumput garam",
                'steps' => "1. Rebus santan bersama jahe.\n2. Tambahkan gula aren dan garam.\n3. Aduk hingga hangat dan harum.\n4. Sajikan panas.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/bajigur.jpg',
                'other_attributes' => ['prep_time' => 5, 'cook_time' => 15, 'servings' => 3, 'cuisine' => 'Sunda'],
                'tags' => ['Minuman', 'Tradisional']
            ],
            [
                'title' => 'Pisang Goreng',
                'description' => 'Pisang goreng renyah di luar dan lembut di dalam, cocok sebagai cemilan sore.',
                'ingredients' => "5 buah pisang kepok\n100g tepung terigu\n1 sdm gula\nSejumput garam\nAir secukupnya\nMinyak goreng",
                'steps' => "1. Campur tepung, gula, garam, dan air hingga kental.\n2. Celupkan pisang ke adonan.\n3. Goreng hingga kuning keemasan.\n4. Angkat dan sajikan.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/pisang-goreng.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 10, 'servings' => 3, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Tahu Crispy',
                'description' => 'Tahu goreng berbalut tepung renyah dengan rasa gurih.',
                'ingredients' => "10 buah tahu putih\n100g tepung bumbu serbaguna\nAir secukupnya\nMinyak goreng",
                'steps' => "1. Potong tahu sesuai selera.\n2. Celupkan tahu ke adonan tepung.\n3. Goreng hingga renyah dan kering.\n4. Sajikan hangat.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/tahu-crispy.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 10, 'servings' => 3, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Bakwan Sayur',
                'description' => 'Gorengan sayur renyah dengan rasa gurih, favorit segala usia.',
                'ingredients' => "100g tepung terigu\nWortel iris\nKol iris\nDaun bawang\nBawang putih\nAir dan garam secukupnya",
                'steps' => "1. Campur semua bahan hingga rata.\n2. Panaskan minyak.\n3. Goreng adonan hingga kecokelatan.\n4. Angkat dan tiriskan.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/bakwan.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 10, 'servings' => 4, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Risoles Mayo',
                'description' => 'Risoles isi smoked beef, telur, dan mayones dengan kulit lembut dan renyah.',
                'ingredients' => "Kulit risoles\nSmoked beef\nTelur rebus\nMayones\nTepung panir\nMinyak goreng",
                'steps' => "1. Isi kulit risoles dengan bahan isian.\n2. Gulung dan rekatkan.\n3. Celupkan ke tepung panir.\n4. Goreng hingga keemasan.",
                'difficulty' => 'sedang',
                'hero_image' => 'recipes/risoles.jpg',
                'other_attributes' => ['prep_time' => 25, 'cook_time' => 10, 'servings' => 4, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional']
            ],
            [
                'title' => 'Tempe Mendoan',
                'description' => 'Tempe tipis khas Banyumas yang digoreng setengah matang dengan balutan tepung berbumbu.',
                'ingredients' => "10 lembar tempe mendoan\n100g tepung terigu\n2 siung bawang putih\nKetumbar bubuk\nDaun bawang\nAir secukupnya\nMinyak goreng",
                'steps' => "1. Campur tepung, bawang putih halus, ketumbar, dan daun bawang.\n2. Tambahkan air hingga adonan encer.\n3. Celupkan tempe ke adonan.\n4. Goreng sebentar hingga matang lembut.\n5. Sajikan hangat.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/tempe-mendoan.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 5, 'servings' => 3, 'cuisine' => 'Banyumas'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Tahu Isi Sayur',
                'description' => 'Tahu goreng berisi sayuran tumis dengan rasa gurih dan tekstur renyah.',
                'ingredients' => "8 buah tahu pong\nWortel iris\nKol iris\nTauge\nBawang putih\nTepung terigu\nAir dan garam secukupnya",
                'steps' => "1. Tumis bawang putih dan sayuran hingga layu.\n2. Belah tahu, isi dengan tumisan sayur.\n3. Celupkan ke adonan tepung.\n4. Goreng hingga kecokelatan.\n5. Sajikan hangat.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/tahu-isi.jpg',
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 10, 'servings' => 4, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Singkong Goreng',
                'description' => 'Singkong goreng empuk di dalam dan renyah di luar, cemilan sederhana khas rumahan.',
                'ingredients' => "500g singkong\nBawang putih\nGaram\nAir\nMinyak goreng",
                'steps' => "1. Rebus singkong dengan bawang putih dan garam hingga empuk.\n2. Tiriskan singkong.\n3. Goreng hingga kuning keemasan.\n4. Sajikan hangat.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/singkong-goreng.jpg',
                'other_attributes' => ['prep_time' => 10, 'cook_time' => 20, 'servings' => 3, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ],
            [
                'title' => 'Ubi Goreng',
                'description' => 'Ubi goreng manis alami dengan tekstur lembut dan aroma khas.',
                'ingredients' => "500g ubi jalar\nMinyak goreng secukupnya",
                'steps' => "1. Kupas dan potong ubi.\n2. Panaskan minyak.\n3. Goreng ubi hingga matang dan keemasan.\n4. Angkat dan sajikan.",
                'difficulty' => 'mudah',
                'hero_image' => 'recipes/ubi-goreng.jpg',
                'other_attributes' => ['prep_time' => 5, 'cook_time' => 15, 'servings' => 3, 'cuisine' => 'Indonesia'],
                'tags' => ['Cemilan', 'Tradisional', 'Vegetarian']
            ]
        ];

        foreach ($indonesianRecipes as $data) {
            $slug = \Illuminate\Support\Str::slug($data['title']);

            // Check if recipe exists
            $recipe = Recipe::where('slug', $slug)->first();

            if (!$recipe) {
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
                if (isset($data['tags']) && !empty($data['tags'])) {
                    // Get tag IDs from tag names
                    $tagIds = $tags->whereIn('name', $data['tags'])->pluck('id')->all();
                    $recipe->tags()->sync($tagIds);
                }
            }
        }
    }
}
