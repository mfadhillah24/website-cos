<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Urutan penting: Permission → Role → User
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            AdminUserSeeder::class,
            MemberStatusSeeder::class,
            PengurusUserSeeder::class,
            FounderMemberSeeder::class,
            MemberSeeder::class,
            PeriodSeeder::class,
            PositionSeeder::class,
            ManagementSeeder::class,
            DivisionSeeder::class,
            ProgramSeeder::class,
            ArticleCategorySeeder::class,
            ArticleSeeder::class,
            RegistrationSeeder::class,
            DivisionReportSeeder::class,
        ]);
    }
}
