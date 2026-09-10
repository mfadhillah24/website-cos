<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'org_name',
                'value' => 'UKM-IT COS',
                'label' => 'Nama Organisasi',
                'type' => 'text',
                'group' => 'general'
            ],
            [
                'key' => 'org_logo',
                'value' => '',
                'label' => 'Logo Organisasi',
                'type' => 'image',
                'group' => 'general'
            ],
            [
                'key' => 'org_description',
                'value' => 'Unit Kegiatan Mahasiswa Ilmu Teknologi & Coding Student',
                'label' => 'Deskripsi Organisasi',
                'type' => 'textarea',
                'group' => 'general'
            ],
            [
                'key' => 'whatsapp_group_link',
                'value' => 'https://chat.whatsapp.com/...',
                'label' => 'Link Grup WhatsApp',
                'type' => 'url',
                'group' => 'social'
            ],
            [
                'key' => 'instagram_link',
                'value' => 'https://instagram.com/ukmitcos',
                'label' => 'Link Instagram',
                'type' => 'url',
                'group' => 'social'
            ],
            [
                'key' => 'email_contact',
                'value' => 'contact@ukmitcos.example.com',
                'label' => 'Email Kontak',
                'type' => 'text',
                'group' => 'contact'
            ],
            [
                'key' => 'address',
                'value' => 'Sekretariat UKM-IT COS, Universitas...',
                'label' => 'Alamat Sekretariat',
                'type' => 'textarea',
                'group' => 'contact'
            ],
            // About / Profil UKM
            [
                'key' => 'org_vision',
                'value' => '',
                'label' => 'Visi Organisasi',
                'type' => 'textarea',
                'group' => 'about'
            ],
            [
                'key' => 'org_mission',
                'value' => '',
                'label' => 'Misi Organisasi',
                'type' => 'textarea',
                'group' => 'about'
            ],
            [
                'key' => 'org_history',
                'value' => '',
                'label' => 'Sejarah Singkat',
                'type' => 'textarea',
                'group' => 'about'
            ],
            [
                'key' => 'org_founded',
                'value' => '',
                'label' => 'Tahun Berdiri',
                'type' => 'text',
                'group' => 'about'
            ],
            [
                'key' => 'ketua_sambutan',
                'value' => '',
                'label' => 'Sambutan Ketua Umum',
                'type' => 'textarea',
                'group' => 'general'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
