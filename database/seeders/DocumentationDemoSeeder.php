<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Letter;
use App\Models\LetterTemplate;
use App\Models\Agenda;
use App\Models\Meeting;
use App\Models\MeetingMinute;
use App\Models\Announcement;
use App\Models\FinanceCategory;
use App\Models\Finance;
use App\Models\Contact;
use App\Models\Activity;
use App\Models\GalleryPhoto;
use App\Models\Division;
use App\Models\Period;

class DocumentationDemoSeeder extends Seeder
{
    public function run(): void
    {
        $period = Period::where('is_active', true)->first();
        $div = Division::first();

        // ──────────────────────────────────────────
        // 1. SURAT MASUK (incoming)
        // ──────────────────────────────────────────
        $incomingLetters = [
            [
                'type'          => 'incoming',
                'letter_number' => '102/UND/BEM/VIII/2026',
                'letter_date'   => now()->subDays(10),
                'received_date' => now()->subDays(8),
                'sender'        => 'BEM Universitas',
                'subject'       => 'Undangan Rapat Koordinasi Ormawa',
                'priority'      => 'Penting',
                'status'        => 'diproses',
                'summary'       => 'Undangan rapat koordinasi untuk seluruh ketua UKM.',
                'agenda_number' => '001/SM/2026',
            ],
            [
                'type'          => 'incoming',
                'letter_number' => '085/DEKAN/FTI/VIII/2026',
                'letter_date'   => now()->subDays(20),
                'received_date' => now()->subDays(19),
                'sender'        => 'Dekan Fakultas Teknologi Informasi',
                'subject'       => 'Permintaan Data Kegiatan UKM Semester Genap',
                'priority'      => 'Biasa',
                'status'        => 'selesai',
                'summary'       => 'Permintaan rekap laporan kegiatan UKM untuk keperluan akreditasi.',
                'agenda_number' => '002/SM/2026',
            ],
            [
                'type'          => 'incoming',
                'letter_number' => '011/SPJ/REKTORAT/IX/2026',
                'letter_date'   => now()->subDays(3),
                'received_date' => now()->subDays(2),
                'sender'        => 'Rektorat',
                'subject'       => 'Surat Pemberitahuan Jadwal Dies Natalis',
                'priority'      => 'Segera',
                'status'        => 'baru',
                'agenda_number' => '003/SM/2026',
            ],
        ];

        foreach ($incomingLetters as $data) {
            Letter::firstOrCreate(
                ['letter_number' => $data['letter_number'], 'type' => 'incoming'],
                $data
            );
        }

        // ──────────────────────────────────────────
        // 2. SURAT KELUAR (outgoing)
        // ──────────────────────────────────────────
        $outgoingLetters = [
            [
                'type'          => 'outgoing',
                'letter_number' => '015/UKM-IT-COS/VIII/2026',
                'letter_date'   => now()->subDays(5),
                'receiver'      => 'Kepala Laboratorium Komputer',
                'subject'       => 'Permohonan Peminjaman Ruangan Lab',
                'status'        => 'dikirim',
                'summary'       => 'Permohonan peminjaman ruang lab komputer untuk kegiatan workshop web development.',
                'signer'        => 'Ketua Umum UKM-IT COS',
                'signer_position' => 'Ketua Umum',
            ],
            [
                'type'          => 'outgoing',
                'letter_number' => '016/UKM-IT-COS/VIII/2026',
                'letter_date'   => now()->subDays(2),
                'receiver'      => 'BEM Universitas',
                'subject'       => 'Konfirmasi Kehadiran Rapat Koordinasi Ormawa',
                'status'        => 'disetujui',
                'signer'        => 'Sekretaris Umum',
                'signer_position' => 'Sekretaris Umum',
            ],
        ];

        foreach ($outgoingLetters as $data) {
            Letter::firstOrCreate(
                ['letter_number' => $data['letter_number'], 'type' => 'outgoing'],
                $data
            );
        }

        // ──────────────────────────────────────────
        // 3. TEMPLATE SURAT
        // ──────────────────────────────────────────
        LetterTemplate::firstOrCreate(
            ['name' => 'Template Surat Keterangan Aktif'],
            [
                'description'    => 'Template standar untuk surat keterangan anggota aktif UKM-IT COS.',
                'content'        => "Yang bertanda tangan di bawah ini, Ketua Umum UKM-IT COS menerangkan bahwa:\n[NAMA ANGGOTA] adalah anggota aktif UKM-IT COS periode 2026/2027.",
                'file_extension' => 'txt',
            ]
        );
        LetterTemplate::firstOrCreate(
            ['name' => 'Template Surat Undangan Rapat'],
            [
                'description'    => 'Template standar untuk undangan rapat internal pengurus.',
                'content'        => "Mengundang seluruh pengurus UKM-IT COS untuk hadir pada:\nHari/Tanggal: [HARI], [TANGGAL]\nWaktu: [WAKTU]\nTempat: [LOKASI]",
                'file_extension' => 'txt',
            ]
        );

        // ──────────────────────────────────────────
        // 4. AGENDA
        // ──────────────────────────────────────────
        $agendas = [
            [
                'title'       => 'Rapat Evaluasi Program Kerja Semester',
                'type'        => 'Internal',
                'agenda_date' => now()->addDays(2)->toDateString(),
                'start_time'  => '13:00',
                'end_time'    => '15:00',
                'location'    => 'Sekretariat UKM-IT COS',
                'description' => 'Evaluasi seluruh program kerja divisi yang sudah dan belum berjalan.',
                'status'      => 'terjadwal',
            ],
            [
                'title'       => 'Workshop Open Source — Kontribusi GitHub',
                'type'        => 'Eksternal',
                'agenda_date' => now()->subDays(7)->toDateString(),
                'start_time'  => '09:00',
                'end_time'    => '12:00',
                'location'    => 'Lab Komputer Gedung A',
                'description' => 'Workshop cara berkontribusi ke proyek open source melalui GitHub.',
                'status'      => 'selesai',
            ],
        ];
        foreach ($agendas as $data) {
            Agenda::firstOrCreate(['title' => $data['title']], $data);
        }

        // ──────────────────────────────────────────
        // 5. RAPAT & NOTULEN
        // ──────────────────────────────────────────
        $meeting = Meeting::firstOrCreate(
            ['title' => 'Rapat Koordinasi Pengurus Inti'],
            [
                'meeting_date'     => now()->subDays(3)->toDateString(),
                'start_time'       => '19:00',
                'end_time'         => '21:00',
                'location'         => 'Google Meet (Online)',
                'agenda'           => 'Evaluasi kegiatan bulan lalu, persiapan open recruitment anggota baru.',
                'attendance_count' => 12,
                'participants'     => 'Ketua, Sekretaris, Bendahara, Ketua Bidang Programming, Ketua Bidang Networking, Ketua Bidang DKV',
                'status'           => 'selesai',
            ]
        );

        MeetingMinute::firstOrCreate(
            ['meeting_id' => $meeting->id],
            [
                'leader'             => 'Ahmad Fauzan (Ketua Umum)',
                'notulist'           => 'Siti Rahma (Sekretaris)',
                'discussion_results' => 'Seluruh divisi telah memaparkan progress kegiatan. Divisi Programming berhasil menyelesaikan 2 program kerja dari 4 yang direncanakan. Divisi Networking sedang berjalan 1 kegiatan. Divisi DKV telah menyelesaikan semua konten promosi bulan ini.',
                'decisions'          => "1. Open Recruitment dijadwalkan bulan September 2026.\n2. Divisi DKV diberikan tugas membuat poster Open Recruitment.\n3. Anggaran kegiatan Open Recruitment disetujui sebesar Rp 1.000.000.",
                'follow_up'          => 'Divisi DKV mengirimkan desain poster paling lambat 2 minggu sebelum pelaksanaan.',
                'follow_up_deadline' => now()->addDays(14)->toDateString(),
            ]
        );

        // Rapat kedua
        $meeting2 = Meeting::firstOrCreate(
            ['title' => 'Rapat Persiapan Dies Natalis Universitas'],
            [
                'meeting_date'     => now()->subDays(15)->toDateString(),
                'start_time'       => '10:00',
                'end_time'         => '11:30',
                'location'         => 'Ruang Rapat Dekanat',
                'agenda'           => 'Pembahasan kontribusi UKM-IT COS pada acara Dies Natalis.',
                'attendance_count' => 8,
                'participants'     => 'Ketua, Wakil Ketua, Sekretaris, Bendahara, Perwakilan Divisi',
                'status'           => 'selesai',
            ]
        );

        // ──────────────────────────────────────────
        // 6. PENGUMUMAN
        // ──────────────────────────────────────────
        Announcement::firstOrCreate(
            ['title' => 'Pemeliharaan Server Aplikasi Internal'],
            [
                'content'    => 'Akan dilakukan maintenance server aplikasi UKM-IT COS pada hari Minggu, 31 Agustus 2026 pukul 00:00 - 04:00 WITA. Mohon tidak melakukan input data pada jam tersebut.',
                'is_active'  => true,
                'starts_at'  => now()->subDay(),
                'ends_at'    => now()->addDays(3),
            ]
        );
        Announcement::firstOrCreate(
            ['title' => 'Open Recruitment Anggota Baru 2026'],
            [
                'content'    => 'UKM-IT COS membuka pendaftaran anggota baru periode 2026/2027. Daftarkan dirimu sekarang melalui website resmi kami!',
                'is_active'  => true,
                'starts_at'  => now(),
                'ends_at'    => now()->addDays(30),
            ]
        );

        // ──────────────────────────────────────────
        // 7. KEUANGAN
        // ──────────────────────────────────────────
        $catIn = FinanceCategory::firstOrCreate(
            ['name' => 'Iuran Anggota'],
            ['type' => 'pemasukan']
        );
        $catIn2 = FinanceCategory::firstOrCreate(
            ['name' => 'Dana Kemahasiswaan'],
            ['type' => 'pemasukan']
        );
        $catOut = FinanceCategory::firstOrCreate(
            ['name' => 'Konsumsi Kegiatan'],
            ['type' => 'pengeluaran']
        );
        $catOut2 = FinanceCategory::firstOrCreate(
            ['name' => 'Perlengkapan & ATK'],
            ['type' => 'pengeluaran']
        );

        $finances = [
            ['description' => 'Iuran anggota bulan Agustus 2026', 'type' => 'pemasukan',   'amount' => 700000,  'date' => now()->subDays(2),  'category_id' => $catIn->id,   'period_id' => $period?->id],
            ['description' => 'Dana kemahasiswaan semester genap',  'type' => 'pemasukan',   'amount' => 2500000, 'date' => now()->subDays(15), 'category_id' => $catIn2->id,  'period_id' => $period?->id],
            ['description' => 'Pembelian snack rapat pengurus',     'type' => 'pengeluaran', 'amount' => 150000,  'date' => now()->subDays(3),  'category_id' => $catOut->id,  'period_id' => $period?->id],
            ['description' => 'Pembelian kertas dan spidol whiteboard','type' => 'pengeluaran','amount' => 85000, 'date' => now()->subDays(10), 'category_id' => $catOut2->id, 'period_id' => $period?->id],
        ];
        foreach ($finances as $data) {
            Finance::firstOrCreate(['description' => $data['description']], $data);
        }

        // ──────────────────────────────────────────
        // 8. KONTAK / PESAN MASUK
        // ──────────────────────────────────────────
        $contacts = [
            [
                'name'    => 'Fajar Setiawan',
                'email'   => 'fajar.setiawan@mhs.example.ac.id',
                'subject' => 'Pertanyaan Syarat Pendaftaran Anggota',
                'message' => 'Halo min, untuk pendaftaran UKM IT COS apakah mahasiswa semester 5 masih bisa ikut mendaftar? Terima kasih.',
                'is_read' => false,
            ],
            [
                'name'    => 'Diana Puspita',
                'email'   => 'diana.puspita@gmail.com',
                'subject' => 'Kolaborasi Kegiatan Seminar Teknologi',
                'message' => 'Kami dari Himpunan Mahasiswa Informatika ingin mengajukan kerja sama untuk menyelenggarakan seminar teknologi bersama UKM-IT COS.',
                'is_read' => true,
            ],
        ];
        foreach ($contacts as $data) {
            Contact::firstOrCreate(['email' => $data['email']], $data);
        }

        // ──────────────────────────────────────────
        // 9. KEGIATAN (Activity) & GALERI
        // ──────────────────────────────────────────
        if ($div) {
            $activities = [
                [
                    'division_id' => $div->id,
                    'period_id'   => $period?->id,
                    'title'       => 'Workshop UI/UX Design with Figma',
                    'description' => 'Pelatihan intensif 2 hari mengenai dasar-dasar UI/UX menggunakan Figma.',
                    'location'    => 'Laboratorium Komputer Gedung A',
                    'start_date'  => now()->subDays(20)->toDateString(),
                    'end_date'    => now()->subDays(19)->toDateString(),
                    'status'      => 'publish',
                ],
                [
                    'division_id' => $div->id,
                    'period_id'   => $period?->id,
                    'title'       => 'Pelatihan Git & GitHub untuk Pemula',
                    'description' => 'Pengenalan version control menggunakan Git dan GitHub dalam pengembangan proyek kolaboratif.',
                    'location'    => 'Online — Google Meet',
                    'start_date'  => now()->subDays(45)->toDateString(),
                    'end_date'    => now()->subDays(45)->toDateString(),
                    'status'      => 'publish',
                ],
            ];
            foreach ($activities as $data) {
                $activity = Activity::firstOrCreate(['title' => $data['title']], $data);

                // Galeri: tambahkan referensi foto (path dummy, tidak perlu file asli untuk tabel)
                GalleryPhoto::firstOrCreate(
                    ['activity_id' => $activity->id, 'caption' => 'Dokumentasi ' . $data['title']],
                    [
                        'division_id'  => $div->id,
                        'path'         => 'gallery/demo-placeholder.jpg',
                        'is_published' => true,
                    ]
                );
            }
        }

        $this->command->info('✅ DocumentationDemoSeeder: All demo data seeded successfully!');
    }
}
