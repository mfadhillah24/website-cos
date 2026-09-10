<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Period;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $activePeriod = Period::where('is_active', true)->first();
        if (!$activePeriod) {
            $this->command->warn('⚠️ ProgramSeeder: Tidak ada periode aktif. Seeder dilewati.');
            return;
        }

        $superAdmin = User::whereHas('roles', fn($q) => $q->where('name', 'Super Admin'))->first();

        $networking = Division::where('slug', 'networking')->first();
        $programming = Division::where('slug', 'programming')->first();
        $dkv = Division::where('slug', 'dkv')->first();

        $programs = [
            [
                'division_id' => $networking?->id,
                'period_id'   => $activePeriod->id,
                'title'       => 'Pelatihan Dasar Jaringan',
                'description' => 'Program pelatihan dasar jaringan komputer untuk anggota baru, mencakup topologi, routing, dan konfigurasi dasar.',
                'target'      => '30 peserta, modul digital, sertifikat keikutsertaan',
                'status'      => 'planning',
                'created_by'  => $superAdmin?->id,
            ],
            [
                'division_id' => $networking?->id,
                'period_id'   => $activePeriod->id,
                'title'       => 'Workshop Keamanan Siber',
                'description' => 'Workshop pengenalan keamanan siber, ethical hacking, dan perlindungan data.',
                'target'      => '25 peserta, modul cybersecurity',
                'status'      => 'planning',
                'created_by'  => $superAdmin?->id,
            ],
            [
                'division_id' => $programming?->id,
                'period_id'   => $activePeriod->id,
                'title'       => 'Hackathon Internal',
                'description' => 'Kompetisi pemrograman internal untuk menyelesaikan permasalahan nyata kampus dalam 24 jam.',
                'target'      => '10 tim, aplikasi prototype',
                'status'      => 'planning',
                'created_by'  => $superAdmin?->id,
            ],
            [
                'division_id' => $dkv?->id,
                'period_id'   => $activePeriod->id,
                'title'       => 'Dokumentasi Kegiatan Organisasi',
                'description' => 'Mendokumentasikan seluruh kegiatan UKM-IT COS dalam bentuk foto, video, dan infografis.',
                'target'      => 'Dokumentasi 100% kegiatan, konten media sosial',
                'status'      => 'on_progress',
                'created_by'  => $superAdmin?->id,
            ],
        ];

        foreach ($programs as $data) {
            if ($data['division_id']) {
                Program::firstOrCreate(
                    ['title' => $data['title'], 'period_id' => $data['period_id']],
                    $data
                );
            }
        }

        $this->command->info('✅ ProgramSeeder: Program kerja dummy seeded.');
    }
}
