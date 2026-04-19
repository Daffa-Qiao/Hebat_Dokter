<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Event;
use App\Models\DietTip;
use App\Models\HealthyMenu;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seeder user role dokter
        \App\Models\User::updateOrCreate([
            'email' => 'dokter@example.com',
        ], [
            'name' => 'dr. Ahmad Fauzi, Sp.PD-KGH',
            'password' => bcrypt('password'),
            'role' => 'dokter',
            'specialization' => 'Gastroenterologi',
            'bio' => 'Spesialis Penyakit Dalam Konsultan Gastroenterologi-Hepatologi lulusan Universitas Indonesia. Ahli dalam penanganan gangguan saluran pencernaan, maag kronis, hepatitis, dan sindrom iritasi usus besar.',
            'experience' => '10 tahun menangani kasus gastroenterologi dan penyakit hati di rumah sakit tersier.',
            'phone' => '081234567890',
            'email_verified_at' => now(),
        ]);

        // Seeder dokter tambahan
        $additionalDoctors = [
            [
                'name' => 'dr. Budi Santoso, Sp.JP',
                'email' => 'dokter2@example.com',
                'specialization' => 'Kardiologi',
                'bio' => 'Spesialis Jantung dan Pembuluh Darah lulusan Universitas Gadjah Mada. Berpengalaman menangani penyakit jantung koroner, gagal jantung, dan aritmia. Aktif dalam program pencegahan penyakit kardiovaskular.',
                'experience' => '8 tahun berpraktik di RS rujukan jantung nasional.',
                'phone' => '081298765432',
            ],
            [
                'name' => 'dr. Citra Dewi, Sp.A',
                'email' => 'dokter3@example.com',
                'specialization' => 'Pediatri',
                'bio' => 'Spesialis Anak lulusan Universitas Airlangga. Fokus pada tumbuh kembang anak, gizi pediatri, dan imunisasi. Berpengalaman menangani kasus malnutrisi dan gangguan pertumbuhan pada anak usia dini.',
                'experience' => '7 tahun pengalaman di klinik dan rumah sakit anak.',
                'phone' => '081255512345',
            ],
            [
                'name' => 'dr. Dedi Wahyono, Sp.PD-KGK',
                'email' => 'dokter4@example.com',
                'specialization' => 'Nefrologi',
                'bio' => 'Spesialis Penyakit Dalam Konsultan Ginjal-Hipertensi lulusan Universitas Padjadjaran. Ahli dalam penanganan penyakit ginjal kronik, batu ginjal, dan hipertensi nefrosklerosis. Aktif dalam program terapi hemodialisis.',
                'experience' => '9 tahun menangani kasus ginjal dan hipertensi di rumah sakit tersier.',
                'phone' => '081266612345',
            ],
            [
                'name' => 'dr. Eka Rahmawati, Sp.P',
                'email' => 'dokter5@example.com',
                'specialization' => 'Pulmonologi',
                'bio' => 'Spesialis Paru lulusan Universitas Diponegoro. Berpengalaman menangani PPOK, asma, TB paru, dan pneumonia. Aktif dalam program berhenti merokok dan edukasi kesehatan paru di masyarakat.',
                'experience' => '6 tahun di bidang penyakit paru dan pernapasan.',
                'phone' => '081277712345',
            ],
            [
                'name' => 'dr. Fajar Nugroho, Sp.KK',
                'email' => 'dokter6@example.com',
                'specialization' => 'Dermatologi',
                'bio' => 'Spesialis Kulit dan Kelamin lulusan Universitas Brawijaya. Berpengalaman menangani dermatitis, psoriasis, infeksi kulit, dan masalah estetika dermatologi. Konsultan kesehatan kulit berbasis nutrisi dan gaya hidup.',
                'experience' => '5 tahun menangani penyakit kulit umum dan estetika medis.',
                'phone' => '081288812345',
            ],
            [
                'name' => 'dr. Gita Permana, Sp.S',
                'email' => 'dokter7@example.com',
                'specialization' => 'Neurologi',
                'bio' => 'Spesialis Saraf lulusan Universitas Hasanuddin. Berpengalaman menangani stroke, migrain kronis, epilepsi, dan penyakit Parkinson. Aktif dalam edukasi pencegahan stroke dan kesehatan otak di masyarakat.',
                'experience' => '8 tahun di bidang neurologi klinis dan rehabilitasi saraf.',
                'phone' => '081299912345',
            ],
            [
                'name' => 'dr. Hendra Kusuma, Sp.U',
                'email' => 'dokter8@example.com',
                'specialization' => 'Umum',
                'bio' => 'Dokter Umum lulusan Universitas Sebelas Maret. Berpengalaman menangani berbagai keluhan kesehatan umum, pemeriksaan rutin, dan promotif preventif kesehatan keluarga. Siap melayani pasien dari semua kalangan.',
                'experience' => '5 tahun sebagai dokter umum praktik mandiri dan klinik.',
                'phone' => '081311112345',
            ],
        ];

        foreach ($additionalDoctors as $doctor) {
            User::updateOrCreate([
                'email' => $doctor['email'],
            ], [
                'name' => $doctor['name'],
                'password' => bcrypt('password'),
                'role' => 'dokter',
                'specialization' => $doctor['specialization'],
                'bio' => $doctor['bio'],
                'experience' => $doctor['experience'],
                'phone' => $doctor['phone'],
                'email_verified_at' => now(),
            ]);
        }

        // Seeder user role admin
        User::updateOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin Satu',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '081387654321',
            'email_verified_at' => now(),
        ]);

        // Seeder user role pasien
        User::updateOrCreate([
            'email' => 'pasien@example.com',
        ], [
            'name' => 'Pasien Satu',
            'password' => bcrypt('password'),
            'role' => 'pasien',
            'phone' => '081397654321',
            'email_verified_at' => now(),
        ]);

        $additionalPatients = [
            [
                'name' => 'Pasien Dua',
                'email' => 'pasien2@example.com',
                'phone' => '081445566778',
            ],
            [
                'name' => 'Pasien Tiga',
                'email' => 'pasien3@example.com',
                'phone' => '081433322110',
            ],
            [
                'name' => 'Pasien Empat',
                'email' => 'pasien4@example.com',
                'phone' => '081466677889',
            ],
        ];

        foreach ($additionalPatients as $patient) {
            User::updateOrCreate([
                'email' => $patient['email'],
            ], [
                'name' => $patient['name'],
                'password' => bcrypt('password'),
                'role' => 'pasien',
                'phone' => $patient['phone'],
                'email_verified_at' => now(),
            ]);
        }

        // Contoh data event
        $events = [
            [
                'title' => 'Senam Pagi Bersama',
                'location' => 'Taman Bungkul, Surabaya',
                'date' => '2024-04-28',
                'time' => '06:00:00',
                'description' => 'Senam aerobik dan zumba bersama instruktur profesional untuk memulai hari dengan semangat.',
            ],
            [
                'title' => 'Seminar Diet Sehat',
                'location' => 'Hotel Shangri-La, Surabaya',
                'date' => '2024-05-04',
                'time' => '13:00:00',
                'description' => 'Pelajari cara diet yang benar dan sehat dari pakar nutrisi terkemuka.',
            ],
            [
                'title' => 'Yoga untuk Pemula',
                'location' => 'Taman Prestasi, Surabaya',
                'date' => '2024-05-12',
                'time' => '07:00:00',
                'description' => 'Kelas yoga dasar untuk pemula dengan instruktur berpengalaman.',
            ],
        ];

        foreach ($events as $event) {
            Event::updateOrCreate([
                'title' => $event['title'],
                'date' => $event['date'],
            ], $event);
        }

        // Contoh data tips diet
        $dietTips = [
            [
                'title' => 'Intermittent Fasting Dasar',
                'video_url' => 'https://www.youtube.com/embed/SsUmvFydj68',
                'source_url' => 'https://www.youtube.com/watch?v=SsUmvFydj68',
                'description' => 'Pelajari prinsip dasar intermittent fasting untuk membantu manajemen berat badan dengan cara aman.',
            ],
            [
                'title' => 'Diet Seimbang Tanpa Kelaparan',
                'video_url' => 'https://www.youtube.com/embed/K6spoYJvr50',
                'source_url' => 'https://www.youtube.com/watch?v=K6spoYJvr50',
                'description' => 'Tips memilih menu sehat dan seimbang agar diet tetap nyaman dan tanpa kelaparan.',
            ],
            [
                'title' => '5 Langkah Turun Berat Badan',
                'video_url' => 'https://www.youtube.com/embed/rsZqOh6fR20',
                'source_url' => 'https://www.youtube.com/watch?v=rsZqOh6fR20',
                'description' => 'Langkah praktis menurunkan berat badan dalam 1 minggu dengan pola makan dan aktivitas yang benar.',
            ],
        ];

        foreach ($dietTips as $tip) {
            DietTip::updateOrCreate([
                'title' => $tip['title'],
            ], $tip);
        }

        $dokterUser = User::where('email', 'dokter@example.com')->first();
        $adminUser = User::where('email', 'admin@example.com')->first();

        if ($dokterUser) {
            $dokterUser->update(['specialization' => 'Gizi Klinis']);
        }

        $healthyMenus = [
            [
                'title'          => 'Salad Ayam Mediterania',
                'description'    => 'Salad segar kaya protein dengan ayam panggang, sayuran berwarna, zaitun, dan saus lemon-minyak zaitun. Rendah kalori, tinggi serat, dan memuaskan.',
                'calories'       => 320,
                'category'       => 'Salad',
                'specialization' => 'Umum',
                'image'          => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=600&q=80',
                'recipe'         => "Bahan:\n- 150 g dada ayam tanpa kulit\n- 2 genggam selada romaine\n- 10 buah tomat ceri, belah dua\n- ½ mentimun, potong dadu\n- 50 g zaitun hitam\n- 30 g keju feta (opsional)\n\nSaus:\n- 2 sdm minyak zaitun extra virgin\n- 1 sdm perasan lemon\n- ½ sdt oregano kering\n- Garam & merica secukupnya\n\nCara Membuat:\n1. Lumuri ayam dengan minyak zaitun, garam, dan merica. Panggang 15–18 menit hingga matang. Istirahatkan 5 menit, lalu iris.\n2. Campur semua bahan saus dalam mangkuk kecil.\n3. Tata selada, tomat, mentimun, dan zaitun di piring.\n4. Letakkan irisan ayam di atas sayuran.\n5. Siramkan saus dan tabur keju feta. Sajikan segera.",
                'doctor_id'      => null,
            ],
            [
                'title'          => 'Nasi Merah & Sayuran Panggang',
                'description'    => 'Menu makan siang seimbang dengan nasi merah berserat tinggi, sayuran panggang aneka warna, dan tahu bumbu kecap. Kaya serat, vitamin, dan antioksidan.',
                'calories'       => 420,
                'category'       => 'Utama',
                'specialization' => 'Umum',
                'image'          => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=600&q=80',
                'recipe'         => "Bahan:\n- 150 g nasi merah (dari 80 g beras merah)\n- 200 g campuran paprika merah & kuning, potong kotak\n- 150 g brokoli, potong floret\n- 100 g tahu, potong dadu\n- 1 sdm kecap asin rendah natrium\n- 1 sdm minyak zaitun\n- ½ sdt bawang putih bubuk\n- Garam & merica secukupnya\n\nCara Membuat:\n1. Masak nasi merah sesuai petunjuk (rasio 1:2 dengan air, masak ±40 menit).\n2. Campur sayuran dan tahu dengan minyak zaitun, kecap, bawang putih, garam, dan merica.\n3. Panggang dalam oven 200°C selama 20–25 menit, aduk sekali di tengah waktu, hingga sayuran sedikit karamelisasi.\n4. Sajikan sayuran panggang di atas nasi merah.",
                'doctor_id'      => null,
            ],
            [
                'title'          => 'Smoothie Hijau Detox',
                'description'    => 'Minuman bergizi padat dari bayam segar, alpukat, pisang, dan yogurt. Kaya serat, lemak sehat, dan probiotik untuk membantu detoksifikasi alami tubuh.',
                'calories'       => 180,
                'category'       => 'Minuman',
                'specialization' => 'Gizi Klinis',
                'image'          => 'https://images.unsplash.com/photo-1610970881699-44a5587cabec?w=600&q=80',
                'recipe'         => "Bahan:\n- 2 genggam bayam segar\n- ½ buah alpukat matang\n- 1 buah pisang beku\n- 150 ml yogurt plain tanpa lemak\n- 100 ml air kelapa\n- 1 sdt madu (opsional)\n- 3–4 es batu\n\nCara Membuat:\n1. Masukkan semua bahan ke dalam blender.\n2. Blender dengan kecepatan tinggi selama 60 detik hingga benar-benar halus.\n3. Cicipi dan tambahkan madu jika kurang manis.\n4. Tuang ke dalam gelas dan konsumsi segera untuk nutrisi optimal.\n\nTip: Bekukan bayam sebelumnya agar smoothie lebih dingin dan segar.",
                'doctor_id'      => null,
            ],
            [
                'title'          => 'Sup Kembang Kol Rempah',
                'description'    => 'Sup krim kembang kol rendah kalori dengan kunyit dan jahe untuk mendukung pencernaan dan mengurangi peradangan. Hangat, mengenyangkan, dan bebas gluten.',
                'calories'       => 150,
                'category'       => 'Sup',
                'specialization' => 'Gizi Klinis',
                'image'          => 'https://images.unsplash.com/photo-1547592180-85f173990554?w=600&q=80',
                'recipe'         => "Bahan:\n- 1 kepala kembang kol (±500 g), potong floret\n- 1 bawang bombay, cincang\n- 3 siung bawang putih\n- 1 sdt kunyit bubuk\n- ½ sdt jahe bubuk\n- ½ sdt jintan bubuk\n- 700 ml kaldu sayuran\n- 100 ml santan light\n- 1 sdm minyak zaitun\n- Garam & merica secukupnya\n\nCara Membuat:\n1. Panaskan minyak zaitun di panci, tumis bawang bombay 5 menit hingga lunak.\n2. Tambahkan bawang putih, kunyit, jahe, dan jintan. Tumis 1 menit hingga harum.\n3. Masukkan kembang kol dan kaldu sayuran. Didihkan, kecilkan api, masak 15 menit.\n4. Blender hingga halus menggunakan blender tangan.\n5. Tambahkan santan light, panaskan kembali tanpa mendidih. Koreksi rasa.",
                'doctor_id'      => null,
            ],
            [
                'title'          => 'Overnight Oats Buah Segar',
                'description'    => 'Sarapan praktis tinggi serat dan protein dengan oat, susu almond, chia seed, dan buah segar. Siapkan malam hari, siap dimakan pagi tanpa memasak.',
                'calories'       => 290,
                'category'       => 'Sarapan',
                'specialization' => 'Umum',
                'image'          => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=600&q=80',
                'recipe'         => "Bahan:\n- 50 g oat gulung (rolled oats)\n- 200 ml susu almond tanpa gula\n- 1 sdm biji chia\n- 1 sdt madu atau sirup maple\n- ½ sdt vanila ekstrak\n- Topping: stroberi, blueberry, pisang iris, granola\n\nCara Membuat:\n1. Campur oat, susu almond, biji chia, madu, dan vanila dalam toples kaca.\n2. Aduk rata, tutup rapat.\n3. Simpan di kulkas minimal 6 jam atau semalaman.\n4. Saat akan disajikan, tambahkan topping buah segar dan granola.\n5. Tambahkan sedikit susu jika terlalu kental.",
                'doctor_id'      => null,
            ],
            [
                'title'          => 'Bowl Quinoa & Telur Rebus',
                'description'    => 'Bowl bergizi tinggi dengan quinoa kaya protein lengkap, telur rebus, edamame, dan alpukat. Cocok untuk atlet atau yang sedang membangun massa otot.',
                'calories'       => 480,
                'category'       => 'Utama',
                'specialization' => 'Umum',
                'image'          => 'https://images.unsplash.com/photo-1543339308-43e59d6b73a6?w=600&q=80',
                'recipe'         => "Bahan:\n- 80 g quinoa kering\n- 2 butir telur\n- 100 g edamame rebus\n- ½ alpukat, iris\n- 1 wortel, serut\n- Saus: 1 sdm kecap asin, 1 sdt minyak wijen, ½ sdt perasan lemon, ½ sdt biji wijen\n\nCara Membuat:\n1. Masak quinoa: cuci bersih, masak dengan 160 ml air selama 15 menit hingga air terserap dan biji melengkung.\n2. Rebus telur 7 menit untuk kuning matang tapi masih lembut, kupas dan belah.\n3. Campur bahan saus dalam mangkuk kecil.\n4. Tata quinoa dalam bowl, susun telur, edamame, wortel serut, dan alpukat.\n5. Siramkan saus dan tabur biji wijen.",
                'doctor_id'      => null,
            ],
            [
                'title'          => 'Jus Bit Wortel Jahe',
                'description'    => 'Minuman anti-inflamasi dengan bit yang kaya nitrat, wortel tinggi beta-karoten, dan jahe untuk menghangatkan tubuh. Bantu meningkatkan stamina dan imunitas.',
                'calories'       => 110,
                'category'       => 'Minuman',
                'specialization' => 'Umum',
                'image'          => 'https://images.unsplash.com/photo-1622597467836-f3285f2131b8?w=600&q=80',
                'recipe'         => "Bahan:\n- 1 buah bit ukuran sedang, kupas potong\n- 2 buah wortel ukuran sedang, kupas potong\n- 2 cm jahe segar, kupas\n- 1 buah jeruk peras\n- 150 ml air matang\n- Es batu secukupnya\n\nCara Membuat:\n1. Masukkan bit, wortel, dan jahe ke dalam juicer atau blender.\n2. Tambahkan air dan proses hingga halus.\n3. Jika menggunakan blender, saring dengan kain tipis atau saringan halus.\n4. Tambahkan perasan jeruk, aduk rata.\n5. Sajikan dengan es batu. Konsumsi segera setelah dibuat.\n\nCatatan: Jus bit dapat mewarnai urine menjadi merah — ini normal dan tidak berbahaya.",
                'doctor_id'      => null,
            ],
            [
                'title'          => 'Ikan Salmon Panggang Lemon',
                'description'    => 'Fillet salmon panggang dengan saus lemon-dill, disajikan dengan asparagus dan kentang kukus. Kaya omega-3 untuk kesehatan jantung dan otak.',
                'calories'       => 380,
                'category'       => 'Utama',
                'specialization' => 'Kardiologi',
                'image'          => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?w=600&q=80',
                'recipe'         => "Bahan:\n- 150 g fillet salmon segar\n- 1 sdm minyak zaitun\n- 1 sdm perasan lemon\n- 1 siung bawang putih, parut\n- 1 sdt dill segar atau ½ sdt kering\n- 200 g asparagus\n- 150 g kentang kecil, belah dua\n- Garam & merica secukupnya\n\nCara Membuat:\n1. Panaskan oven ke 200°C.\n2. Kukus kentang 10 menit hingga setengah matang.\n3. Campur minyak zaitun, lemon, bawang putih, garam, dan merica.\n4. Olesi salmon dengan 2/3 campuran saus, biarkan marinasi 10 menit.\n5. Tata salmon, asparagus, dan kentang di loyang. Siram sisa saus.\n6. Panggang 12–15 menit hingga salmon mudah dikelupas dengan garpu.",
                'doctor_id'      => null,
            ],
        ];

        foreach ($healthyMenus as $menu) {
            HealthyMenu::updateOrCreate([
                'title' => $menu['title'],
            ], $menu);
        }

        $this->call(HealthChallengeSeeder::class);
        $this->call(ArticleSeeder::class);
    }
}
