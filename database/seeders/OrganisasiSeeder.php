<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organisasi')->insert([
            // UKM Data
            ['nama_organisasi' => 'UKM Basket', 'jenis_organisasi' => 'UKM', 'tautan' => 'basket.unikom.ac.id'],
            ['nama_organisasi' => 'UKM Birama', 'jenis_organisasi' => 'UKM', 'tautan' => 'persbirama.unikom.ac.id'],
            ['nama_organisasi' => 'UKM Bulu Tangkis', 'jenis_organisasi' => 'UKM', 'tautan' => 'badminton.unikom.ac.id'],
            ['nama_organisasi' => 'UKM Catur UNIKOM', 'jenis_organisasi' => 'UKM', 'tautan' => 'catur.unikom.ac.id'],
            ['nama_organisasi' => 'UKM Fotografi', 'jenis_organisasi' => 'UKM', 'tautan' => 'glosariumfoto.unikom.ac.id'],
            ['nama_organisasi' => 'UKM Futsal', 'jenis_organisasi' => 'UKM', 'tautan' => 'futsalclub.unikom.ac.id'],
            ['nama_organisasi' => 'UKM HIPMA', 'jenis_organisasi' => 'UKM', 'tautan' => 'hipma.unikom.ac.id'],
            ['nama_organisasi' => 'UKM KMK', 'jenis_organisasi' => 'UKM', 'tautan' => 'kmk.unikom.ac.id'],
            ['nama_organisasi' => 'UKM KPM', 'jenis_organisasi' => 'UKM', 'tautan' => 'kpm.unikom.ac.id'],
            ['nama_organisasi' => 'UKM KSR', 'jenis_organisasi' => 'UKM', 'tautan' => 'ksr.unikom.ac.id'],
            ['nama_organisasi' => 'UKM LDK UMMI', 'jenis_organisasi' => 'UKM', 'tautan' => 'ldkummi.unikom.ac.id'],
            ['nama_organisasi' => 'UKM Mapaligi', 'jenis_organisasi' => 'UKM', 'tautan' => 'mapaligi.unikom.ac.id'],
            ['nama_organisasi' => 'UKM Pencak Silat', 'jenis_organisasi' => 'UKM', 'tautan' => 'pencaksilat.unikom.ac.id'],
            ['nama_organisasi' => 'UKM PMK', 'jenis_organisasi' => 'UKM', 'tautan' => 'pmk.unikom.ac.id'],
            ['nama_organisasi' => 'UKM Pramuka', 'jenis_organisasi' => 'UKM', 'tautan' => 'pramuka.unikom.ac.id'],
            ['nama_organisasi' => 'UKM PSM', 'jenis_organisasi' => 'UKM', 'tautan' => 'psm.unikom.ac.id'],
            ['nama_organisasi' => 'UKM PTQ', 'jenis_organisasi' => 'UKM', 'tautan' => 'ptq.unikom.ac.id'],
            ['nama_organisasi' => 'UKM Sadaya', 'jenis_organisasi' => 'UKM', 'tautan' => 'sadaya.unikom.ac.id'],
            ['nama_organisasi' => 'UKM Sepak Bola', 'jenis_organisasi' => 'UKM', 'tautan' => 'sepakbola.unikom.ac.id'],
            ['nama_organisasi' => 'UKM Taekwondo', 'jenis_organisasi' => 'UKM', 'tautan' => 'taekwondo.unikom.ac.id'],
            ['nama_organisasi' => 'UKM Tarung Derajat', 'jenis_organisasi' => 'UKM', 'tautan' => 'tarungderajat.unikom.ac.id'],
            ['nama_organisasi' => 'UKM YES', 'jenis_organisasi' => 'UKM', 'tautan' => 'yes.unikom.ac.id'],
            // HIMA Data
            ['nama_organisasi' => 'HIMA Akuntansi', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himaak.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Arsitektur', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himars.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Desain Interior', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himadi.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Desain Komunikasi Visual', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himadkv.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Hubungan Internasional', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himahi.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Ilmu Komunikasi', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himaik.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Ilmu Politik', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himaip.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Komputerisasi Akuntansi', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himaka.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Manajemen', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himama.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Perancangan Wilayah dan Kota', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himapwk.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Sastra Inggris', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himasais.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Sastra Jepang', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himasj.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Sistem Informasi', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himasi.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Teknik Komputer', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himatekkom.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Teknik Elektro', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himael.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Teknik Industri', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himati.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Teknik Informatika', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himaif.unikom.ac.id'],
            ['nama_organisasi' => 'HIMA Teknik Sipil', 'jenis_organisasi' => 'HIMA', 'tautan' => 'himats.unikom.ac.id'],
            // BEM Data
            ['nama_organisasi' => 'BEM', 'jenis_organisasi' => 'BEM', 'tautan' => 'https://bem.unikom.ac.id/'],
        ]);
    }
}
