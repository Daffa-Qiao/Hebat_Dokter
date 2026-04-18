<?php

namespace Database\Seeders;

use App\Models\HealthChallenge;
use Illuminate\Database\Seeder;

class HealthChallengeSeeder extends Seeder
{
    public function run(): void
    {
        $challenges = [
            ['title' => 'Minum 8 Gelas Air',           'description' => 'Hidrasi yang baik menjaga energi dan pencernaan tetap optimal sepanjang hari.', 'category' => 'hidrasi',   'points' => 10],
            ['title' => 'Tambah Sayuran di Makan Siang','description' => 'Tambahkan sayuran hijau atau salad untuk meningkatkan serat dan vitamin.',       'category' => 'nutrisi',   'points' => 10],
            ['title' => 'Berjalan 20 Menit',            'description' => 'Aktivitas sederhana ini membantu sirkulasi dan membakar kalori secara alami.',   'category' => 'olahraga',  'points' => 15],
            ['title' => 'Istirahat Tanpa Gadget',       'description' => 'Berikan mata dan pikiran Anda jeda singkat dari layar setiap 2 jam.',            'category' => 'mental',    'points' => 10],
            ['title' => 'Pilih Camilan Sehat',          'description' => 'Pilih buah atau kacang sebagai camilan daripada makanan manis olahan.',          'category' => 'nutrisi',   'points' => 10],
            ['title' => 'Tarik Napas Dalam 5 Menit',   'description' => 'Latihan pernapasan membantu meredakan stres dan menenangkan sistem saraf.',      'category' => 'mental',    'points' => 5],
            ['title' => 'Tidur Teratur 7–8 Jam',        'description' => 'Jaga waktu tidur yang cukup dan teratur untuk pemulihan tubuh optimal.',        'category' => 'istirahat', 'points' => 15],
            ['title' => 'Peregangan Pagi 10 Menit',     'description' => 'Mulai hari dengan peregangan ringan untuk membangunkan otot dan sendi.',        'category' => 'olahraga',  'points' => 10],
            ['title' => 'Kurangi Gula Hari Ini',        'description' => 'Kurangi konsumsi minuman manis dan makanan ultra-proses sepanjang hari.',       'category' => 'nutrisi',   'points' => 10],
            ['title' => 'Makan Buah 2 Porsi',           'description' => 'Konsumsi minimal 2 porsi buah segar untuk antioksidan dan vitamin alami.',      'category' => 'nutrisi',   'points' => 10],
        ];

        foreach ($challenges as $c) {
            HealthChallenge::firstOrCreate(
                ['title' => $c['title']],
                array_merge($c, ['active' => true])
            );
        }
    }
}

