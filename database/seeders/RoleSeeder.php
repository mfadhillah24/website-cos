<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin — akses penuh seluruh sistem
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // Admin — konfigurasi bisa diatur, default akses penuh tapi mungkin tanpa manage_users dll
        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        
        // 1. Ketua Umum
        $ketuaUmum = Role::firstOrCreate(['name' => 'Ketua Umum', 'guard_name' => 'web']);
        $ketuaUmum->syncPermissions([
            'view_dashboard',
            // Anggota — bisa tambah & lihat anggota baru
            'view_members', 'manage_members',
            // Kepengurusan
            'view_management', 'manage_management', 'manage_periods', 'manage_positions',
            // Divisi & Program (view only)
            'view_division', 'view_programs',
            // Keuangan (view only)
            'view_finance', 'view_rab',
            // Laporan & Review
            'view_org_reports', 'approve_reports', 'review_reports',
            // User management — bisa buat akun pengurus baru
            'manage_users',
        ]);

        // 2. Sekretaris
        $sekretaris = Role::firstOrCreate(['name' => 'Sekretaris', 'guard_name' => 'web']);
        $sekretaris->syncPermissions([
            'view_dashboard', 'view_members', 'manage_members', 
            'view_management', 'manage_management', 'manage_periods', 'manage_positions', 
            'manage_documents', 'view_registration', 'manage_registration', 
            'view_announcements', 'manage_announcements',
            
            // New permissions
            'manage_incoming_letters', 'manage_outgoing_letters', 'manage_dispositions',
            'manage_letter_templates', 'manage_agendas', 'manage_meetings', 
            'manage_minutes', 'manage_archives', 'view_admin_reports', 'view_rab'
        ]);

        // 3. Bendahara
        $bendahara = Role::firstOrCreate(['name' => 'Bendahara', 'guard_name' => 'web']);
        $bendahara->syncPermissions([
            'view_dashboard', 'view_finance', 'manage_finance', 'view_rab', 'manage_rab'
        ]);

        // 4. Kabid Networking
        $kabidNetworking = Role::firstOrCreate(['name' => 'Kabid Networking', 'guard_name' => 'web']);
        $kabidNetworking->syncPermissions([
            'view_dashboard', 'view_division', 'manage_division',
            'view_programs', 'manage_programs', 'view_activities', 'manage_activities',
            'view_reports', 'submit_reports',
            'view_division_members', // melihat anggota bidang
        ]);

        // 5. Kabid Programming
        $kabidProgramming = Role::firstOrCreate(['name' => 'Kabid Programming', 'guard_name' => 'web']);
        $kabidProgramming->syncPermissions([
            'view_dashboard', 'view_division', 'manage_division',
            'view_programs', 'manage_programs', 'view_activities', 'manage_activities',
            'view_reports', 'submit_reports',
            'view_division_members', // melihat anggota bidang
        ]);

        // 6. Kabid Desain Komunikasi Visual
        $kabidDkv = Role::firstOrCreate(['name' => 'Kabid Desain Komunikasi Visual', 'guard_name' => 'web']);
        $kabidDkv->syncPermissions([
            'view_dashboard', 'view_division', 'manage_division',
            'view_programs', 'manage_programs', 'view_activities', 'manage_activities',
            'view_reports', 'submit_reports',
            'view_division_members', // melihat anggota bidang
        ]);

        // 7. Humas
        $humas = Role::firstOrCreate(['name' => 'Humas', 'guard_name' => 'web']);
        $humas->syncPermissions([
            'view_dashboard',
            'view_activities', 'manage_activities',
            'view_announcements', 'manage_announcements',
            'view_gallery', 'manage_gallery',
            'view_news', 'manage_news',
            'view_registration', // Added permission for Humas
        ]);

        $this->command->info('✅ Roles seeded: Super Admin, Admin, Ketua Umum, Sekretaris, Bendahara, Humas, Kabid Networking, Kabid Programming, Kabid Desain Komunikasi Visual');
    }
}
