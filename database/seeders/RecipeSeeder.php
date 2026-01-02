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
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 10, 'servings' => 4, 'cuisine' => 'Madura']
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
                'other_attributes' => ['prep_time' => 30, 'cook_time' => 13, 'servings' => 2, 'cuisine' => 'Lombok']
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
                'other_attributes' => ['prep_time' => 15, 'cook_time' => 15, 'servings' => 2, 'cuisine' => 'Lombok']
            ],
            [
                'title' => 'Beberuk Terong Lombok',
                'description' => 'hidangan sambal sayuran mentah khas Lombok, Nusa Tenggara Barat, yang biasanya disajikan sebagai pendamping ayam taliwang',
                'ingredients' => "4 terong hijau bulat\n3 lunjur kacang panjang\n1 bawang merah yang iris halus\n1 buah jeruk limo\nMinyak goreng secukupnya \n Bumbu halus :8 buah cabe merah keriting, 5 buah cabe rawit, 1 siung bawang putih, 5 siung bawang merah,  1 buah tomat, 3 cm kencur, 1 sdt terasi bakar, Secukupnya Garam dan Gula. ",
                'steps' => "Siapkan bahan-bahan yang diperlukan. Cuci terlebih dahulu bahan-bahan yang akan digunakan agar tetap  higienis dan sehat.\n Potong terong menjadi dadu atau kubus. Jangan terlalu besar atau  terlalu kecil. Jangan terlalu tebal atau  terlalu tipis. Iris terong agar tidak pahit saat dimakan\n Setelah dipotong kotak-kotak, masukkan terong ke dalam air agar tidak berubah warna.\n  Iris kacang hijau sesuai selera. Bisa sedikit tebal atau bahkan sedikit tipis, rasanya tetap enak \nCampur kacang hijau dengan terong yang direndam dalam air. Diamkan dalam air sambil membuat saus\nSiapkan lesung dan bahan untuk membuat sambal garam dan gula secukupnya, lalu giling hingga halus \nCukup tambahkan sedikit terasi dan aduk. Tambahkan  tomat dan tumbuk serta sambal cabai yang ditumbuk halus. \nSaat cabai sudah jadi, cicipi rasanya. Apakah rasanya enak atau tidak. Jika terlalu pedas tambahkan sedikit gula atau bisa juga tambahkan tomat  \nMasukkan irisan terong dan kacang hijau ke dalam cobek yang berisi sambal  \nSajikan dengan beberuq dicampur sambal ",
                'difficulty' => 'Mudah',
                'hero_image' => 'recipes/beberuk.jpg',
                'other_attributes' => ['prep_time' => 5, 'cook_time' => 12, 'servings' => 3, 'cuisine' => 'Lombok']
            ],
            [
                'title' => 'Plecing Kangkung Dompu',
                'description' => 'hidangan khas dari Dompu, Nusa Tenggara Barat, yang terkenal dengan rasa pedas dan segar',
                'ingredients' => "1 ikat kangkung\n1 bks Tauge panjang\n1 buah jeruk limau\n1 buah jeruk limo\n50 ml Air\n Bahan sambal :6 siung bawang merah, 2 siung bawang putih, seruas kencur, 1 buah tomat,  6 buah cabe merah besar, 5 buah cabe rawit merah, 1 bks terasi, 1/2 sdt garam, 1 sdt gula pasir. ",
                'steps' => "Siapkan bahan-bahan dan bumbu yang diperlukan. Cuci terlebih dahulu bahan-bahan yang akan digunakan agar tetap  higienis.\n Potong kangkung panjang - panjang, kemudian cuci bersih bersama taugenya\n Didihkan air & garam (ini agar supaya warna kangkung tetep hijau) lalu masukkan kangkung...masak sampai layu, angkat & tiriskan\n  Haluskan semua bahan sambal\nTumis bahan sambal hingga harum\nLalu tuangi sedikit air & perasan air jeruk limau... aduk rata \nSajikan kangkung & tauge rebus bersama tumisan sambal  \n campur dan siap di sajikan ",
                'difficulty' => 'Mudah',
                'hero_image' => 'recipes/plecing.jpg',
                'other_attributes' => ['prep_time' => 10 , 'cook_time' => 25, 'servings' => 2, 'cuisine' => 'Dompu NTB']
            ],
            [
                'title' => 'Ayam Rarang Lombok',
                'description' => 'Ayam Rarang menawarkan perpaduan rasa pedas, gurih, dan aromatik rempah yang kuat',
                'ingredients' => "6 potong ayam bagian paha\n Bumbu halus :10 bawang merah, 5 bawang putih, 10 cabe rawit, 3 cabe merah/keriting,  1/2 sdm terasi bakar/terasi instan, 5 butir kemiri , 1 bks terasi \nBumbu pelengkap : 1/2 sdt garam, 1 sdt gula pasir, Secukupnya penyedap. ",
                'steps' => "Siapkan dan cuci bersih semua bahan. Potong-potong ayam sesuai dengan jumlah selera.\n Ulek bumbu halus. Sisihkan. Siapkan pan utk memanggang ayam. Beri minyak goreng secukupnya, sebagai olesan di pan. Panggang ayam selama 3-4 menit atau hingga agak berwarna agak kecoklatan. Pastikan ayam dibolak-balik untuk memastikan agar tidak gosong\n Tumis bumbu halus hingga agak asat/kering. Lalu beri air secukupnya. Jika sudah mendidih, masukkan garam, gula dan penyedap serta ayam. Koreksi rasa. Jika sudah terasa pas, aduk-aduk dan diamkan hingga air agak menyusut. Terakhir, siapkan pan lagi. Olesi ayam dengan bumbu yg sudah matang, lalu panggang kembali selama 2 menit atau hingga berwarna kecoklatan.\n  Selesai dan siap disajikan.",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/ayam-rarang.jpg',
                'other_attributes' => ['prep_time' => 30 , 'cook_time' => 80, 'servings' => 4, 'cuisine' => 'Lombok']
            ],
            [
                'title' => 'Bebalung',
                'description' => 'Bebalung adalah hidangan tradisional khas suku Sasak, Lombok, Nusa Tenggara Barat, berupa sup tulang iga sapi atau kerbau.',
                'ingredients' => "1 kg tulang iga sapi\n 4 sdm air asam jawa \n50 gram daun asam jawa \n2 buah belimbing wuluh \n5 buah cabe rawit utuh \nair asam jawa secukupnya \nGaram, gula, kaldu bubuk \nBumbu Halus : 8 siung bawang merah, 4 siung bawang putih, 3 buah cabe merah, 1 ruas jahe, 1 sdt ketumbar, 1 ruas kencur \nBumbu Aromatik : 2 batang serai, 5 lembar daun salam, 3 lembar daun jeruk, 1 ruas lengkuas.  ",
                'steps' => "Cuci tulang sapi sampai bersih lalu presto sampai lunak\n Tumis bumbu halus dan masukan bumbu aromatik. Sisihkan, Setelah lapisan lemak dibuang, panaskan lagi, setelah mendidih masukan bumbu yang sudah ditumis.\n Beri garam, kaldu bubuk dan gula, Rebus sampai bumbu meresap.\n  Siap dihidangkan bersama nasi.",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/bebalung.jpg',
                'other_attributes' => ['prep_time' => 35 , 'cook_time' => 95, 'servings' => 5, 'cuisine' => 'Lombok']
            ],
            [
                'title' => 'Poteng Jaje Tujak',
                'description' => 'Poteng Jaje Tujak merupakan jajanan khas Lombok yang sering disajikan pada acara-acara keagamaan.',
                'ingredients' => "Bahan Poteng :\n 1kg beras ketan putih\n 800 ml air  \n¼ bagian ragi tape \nDaun saga \ngula secukupnya\nDaun pisang untuk membungkus \n Bahan Jaje:\n 1 kg beras ketan putih \nKelapa parut dari 1 butir kelapa + garam secukupnya. ",
                'steps' => " Berikut beberapa langkah pembuatan poteng:\nRendam beras ketan putih dalam 2 liter air selama semalam, lalu tiriskan\n Kukus beras ketan putih hingga mengeluarkan uap yang banyak, setelah itu siram menggunakan air saga 800ml\n Kemudian dikukus lagi selama kurang lebih 15 menit, angkat dan biarkan dingin.\n  Ambil ½ beras ketan putih taruh dalam wadah kemudian, lalu taburi gula dan ragi \nTutupi ketan yang sudah ditaburi ragi dengan sisa setengah ketan \nBungkus ketan dengan kain lap, kemudian tutup wadah ketan dengan rapat \nBiarkan berfermentasi selama 2-3 hari. \nSementara untuk Jaje Tujak dibuat dengan cara : \nPertama cuci beras ketan putih, dan kemudian rendam kurang lebih 2 jam \nKukus beras ketan sampai matang kira-kira 30 menit. Siram dengan air garam, lalu angkat \nCampur ketan dengan kelapa parut, aduk rata \nKukus lagi ketan yang sudah dicampur kelapa parut hingga matang sempurna \nAngkat ketan, ratakan dan haluskan panas-panas. \nBungkus jaje tujak dengan daun pisang sisihkan \n Siap disajikan ",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/poteng-jaje.jpg',
                'other_attributes' => ['prep_time' => 30 , 'cook_time' => 85, 'servings' => 6, 'cuisine' => 'Lombok']
            ],
            [
                'title' => 'Sate Bulayak',
                'description' => 'Sate khas Lombok yang disajikan dengan kuah santan kaya rasa, bukan bumbu kacang, dan dinikmati bersama lontong khas bernama "bulayak.',
                'ingredients' => "Daging sapi sepanyak 400 gram, potong bentuk dadu\n Kelapa setengah tua sebanyak 100 gram, diparut\n Kacang tanah goreng sebanyak 75 gram, ditumbuk  \nSantan kental sebanyak 200 ml \nJeruk nipis sebanyak 1 sdm \nGula merah sebanyak 2 sdm\nTusuk sate sebanyak 25 buah\n Bulayak sebanyak 10 buah\n cabe rawit merah sebanyak 12 buah \nBawang merah sebanyak 6 siung \nBawang putih sebanyak 4 siung \nMerica sebanyak 1 sdt \nGaram secukupnya ",
                'steps' => " Daging yang sudah dipotong dadu kemudian dibaluri dengan air jeruk nipis dan diamkan selama 15 menit. Setelah itu campur daging dengan setengah bumbu halus dan kasih kelapa parut, kemudian aduk dengan rata.\nTusuklah sate ke dalam tusukan sate, kemudian kukus selama 20 menit atau sampai matang.\n Siapkan alat untuk membakar, kemudian bakar sate sampai warnanya kecokelatan.\n Panaskan minyak goreng, tumis bumbu hingga halus dan hingga mengeluarkan aroma yang sedap. Kemudian masukkan kacang tanah yang sudah ditumbuk, gula merah dan santan, kemudian aduk merata hingga kental.\n  Siapkan piring dan letakkan sate bulayak diatas piring tersebut dan baluri dengan sambal kacang. \nSate bulayak siap disajikan. ",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/sate-bulayak.jpg',
                'other_attributes' => ['prep_time' => 25 , 'cook_time' => 10, 'servings' => 4, 'cuisine' => 'Lombok']
            ],
            [
                'title' => 'Nasi Cumi',
                'description' => 'Nasi Cumi adalah hidangan ikonik dari Surabaya yang menggabungkan keunikan dan kekayaan rasa laut dalam satu piring.',
                'ingredients' => "Nasi putih hangat\n Serundeng (kelapa sangrai berbumbu)\n Peyek teri  \nTelor pindang hitam \n Bahan Cumi : 250 gram cumi segar, 2 buah daun salam, 200 mL air, 6 buah cabe keriting merah, 5 buah bawang merah, 2 buah bawang putih, 1/2 buah tomat, 1/2 sdt garam , 1 sdm gula merah. ",
                'steps' => " Cuci bersih cumi tapi harus hati-hati jangan sampai tinta cumi terbung\nHaluskan cabe, bawang merah, bawang putih, tomat. Lalu tumis bumbu tersebut dan daun salam hingga matang dan harum.\n Masukan cumi, garam dan gula lalu aduk rata. Biarkan sampai tinta cumi keluar dan bumbu meresap\n Kemudian, tuang air dan masak hingga air menyusut tapi tidak sampai kering. Jangan lupa koreksi rasa terlebih dahulu\n  Siapkan piring dan letakkan sate bulayak diatas piring tersebut dan baluri dengan sambal kacang. \nTuk penyajian, siapkan nasi dalam piring. Letakan semua bahan pelengkap di sisi nasi, lalu siramkan cumi hitam di atas nasi. ",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/nasi-cumii.jpg',
                'other_attributes' => ['prep_time' => 25 , 'cook_time' => 40, 'servings' => 5, 'cuisine' => 'Surabaya']
            ],
            [
                'title' => 'Kare Ayam',
                'description' => 'Kare Ayam khas Jawa Timur dikenal dengan kuah santan berwarna kuning yang gurih, "medok" (kental dan berani bumbu), serta sedikit sentuhan manis.',
                'ingredients' => "1 kg ayam \n 15 siung bawang merah\n 8 siung bawang putih  \n4 biji cabe merah \n1 ruas jahe \n1 sdt ketumbar \n1 sdt merica (opsional)\n Bahan Pelengkap : 1 ruas lengkuas yg di geprek, 3 ruas serai, 5 helai daun jeruk, 2-2.5 bungkus santan instan kara, 1 sdm garam, 1 sdm gula, Bawang goreng utk taburan.",
                'steps' => " Ulek/blender bumbu halus. lalu, masukkan ke dalam wajan yg berisi minyak panas lalu tambahkan serai, lengkuas dan daun jeruk. tumis hingga aromanya tidak langu lagi. sisihkan.\nSiapkan panci yg berisi air. lalu, rebus ayam. masukkan juga bumbu halus yg sebelumnya sudah ditumis. rebus hingga ayam empuk dan matang. jika sudah agak mendidih, masukkan garam dan gula. cek rasa.\n Jika rasa sudah sesuai selera, kecilkan api kompor, lalu tambahkan santan. segera aduk, agar santan tidak pecah/menggumpal. jika dirasa masih kurang kental, silakan ditambah lagi yaa santannya. cek rasa kembali, jika masih kurang garam dan gula. segera tambahkan. lalu, sajikan dengan taburan bawang goreng dan perasan jeruk nipis serta sambal sebagai pelengkap.",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/karee-ayam.jpg',
                'other_attributes' => ['prep_time' => 25 , 'cook_time' => 55, 'servings' => 7, 'cuisine' => 'Jawa Timur']
            ],
            [
                'title' => 'Tahu Telur',
                'description' => 'Tahu Telur adalah kuliner khas Surabaya yang terdiri dari tahu dan telur yang digoreng bersamaan, disajikan dengan lontong, kentang goreng, tauge, kerupuk, dan disiram dengan saus kacang yang kental berbumbu petis.',
                'ingredients' => "3 buah tahu putih \n 3 butir telur ayam\n garam secukupnya  \nmerica bubuk secukupnya \nkaldu ayam bubuk \n1 batang daun bawang \nBahan Pelengkap : Secukupnya tauge, Secukupnya krupuk kanji, Secukupnya bawang goreng \nBumbu Kcang: 100 gram kacang tanah goreng / sangrai, 2 siung bawang putih, goreng, 3 cabai rawit merah, goreng (sesuai selera pedasnya).",
                'steps' => " Ulek semua bahan sambal kacang, campur dgn air matang, dan kecap aduk rata.\nPotong tahu putih kotak kecil. Kocok lepas telur, tambahkan garam dan merica, masukkan tahu.\n Buat dadar tahu telur ( jadi 2 atau 3 ). Sajikan dengan disiram sambal kacang, tauge, daun bawang dan bawang merah goreng.",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/tahu-telur.jpg',
                'other_attributes' => ['prep_time' => 20 , 'cook_time' => 30, 'servings' => 2, 'cuisine' => 'Surabaya']
            ],
            [
                'title' => 'Nasi Bebek Goreng',
                'description' => 'Nasi bebek goreng Surabaya adalah hidangan ikonik yang terdiri dari potongan bebek berbumbu rempah yang digoreng hingga garing, disajikan bersama nasi hangat, sambal pedas, dan lalapan.',
                'ingredients' => "1 ekor bebek yg dipotong \n 1 buah jeruk nipis \n 2 batang serai  \n6 lembar daun jeruk \n500 ml Air \nBumbu halus : 8 siung bawang merah, 6 siung bawang putih, 6 butir kemiri, 2 sdt ketumbar,1 1/2 ruas kunyit, 1 ruas jahe, 1 ruas lengkuas, 1/2 sdt lada bubuk, 1/2 sdt jintan, 1 batang serai, garam & royco sapi secukupnya. \nSambal Bawang: 3 siung bawang putih, 6 buah cabe merah, Secukupnya garam, Minyak panas (tuang setelah bahan diatas dihaluskan).",
                'steps' => " Lumuri potongan bebek dengan air jeruk nipis diamkan selama 30 menit di lemari es setelah itu cuci bersih. Masukan potongan bebek dengan semua bumbu halus, serai, daun jeruk dan air, rebus selama 25menit\nPisahkan potongan bebek dengan sisa bumbu hasil rebusan, kemudian goreng bebek hingga kecoklatan.\n Siapkan wajan dengan sedikit minyak, ambil secukupnya sisa bumbu hasil rebusan, masak hingga kental. Siap dihidangkan bersama bebek goreng, aku coba pake sambal matah dan sambal bawang rasanya enak .",
                'difficulty' => 'Sedang',
                'hero_image' => 'recipes/nasi-bebek.jpg',
                'other_attributes' => ['prep_time' => 25 , 'cook_time' => 35, 'servings' => 5, 'cuisine' => 'Surabaya']
            ],
            [
                'title' => 'Ote-Ote Udang',
                'description' => 'Ote-ote udang adalah varian gorengan khas Surabaya dan sekitarnya (Sidoarjo, Gresik) yang di daerah lain lebih dikenal sebagai bakwan sayur atau bala-bala.',
                'ingredients' => "1/4 kg Udang Segar \n 2 Buah Wortel \n 2 bungkus kecambah  \n4 bungkus tepung bakwan kobe \nbawang prai dan seledri secukupnya \nBumbu halus : 5 siung bawang merah, 3 siung bawang putih, 2 buah ketumbar, Garam secukupnya, merica bubuk merica.",
                'steps' => " Cuci sampai bersih udang\nHaluskan semua bumbu halus dan tambahkan sedikit air.\n Campurkan semua bahan dan cuci bersih, Masukkan bumbu halus ke adonan sayuran, kemudian tambahkan tepung bumbu serta air dan aduk adonan hingga mengental, Setelah adonan tercampur, cetak adonan dgn menggunakan sendok sayur, tambahkan udang di atasnya, Panaskan minyak di atas wajan, Goreng Adonan di atas minyak panas, gunakan api kecil agar tdk gosong, Setelah matang, angkat,tiriskan dan siap dihidangkan bersama teman atau keluarga  ",
                'difficulty' => 'Mudah',
                'hero_image' => 'recipes/ote-ote.jpg',
                'other_attributes' => ['prep_time' => 20 , 'cook_time' => 30, 'servings' => 9, 'cuisine' => 'Surabaya']
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
