<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id')->all();

        $agendaEntries = [];

        for ($i = 1; $i <= 15; $i++) {
            $tglMulai = $faker->dateTimeBetween('-1 year', '+1 year');
            $tglSelesai = (clone $tglMulai)->modify('+1 day');
            $jamMulai = $faker->time('H:i');
            $jamSelesai = (new Carbon($jamMulai))->addHours(2)->format('H:i');
            $address = $faker->address;
            $shortAddress = implode(' ', array_slice(explode(' ', $address), 0, 3));

            $agendaEntries[] = [
                'nama_agenda' => $faker->sentence(3),
                'tgl_mulai' => $tglMulai,
                'tgl_selesai' => $tglSelesai,
                'tempat' => $shortAddress,
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'keterangan' => $faker->paragraph,
                'id_user' => $faker->randomElement($userIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('agenda')->insert($agendaEntries);
    }
}
