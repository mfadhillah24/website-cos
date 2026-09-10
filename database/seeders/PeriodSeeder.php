<?php

namespace Database\Seeders;

use App\Models\Period;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    public function run(): void
    {
        // Periode demisioner
        Period::firstOrCreate(
            ['name' => '2025/2026'],
            [
                'start_date' => '2025-01-01',
                'end_date' => '2025-12-31',
                'is_active' => false,
                'closed_at' => '2026-01-15 10:00:00',
                'closed_by' => 1,
            ]
        );

        // Periode aktif saat ini
        Period::firstOrCreate(
            ['name' => '2026/2027'],
            [
                'start_date' => '2026-01-01',
                'end_date' => '2026-12-31',
                'is_active' => true,
            ]
        );

        $this->command->info('✅ PeriodSeeder: 2 periods seeded.');
    }
}
