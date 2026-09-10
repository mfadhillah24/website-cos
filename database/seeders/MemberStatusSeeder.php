<?php

namespace Database\Seeders;

use App\Models\MemberStatus;
use Illuminate\Database\Seeder;

class MemberStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'Anggota Muda',
                'description' => 'Anggota yang sedang mengikuti proses pembelajaran.'
            ],
            [
                'name' => 'Anggota Tetap',
                'description' => 'Anggota yang aktif dan telah lulus tahap pembelajaran.'
            ],
            [
                'name' => 'Anggota Kehormatan',
                'description' => 'Mantan pengurus yang telah demisioner.'
            ],
            [
                'name' => 'Pendiri',
                'description' => 'Pendiri UKM-IT Cyber Open Source.'
            ],
        ];

        foreach ($statuses as $status) {
            MemberStatus::firstOrCreate(['name' => $status['name']], $status);
        }

        $this->command->info('✅ Member statuses seeded.');
    }
}
