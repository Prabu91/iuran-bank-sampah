<?php

namespace Database\Seeders;

use App\Models\Peserta;
use Illuminate\Database\Seeder;

class PesertaSeeder extends Seeder
{
    public function run(): void
    {
        $kecamatanList = ['Baleendah', 'Dayeuhkolot', 'Bojongsoang'];

        for ($i = 1; $i <= 9; $i++) {
            $bulan = rand(0, 12);
            $tagihan = $bulan * 35000;

            Peserta::create([
                'nik'            => (string) fake()->unique()->numerify('################'),
                'nama'           => fake()->name(),
                'noka'           => (string) fake()->unique()->numerify('#############'),
                'no_hp'          => '08' . rand(11, 99) . rand(10000000, 99999999),
                'alamat'         => fake()->address(),
                'kecamatan'      => $kecamatanList[array_rand($kecamatanList)],
                'bln_menunggak'  => $bulan,
                'total_tagihan'  => $tagihan,
            ]);
        }
    }
}
