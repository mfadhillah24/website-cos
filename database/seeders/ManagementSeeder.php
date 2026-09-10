<?php

namespace Database\Seeders;

use App\Models\Management;
use App\Models\Member;
use App\Models\Period;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;

class ManagementSeeder extends Seeder
{
    public function run(): void
    {
        $activePeriod = Period::where('is_active', true)->first();
        if (!$activePeriod) return;

        $ketua = Position::where('slug', 'ketua')->first();
        $sekretaris = Position::where('slug', 'sekretaris')->first();

        // Get members
        $founder1 = Member::where('nim', '1234567890')->first();
        $founder2 = Member::where('nim', '0987654321')->first();

        if ($founder1 && $ketua) {
            Management::firstOrCreate(
                ['member_id' => $founder1->id, 'period_id' => $activePeriod->id, 'position_id' => $ketua->id],
                [
                    'user_id' => $founder1->user_id,
                    'is_active' => true,
                    'started_at' => $activePeriod->start_date,
                    'notes' => 'Diassign dari seeder'
                ]
            );
        }

        if ($founder2 && $sekretaris) {
            Management::firstOrCreate(
                ['member_id' => $founder2->id, 'period_id' => $activePeriod->id, 'position_id' => $sekretaris->id],
                [
                    'user_id' => $founder2->user_id,
                    'is_active' => true,
                    'started_at' => $activePeriod->start_date,
                    'notes' => 'Diassign dari seeder'
                ]
            );
        }

        $this->command->info('✅ ManagementSeeder: Kepengurusan seeded.');
    }
}
