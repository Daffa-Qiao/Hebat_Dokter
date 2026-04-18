<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            \App\Models\User::updateOrCreate([
                'email' => $doctor['email'],
            ], [
                'name' => $doctor['name'],
                'password' => bcrypt('password'),
                'role' => 'dokter',
                'specialization' => $doctor['specialization'],
                'bio' => $doctor['bio'],
                'experience' => $doctor['experience'],
                'phone' => $doctor['phone'],
            ]);
        }

        // Seeder user role admin
        \App\Models\User::updateOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin Satu',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '081387654321',
        ]);

        // Seeder user role pasien
        \App\Models\User::updateOrCreate([
            'email' => 'pasien@example.com',
        ], [
            'name' => 'Pasien Satu',
            'password' => bcrypt('password'),
            'role' => 'pasien',
            'phone' => '081397654321',
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
            \App\Models\User::updateOrCreate([
                'email' => $patient['email'],
            ], [
                'name' => $patient['name'],
                'password' => bcrypt('password'),
                'role' => 'pasien',
                'phone' => $patient['phone'],
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
            \App\Models\Event::updateOrCreate([
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
            \App\Models\DietTip::updateOrCreate([
                'title' => $tip['title'],
            ], $tip);
        }

        $dokterUser = \App\Models\User::where('email', 'dokter@example.com')->first();
        $adminUser = \App\Models\User::where('email', 'admin@example.com')->first();

        if ($dokterUser) {
            $dokterUser->update(['specialization' => 'Gizi Klinis']);
        }

        $healthyMenus = [
            [
                'title' => 'Salad Ayam Mediterania',
                'description' => 'Paket salad rendah kalori dengan sayuran segar, ayam panggang, dan saus lemon ringan.',
                'calories' => 320,
                'category' => 'Salad',
                'specialization' => 'Umum',
                'doctor_id' => $adminUser ? null : null,
            ],
            [
                'title' => 'Nasi Merah & Sayuran Panggang',
                'description' => 'Menu seimbang dengan nasi merah, sayuran panggang, dan sumber protein rendah lemak.',
                'calories' => 420,
                'category' => 'Utama',
                'specialization' => 'Umum',
                'doctor_id' => $adminUser ? null : null,
            ],
            [
                'title' => 'Smoothie Hijau Detox',
                'description' => 'Kombinasi bayam, alpukat, yogurt rendah lemak, dan madu untuk membantu detoksifikasi dan energi.',
                'calories' => 180,
                'category' => 'Minuman',
                'specialization' => 'Gizi Klinis',
                'doctor_id' => $dokterUser ? $dokterUser->id : null,
            ],
            [
                'title' => 'Sup Kembang Kol Rempah',
                'description' => 'Sup krim kembang kol rendah kalori dengan rempah alami untuk dukungan pencernaan yang baik.',
                'calories' => 150,
                'category' => 'Sup',
                'specialization' => 'Gizi Klinis',
                'doctor_id' => $dokterUser ? $dokterUser->id : null,
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
