<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Daftar seluruh permission sesuai PRD Seksi 5.4
     */
    private array $permissions = [
        // Dashboard
        'view_dashboard',

        // Anggota
        'view_members',
        'manage_members',

        // Kepengurusan & Jabatan
        'view_management',
        'manage_management',
        'manage_periods',
        'manage_positions',

        // Divisi
        'view_division',
        'manage_division',
        'view_division_members', // KABID: melihat anggota bidangnya

        // Program Kerja
        'view_programs',
        'manage_programs',

        // Kegiatan
        'view_activities',
        'manage_activities',

        // Berita & Publikasi
        'view_news',
        'manage_news',
        'view_announcements',
        'manage_announcements',

        // Galeri
        'view_gallery',
        'manage_gallery',

        // Pendaftaran
        'view_registration',
        'manage_registration',

        // Keuangan
        'view_finance',
        'manage_finance',
        'view_rab',
        'manage_rab',

        // Laporan
        'view_reports',
        'manage_reports',
        'manage_all_reports',
        'submit_reports',
        'review_reports',
        'approve_reports',
        'view_org_reports',
        'view_organization_report', // legacy

        // Administrasi & Sekretariat
        'manage_agenda',
        'manage_documents',
        'manage_incoming_letters',
        'manage_outgoing_letters',
        'manage_dispositions',
        'manage_letter_templates',
        'manage_agendas',
        'manage_meetings',
        'manage_minutes',
        'manage_archives',
        'view_admin_reports',

        // Sistem
        'manage_users',
        'manage_roles',
        'manage_permissions',
        'manage_settings',
    ];

    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $this->command->info('✅ ' . count($this->permissions) . ' permissions seeded.');
    }
}
