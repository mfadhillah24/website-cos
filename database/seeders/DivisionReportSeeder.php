<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\DivisionReport;
use App\Models\Period;
use App\Models\User;
use Illuminate\Database\Seeder;

class DivisionReportSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@ukmitcos.org')->first();
        $divisions = Division::all();
        $period = Period::latest()->first();

        if (!$admin || $divisions->isEmpty() || !$period) {
            $this->command->warn('⚠️ DivisionReportSeeder: Data prasyarat tidak ditemukan.');
            return;
        }

        $statuses = ['draft', 'submitted', 'approved'];

        foreach ($divisions->take(3) as $division) {
            $status = fake()->randomElement($statuses);
            DivisionReport::create([
                'division_id'  => $division->id,
                'period_id'    => $period->id,
                'author_id'    => $admin->id,
                'title'        => 'Laporan Pertanggungjawaban Divisi ' . $division->name . ' ' . $period->name,
                'content'      => "A. Pendahuluan\nDivisi " . $division->name . " telah melaksanakan program kerja dengan baik selama periode ini.\n\nB. Capaian Program Kerja\n- Program 1: Terlaksana 100%\n- Program 2: Terlaksana 85%\n\nC. Kendala & Evaluasi\nBeberapa program mengalami kendala teknis namun dapat diselesaikan dengan baik.\n\nD. Penutup\nDemikian laporan ini dibuat untuk pertanggungjawaban Divisi " . $division->name . ".",
                'status'       => $status,
                'submitted_at' => in_array($status, ['submitted', 'approved']) ? now()->subDays(5) : null,
                'approved_at'  => $status === 'approved' ? now()->subDays(2) : null,
            ]);
        }

        $this->command->info('✅ DivisionReportSeeder: Data laporan dummy berhasil di-seed.');
    }
}
