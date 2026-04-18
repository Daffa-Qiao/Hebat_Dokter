<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            // Kardiologi — dr. Budi Santoso (dokter2) — Penyakit: Jantung
            [
                'doctor_email'   => 'dokter2@example.com',
                'specialization' => 'Jantung',
                'title'          => 'Menjaga Kesehatan Jantung dengan Pola Makan Sehat',
                'content'        => "Penyakit jantung adalah penyebab kematian terbesar di dunia. Dengan perubahan pola makan dan gaya hidup yang tepat, risiko tersebut dapat dikurangi secara signifikan.\n\nKonsumsi ikan berlemak (salmon, tuna) minimal dua kali seminggu untuk omega-3. Perbanyak sayuran berdaun hijau dan biji-bijian utuh. Batasi garam hingga kurang dari 2.300 mg per hari. Hindari lemak jenuh dan lemak trans dari makanan olahan. Olahraga aerobik 30 menit per hari dan berhenti merokok adalah kunci utama.",
                'published'      => true,
            ],
            [
                'doctor_email'   => 'dokter2@example.com',
                'specialization' => 'Jantung',
                'title'          => 'Mengenali Tanda Awal Penyakit Jantung yang Sering Diabaikan',
                'content'        => "Banyak orang tidak menyadari masalah jantung karena gejalanya sering tersamar.\n\nGejala yang perlu diwaspadai: (1) Nyeri atau rasa tidak nyaman di dada saat beraktivitas. (2) Sesak napas saat aktivitas ringan. (3) Kelelahan tidak biasa. (4) Detak jantung tidak teratur. (5) Pembengkakan pada kaki atau pergelangan kaki.\n\nSegera konsultasikan ke dokter jika mengalami gejala di atas. Pemeriksaan EKG, tes darah, dan ekokardiografi dapat mendeteksi masalah jantung lebih awal.",
                'published'      => true,
            ],

            // Gastroenterologi — dr. Ahmad Fauzi (dokter) — Penyakit: Pencernaan
            [
                'doctor_email'   => 'dokter@example.com',
                'specialization' => 'Pencernaan',
                'title'          => 'Menjaga Kesehatan Saluran Pencernaan dengan Pola Makan Tepat',
                'content'        => "Sekitar 70% sistem imun kita berada di usus, sehingga menjaga kesehatan pencernaan berarti menjaga kesehatan tubuh secara umum.\n\nKonsumsi serat minimal 25-30 gram per hari dari sayuran, buah, dan biji-bijian. Probiotik (yogurt, kefir, tempe, kimchi) membantu menjaga keseimbangan bakteri usus. Prebiotik (pisang, bawang putih, asparagus) memberi makan bakteri baik.\n\nKebiasaan penting: makan perlahan, jangan berbaring setelah makan, minum cukup air, dan batasi makanan pedas jika ada masalah pencernaan.",
                'published'      => true,
            ],
            [
                'doctor_email'   => 'dokter@example.com',
                'specialization' => 'Pencernaan',
                'title'          => 'Mengatasi Maag Kronis: Penyebab, Pencegahan, dan Diet yang Tepat',
                'content'        => "Gastritis kronik adalah peradangan pada dinding lambung yang berlangsung lama.\n\nPenyebab utama: infeksi bakteri Helicobacter pylori, penggunaan NSAID jangka panjang, konsumsi alkohol berlebihan, dan stres tinggi.\n\nMakanan yang dianjurkan: nasi lunak, roti putih, pisang, apel, kentang rebus, ayam tanpa kulit, ikan kukus, yogurt rendah lemak.\n\nMakanan yang dihindari: makanan pedas dan asam, kopi, teh pekat, soda, makanan berlemak tinggi, cokelat.\n\nMakan dengan porsi kecil 5-6 kali sehari dan hindari makan larut malam.",
                'published'      => true,
            ],

            // Nefrologi — dr. Dedi Wahyono (dokter4) — Penyakit: Ginjal
            [
                'doctor_email'   => 'dokter4@example.com',
                'specialization' => 'Ginjal',
                'title'          => 'Diet Ramah Ginjal: Panduan untuk Penderita Penyakit Ginjal Kronik',
                'content'        => "Penyakit Ginjal Kronik (PGK) memerlukan pengaturan diet ketat karena ginjal yang melemah tidak mampu menyaring zat sisa metabolisme secara optimal.\n\nBatasi natrium kurang dari 2.000 mg per hari. Pada stadium lanjut, batasi kalium (pisang, jeruk, alpukat) dan fosfor (susu, kacang-kacangan, soda). Asupan protein disesuaikan dengan stadium PGK.\n\nSetiap pasien PGK memiliki kebutuhan diet berbeda. Selalu konsultasikan rencana diet dengan dokter nefrologi Anda.",
                'published'      => true,
            ],
            [
                'doctor_email'   => 'dokter4@example.com',
                'specialization' => 'Ginjal',
                'title'          => 'Mencegah Batu Ginjal dengan Perubahan Gaya Hidup',
                'content'        => "Batu ginjal dapat dicegah dengan perubahan gaya hidup sederhana.\n\nFaktor risiko: kurang minum air, diet tinggi protein hewani dan garam, obesitas, riwayat keluarga.\n\nPencegahan: minum minimal 2,5-3 liter air per hari, batasi garam, batasi protein hewani berlebih. Jangan menghindari kalsium dari makanan karena justru membantu mencegah batu oksalat.\n\nJika pernah mengalami batu ginjal, konsultasikan dengan dokter nefrologi untuk rencana pencegahan personal.",
                'published'      => true,
            ],

            // Pediatri — dr. Citra Dewi (dokter3) — Penyakit: Anak
            [
                'doctor_email'   => 'dokter3@example.com',
                'specialization' => 'Anak',
                'title'          => 'Nutrisi Penting untuk Tumbuh Kembang Anak Optimal',
                'content'        => "Masa pertumbuhan anak membutuhkan asupan nutrisi lengkap. Kekurangan nutrisi dapat berdampak jangka panjang pada kesehatan fisik dan kognitif anak.\n\nNutrisi kritis: Protein untuk otot dan hormon (telur, ikan, tahu, tempe). Kalsium dan Vitamin D untuk tulang kuat (susu, yogurt). Zat Besi mencegah anemia (hati ayam, bayam, kacang merah). Omega-3 untuk otak (salmon, sarden).\n\nTip mengatasi anak susah makan: sajikan makanan menarik, libatkan anak dalam memilih menu, ciptakan suasana makan yang menyenangkan.",
                'published'      => true,
            ],

            // Pulmonologi — dr. Eka Rahmawati (dokter5) — Penyakit: Paru-paru
            [
                'doctor_email'   => 'dokter5@example.com',
                'specialization' => 'Paru-paru',
                'title'          => 'Kesehatan Paru-paru: Cara Menjaga Fungsi Pernapasan Tetap Optimal',
                'content'        => "Polusi udara, merokok, dan infeksi berulang dapat merusak paru-paru secara perlahan.\n\nAncaman utama: rokok (penyebab PPOK dan kanker paru), polusi udara (PM2.5), pneumonia dan TBC.\n\nCara menjaga: berhenti merokok (dalam 2 minggu kapasitas paru meningkat), olahraga aerobik rutin, perbaiki kualitas udara dalam ruangan dengan tanaman hias, latihan pernapasan diafragma, vaksin influenza dan pneumonia.\n\nPeriksa kesehatan paru secara rutin terutama jika Anda merokok.",
                'published'      => true,
            ],

            // Dermatologi — dr. Fajar Nugroho (dokter6) — Penyakit: Kulit
            [
                'doctor_email'   => 'dokter6@example.com',
                'specialization' => 'Kulit',
                'title'          => 'Merawat Kulit Sehat dari Dalam: Nutrisi dan Gaya Hidup',
                'content'        => "Kesehatan kulit sangat dipengaruhi oleh nutrisi yang masuk ke dalam tubuh.\n\nNutrisi penting: Vitamin C untuk kolagen (jeruk, paprika, brokoli). Vitamin E melindungi sel kulit (almond, alpukat). Zinc mengurangi peradangan jerawat (biji labu, kacang mede). Omega-3 menjaga kelembaban kulit (salmon, biji chia).\n\nKebiasaan yang merusak kulit: merokok, kurang tidur, dehidrasi, dan terlalu sering mencuci muka dengan sabun keras.\n\nSelalu gunakan tabir surya SPF 30+ setiap hari. Tidur cukup 7-8 jam untuk regenerasi kulit optimal.",
                'published'      => true,
            ],

            // Neurologi — dr. Gita Permana (dokter7) — Penyakit: Saraf
            [
                'doctor_email'   => 'dokter7@example.com',
                'specialization' => 'Saraf',
                'title'          => 'Mengenal Stroke: Gejala, Pencegahan, dan Pertolongan Pertama',
                'content'        => "Stroke adalah kondisi darurat medis ketika aliran darah ke otak terhenti tiba-tiba.\n\nKenali gejala dengan FAST: Face (wajah turun sebelah), Arms (lengan lemah), Speech (bicara pelo), Time (segera ke IGD).\n\nFaktor risiko: hipertensi, diabetes, kolesterol tinggi, merokok, obesitas.\n\nPencegahan: kontrol tekanan darah rutin (target di bawah 130/80 mmHg), berhenti merokok, olahraga 30 menit 5 kali seminggu, diet rendah garam dan lemak jenuh.\n\nJangan abaikan TIA (mini stroke) - ini tanda peringatan serius.",
                'published'      => true,
            ],
            [
                'doctor_email'   => 'dokter7@example.com',
                'specialization' => 'Saraf',
                'title'          => 'Mengatasi Migrain: Pemicu, Pengobatan, dan Gaya Hidup Sehat',
                'content'        => "Migrain adalah kondisi neurologis dengan nyeri berdenyut yang bisa berlangsung 4-72 jam.\n\nGejala khas: nyeri berdenyut di satu sisi kepala, mual, sangat sensitif terhadap cahaya dan suara, kadang disertai aura.\n\nPemicu umum: kurang tidur, stres, perubahan hormon, makanan tertentu (cokelat, keju tua, MSG, alkohol), dehidrasi.\n\nStrategi pengelolaan: buat migrain diary, tidur teratur 7-8 jam, kelola stres dengan meditasi atau yoga.\n\nKonsultasikan ke dokter saraf jika migrain terjadi lebih dari 4 kali per bulan.",
                'published'      => true,
            ],

            // Umum — dr. Hendra Kusuma (dokter8) — Penyakit: Umum
            [
                'doctor_email'   => 'dokter8@example.com',
                'specialization' => 'Umum',
                'title'          => 'Panduan Pemeriksaan Kesehatan Rutin yang Wajib Dilakukan Setiap Tahun',
                'content'        => "Pemeriksaan kesehatan rutin adalah investasi terbaik. Banyak penyakit serius dapat dicegah jika terdeteksi lebih awal.\n\nPemeriksaan dasar yang direkomendasikan: Tekanan Darah (minimal setahun sekali sejak usia 18 tahun). Gula Darah Puasa (mulai usia 35 tahun). Profil Lipid/Kolesterol (mulai usia 20 tahun). Fungsi Ginjal dan Hati.\n\nPemeriksaan tambahan: wanita di atas 40 tahun (mamografi, pap smear), pria di atas 50 tahun (PSA prostat), semua di atas 50 tahun (kolonoskopi).\n\nJangan tunda pemeriksaan meski merasa sehat!",
                'published'      => true,
            ],

            // Artikel dari Admin — Umum
            [
                'doctor_email'   => 'admin@example.com',
                'specialization' => 'Umum',
                'title'          => 'Tips Hidup Sehat di Era Digital: Kurangi Waktu Layar, Tingkatkan Kualitas Hidup',
                'content'        => "Rata-rata kita menghabiskan 6-10 jam per hari menatap layar. Paparan layar berlebih berdampak nyata pada kesehatan fisik dan mental.\n\nDampak: mata lelah, gangguan tidur (cahaya biru menghambat melatonin), nyeri leher dan punggung, serta kecemasan dari media sosial.\n\nStrategi: (1) Aturan 20-20-20: setiap 20 menit, lihat objek sejauh 20 kaki selama 20 detik. (2) No-phone zone di kamar tidur. (3) Digital sunset 1 jam sebelum tidur. (4) Matikan notifikasi tidak penting. (5) Ganti waktu scrolling dengan aktivitas fisik.",
                'published'      => true,
            ],
        ];

        foreach ($articles as $data) {
            $author = User::where('email', $data['doctor_email'])->first();
            if (!$author) continue;

            Article::updateOrCreate(
                ['title' => $data['title']],
                [
                    'user_id'        => $author->id,
                    'specialization' => $data['specialization'],
                    'content'        => $data['content'],
                    'thumbnail'      => null,
                    'published'      => $data['published'],
                ]
            );
        }
    }
}
