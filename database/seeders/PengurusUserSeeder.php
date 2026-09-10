<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Member;
use App\Models\MemberStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PengurusUserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password123');
        $statusTetap = MemberStatus::where('name', 'Anggota Tetap')->first();

        $pengurusList = [
            [
                'name' => 'John (Ketua Umum)',
                'email' => 'ketua@cos.unitama.ac.id',
                'role' => 'Ketua Umum',
                'nim' => '210001',
            ],
            [
                'name' => 'Jane (Sekretaris)',
                'email' => 'sekretaris@cos.unitama.ac.id',
                'role' => 'Sekretaris',
                'nim' => '210002',
            ],
            [
                'name' => 'Budi (Bendahara)',
                'email' => 'bendahara@cos.unitama.ac.id',
                'role' => 'Bendahara',
                'nim' => '210003',
            ],
            [
                'name' => 'Siti (Ketua Bidang Networking)',
                'email' => 'ketuabidang.networking@cos.unitama.ac.id',
                'role' => 'Ketua Bidang',
                'nim' => '210004',
            ],
            [
                'name' => 'Agus (Ketua Bidang DKV)',
                'email' => 'ketuabidang.dkv@cos.unitama.ac.id',
                'role' => 'Ketua Bidang',
                'nim' => '210005',
            ],
            [
                'name' => 'Dewi (Ketua Bidang Programming)',
                'email' => 'ketuabidang.programming@cos.unitama.ac.id',
                'role' => 'Ketua Bidang',
                'nim' => '210006',
            ]
        ];

        foreach ($pengurusList as $p) {
            $user = User::firstOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['name'],
                    'password' => $password,
                    'is_active' => true,
                ]
            );

            // Assign role
            if (!$user->hasRole($p['role'])) {
                $user->assignRole($p['role']);
            }

            // Create Member profile if not exists
            if ($statusTetap) {
                $member = Member::firstOrCreate(
                    ['nim' => $p['nim']],
                    [
                        'name' => $p['name'],
                        'email' => $p['email'],
                        'user_id' => $user->id,
                        'status_id' => $statusTetap->id,
                        'angkatan' => '2021',
                        'generation' => 7,
                    ]
                );

                // Make sure NTA exists (simulated since auto-gen is removed)
                if (empty($member->nta)) {
                    $member->update(['nta' => 'COS.UNITAMA.VII.' . rand(100, 999) . '.2024-2025']);
                }
            }
        }

        $this->command->info('✅ Dummy Pengurus Users (Ketua, Sekretaris, Bendahara, Ketua Bidang) seeded.');
    }
}
