<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\MemberStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class FounderMemberSeeder extends Seeder
{
    public function run(): void
    {
        $statusPendiri = MemberStatus::where('name', 'Pendiri')->first();
        $superAdminUser = User::where('email', 'superadmin@ukmitcos.org')->first();

        // 1. Founder Pertama (Kaitkan dengan superadmin)
        Member::firstOrCreate(
            ['nim' => '0000000001'],
            [
                'user_id'    => $superAdminUser?->id,
                'status_id'  => $statusPendiri->id,
                'name'       => 'Bapak Pendiri A',
                'email'      => 'founder.a@ukmitcos.org',
                'angkatan'   => '2010',
                'is_founder' => true,
            ]
        );

        // 2. Founder Kedua
        Member::firstOrCreate(
            ['nim' => '0000000002'],
            [
                'user_id'    => null, // tidak terikat akun login
                'status_id'  => $statusPendiri->id,
                'name'       => 'Bapak Pendiri B',
                'email'      => 'founder.b@ukmitcos.org',
                'angkatan'   => '2010',
                'is_founder' => true,
            ]
        );

        $this->command->info('✅ 2 Founder members seeded.');
    }
}
