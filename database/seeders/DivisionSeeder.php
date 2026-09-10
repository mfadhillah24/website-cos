<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = [
            [
                'name'        => 'Networking',
                'slug'        => 'networking',
                'description' => 'Divisi yang berfokus pada jaringan komputer, infrastruktur IT, dan keamanan siber. Mengelola program pelatihan dan kegiatan di bidang networking.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Programming',
                'slug'        => 'programming',
                'description' => 'Divisi yang berfokus pada pengembangan perangkat lunak, pemrograman, dan open source. Mengelola hackathon, workshop coding, dan proyek kolaboratif.',
                'is_active'   => true,
            ],
            [
                'name'        => 'DKV',
                'slug'        => 'dkv',
                'description' => 'Divisi Desain Komunikasi Visual yang berfokus pada konten kreatif, desain grafis, dan dokumentasi visual kegiatan organisasi.',
                'is_active'   => true,
            ],
        ];

        foreach ($divisions as $data) {
            Division::firstOrCreate(['slug' => $data['slug']], $data);
        }

        $this->command->info('✅ DivisionSeeder: Networking, Programming, DKV seeded.');
    }
}
