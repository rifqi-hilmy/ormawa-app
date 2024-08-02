<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodiData = [
            ['nama_prodi' => 'Teknik Informatika', 'fakultas' => 'Fakultas Teknik Dan Ilmu Komputer'],
            ['nama_prodi' => 'Sistem Komputer', 'fakultas' => 'Fakultas Teknik Dan Ilmu Komputer'],
            ['nama_prodi' => 'Teknik Industri', 'fakultas' => 'Fakultas Teknik Dan Ilmu Komputer'],
            ['nama_prodi' => 'Teknik Arsitektur', 'fakultas' => 'Fakultas Teknik Dan Ilmu Komputer'],
            ['nama_prodi' => 'Sistem Informasi', 'fakultas' => 'Fakultas Teknik Dan Ilmu Komputer'],
            ['nama_prodi' => 'Perencanaan Wilayah Dan Kota', 'fakultas' => 'Fakultas Teknik Dan Ilmu Komputer'],
            ['nama_prodi' => 'Teknik Komputer', 'fakultas' => 'Fakultas Teknik Dan Ilmu Komputer'],
            ['nama_prodi' => 'Manajemen Informatika', 'fakultas' => 'Fakultas Teknik Dan Ilmu Komputer'],
            ['nama_prodi' => 'Komputerisasi Akuntansi', 'fakultas' => 'Fakultas Teknik Dan Ilmu Komputer'],
            ['nama_prodi' => 'Teknik Sipil', 'fakultas' => 'Fakultas Teknik Dan Ilmu Komputer'],
            ['nama_prodi' => 'Teknik Elektro', 'fakultas' => 'Fakultas Teknik Dan Ilmu Komputer'],
            ['nama_prodi' => 'Akuntansi', 'fakultas' => 'Fakultas Ekonomi dan Bisnis'],
            ['nama_prodi' => 'Manajemen', 'fakultas' => 'Fakultas Ekonomi dan Bisnis'],
            ['nama_prodi' => 'Akuntansi (D3)', 'fakultas' => 'Fakultas Ekonomi dan Bisnis'],
            ['nama_prodi' => 'Keuangan dan Perbankan', 'fakultas' => 'Fakultas Ekonomi dan Bisnis'],
            ['nama_prodi' => 'Manajemen Pemasaran', 'fakultas' => 'Fakultas Ekonomi dan Bisnis'],
            ['nama_prodi' => 'Ilmu Hukum', 'fakultas' => 'Fakultas Hukum'],
            ['nama_prodi' => 'Ilmu Pemerintahan', 'fakultas' => 'Fakultas Ilmu Sosial Dan Ilmu Politik'],
            ['nama_prodi' => 'Ilmu Komunikasi', 'fakultas' => 'Fakultas Ilmu Sosial Dan Ilmu Politik'],
            ['nama_prodi' => 'Hubungan Internasional', 'fakultas' => 'Fakultas Ilmu Sosial Dan Ilmu Politik'],
            ['nama_prodi' => 'Desain Komunikasi Visual', 'fakultas' => 'Fakultas Desain'],
            ['nama_prodi' => 'Desain Interior', 'fakultas' => 'Fakultas Desain'],
            ['nama_prodi' => 'Desain Komunikasi Visual (D3)', 'fakultas' => 'Fakultas Desain'],
            ['nama_prodi' => 'Sastra Inggris', 'fakultas' => 'Fakultas Ilmu Budaya'],
            ['nama_prodi' => 'Sastra Jepang', 'fakultas' => 'Fakultas Ilmu Budaya'],
        ];

        DB::table('prodi')->insert($prodiData);
    }
}
