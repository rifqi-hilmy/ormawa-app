<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Insert users
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@email.test',
                'password' => bcrypt('password'),
                'roles' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $mahasiswaUserId = DB::table('users')->insertGetId([
            'name' => 'Mahasiswa User',
            'email' => 'mahasiswa@email.test',
            'password' => bcrypt('password'),
            'roles' => 'mahasiswa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mahasiswa')->insert([
            'id_user' => $mahasiswaUserId,
            'nim' => $faker->unique()->numerify('########'),
            'jenis_kelamin' => $faker->randomElement(['L', 'P']),
            'alamat' => $faker->address,
            'no_hp' => $faker->phoneNumber,
            'id_organisasi' => $faker->numberBetween(1, 41),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $dosenUserId = DB::table('users')->insertGetId([
            'name' => 'Dosen User',
            'email' => 'dosen@email.test',
            'password' => bcrypt('password'),
            'roles' => 'dosen',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('dosen')->insert([
            'id_user' => $dosenUserId,
            'nip' => $faker->unique()->numerify('##########'),
            'nidn' => $faker->unique()->numerify('##########'),
            'jenis_kelamin' => $faker->randomElement(['L', 'P']),
            'alamat' => $faker->address,
            'no_hp' => $faker->phoneNumber,
            'id_prodi' => $faker->numberBetween(1, 25),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $dirmawaUserId = DB::table('users')->insertGetId([
            'name' => 'DirMawa User',
            'email' => 'dirmawa@email.test',
            'password' => bcrypt('password'),
            'roles' => 'dirmawa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('dirmawa')->insert([
            'id_user' => $dirmawaUserId,
            'nip' => $faker->unique()->numerify('##########'),
            'nidn' => $faker->unique()->numerify('##########'),
            'jenis_kelamin' => $faker->randomElement(['L', 'P']),
            'alamat' => $faker->address,
            'no_hp' => $faker->phoneNumber,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mahasiswaEntries = [];

        for ($i = 1; $i <= 15; $i++) {
            $userId = DB::table('users')->insertGetId([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'roles' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $mahasiswaEntries[] = [
                'id_user' => $userId,
                'nim' => $faker->unique()->numerify('########'),
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'alamat' => $faker->address,
                'no_hp' => $faker->phoneNumber,
                'id_organisasi' => $faker->numberBetween(1, 41),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('mahasiswa')->insert($mahasiswaEntries);

        $dosenEntries = [];

        for ($i = 1; $i <= 15; $i++) {
            $userId = DB::table('users')->insertGetId([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'roles' => 'dosen',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $dosenEntries[] = [
                'id_user' => $userId,
                'nip' => $faker->unique()->numerify('##########'),
                'nidn' => $faker->unique()->numerify('##########'),
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'alamat' => $faker->address,
                'no_hp' => $faker->phoneNumber,
                'id_prodi' => $faker->numberBetween(1, 25),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('dosen')->insert($dosenEntries);

        $dirmawaEntries = [];

        for ($i = 1; $i <= 5; $i++) {
            $userId = DB::table('users')->insertGetId([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'roles' => 'dirmawa',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $dirmawaEntries[] = [
                'id_user' => $userId,
                'nip' => $faker->unique()->numerify('##########'),
                'nidn' => $faker->unique()->numerify('##########'),
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'alamat' => $faker->address,
                'no_hp' => $faker->phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('dirmawa')->insert($dirmawaEntries);
    }
}
