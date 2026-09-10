# PRD — Website Profil & Sistem Manajemen Organisasi
# UKM-IT Cyber Open Source (UKM-IT COS)

**Versi:** 2.1.0  
**Tanggal:** 14 Agustus 2026  
**Status:** Draft — Revisi  
**Stack Teknologi:** Laravel 13 · PHP 8.4 · SQLite · Vite · TailwindCSS v4  

> **Changelog v2.1:**  
> - Memperjelas pemisahan Member dan User Account
> - Memperjelas lifecycle Anggota Muda → Anggota Tetap → Anggota Kehormatan
> - Memperjelas mekanisme demisioner
> - Memisahkan Position dan Division
> - Merapikan arsitektur permission
> - Memperjelas Division Scope
> - Menetapkan final workflow pendaftaran tanpa verifikasi
> - Memperkuat requirement Landing Page
> - Memperjelas public access dan internal access
> - Menyesuaikan database schema

---

## 1. Latar Belakang

UKM-IT Cyber Open Source adalah unit kegiatan mahasiswa di bidang teknologi informasi yang berfokus pada pengembangan software open source, keamanan siber, dan pemberdayaan komunitas teknologi. Website ini dibangun sebagai platform publik dan sistem manajemen internal organisasi dalam satu aplikasi terpadu.

---

## 2. Tujuan Produk

1. Menyajikan profil resmi UKM-IT COS kepada publik (mahasiswa, dosen, sponsor, dan masyarakat umum).
2. Memfasilitasi manajemen anggota, kegiatan, divisi, dan dokumentasi organisasi secara internal.
3. Menjadi pusat informasi kegiatan, berita, dan pencapaian organisasi.
4. Mendukung sistem multi-periode kepengurusan dengan histori yang lengkap dan tidak dapat dihapus.
5. Menyediakan sistem laporan per divisi dengan workflow review dan persetujuan.

---

## 3. Target Pengguna

| Pengguna          | Deskripsi                                                                          |
|-------------------|------------------------------------------------------------------------------------|
| **Publik / Guest**     | Mahasiswa, tamu, calon anggota — akses halaman publik tanpa login                  |
| **Anggota Muda**       | Anggota dalam proses pembelajaran (tidak otomatis memiliki akun login)             |
| **Anggota Tetap**      | Pengurus aktif periode berjalan — jika butuh akses sistem, dibuatkan User Account  |
| **Anggota Kehormatan** | Mantan pengurus demisioner — (tidak otomatis memiliki akun login)                  |
| **Pendiri**            | 2 orang pendiri organisasi — status permanen                                       |
| **Admin**              | Administrator sistem — kelola user, role, permission, konfigurasi                  |
| **Super Admin**        | Akses penuh seluruh sistem                                                         |

> **Catatan:** Member (data organisasi) ≠ User (akun login). Tidak semua member memiliki user account.

---

## 4. Konsep Visual & Desain

### 4.1 Tema
Modern, clean, profesional, responsif, bertema teknologi.

### 4.2 Palet Warna

| Nama           | Kode Hex    | Penggunaan                        |
|----------------|-------------|-----------------------------------|
| Navy Blue      | `#0A1628`   | Background utama, sidebar         |
| Dark Blue      | `#0D2137`   | Section background, card          |
| Electric Blue  | `#0EA5E9`   | Aksen utama, CTA button, link     |
| Steel Blue     | `#3B82F6`   | Elemen interaktif, hover state    |
| Gray           | `#6B7280`   | Teks sekunder, border, divider    |
| White          | `#FFFFFF`   | Teks utama pada dark bg, card bg  |

### 4.3 Tipografi
- **Heading:** `Inter` / `Plus Jakarta Sans` (Google Fonts)
- **Body:** `Inter`
- **Code/Mono:** `JetBrains Mono` (untuk dekorasi/teknis)

### 4.4 Karakteristik UI
- Dark mode sebagai tema utama
- Glassmorphism pada card dan modal
- Gradient subtle pada hero dan section header
- Micro-animation pada hover, scroll reveal, dan transisi halaman
- Responsif penuh (mobile-first)

---

## 5. Arsitektur Aplikasi

### 5.1 Struktur Keanggotaan & Jabatan

Status keanggotaan dan jabatan kepengurusan adalah **dua hal yang terpisah**.

**Status Keanggotaan** (melekat pada anggota, bisa berubah seiring waktu):

| Status              | Deskripsi                                                              |
|---------------------|------------------------------------------------------------------------|
| **Anggota Muda**    | Anggota dalam proses pembelajaran dan pengembangan kemampuan           |
| **Anggota Tetap**   | Anggota yang menjadi bagian dari kepengurusan aktif periode berjalan   |
| **Anggota Kehormatan** | Mantan pengurus yang telah demisioner                               |
| **Pendiri**         | Pendiri UKM-IT COS (2 orang), status permanen tidak dapat diubah       |

**Jabatan Kepengurusan** (terikat pada periode tertentu):

| Jabatan              | Deskripsi                              |
|----------------------|----------------------------------------|
| Ketua                | Pimpinan organisasi periode berjalan   |
| Sekretaris           | Administrasi organisasi                |
| Bendahara            | Keuangan organisasi                    |
| Kabid Networking     | Kepala bidang Networking               |
| Kabid Programming    | Kepala bidang Programming              |
| Kabid DKV            | Kepala bidang DKV                      |
| Humas                | Hubungan masyarakat & publikasi        |

> **Contoh siklus anggota:**  
> Budi bergabung → **Anggota Muda** → menjadi pengurus aktif → **Anggota Tetap** (Jabatan: Ketua, Periode 2026/2027) → periode berakhir → **Anggota Kehormatan** (Jabatan di-archive, akses dicabut)

### 5.2 Sistem Multi-Periode

- Setiap periode kepengurusan memiliki struktur jabatan sendiri (contoh: 2025/2026, 2026/2027, 2027/2028, dst.)
- Ketika periode berakhir:
  - Pengurus menjadi **demisioner**
  - Akses sebagai pengurus aktif **dicabut otomatis**
  - Histori jabatan **tetap tersimpan**
  - Status dapat diperbarui menjadi **Anggota Kehormatan**
  - Data **tidak boleh dihapus**
- Hak akses pengurus **hanya berlaku** pada periode kepengurusan aktif

### 5.3 Arsitektur Permission

Hak akses tidak boleh di-hardcode berdasarkan nama jabatan. Gunakan hierarki berikut:

```
User
  └── Member (status keanggotaan)
        └── Management (jabatan pada periode)
              └── Position (definisi jabatan)
                    └── Permission (hak akses granular)
```

Permission memiliki scope:

| Scope       | Deskripsi                                       |
|-------------|-------------------------------------------------|
| `global`    | Berlaku untuk semua data                        |
| `division`  | Berlaku hanya untuk divisi yang bersangkutan    |
| `own`       | Berlaku hanya untuk data milik sendiri          |
| `read`      | Hanya baca                                      |
| `create`    | Membuat data baru                               |
| `update`    | Mengubah data yang ada                          |
| `delete`    | Menghapus data                                  |
| `approve`   | Menyetujui / reject data                        |

### 5.4 Daftar Permission

```
# Dashboard
view_dashboard

# Anggota
view_members
manage_members

# Kepengurusan & Jabatan
view_management
manage_management
manage_periods
manage_positions

# Divisi
view_division
manage_division

# Program Kerja
view_programs
manage_programs

# Kegiatan
view_activities
manage_activities

# Berita & Publikasi
view_news
manage_news
view_announcements
manage_announcements

# Galeri
view_gallery
manage_gallery

# Pendaftaran
view_registration
manage_registration

# Keuangan
view_finance
manage_finance

# Laporan
view_reports
manage_reports
submit_reports
approve_reports
view_organization_report

# Administrasi
manage_agenda
manage_documents

# Sistem
manage_users
manage_roles
manage_permissions
manage_settings
```

### 5.5 Hak Akses Per Jabatan

> **PENTING:** Hak akses berikut adalah **konfigurasi default** yang di-seed ke sistem. Dapat dimodifikasi oleh Super Admin melalui panel permission. Tidak boleh di-hardcode dalam kode aplikasi.

| Jabatan          | Permission Default                                                                                                   |
|------------------|----------------------------------------------------------------------------------------------------------------------|
| **Super Admin**  | Semua permission (global scope)                                                                                      |
| **Admin**        | Sesuai permission yang dikonfigurasi Super Admin                                                                     |
| **Ketua**        | `view_dashboard`, `view_members`, `view_management`, `view_division`, `view_programs`, `view_activities`, `view_registration`, `view_reports`, `view_organization_report`, `view_finance`, `approve_reports` |
| **Sekretaris**   | `view_dashboard`, `view_members`, `manage_members`, `manage_management`, `manage_periods`, `manage_positions`, `view_programs`, `view_activities`, `manage_agenda`, `manage_documents`, `manage_news`, `view_reports`, `view_organization_report` |
| **Bendahara**    | `view_dashboard`, `view_finance`, `manage_finance`, `view_reports`                                                   |
| **Kabid Networking** | `view_dashboard`, `view_members` (scope: division), `manage_division` (scope: own), `view_programs` (scope: division), `manage_programs` (scope: division), `view_activities` (scope: division), `manage_activities` (scope: division), `manage_reports` (scope: division), `submit_reports` (scope: division) |
| **Kabid Programming** | (sama dengan Kabid Networking, scope: divisi Programming)                                                       |
| **Kabid DKV**    | (sama dengan Kabid Networking, scope: divisi DKV) + `manage_gallery` (scope: division)                              |
| **Humas**        | `view_dashboard`, `manage_news`, `manage_announcements`, `manage_gallery`, `manage_registration`, `view_activities`, `view_members` (public info) |

### 5.6 Guard & Middleware

- Guard: `web` (session-based)
- Package permission: `spatie/laravel-permission`
- Middleware: `auth`, `permission:{name}`, `role:{name}`
- Scope middleware tambahan: `division.scope` (memfilter data sesuai divisi pengurus)

---

## 6. Modul & Fitur

### 6.1 Halaman Publik (Guest / Tanpa Login)

#### M01 — Landing Page / Beranda
- **Desain dari scratch, TIDAK mengikuti layout template admin seperti NiceAdmin.**
- **Struktur Minimal:**
  1. Navbar
  2. Hero Section
  3. Profil singkat UKM
  4. Statistik organisasi
  5. Bidang/Divisi
  6. Program kerja unggulan
  7. Kegiatan terbaru
  8. Berita terbaru
  9. Struktur kepengurusan aktif
  10. Prestasi/pencapaian
  11. Galeri
  12. CTA "Daftar Menjadi Anggota" (Grup WhatsApp flow)
  13. Footer
- Menggunakan palet kombinasi light/dark secara elegan agar terasa modern dan premium.

#### M02 — Halaman Tentang (About)
- Sejarah organisasi
- Visi dan misi
- Tujuan organisasi
- Nilai-nilai organisasi
- Profil Pendiri (2 orang pendiri)

#### M03 — Halaman Struktur Organisasi
- Pilihan periode (default: periode aktif)
- Tampilan struktur kepengurusan per periode:
  - Ketua, Sekretaris, Bendahara
  - Kabid Networking, Kabid Programming, Kabid DKV
  - Humas
- Informasi opsional: Pendiri, Anggota Kehormatan/Demisioner
- Filter berdasarkan periode kepengurusan

#### M04 — Halaman Divisi
- Daftar divisi: Networking, Programming, DKV
- Detail divisi: deskripsi, Kabid, anggota aktif, program kerja

#### M05 — Halaman Kegiatan / Program Kerja
- Daftar kegiatan (past & upcoming)
- Filter: tahun, divisi, periode
- Detail kegiatan: foto, deskripsi, tanggal, peserta

#### M06 — Halaman Berita / Artikel
- Blog/news list dengan pagination
- Kategori berita
- Detail artikel dengan konten rich text
- Share ke media sosial

#### M07 — Halaman Galeri
- Grid foto kegiatan
- Filter per kegiatan / divisi

#### M08 — Halaman Anggota (Publik)
- Daftar anggota aktif (card avatar, nama, divisi, jabatan)
- Filter per divisi / angkatan / status
- Badge khusus untuk Pendiri dan Anggota Kehormatan

#### M09 — Halaman Kontak
- Form kontak (nama, email, pesan)
- Info kontak organisasi
- Embed media sosial

#### M10 — Halaman Pendaftaran Anggota (Tanpa Login)
- Khusus mahasiswa aktif UNITAMA (terdapat text disclaimer)
- Form: Nama lengkap, NIM (Primary, cegah duplikasi), Program studi, Angkatan, Email, Nomor HP, Tempat/Tanggal Lahir, Alamat, Pilihan divisi, Alasan bergabung, Foto
- Tanpa pembuatan password/akun
- Halaman Sukses menampilkan tombol "Gabung Grup WhatsApp"
- Link Grup WhatsApp dikelola dari setting admin

### 6.2 Panel Admin / Pengurus (Setelah Login)

#### M11 — Dashboard
- Statistik: total anggota per status, kegiatan, artikel, program kerja
- Statistik per divisi (untuk Kabid: hanya divisinya)
- Grafik anggota per angkatan / status
- Kegiatan mendatang
- Laporan yang menunggu review (untuk Ketua)
- Widget disesuaikan dengan jabatan pengguna yang login

#### M12 — Manajemen Anggota *(Sekretaris, Ketua)*
- CRUD data anggota (nama, NIM, email, phone, angkatan, foto, bio, linkedin, github)
- Kelola status keanggotaan: Anggota Muda → Anggota Tetap → Anggota Kehormatan
- Status **Pendiri** tidak dapat diubah melalui UI biasa (hanya Super Admin)
- Import/export CSV
- Histori status keanggotaan per anggota

#### M13 — Manajemen Status Keanggotaan *(Sekretaris)*
- Daftar riwayat perubahan status seluruh anggota
- Filter per status, angkatan, periode

#### M14 — Manajemen Periode *(Sekretaris)*
- CRUD periode kepengurusan (nama periode, tahun mulai, tahun selesai)
- Tetapkan periode aktif
- Tutup periode (otomatis mencabut akses pengurus aktif)
- Lihat histori seluruh periode

#### M15 — Manajemen Kepengurusan *(Sekretaris)*
- Assign anggota ke jabatan pada periode tertentu
- Setiap periode memiliki struktur jabatan sendiri
- Ketika periode ditutup, jabatan menjadi arsip (tidak dapat diubah)
- Histori jabatan seluruh anggota tetap tersimpan

#### M16 — Manajemen Jabatan *(Sekretaris, Super Admin)*
- Definisi jabatan yang tersedia (Ketua, Sekretaris, Bendahara, Kabid Networking, Kabid Programming, Kabid DKV, Humas)
- Permission default per jabatan
- Jabatan dapat dikembangkan jika struktur organisasi berubah

#### M17 — Manajemen Divisi *(Sekretaris, Kabid masing-masing)*
- CRUD divisi: Networking, Programming, DKV
- Assign Kabid dan anggota ke divisi (per periode)
- Kabid hanya dapat mengelola data divisinya sendiri

#### M18 — Manajemen Program Kerja *(Kabid, Sekretaris)*
- CRUD program kerja per divisi per periode
- Kabid hanya melihat/mengelola program kerja divisinya
- Status program kerja: planning / on-progress / completed / cancelled
- Terhubung ke laporan divisi

#### M19 — Manajemen Kegiatan *(Kabid, Humas, Sekretaris)*
- CRUD kegiatan (nama, deskripsi, tanggal, divisi, foto, status)
- Galeri foto per kegiatan
- Kabid hanya mengelola kegiatan divisinya
- Humas dapat mempublikasikan kegiatan ke halaman publik
- Status: draft / published / completed

#### M20 — Manajemen Berita & Pengumuman *(Humas, Sekretaris)*
- CRUD artikel/berita dengan rich text editor
- Kategori artikel
- Status: draft / published
- Upload thumbnail
- Pengumuman (banner/popup khusus)

#### M21 — Manajemen Galeri *(Humas, Kabid DKV)*
- Upload foto kegiatan
- Tag per kegiatan / divisi
- Hapus / kelola foto

#### M22 — Manajemen Pendaftaran *(Sekretaris, Humas)*
- Melihat daftar formulir pendaftar
- Detail pendaftar
- Pencarian data pendaftar
- Filter per angkatan, prodi, divisi, tanggal pendaftaran
- Export data pendaftar
- **TIDAK ADA workflow Approve/Reject/Verify di modul ini (hanya view/filter/export)**

#### M23 — Laporan Divisi *(Kabid — scope: divisi masing-masing)*
- Buat laporan divisi per periode
- Isi laporan: periode, program kerja, kegiatan, progress, pencapaian, kendala, evaluasi, rencana tindak lanjut, dokumentasi, kesimpulan
- Laporan terhubung ke: periode, divisi, Kabid, program kerja, kegiatan
- Workflow status laporan:
  ```
  Draft → Diajukan → Direview → Disetujui
                  ↘
                   Perlu Revisi → Diajukan Kembali → Disetujui
  ```
- Kabid dapat: membuat, mengedit (jika Draft/Perlu Revisi), mengajukan laporan
- Setelah diajukan, laporan tidak dapat diedit kecuali dikembalikan ke Perlu Revisi

#### M24 — Review Laporan *(Ketua)*
- Lihat seluruh laporan divisi dari semua divisi
- Beri catatan/komentar per laporan
- Minta revisi (ubah status ke Perlu Revisi)
- Setujui laporan (ubah status ke Disetujui)
- Histori review dan catatan tersimpan

#### M25 — Laporan Organisasi *(Ketua, Sekretaris)*
- Rekap seluruh laporan divisi per periode
- Ringkasan: jumlah program kerja, kegiatan, progress, pencapaian, kendala, evaluasi, status laporan
- Tampilan per divisi: Networking, Programming, DKV
- Export rekap ke PDF (via `barryvdh/laravel-dompdf`)
- Histori laporan periode sebelumnya tetap dapat diakses

#### M26 — Keuangan *(Bendahara)*
- Catat pemasukan dan pengeluaran
- Kategori transaksi keuangan
- Saldo organisasi (auto-kalkulasi)
- Histori transaksi per periode
- Laporan keuangan (ringkasan per periode)
- Export laporan keuangan ke PDF

#### M27 — Manajemen Pengguna *(Admin, Super Admin)*
- Daftar user sistem
- Assign role ke user
- Reset password
- Aktifkan / nonaktifkan akun
- Kelola permission spesifik per user (override)

#### M28 — Manajemen Role & Permission *(Super Admin)*
- Lihat seluruh role yang tersedia
- Edit permission per role
- Buat role baru jika diperlukan
- Audit log perubahan permission

#### M29 — Pengaturan Website *(Admin, Super Admin)*
- Informasi organisasi (nama, deskripsi, logo, banner)
- Konfigurasi media sosial
- Pengaturan kontak
- Pengaturan sistem (maintenance mode, dll.)

---

## 7. Database Schema

### 7.1 Daftar Tabel

| Tabel                  | Deskripsi                                                   |
|------------------------|-------------------------------------------------------------|
| `users`                | Akun login sistem                                           |
| `members`              | Data anggota organisasi                                     |
| `member_statuses`      | Master data status keanggotaan                              |
| `member_status_histories` | Histori perubahan status keanggotaan                    |
| `periods`              | Periode kepengurusan                                        |
| `positions`            | Definisi jabatan (Ketua, Sekretaris, dst.)                  |
| `managements`          | Assign jabatan anggota per periode (kepengurusan aktif)     |
| `divisions`            | Data divisi organisasi                                      |
| `division_members`     | Pivot anggota - divisi per periode                          |
| `programs`             | Program kerja per divisi per periode                        |
| `activities`           | Kegiatan organisasi                                         |
| `activity_photos`      | Foto per kegiatan                                           |
| `division_reports`     | Laporan divisi per periode                                  |
| `report_reviews`       | Catatan review laporan oleh Ketua                           |
| `articles`             | Artikel / berita                                            |
| `article_categories`   | Kategori artikel                                            |
| `gallery_photos`       | Foto galeri                                                 |
| `registrations`        | Form pendaftaran calon anggota baru (pencatatan)            |
| `contacts`             | Pesan masuk dari form kontak                                |
| `finances`             | Transaksi keuangan                                          |
| `finance_categories`   | Kategori keuangan                                           |
| `settings`             | Konfigurasi website                                         |
| `roles`                | Role sistem (via spatie/laravel-permission)                  |
| `permissions`          | Permission sistem (via spatie/laravel-permission)           |

### 7.2 Detail Kolom Kunci

**`users`**
```
id, name, email, password,
email_verified_at, remember_token,
is_active (boolean),
created_at, updated_at
```
> Tidak ada kolom `role` langsung. Role dikelola via `spatie/laravel-permission`.

**`members`**
```
id, user_id (FK users, nullable),
nim, name, email, phone, photo,
angkatan (year),
status_id (FK member_statuses),
bio, linkedin, github,
is_founder (boolean, default: false),
created_at, updated_at
```

**`member_statuses`**
```
id, name (Anggota Muda|Anggota Tetap|Anggota Kehormatan|Pendiri),
slug, description,
created_at, updated_at
```

**`member_status_histories`**
```
id, member_id (FK),
from_status_id (FK member_statuses, nullable),
to_status_id (FK member_statuses),
changed_by (FK users),
reason (text, nullable),
changed_at (timestamp),
created_at, updated_at
```

**`periods`**
```
id, name (contoh: "2026/2027"),
start_date, end_date,
is_active (boolean),
closed_at (timestamp, nullable),
closed_by (FK users, nullable),
created_at, updated_at
```

**`positions`**
```
id, name (Ketua|Sekretaris|Bendahara|Kabid Networking|...),
slug, description,
default_permissions (JSON — daftar permission default),
order (integer, untuk urutan tampilan),
created_at, updated_at
```

**`managements`**
```
id, member_id (FK), period_id (FK), position_id (FK),
user_id (FK users, nullable),
is_active (boolean),
started_at, ended_at (nullable),
notes (text, nullable),
created_at, updated_at
```
> Unique constraint: `(member_id, period_id, position_id)`  
> Satu anggota hanya bisa memegang satu jabatan per periode.

**`divisions`**
```
id, name (Networking|Programming|DKV),
slug, description, logo,
is_active (boolean),
created_at, updated_at
```

**`division_members`**
```
id, member_id (FK), division_id (FK), period_id (FK),
role_in_division (anggota|kabid),
joined_at, left_at (nullable),
created_at, updated_at
```

**`programs`**
```
id, division_id (FK), period_id (FK),
title, description, target,
status (enum: planning|on_progress|completed|cancelled),
pic_member_id (FK members, nullable),
created_by (FK users),
created_at, updated_at
```

**`activities`**
```
id, division_id (FK, nullable), period_id (FK, nullable),
program_id (FK programs, nullable),
title, slug, description, content,
thumbnail, start_date, end_date, location,
status (enum: draft|published|completed),
created_by (FK users),
created_at, updated_at
```

**`division_reports`**
```
id, division_id (FK), period_id (FK),
submitted_by (FK members — Kabid),
title, content (longtext),
programs_summary (text, nullable),
activities_summary (text, nullable),
achievements (text, nullable),
obstacles (text, nullable),
evaluation (text, nullable),
follow_up_plan (text, nullable),
conclusion (text, nullable),
documentation (JSON — array path foto, nullable),
status (enum: draft|diajukan|direview|perlu_revisi|disetujui),
submitted_at (nullable),
approved_at (nullable),
approved_by (FK users, nullable),
created_at, updated_at
```

**`report_reviews`**
```
id, division_report_id (FK),
reviewed_by (FK users — Ketua),
action (enum: direview|perlu_revisi|disetujui),
notes (text),
reviewed_at (timestamp),
created_at, updated_at
```

**`articles`**
```
id, category_id (FK), author_id (FK users),
title, slug, excerpt, content (longtext),
thumbnail, status (enum: draft|published),
published_at, created_at, updated_at
```

**`finances`**
```
id, period_id (FK),
category_id (FK finance_categories),
type (enum: income|expense),
amount (decimal 15,2),
description, date,
recorded_by (FK users),
created_at, updated_at
```

**`finance_categories`**
```
id, name, type (enum: income|expense|both),
description, created_at, updated_at
```

**`registrations`**
```
id, nim (unique), name, email, phone,
program_studi, angkatan, tempat_lahir, tanggal_lahir, alamat,
division_id (FK, nullable),
alasan, photo,
created_at, updated_at
```

**`settings`**
```
id, key (unique), value, group,
created_at, updated_at
```

---

## 8. Routing Plan

### Public Routes
```
GET  /                       -> PublicLandingController@index
GET  /about                  -> PublicAboutController@index
GET  /structure              -> PublicStructureController@index
GET  /structure/{period}     -> PublicStructureController@show  [?periode=2026/2027]
GET  /divisions              -> PublicDivisionController@index
GET  /divisions/{slug}       -> PublicDivisionController@show
GET  /activities             -> PublicActivityController@index
GET  /activities/{slug}      -> PublicActivityController@show
GET  /articles               -> PublicArticleController@index
GET  /articles/{slug}        -> PublicArticleController@show
GET  /gallery                -> PublicGalleryController@index
GET  /members                -> PublicMemberController@index
GET  /contact                -> PublicContactController@index
POST /contact                -> PublicContactController@store
GET  /register-member        -> PublicRegistrationController@create
POST /register-member        -> PublicRegistrationController@store
```

### Auth Routes
```
GET  /login                  -> Auth\LoginController@showLoginForm
POST /login                  -> Auth\LoginController@login
POST /logout                 -> Auth\LoginController@logout
GET  /password/reset         -> Auth\ResetPasswordController@showLinkRequestForm
POST /password/email         -> Auth\ResetPasswordController@sendResetLinkEmail
```

### Admin Panel Routes *(prefix: /admin, middleware: auth)*

```
# Dashboard
GET  /admin/dashboard        -> Admin\DashboardController@index  [perm: view_dashboard]

# Anggota
     /admin/members/**       [perm: view_members | manage_members]

# Status Keanggotaan (histori)
     /admin/member-statuses/**  [perm: manage_members]

# Periode
     /admin/periods/**       [perm: manage_periods]

# Kepengurusan
     /admin/managements/**   [perm: manage_management]

# Jabatan
     /admin/positions/**     [perm: manage_positions]

# Divisi
     /admin/divisions/**     [perm: view_division | manage_division]

# Program Kerja
     /admin/programs/**      [perm: view_programs | manage_programs]

# Kegiatan
     /admin/activities/**    [perm: view_activities | manage_activities]

# Berita & Pengumuman
     /admin/articles/**      [perm: view_news | manage_news]
     /admin/announcements/** [perm: manage_announcements]

# Galeri
     /admin/gallery/**       [perm: view_gallery | manage_gallery]

# Pendaftaran
     /admin/registrations/** [perm: view_registration | manage_registration]

# Laporan Divisi
GET  /admin/reports/division        -> Admin\DivisionReportController@index
GET  /admin/reports/division/create -> Admin\DivisionReportController@create  [perm: manage_reports]
POST /admin/reports/division        -> Admin\DivisionReportController@store
GET  /admin/reports/division/{id}   -> Admin\DivisionReportController@show
PATCH /admin/reports/division/{id}/submit  -> (submit laporan)  [perm: submit_reports]

# Review Laporan
GET  /admin/reports/review          -> Admin\ReportReviewController@index    [perm: approve_reports]
POST /admin/reports/review/{id}     -> Admin\ReportReviewController@store

# Laporan Organisasi
GET  /admin/reports/organization    -> Admin\OrganizationReportController@index  [perm: view_organization_report]
GET  /admin/reports/organization/export -> (export PDF)

# Keuangan
     /admin/finances/**      [perm: view_finance | manage_finance]

# Pengguna
     /admin/users/**         [perm: manage_users]

# Role & Permission
     /admin/roles/**         [perm: manage_roles]
     /admin/permissions/**   [perm: manage_permissions]

# Pengaturan
     /admin/settings/**      [perm: manage_settings]
```

---

## 9. Teknologi & Library

### Backend
| Package                      | Versi    | Fungsi                                        |
|------------------------------|----------|-----------------------------------------------|
| `laravel/framework`          | ^13.0    | Core framework                                |
| `laravel/tinker`             | ^3.0     | REPL development                              |
| `spatie/laravel-permission`  | ^6.0     | Role & permission management (granular)       |
| `barryvdh/laravel-dompdf`    | ^3.1     | Export PDF (laporan, rekap, keuangan)         |
| `intervention/image`         | ^3.0     | Image processing / resize                     |

### Frontend
| Package                  | Versi   | Fungsi                                |
|--------------------------|---------|---------------------------------------|
| `tailwindcss`            | ^4.0    | Utility CSS framework                 |
| `@tailwindcss/vite`      | ^4.0    | Vite integration                      |
| `vite`                   | ^7.0    | Asset bundler                         |
| `laravel-vite-plugin`    | ^2.0    | Laravel-Vite integration              |
| `axios`                  | ^1.11   | HTTP client JS                        |
| `alpinejs`               | ^3.0    | Lightweight JS reactivity             |

### Dev Dependencies
| Package                        | Fungsi                       |
|--------------------------------|------------------------------|
| `fakerphp/faker`               | Fake data untuk seeder       |
| `laravel/pint`                 | Code formatter               |
| `pestphp/pest`                 | Testing framework            |
| `pestphp/pest-plugin-laravel`  | Laravel plugin for Pest      |
| `nunomaduro/collision`         | Error reporting              |

---

## 10. Autentikasi

- Laravel built-in authentication (session-based)
- Tidak menggunakan Laravel Breeze/Jetstream (custom auth flow)
- **Hanya Super Admin yang dapat membuat akun User**. Tidak ada fitur registrasi publik maupun self-registration.
- **Membership berbeda dengan User Account**. Tidak semua Member harus memiliki akun User. User dihubungkan dengan Member oleh Super Admin.
- Role & permission via `spatie/laravel-permission`
- Login URL: `/login` (Hanya untuk user internal yang telah dibuatkan akun)
- Setelah login, redirect berdasarkan permission:
  - Punya akses internal (dashboard/management) → `/admin/dashboard`
  - Tanpa akses internal (hanya akun biasa tanpa role internal) → diarahkan kembali ke halaman publik atau dicegah masuk ke panel admin
- Hak akses pengurus **hanya berlaku** selama periode kepengurusan aktif (`managements.is_active = true`)
- Ketika periode ditutup: `managements.is_active` di-set `false`, role pengurus dicabut otomatis
- Password reset via email (log driver untuk dev, SMTP untuk production)

---

## 11. Keamanan

- CSRF protection (bawaan Laravel)
- Input validation semua form (Form Request class)
- Granular permission-based access control via `spatie/laravel-permission`
- **Division scope**: Kabid hanya dapat mengakses data divisinya (enforced via middleware `division.scope`)
- Rate limiting pada login (`throttle:6,1`)
- Sanitasi upload file (type: jpg/png/pdf, max size: 2MB foto, 10MB dokumen)
- `.env` tidak ter-commit ke repository (`.gitignore`)
- Soft-delete atau flag `is_active` untuk data yang tidak boleh dihapus (anggota, kepengurusan, laporan)

---

## 12. SEO & Performance

- Meta title & description per halaman publik
- Semantic HTML5
- Open Graph tags untuk artikel dan kegiatan
- Lazy loading gambar
- Vite asset hashing untuk cache busting
- Compression gambar saat upload (via `intervention/image`)

---

## 13. Responsive Design

| Breakpoint | Lebar       | Target Device            |
|------------|-------------|--------------------------|
| `sm`       | >= 640px    | Mobile landscape         |
| `md`       | >= 768px    | Tablet                   |
| `lg`       | >= 1024px   | Desktop                  |
| `xl`       | >= 1280px   | Large desktop            |

---

## 14. Aturan Bisnis

1. **Status keanggotaan berbeda dengan jabatan kepengurusan** — keduanya dicatat secara terpisah.
2. Pengurus aktif berstatus **Anggota Tetap**; status ini dapat diperbarui manual oleh Sekretaris.
3. Pengurus yang telah demisioner **dapat** diubah statusnya menjadi **Anggota Kehormatan**.
4. Status **Pendiri** bersifat permanen — tidak dapat diubah kecuali oleh Super Admin.
5. **Histori kepengurusan tidak boleh dihapus** — cukup `is_active = false` + `ended_at`.
6. **Mekanisme Demisioner**: Saat periode ditutup, semua management aktif menjadi tidak aktif (`is_active = false`), `ended_at` diisi, dan akses pengurus dicabut otomatis.
7. **Struktur Jabatan (Position) vs Divisi (Division) adalah entitas berbeda**. Ketua, Sekretaris, Bendahara, Humas tidak terikat pada satu divisi. Kabid Networking terikat pada Position Kabid Networking dan Division Networking.
8. **Kabid hanya dapat mengelola data divisinya sendiri** — dikenforce oleh middleware `division.scope`. (Contoh: Kabid Networking hanya melihat/mengelola data Networking).
9. Ketua dapat melihat **seluruh laporan** semua divisi.
10. Bendahara memiliki akses eksklusif terhadap data keuangan.
11. Sekretaris memiliki akses eksklusif terhadap administrasi dan kepengurusan.
12. Humas memiliki akses eksklusif terhadap publikasi dan galeri.
13. **Hak akses tidak boleh bergantung secara hardcode pada nama jabatan** — selalu via permission dari Spatie.
14. Hak akses pengurus terkait dengan periode kepengurusan aktif (`managements.is_active = true`).
15. Laporan divisi harus terhubung ke periode dan divisi yang spesifik.
16. **Data histori berikut tidak boleh dihapus permanen:** histori status anggota, histori kepengurusan, laporan divisi yang diajukan/disetujui, histori review laporan, histori periode.
17. Setiap perubahan status laporan harus dicatat di `report_reviews`.
18. Laporan tidak dapat diedit setelah statusnya **Diajukan** kecuali dikembalikan ke **Perlu Revisi** oleh Ketua.
19. Terdapat tepat **2 orang Pendiri** — dapat di-flag dengan `is_founder = true` pada tabel `members`.

---

## 15. Acceptance Criteria

### Keanggotaan & Status
- [ ] Semua 4 status keanggotaan tersedia: Anggota Muda, Anggota Tetap, Anggota Kehormatan, Pendiri
- [ ] Status keanggotaan dan jabatan kepengurusan tersimpan di tabel terpisah
- [ ] Histori perubahan status tercatat di `member_status_histories`
- [ ] Status Pendiri tidak dapat diubah melalui UI biasa
- [ ] 2 orang Pendiri dapat di-flag di sistem

### Autentikasi & Akun
- [ ] Pengunjung dapat melihat website tanpa login (Public Website is read-only).
- [ ] Tidak ada public user registration (tidak ada public account creation).
- [ ] Tidak ada user yang dapat membuat akun sendiri.
- [ ] Hanya Super Admin yang dapat membuat user.
- [ ] User dapat dihubungkan dengan data Member.
- [ ] Tidak semua Member harus memiliki User Account.
- [ ] Role dan Permission menentukan akses internal.
- [ ] User tanpa permission internal tidak dapat membuka modul internal.
- [ ] Public Website tetap dapat diakses tanpa login.
- [ ] Login hanya tersedia untuk user internal.

### Pendaftaran Anggota
- [ ] Terdapat halaman Pendaftaran Anggota publik (tanpa login).
- [ ] Khusus mahasiswa aktif UNITAMA.
- [ ] Form: Nama, NIM (Primary, cegah duplikasi), Program Studi, Angkatan, Email, Nomor HP, TTL, Alamat, Divisi, Alasan, Foto.
- [ ] Form submit HANYA mencatat data, tidak membuat User Account.
- [ ] Setelah sukses, diarahkan ke Halaman Sukses dengan tombol "Gabung Grup WhatsApp".
- [ ] Link WhatsApp dikelola dari Settings oleh Super Admin.
- [ ] Dashboard pengurus HANYA memiliki fungsi view/filter/export pendaftar, TANPA workflow Approve/Reject/Verify.

### Periode & Kepengurusan
- [ ] Sistem mendukung multi-periode (2025/2026, 2026/2027, dst.)
- [ ] Setiap periode memiliki struktur jabatan sendiri di tabel `managements`
- [ ] Semua 7 jabatan tersedia: Ketua, Sekretaris, Bendahara, Kabid Networking, Kabid Programming, Kabid DKV, Humas
- [ ] Menutup periode otomatis mencabut akses pengurus aktif
- [ ] Histori kepengurusan periode lama tidak dihapus
- [ ] Pengurus demisioner tidak dapat mengakses fitur pengurus aktif

### Hak Akses
- [ ] Permission tidak di-hardcode berdasarkan nama jabatan
- [ ] Kabid hanya dapat mengelola data divisinya sendiri
- [ ] Ketua dapat melihat seluruh laporan dan data divisi
- [ ] Bendahara dapat mengelola keuangan
- [ ] Sekretaris dapat mengelola administrasi dan kepengurusan
- [ ] Humas dapat mengelola publikasi, berita, dan galeri
- [ ] Super Admin memiliki akses penuh ke seluruh sistem
- [ ] Permission dapat dikonfigurasi melalui panel admin

### Laporan Divisi
- [ ] Setiap divisi (Networking, Programming, DKV) dapat membuat laporan per periode
- [ ] Laporan memiliki workflow: Draft → Diajukan → Direview → Disetujui
- [ ] Alur revisi tersedia: Perlu Revisi → Diajukan Kembali → Disetujui
- [ ] Kabid hanya dapat membuat laporan divisinya sendiri
- [ ] Ketua dapat melakukan review, memberi catatan, dan menyetujui laporan
- [ ] Sekretaris dapat melihat rekap laporan seluruh divisi
- [ ] Histori review dan catatan tersimpan di `report_reviews`
- [ ] Laporan tidak dapat diedit setelah diajukan (kecuali dikembalikan ke Perlu Revisi)

### Rekap & Laporan Organisasi
- [ ] Sistem menghasilkan rekap laporan seluruh divisi per periode
- [ ] Rekap menampilkan ringkasan: program kerja, kegiatan, progress, pencapaian, kendala
- [ ] Rekap dapat diekspor ke PDF
- [ ] Histori rekap periode sebelumnya tetap dapat diakses

### Halaman Publik
- [ ] Halaman struktur organisasi menampilkan jabatan per periode
- [ ] Filter periode tersedia di halaman struktur
- [ ] Profil Pendiri ditampilkan di halaman About
- [ ] Badge khusus untuk Pendiri dan Anggota Kehormatan di halaman anggota publik

---

## 16. Rencana Implementasi (Roadmap)

### Fase 1 — Foundation ✅ SELESAI
- [x] Setup Laravel 13
- [x] Konfigurasi SQLite
- [x] NPM install & Vite build
- [x] Migration default (users, cache, jobs)
- [x] PRD.md dibuat

### Fase 2 — Database, Auth & Permission
- [ ] Install & konfigurasi `spatie/laravel-permission`
- [ ] Buat migration: `member_statuses`, `members`, `member_status_histories`, `periods`, `positions`, `managements`, `divisions`, `division_members`, `programs`, `activities`, `activity_photos`, `division_reports`, `report_reviews`, `articles`, `article_categories`, `gallery_photos`, `registrations`, `contacts`, `finances`, `finance_categories`, `settings`
- [ ] Buat Model dan relasi antar tabel
- [ ] Buat Seeder: periods, positions, divisions, permissions, roles, admin user, founder members
- [ ] Implementasi custom auth (login/logout) dengan redirect berbasis permission
- [ ] Middleware: `CheckPermission`, `DivisionScope`
- [ ] Sistem pencabutan akses otomatis saat periode ditutup

### Fase 3 — Layout & Design System
- [ ] Layout utama (public): navbar, footer
- [ ] Layout admin: sidebar (role-aware menu), topbar
- [ ] Design system: color tokens, typography, components (dark theme)
- [ ] TailwindCSS v4 konfigurasi custom
- [ ] Micro-animations & transitions

### Fase 4 — Halaman Publik (M01–M10)
- [ ] Landing Page (M01)
- [ ] About + Profil Pendiri (M02)
- [ ] Struktur Organisasi dengan filter periode (M03)
- [ ] Divisi (M04)
- [ ] Kegiatan (M05)
- [ ] Berita/Artikel (M06)
- [ ] Galeri (M07)
- [ ] Anggota Publik + badge (M08)
- [ ] Kontak (M09)
- [ ] Pendaftaran Anggota (M10)

### Fase 5 — Panel Admin (M11–M29)
- [ ] Dashboard role-aware (M11)
- [ ] Manajemen Anggota & Status (M12–M13)
- [ ] Manajemen Periode & Kepengurusan & Jabatan (M14–M16)
- [ ] Manajemen Divisi & Program Kerja (M17–M18)
- [ ] Manajemen Kegiatan (M19)
- [ ] Manajemen Berita & Pengumuman (M20)
- [ ] Manajemen Galeri (M21)
- [ ] Manajemen Pendaftaran (M22)
- [ ] Laporan Divisi + Workflow (M23)
- [ ] Review Laporan oleh Ketua (M24)
- [ ] Laporan Organisasi + Export PDF (M25)
- [ ] Keuangan (M26)
- [ ] Manajemen User, Role & Permission (M27–M28)
- [ ] Pengaturan Website (M29)

### Fase 6 — Polish & Testing
- [ ] Unit & Feature tests (Pest)
- [ ] Responsive testing
- [ ] SEO audit
- [ ] Performance optimization
- [ ] Dokumentasi akhir

---

## 17. Struktur Direktori Laravel (Target)

```
website-cos/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── MemberController.php
│   │   │   │   ├── PeriodController.php
│   │   │   │   ├── ManagementController.php
│   │   │   │   ├── PositionController.php
│   │   │   │   ├── DivisionController.php
│   │   │   │   ├── ProgramController.php
│   │   │   │   ├── ActivityController.php
│   │   │   │   ├── ArticleController.php
│   │   │   │   ├── GalleryController.php
│   │   │   │   ├── RegistrationController.php
│   │   │   │   ├── DivisionReportController.php
│   │   │   │   ├── ReportReviewController.php
│   │   │   │   ├── OrganizationReportController.php
│   │   │   │   ├── FinanceController.php
│   │   │   │   ├── UserController.php
│   │   │   │   └── SettingController.php
│   │   │   ├── Auth/
│   │   │   │   └── LoginController.php
│   │   │   └── Public/
│   │   │       ├── LandingController.php
│   │   │       ├── AboutController.php
│   │   │       ├── StructureController.php
│   │   │       ├── RegistrationController.php
│   │   │       └── ...
│   │   ├── Middleware/
│   │   │   └── DivisionScope.php
│   │   └── Requests/           # Form Request classes
│   └── Models/
│       ├── User.php
│       ├── Member.php
│       ├── MemberStatus.php
│       ├── MemberStatusHistory.php
│       ├── Period.php
│       ├── Position.php
│       ├── Management.php
│       ├── Division.php
│       ├── DivisionMember.php
│       ├── Program.php
│       ├── Activity.php
│       ├── DivisionReport.php
│       ├── ReportReview.php
│       ├── Article.php
│       ├── Finance.php
│       └── ...
├── database/
│   ├── migrations/
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── PeriodSeeder.php
│   │   ├── MemberStatusSeeder.php
│   │   ├── PositionSeeder.php
│   │   ├── DivisionSeeder.php
│   │   ├── PermissionSeeder.php
│   │   ├── RoleSeeder.php
│   │   ├── AdminUserSeeder.php
│   │   ├── FounderMemberSeeder.php
│   │   └── SettingSeeder.php
│   └── database.sqlite
├── resources/
│   ├── css/app.css
│   ├── js/app.js
│   └── views/
│       ├── layouts/
│       │   ├── public.blade.php
│       │   └── admin.blade.php
│       ├── public/
│       └── admin/
├── routes/
│   ├── web.php
│   └── admin.php
└── public/
    └── build/
```

---

## 18. Catatan Penting

> **AUTENTIKASI**  
> Tidak menggunakan template bawaan (Breeze/Jetstream). Autentikasi dibuat custom agar sesuai dengan alur dan desain website.

> **DATABASE**  
> Menggunakan SQLite untuk development. Jika diperlukan production deployment, migrate ke MySQL/PostgreSQL dengan perubahan minimal pada `.env`.

> **DESAIN**  
> Tidak mengikuti template NiceAdmin atau template manapun. Desain dibuat dari scratch dengan konsep dark-tech menggunakan palet warna Navy/Electric Blue.

> **PERMISSION**  
> Gunakan `spatie/laravel-permission` untuk manajemen role & permission. Jangan hardcode hak akses berdasarkan nama jabatan di dalam kode. Selalu cek permission via `$user->can('permission_name')`.

> **DATA INTEGRITY**  
> Data kepengurusan, laporan divisi, dan histori keanggotaan tidak boleh dihapus secara permanen. Gunakan soft delete atau flag `is_active` / `closed_at` untuk menonaktifkan data yang tidak lagi aktif.

---

*Dokumen ini adalah blueprint utama pembangunan Website UKM-IT Cyber Open Source.*  
*Versi: 2.0.0 — Setiap perubahan signifikan pada arsitektur atau fitur harus diperbarui di dokumen ini.*
