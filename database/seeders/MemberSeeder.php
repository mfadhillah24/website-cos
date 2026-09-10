<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\MemberStatus;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $statusMuda = MemberStatus::where('name', 'Anggota Muda')->first();
        $statusTetap = MemberStatus::where('name', 'Anggota Tetap')->first();

        // Beberapa data dummy untuk Anggota Tetap (Nanti bisa di-assign jabatan)
        $tetapMembers = [
            ['nim' => '22001', 'name' => 'Budi Santoso', 'email' => 'budi@ukmitcos.org', 'angkatan' => '2022'],
            ['nim' => '22002', 'name' => 'Andi Saputra', 'email' => 'andi@ukmitcos.org', 'angkatan' => '2022'],
            ['nim' => '22003', 'name' => 'Siti Aminah',  'email' => 'siti@ukmitcos.org', 'angkatan' => '2022'],
            ['nim' => '22004', 'name' => 'Doni Kusuma',  'email' => 'doni@ukmitcos.org', 'angkatan' => '2022'],
            ['nim' => '22005', 'name' => 'Rina Melati',  'email' => 'rina@ukmitcos.org', 'angkatan' => '2022'],
        ];

        foreach ($tetapMembers as $data) {
            Member::firstOrCreate(
                ['nim' => $data['nim']],
                [
                    'status_id' => $statusTetap->id,
                    'name'      => $data['name'],
                    'email'     => $data['email'],
                    'angkatan'  => $data['angkatan'],
                ]
            );
        }

        // Data dummy Anggota Muda
        $mudaMembers = [
            ['nim' => '23001', 'name' => 'Reza Pahlevi', 'email' => 'reza@mhs.unitama.ac.id', 'angkatan' => '2023'],
            ['nim' => '23002', 'name' => 'Kirana Laras', 'email' => 'kirana@mhs.unitama.ac.id', 'angkatan' => '2023'],
        ];

        foreach ($mudaMembers as $data) {
            Member::firstOrCreate(
                ['nim' => $data['nim']],
                [
                    'status_id' => $statusMuda->id,
                    'name'      => $data['name'],
                    'email'     => $data['email'],
                    'angkatan'  => $data['angkatan'],
                ]
            );
        }

        $this->command->info('✅ Dummy members seeded.');
    }
}
