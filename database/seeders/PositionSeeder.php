<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            ['name' => 'Ketua Umum',                         'slug' => 'ketua',                           'order' => 1,  'description' => 'Pimpinan tertinggi organisasi UKM-IT COS.'],
            ['name' => 'Sekretaris',                      'slug' => 'sekretaris',                      'order' => 2,  'description' => 'Bertanggung jawab atas administrasi dan kesekretariatan.'],
            ['name' => 'Bendahara',                       'slug' => 'bendahara',                       'order' => 3,  'description' => 'Bertanggung jawab atas pengelolaan keuangan organisasi.'],
            ['name' => 'Kabid Networking',                'slug' => 'kabid-networking',                'order' => 4,  'description' => 'Kepala bidang yang mengelola jaringan dan infrastruktur.'],
            ['name' => 'Kabid Programming',               'slug' => 'kabid-programming',               'order' => 5,  'description' => 'Kepala bidang yang mengelola pengembangan software dan coding.'],
            ['name' => 'Kabid Desain Komunikasi Visual',  'slug' => 'kabid-dkv',                       'order' => 6,  'description' => 'Kepala bidang yang mengelola desain komunikasi visual.'],
            ['name' => 'Humas',                           'slug' => 'humas',                           'order' => 7,  'description' => 'Bertanggung jawab atas hubungan masyarakat dan komunikasi eksternal.'],
            ['name' => 'Anggota Bidang Networking',       'slug' => 'anggota-bidang-networking',       'order' => 8,  'description' => 'Pengurus anggota bidang Networking di bawah Kabid Networking.'],
            ['name' => 'Anggota Bidang Programming',      'slug' => 'anggota-bidang-programming',      'order' => 9,  'description' => 'Pengurus anggota bidang Programming di bawah Kabid Programming.'],
            ['name' => 'Anggota Bidang DKV',              'slug' => 'anggota-bidang-dkv',              'order' => 10, 'description' => 'Pengurus anggota bidang Desain Komunikasi Visual di bawah Kabid DKV.'],
            ['name' => 'Anggota Humas',                   'slug' => 'anggota-humas',                   'order' => 11, 'description' => 'Pengurus divisi Humas yang membantu tugas Hubungan Masyarakat.'],
        ];

        foreach ($positions as $pos) {
            Position::firstOrCreate(['slug' => $pos['slug']], $pos);
        }

        $this->command->info('✅ PositionSeeder: ' . count($positions) . ' jabatan seeded.');
    }
}
