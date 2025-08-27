<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\UnitWallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'unit_name' => 'Unit 1',
                'pic_name' => 'Budi',
                'address' => 'Jl. Mawar No. 10',
                'phone' => '08123456789'
            ],
            [
                'unit_name' => 'Unit 2',
                'pic_name' => 'Siti',
                'address' => 'Jl. Anggrek No. 20',
                'phone' => '08987654321'
            ],
            [
                'unit_name' => 'Unit 3',
                'pic_name' => 'Andi',
                'address' => 'Jl. Melati No. 30',
                'phone' => '085211223344'
            ],
            [
                'unit_name' => 'Unit 4',
                'pic_name' => 'Dewi',
                'address' => 'Jl. Kenanga No. 40',
                'phone' => '087855667788'
            ],
            [
                'unit_name' => 'Unit 5',
                'pic_name' => 'Joko',
                'address' => 'Jl. Dahlia No. 50',
                'phone' => '082199887766'
            ]
        ];

        foreach ($units as $unitData) {
            $unit = Unit::create($unitData);
            UnitWallet::create([
                'unit_id' => $unit->id,
                'balance' => 0
            ]);
        }
    }
}
