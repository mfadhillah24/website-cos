      # BUKU PANDUAN SISTEM
      ## Sistem Informasi Manajemen UKM-IT Cyber Open Source

      ---

      ## Identitas Dokumen

      | Informasi           | Keterangan                                          |
      | ------------------- | --------------------------------------------------- |
      | Nama Sistem         | Sistem Informasi Manajemen UKM-IT Cyber Open Source |
      | Singkatan           | Website COS                                         |
      | Versi Sistem        | 1.0 (Development / Local)                           |
      | Teknologi Backend   | PHP 8.3, Laravel 13                                 |
      | Teknologi Frontend  | Blade Template, Vanilla CSS, JavaScript             |
      | Database            | SQLite (development)                                |
      | Platform            | Web Application                                     |
      | URL Aplikasi        | http://website-cos.test (lokal)                     |
      | Status Dokumentasi  | Final — berdasarkan analisis source code aktual     |
      | Tanggal Dokumentasi | September 2026                                      |

      ---

      # BAB 1 — PENDAHULUAN

      ## 1.1 Tentang Sistem

      Sistem Informasi Manajemen UKM-IT Cyber Open Source (selanjutnya disebut "Sistem COS") adalah aplikasi web yang dirancang untuk mengelola seluruh aktivitas organisasi Unit Kegiatan Mahasiswa bidang Teknologi Informasi. Sistem ini dibangun menggunakan framework Laravel 13 dengan arsitektur Model-View-Controller (MVC) dan mengimplementasikan manajemen peran dan izin berbasis paket Spatie Laravel Permission.

      Sistem mencakup dua lapisan utama: antarmuka publik yang dapat diakses oleh semua pengunjung tanpa autentikasi, dan panel administrasi yang hanya dapat diakses oleh anggota dan pengurus yang telah terautentikasi.

      ## 1.2 Tujuan Sistem

      Sistem ini dibangun dengan tujuan:

      1. Menyediakan portal informasi publik mengenai profil, kegiatan, divisi, dan berita UKM-IT Cyber Open Source.
      2. Mempermudah pengelolaan data keanggotaan, kepengurusan, dan struktur organisasi.
      3. Mengotomatisasi alur kerja administrasi seperti surat-menyurat, agenda, rapat, dan notulen.
      4. Menyediakan sistem pelaporan kegiatan divisi yang terstruktur dengan alur review dan persetujuan.
      5. Mengelola keuangan organisasi termasuk pencatatan transaksi dan pembuatan Rencana Anggaran Biaya (RAB).
      6. Mempermudah proses pendaftaran calon anggota baru secara online.

      ## 1.3 Manfaat Sistem

      **Bagi Pengurus:**
      - Mempercepat proses administrasi organisasi.
      - Menyediakan informasi real-time mengenai kondisi keuangan, laporan, dan kegiatan.
      - Memudahkan koordinasi antar divisi melalui sistem notifikasi internal.
      - Mengurangi penggunaan dokumen fisik melalui manajemen arsip digital.

      **Bagi Anggota:**
      - Mempermudah akses informasi kegiatan dan program kerja divisi.
      - Menyediakan kanal pendaftaran anggota baru yang mudah diakses.
      - Menyediakan profil dan data diri yang terintegrasi dengan sistem.

      **Bagi Organisasi:**
      - Meningkatkan transparansi dalam pengelolaan keuangan.
      - Mempermudah serah terima jabatan melalui dokumentasi yang tersimpan rapi.
      - Menyediakan laporan historis kegiatan dan keuangan per periode kepengurusan.

      ## 1.4 Ruang Lingkup

      Dokumentasi ini mencakup seluruh fitur yang ditemukan dalam source code sistem, meliputi:

      - Antarmuka publik (halaman beranda, profil, organisasi, divisi, kegiatan, berita, galeri, kontak, pendaftaran)
      - Panel administrasi (manajemen anggota, kepengurusan, divisi, kegiatan, keuangan, sekretariat, laporan)
      - Sistem autentikasi dan otorisasi berbasis peran
      - Alur kerja pelaporan dan persetujuan

      ## 1.5 Target Pengguna

      | Pengguna          | Keterangan                                                           |
      | ----------------- | -------------------------------------------------------------------- |
      | Pengunjung Umum   | Mengakses informasi publik tanpa perlu login                         |
      | Calon Anggota     | Mengisi formulir pendaftaran melalui halaman publik                  |
      | Super Admin       | Pengelola sistem dengan akses penuh ke seluruh fitur                 |
      | Admin             | Pengelola umum yang dapat dikonfigurasi hak aksesnya                 |
      | Ketua Umum        | Menyetujui laporan, mengelola kepengurusan, memantau keuangan        |
      | Sekretaris        | Mengelola surat-menyurat, agenda, rapat, notulen, dan arsip          |
      | Bendahara         | Mengelola keuangan dan Rencana Anggaran Biaya (RAB)                  |
      | Kabid Networking  | Mengelola program dan kegiatan divisi Networking                     |
      | Kabid Programming | Mengelola program dan kegiatan divisi Programming                    |
      | Kabid DKV         | Mengelola program dan kegiatan divisi Desain Komunikasi Visual (DKV) |
      | Humas             | Mengelola berita, pengumuman, kegiatan, dan galeri                   |

      ---

      # BAB 2 — GAMBARAN UMUM SISTEM

      ## 2.1 Arsitektur Sistem

      Sistem COS menggunakan arsitektur **Model-View-Controller (MVC)** dari framework Laravel 13.

      ```text
      Permintaan HTTP
            │
            ▼
      routes/web.php  ←── Mendefinisikan semua URL dan method HTTP
            │
            ▼
      Middleware  ←── auth, permission, division.scope
            │
            ▼
      Controller  ←── App\Http\Controllers\{Admin|Public|Auth}\...
            │
            ├── Model  ←── App\Models\... (Eloquent ORM)
            │     │
            │     └── Database (SQLite)
            │
            └── View  ←── resources/views\... (Blade Template Engine)
                  │
                  ▼
            Response HTML ke Browser
      ```

      **Lapisan utama sistem:**

      - **Routes**: Mendefinisikan pemetaan URL ke controller, dipisah menjadi rute publik dan rute admin yang dilindungi middleware autentikasi.
      - **Controllers**: Memproses logika bisnis, validasi, dan mengembalikan data ke view. Dibagi menjadi namespace `Admin`, `Public`, dan `Auth`.
      - **Models**: Merepresentasikan tabel database menggunakan Eloquent ORM beserta relasi antar entitas.
      - **Views**: Template Blade yang merender HTML dengan data dari controller.
      - **Services**: `NotificationService` untuk mengirim notifikasi internal antar pengguna.

      ## 2.2 Teknologi yang Digunakan

      | Komponen         | Teknologi                              |
      | ---------------- | -------------------------------------- |
      | Backend          | PHP 8.3                                |
      | Framework        | Laravel 13                             |
      | Frontend         | Blade Template Engine, Vanilla CSS, JS |
      | Database         | SQLite (development)                   |
      | ORM              | Eloquent ORM (bawaan Laravel)          |
      | Autentikasi      | Laravel Session Authentication         |
      | Otorisasi        | Spatie Laravel Permission 8.3          |
      | PDF              | barryvdh/laravel-dompdf 3.1            |
      | Ikon             | mallardduck/blade-lucide-icons 2.0     |
      | Build Tool       | Vite (npm run dev / build)             |
      | Queue            | Laravel Queue (database driver)        |
      | Cache            | Database Cache Driver                  |
      | Session          | Database Session Driver                |

      ## 2.3 Struktur Sistem

      ```text
      website-cos/
      ├── app/
      │   ├── Http/
      │   │   ├── Controllers/
      │   │   │   ├── Admin/          ← 36 controller panel admin
      │   │   │   ├── Auth/           ← LoginController
      │   │   │   └── Public/         ← 9 controller halaman publik
      │   │   ├── Middleware/
      │   │   └── Requests/           ← Form Request classes
      │   ├── Models/                 ← 35 model Eloquent
      │   ├── Policies/               ← Authorization policies
      │   └── Services/
      │       └── NotificationService.php
      ├── database/
      │   ├── migrations/             ← 48 file migrasi database
      │   └── seeders/                ← 20 file seeder
      ├── resources/
      │   └── views/
      │       ├── admin/              ← View panel admin
      │       ├── auth/               ← View login
      │       ├── layouts/            ← Template utama (admin, public)
      │       ├── public/             ← View halaman publik
      │       └── pdf/                ← Template PDF
      ├── routes/
      │   └── web.php                 ← Semua definisi rute
      └── public/
      └── images/                 ← File gambar yang diunggah
      ```

      ---

      # BAB 3 — PENGGUNA DAN HAK AKSES

      ## 3.1 Daftar Role

      Sistem memiliki 9 role yang didefinisikan dalam `RoleSeeder`:

      | No | Nama Role                      | Keterangan                              |
      | -- | ------------------------------ | --------------------------------------- |
      | 1  | Super Admin                    | Akses penuh seluruh permission          |
      | 2  | Admin                          | Pengelola umum (permission dikonfigurasi) |
      | 3  | Ketua Umum                     | Pimpinan organisasi                     |
      | 4  | Sekretaris                     | Pengelola administrasi dan sekretariat  |
      | 5  | Bendahara                      | Pengelola keuangan dan RAB              |
      | 6  | Kabid Networking               | Kepala Bidang Networking                |
      | 7  | Kabid Programming              | Kepala Bidang Programming               |
      | 8  | Kabid Desain Komunikasi Visual | Kepala Bidang DKV                       |
      | 9  | Humas                          | Pengelola hubungan masyarakat           |

      ## 3.2 Matriks Hak Akses

      | Fitur / Permission            | Super Admin | Admin | Ketua Umum | Sekretaris | Bendahara | Kabid* | Humas |
      | ----------------------------- | :---------: | :---: | :--------: | :--------: | :-------: | :----: | :---: |
      | view_dashboard                | ✓           | ✓     | ✓          | ✓          | ✓         | ✓      | ✓     |
      | view_members                  | ✓           | ✓     | ✓          | ✓          | ✗         | ✗      | ✗     |
      | manage_members                | ✓           | ✓     | ✓          | ✓          | ✗         | ✗      | ✗     |
      | view_management               | ✓           | ✓     | ✓          | ✓          | ✗         | ✗      | ✗     |
      | manage_management             | ✓           | ✓     | ✓          | ✓          | ✗         | ✗      | ✗     |
      | manage_periods                | ✓           | ✓     | ✓          | ✓          | ✗         | ✗      | ✗     |
      | manage_positions              | ✓           | ✓     | ✓          | ✓          | ✗         | ✗      | ✗     |
      | view_division                 | ✓           | ✓     | ✓          | ✗          | ✗         | ✓      | ✗     |
      | manage_division               | ✓           | ✓     | ✗          | ✗          | ✗         | ✓      | ✗     |
      | view_division_members         | ✓           | ✓     | ✗          | ✗          | ✗         | ✓      | ✗     |
      | view_programs                 | ✓           | ✓     | ✓          | ✗          | ✗         | ✓      | ✗     |
      | manage_programs               | ✓           | ✓     | ✗          | ✗          | ✗         | ✓      | ✗     |
      | view_activities               | ✓           | ✓     | ✗          | ✗          | ✗         | ✓      | ✓     |
      | manage_activities             | ✓           | ✓     | ✗          | ✗          | ✗         | ✓      | ✓     |
      | view_news / manage_news       | ✓           | ✓     | ✗          | ✗          | ✗         | ✗      | ✓     |
      | view_announcements            | ✓           | ✓     | ✗          | ✓          | ✗         | ✗      | ✓     |
      | manage_announcements          | ✓           | ✓     | ✗          | ✓          | ✗         | ✗      | ✓     |
      | view_gallery / manage_gallery | ✓           | ✓     | ✗          | ✗          | ✗         | ✗      | ✓     |
      | view_registration             | ✓           | ✓     | ✗          | ✓          | ✗         | ✗      | ✓     |
      | manage_registration           | ✓           | ✓     | ✗          | ✓          | ✗         | ✗      | ✗     |
      | view_finance                  | ✓           | ✓     | ✓          | ✗          | ✓         | ✗      | ✗     |
      | manage_finance                | ✓           | ✓     | ✗          | ✗          | ✓         | ✗      | ✗     |
      | view_rab                      | ✓           | ✓     | ✓          | ✓          | ✓         | ✗      | ✗     |
      | manage_rab                    | ✓           | ✓     | ✗          | ✗          | ✓         | ✗      | ✗     |
      | view_reports / submit_reports | ✓           | ✓     | ✓          | ✗          | ✗         | ✓      | ✗     |
      | review_reports                | ✓           | ✓     | ✓          | ✗          | ✗         | ✗      | ✗     |
      | approve_reports               | ✓           | ✓     | ✓          | ✗          | ✗         | ✗      | ✗     |
      | view_org_reports              | ✓           | ✓     | ✓          | ✗          | ✗         | ✗      | ✗     |
      | manage_incoming_letters       | ✓           | ✓     | ✗          | ✓          | ✗         | ✗      | ✗     |
      | manage_outgoing_letters       | ✓           | ✓     | ✗          | ✓          | ✗         | ✗      | ✗     |
      | manage_dispositions           | ✓           | ✓     | ✗          | ✓          | ✗         | ✗      | ✗     |
      | manage_letter_templates       | ✓           | ✓     | ✗          | ✓          | ✗         | ✗      | ✗     |
      | manage_agendas                | ✓           | ✓     | ✗          | ✓          | ✗         | ✗      | ✗     |
      | manage_meetings               | ✓           | ✓     | ✗          | ✓          | ✗         | ✗      | ✗     |
      | manage_minutes                | ✓           | ✓     | ✗          | ✓          | ✗         | ✗      | ✗     |
      | manage_archives               | ✓           | ✓     | ✗          | ✓          | ✗         | ✗      | ✗     |
      | manage_users                  | ✓           | ✓     | ✓          | ✗          | ✗         | ✗      | ✗     |
      | manage_roles                  | ✓           | ✓     | ✗          | ✗          | ✗         | ✗      | ✗     |
      | manage_settings               | ✓           | ✓     | ✗          | ✗          | ✗         | ✗      | ✗     |

      > **Catatan:** Kabid* merujuk pada ketiga role Kabid (Networking, Programming, Desain Komunikasi Visual) yang memiliki permission identik, namun data yang diakses dibatasi hanya pada divisi yang bersangkutan melalui middleware `division.scope`.

      ---

      # BAB 4 — CARA MENGAKSES SISTEM

      ## 4.1 Persyaratan Sistem

      **Untuk Menjalankan Server:**

      | Komponen      | Persyaratan Minimum |
      | ------------- | ------------------- |
      | PHP           | >= 8.3              |
      | Laravel       | 13.x                |
      | Database      | SQLite / MySQL      |
      | Composer      | >= 2.x              |
      | Node.js / npm | Untuk Vite build    |
      | Browser       | Chrome, Firefox, Edge (versi modern) |

      **Cara Menjalankan Sistem (Development):**

      ```bash
      composer install
      php artisan key:generate
      php artisan migrate
      php artisan db:seed
      npm install
      composer run dev
      ```

      Perintah `composer run dev` akan menjalankan server Laravel, queue worker, Pail log viewer, dan Vite secara bersamaan.

      ## 4.2 Login

      Panel administrasi hanya dapat diakses oleh pengguna yang telah terautentikasi.

      **Langkah Login:**

      1. Buka browser dan akses URL: `http://website-cos.test/login`
      2. Masukkan alamat **email** yang telah terdaftar di sistem.
      3. Masukkan **password** yang sesuai.
      4. (Opsional) Centang kotak **"Remember Me"** untuk sesi yang lebih panjang.
      5. Klik tombol **Login**.
      6. Sistem memvalidasi kredensial dan status aktif akun.
      7. Jika berhasil, pengguna diarahkan ke halaman **Dashboard** sesuai role-nya.
      8. Jika gagal, sistem menampilkan pesan kesalahan: *"Email atau password tidak valid."*

      **Catatan Keamanan:**
      - Jika akun telah dinonaktifkan oleh administrator, sistem akan menolak login dengan pesan: *"Akun Anda telah dinonaktifkan. Hubungi administrator."*
      - Proses login dilindungi rate limiter (maksimal 6 percobaan per menit).

      ## 4.3 Logout

      1. Klik nama pengguna atau ikon akun di pojok kanan atas header panel admin.
      2. Menu dropdown akan muncul.
      3. Klik tombol **"Keluar Sistem"**.
      4. Sistem menghapus sesi dan mengarahkan kembali ke halaman login.

      ## 4.4 Lupa Password

      > **Catatan:** Berdasarkan analisis source code, fitur lupa password (reset password via email) tidak ditemukan diimplementasikan pada versi sistem ini. Jika pengguna lupa password, hubungi administrator untuk melakukan reset secara manual melalui panel atau Artisan tinker.

      ---

      # BAB 5 — DASHBOARD

      ## 5.1 Gambaran Umum

      Dashboard ditampilkan berbeda sesuai role pengguna yang sedang login. Sistem secara otomatis mendeteksi role dan menampilkan dashboard yang sesuai.

      ## 5.2 Dashboard Default (Super Admin / Admin)

      Ditampilkan untuk role yang tidak termasuk Sekretaris atau Kabid.

      | Komponen      | Data yang Ditampilkan         | Sumber Data          |
      | ------------- | ----------------------------- | -------------------- |
      | Total Pengguna | Jumlah seluruh user           | Tabel `users`        |
      | Pengguna Aktif | Jumlah user dengan is_active=true | Tabel `users`    |
      | Total Role     | Jumlah role yang terdaftar    | Tabel `roles`        |
      | Total Anggota  | Jumlah seluruh anggota        | Tabel `members`      |

      ## 5.3 Dashboard Sekretaris

      Dashboard khusus yang menampilkan ringkasan aktivitas sekretariat.

      | Komponen              | Keterangan                                        |
      | --------------------- | ------------------------------------------------- |
      | Total Surat Masuk     | Jumlah seluruh surat masuk                        |
      | Surat Masuk Baru      | Surat masuk dengan status "baru"                  |
      | Total Surat Keluar    | Jumlah seluruh surat keluar                       |
      | Surat Keluar Bulan Ini | Surat keluar pada bulan dan tahun berjalan       |
      | Disposisi Menunggu    | Disposisi dengan status "menunggu"                |
      | Agenda Berikutnya     | Agenda terdekat yang belum lewat                  |
      | Total Rapat           | Jumlah seluruh rapat yang tercatat                |
      | Total Arsip           | Jumlah seluruh dokumen arsip                      |
      | 5 Surat Masuk Terbaru | Daftar surat masuk terbaru                        |

      ## 5.4 Dashboard Kabid (Kepala Bidang)

      Dashboard dinamis yang scope datanya dibatasi pada divisi Kabid yang bersangkutan.

      | Komponen          | Keterangan                                       |
      | ----------------- | ------------------------------------------------ |
      | Informasi Divisi  | Nama dan data divisi yang dipimpin               |
      | Total Program Kerja | Jumlah program kerja divisi                    |
      | Total Kegiatan    | Jumlah kegiatan divisi                           |
      | Total Anggota     | Jumlah anggota yang terdaftar di divisi          |
      | 5 Program Terbaru | Daftar program kerja terbaru divisi              |
      | 5 Kegiatan Terbaru | Daftar kegiatan terbaru divisi                  |

      > **Catatan:** Jika seorang Kabid belum memiliki `division_id` yang dikonfigurasi pada akunnya, data divisi tidak akan ditampilkan.

      ---
      # BAB 6 — PANDUAN FITUR SISTEM

      ## 6.1 Manajemen Anggota

      ### Tujuan
      Mengelola data seluruh anggota UKM-IT Cyber Open Source, termasuk data pribadi, status keanggotaan, dan histori status.

      ### Akses Menu
      Panel Admin → Anggota

      ### Hak Akses
      Permission `view_members` (melihat) dan `manage_members` (kelola). Dimiliki oleh: Super Admin, Admin, Ketua Umum, Sekretaris.

      ### Menampilkan Data
      Menampilkan daftar anggota dengan fitur pencarian (nama, email, NTA) dan filter berdasarkan status. Data ditampilkan dalam bentuk tabel dengan pagination 15 data per halaman.

      ### Menambahkan Anggota
      1. Klik tombol "Tambah Anggota".
      2. Isi formulir data anggota.
      3. Klik "Simpan".

      **Field yang tersedia:**

      | Field       | Tipe     | Wajib | Keterangan                          |
      | ----------- | -------- | :---: | ----------------------------------- |
      | user_id     | integer  | Tidak | Relasi ke akun pengguna             |
      | status_id   | integer  | Ya    | Status keanggotaan                  |
      | nim         | string   | Tidak | Nomor Induk Mahasiswa               |
      | nta         | string   | Tidak | Nomor Tanda Anggota                 |
      | name        | string   | Ya    | Nama lengkap anggota                |
      | email       | string   | Tidak | Email anggota                       |
      | phone       | string   | Tidak | Nomor telepon                       |
      | photo       | file     | Tidak | Foto anggota (gambar)               |
      | angkatan    | string   | Tidak | Angkatan/tahun masuk                |
      | generation  | string   | Tidak | Generasi anggota                    |
      | bio         | text     | Tidak | Biografi singkat                    |
      | linkedin    | string   | Tidak | URL profil LinkedIn                 |
      | github      | string   | Tidak | URL profil GitHub                   |
      | is_founder  | boolean  | Tidak | Menandai anggota pendiri organisasi |

      ### Mengubah Data
      1. Klik tombol "Edit" pada baris data anggota.
      2. Ubah data yang diperlukan.
      3. Klik "Perbarui".

      ### Menghapus Data
      Klik tombol "Hapus" (soft delete — data tidak benar-benar dihapus dari database).

      ### Histori Status Keanggotaan
      Setiap perubahan status anggota dicatat dalam tabel `member_status_histories`, termasuk status sebelumnya, status baru, dan siapa yang mengubah.

      ---

      ## 6.2 Manajemen Kepengurusan

      ### Tujuan
      Mengelola struktur kepengurusan organisasi berdasarkan periode, jabatan, dan anggota yang menjabat.

      ### Akses Menu
      Panel Admin → Kepengurusan

      ### Hak Akses
      `view_management`, `manage_management`. Dimiliki oleh: Super Admin, Admin, Ketua Umum, Sekretaris.

      ### Menampilkan Data
      Menampilkan daftar pengurus aktif pada periode yang dipilih, diurutkan berdasarkan jabatan.

      ### Menambahkan Pengurus
      1. Klik tombol "Tambah Pengurus".
      2. Pilih anggota, periode, jabatan, dan status aktif.
      3. Isi tanggal mulai dan (opsional) tanggal selesai.
      4. Klik "Simpan".

      **Field Penting:**

      | Field       | Keterangan                        |
      | ----------- | --------------------------------- |
      | member_id   | Anggota yang menjabat             |
      | period_id   | Periode kepengurusan              |
      | position_id | Jabatan yang diemban              |
      | user_id     | Akun sistem yang terhubung        |
      | is_active   | Status aktif pengurus             |
      | started_at  | Tanggal mulai menjabat            |
      | ended_at    | Tanggal selesai menjabat          |

      ---

      ## 6.3 Manajemen Periode

      ### Tujuan
      Mengelola periode kepengurusan organisasi. Setiap data (laporan, kegiatan, keuangan, dsb.) dikaitkan dengan periode tertentu.

      ### Hak Akses
      `manage_periods`. Dimiliki oleh: Super Admin, Admin, Ketua Umum, Sekretaris.

      ### Fitur Penting
      - Hanya satu periode yang dapat berstatus **aktif** pada satu waktu.
      - Terdapat fitur **Tutup Periode** (`/admin/periods/{period}/close`) untuk mengakhiri periode aktif.

      ---

      ## 6.4 Manajemen Divisi

      ### Tujuan
      Mengelola data divisi-divisi yang ada dalam organisasi, termasuk program kerja, anggota divisi, dan kegiatan.

      ### Akses Menu
      Panel Admin → Divisi

      ### Hak Akses
      `view_division`, `manage_division`. Kabid hanya dapat mengelola divisinya sendiri (dibatasi oleh middleware `division.scope`).

      ### Menampilkan Data
      Daftar divisi yang terdaftar beserta jumlah program kerja.

      ### Menambah/Mengubah Divisi

      **Field yang tersedia:**

      | Field       | Tipe    | Wajib | Keterangan                           |
      | ----------- | ------- | :---: | ------------------------------------ |
      | name        | string  | Ya    | Nama divisi                          |
      | slug        | string  | Ya    | Slug URL divisi                      |
      | description | text    | Tidak | Deskripsi divisi                     |
      | logo        | file    | Tidak | Logo divisi                          |
      | cover_image | file    | Tidak | Gambar sampul divisi                 |
      | focus_areas | array   | Tidak | Bidang fokus divisi (JSON array)     |
      | is_active   | boolean | Ya    | Status aktif divisi                  |

      ### Manajemen Anggota Divisi
      Dari halaman detail divisi, administrator dapat menambah atau menghapus anggota divisi melalui:
      - `POST /admin/divisions/{division}/members` — menambah anggota
      - `DELETE /admin/divisions/{division}/members/{member}` — menghapus anggota

      ---

      ## 6.5 Program Kerja

      ### Tujuan
      Mengelola daftar program kerja setiap divisi.

      ### Hak Akses
      `view_programs`, `manage_programs`. Kabid hanya dapat mengelola program divisinya sendiri.

      ### Status Program

      | Status      | Keterangan        |
      | ----------- | ----------------- |
      | planning    | Perencanaan       |
      | on_progress | Sedang berjalan   |
      | completed   | Selesai           |
      | cancelled   | Dibatalkan        |

      ---

      ## 6.6 Kegiatan (Aktivitas)

      ### Tujuan
      Mengelola data kegiatan/aktivitas yang dilaksanakan oleh divisi, termasuk dokumentasi foto.

      ### Hak Akses
      `view_activities`, `manage_activities`. Kabid dan Humas dapat mengelola kegiatan.

      ### Menambah Kegiatan

      **Field Penting:**

      | Field       | Tipe     | Wajib | Keterangan                              |
      | ----------- | -------- | :---: | --------------------------------------- |
      | title       | string   | Ya    | Judul kegiatan                          |
      | slug        | string   | Ya    | Slug URL (auto-generate dari title)     |
      | division_id | integer  | Ya    | Divisi penyelenggara                    |
      | description | text     | Tidak | Deskripsi kegiatan                      |
      | start_date  | date     | Tidak | Tanggal mulai                           |
      | end_date    | date     | Tidak | Tanggal selesai                         |
      | location    | string   | Tidak | Lokasi kegiatan                         |
      | status      | enum     | Ya    | Status: draft / published               |
      | thumbnail   | file     | Tidak | Gambar thumbnail kegiatan               |

      ### Upload Foto Dokumentasi
      Setelah kegiatan dibuat, foto dokumentasi dapat diunggah secara terpisah. File foto disimpan di direktori `public/images/activity_photos/`.

      ### Menghapus Foto
      `DELETE /admin/activities/photos/{photo}` — menghapus foto individual dari kegiatan.

      ---

      ## 6.7 Berita dan Artikel

      ### Tujuan
      Mengelola konten berita/artikel yang dipublikasikan di halaman publik.

      ### Hak Akses
      `view_news`, `manage_news`. Dimiliki oleh: Super Admin, Admin, Humas.

      ### Status Artikel

      | Status    | Keterangan                                  |
      | --------- | ------------------------------------------- |
      | draft     | Dalam penyusunan, tidak tampil di publik    |
      | published | Dipublikasikan, tampil di halaman publik    |

      ### Upload Gambar di Artikel
      Sistem menyediakan endpoint khusus untuk upload gambar dalam editor artikel:
      `POST /admin/articles/upload-image`

      ---

      ## 6.8 Pengumuman

      ### Tujuan
      Mempublikasikan pengumuman yang bersifat penting untuk anggota atau publik.

      ### Hak Akses
      `view_announcements`, `manage_announcements`. Dimiliki oleh: Super Admin, Admin, Sekretaris, Humas.

      ---

      ## 6.9 Galeri Foto

      ### Tujuan
      Menampilkan koleksi foto kegiatan organisasi di halaman publik.

      ### Hak Akses
      `view_gallery`, `manage_gallery`. Dimiliki oleh: Super Admin, Admin, Humas.

      ### Operasi yang Tersedia
      - Menampilkan daftar foto (index)
      - Menambah foto baru (create, store)
      - Menghapus foto (destroy)

      ---

      ## 6.10 Pendaftaran Anggota

      ### Tujuan
      Mengelola data formulir pendaftaran calon anggota baru yang masuk melalui halaman publik.

      ### Hak Akses
      `view_registration`, `manage_registration`. Panel admin untuk melihat dan mengelola data pendaftaran.

      ### Alur Pendaftaran
      Calon anggota mengisi formulir di halaman publik → data tersimpan di tabel `registrations` → notifikasi dikirim ke Ketua Umum dan Sekretaris → administrator meninjau dan memproses pendaftaran.

      ### Field Formulir Pendaftaran

      | Field       | Keterangan                     |
      | ----------- | ------------------------------ |
      | name        | Nama lengkap calon anggota     |
      | nim         | Nomor Induk Mahasiswa          |
      | email       | Alamat email                   |
      | phone       | Nomor telepon                  |
      | division_id | Divisi yang diminati           |
      | photo       | Foto diri                      |

      ### Unduh Bukti Pendaftaran
      Setelah mendaftar, calon anggota dapat mengunduh bukti pendaftaran dalam format PDF melalui:
      `GET /register/download/{registration}`

      ---

      ## 6.11 Manajemen Keuangan

      ### Tujuan
      Mencatat seluruh transaksi keuangan organisasi (pemasukan dan pengeluaran) pada periode aktif.

      ### Hak Akses
      `view_finance`, `manage_finance`. Dimiliki oleh: Super Admin, Admin, Bendahara.

      ### Menambah Transaksi

      **Field yang diperlukan:**

      | Field       | Tipe    | Wajib | Keterangan                               |
      | ----------- | ------- | :---: | ---------------------------------------- |
      | category_id | integer | Ya    | Kategori transaksi                       |
      | date        | date    | Ya    | Tanggal transaksi                        |
      | description | string  | Ya    | Keterangan transaksi (maks. 500 karakter) |
      | amount      | integer | Ya    | Jumlah (dalam rupiah, min. 1)            |
      | type        | enum    | Ya    | `income` (pemasukan) atau `expense` (pengeluaran) |
      | receipt     | file    | Tidak | Bukti transaksi (jpg, jpeg, png, pdf, maks. 2MB) |

      ### Ringkasan Keuangan
      Halaman index keuangan menampilkan:
      - Total Pemasukan periode aktif
      - Total Pengeluaran periode aktif
      - Saldo (Pemasukan - Pengeluaran)
      - Ringkasan RAB (jumlah RAB, status draft/final, total anggaran)

      ### Ekspor PDF
      Laporan keuangan dapat diekspor ke PDF melalui `GET /admin/finances/export-pdf` dalam format A4 landscape.

      ---

      ## 6.12 Rencana Anggaran Biaya (RAB)

      ### Tujuan
      Mengelola dokumen Rencana Anggaran Biaya untuk setiap kegiatan yang akan dilaksanakan.

      ### Hak Akses
      `view_rab` (melihat): Ketua Umum, Sekretaris, Bendahara, Super Admin, Admin.
      `manage_rab` (kelola): Bendahara, Super Admin, Admin.

      ### Menambah RAB

      **Informasi RAB:**

      | Field         | Keterangan                              |
      | ------------- | --------------------------------------- |
      | activity_name | Nama kegiatan yang direncanakan         |
      | period_id     | Periode kepengurusan                    |
      | date          | Tanggal RAB                             |
      | pic_name      | Nama penanggung jawab                   |
      | pic_position  | Jabatan penanggung jawab                |
      | description   | Keterangan tambahan (opsional)          |

      **Item Rincian Anggaran:**

      | Field       | Keterangan                    |
      | ----------- | ----------------------------- |
      | description | Uraian barang/jasa            |
      | quantity    | Volume/jumlah (min. 1)        |
      | unit        | Satuan (pcs, hari, buah, dsb.) |
      | unit_price  | Harga satuan (Rp)             |
      | subtotal    | Volume × Harga Satuan (otomatis dihitung) |

      Minimal harus ada 1 item rincian anggaran.

      ### Status RAB

      | Status | Keterangan                                              |
      | ------ | ------------------------------------------------------- |
      | draft  | Masih dalam penyusunan, dapat diubah                    |
      | final  | Telah difinalisasi, tidak dapat diubah                  |

      ### Finalisasi RAB
      Klik tombol "Finalisasi" pada halaman detail RAB. Status berubah menjadi `final` dan notifikasi dikirim ke Ketua Umum dan Sekretaris.

      ### Ekspor PDF
      Setiap RAB dapat diekspor ke PDF melalui `GET /admin/rabs/{rab}/pdf`.

      ---

      ## 6.13 Laporan Kegiatan Divisi

      ### Tujuan
      Mendokumentasikan kegiatan yang telah dilaksanakan oleh divisi, dengan alur pengajuan dan review dari Ketua Umum.

      ### Hak Akses
      `view_reports`, `submit_reports`: Kabid (melihat dan mengajukan laporan divisinya).
      `review_reports`, `approve_reports`: Ketua Umum (mereview dan menyetujui).
      `manage_all_reports`: Super Admin, Admin (melihat semua laporan).

      ### Alur Laporan

      ```text
      Kabid membuat laporan (status: draft)
            │
            ▼
      Upload foto dokumentasi
            │
            ▼
      Kabid mengajukan laporan (status: submitted)
            │
            ▼
      Notifikasi dikirim ke Ketua Umum
            │
            ▼
      Ketua Umum mereview laporan
            │
            ├── Perlu Revisi (status: revision) → Kabid merevisi
            │
            └── Disetujui (status: approved)
      ```

      ### Tipe Kegiatan

      | Tipe           | Keterangan             |
      | -------------- | ---------------------- |
      | pembelajaran   | Kegiatan Pembelajaran  |
      | program_kerja  | Program Kerja          |
      | rapat          | Rapat                  |
      | lainnya        | Lainnya                |

      ### Status Laporan

      | Status    | Keterangan          |
      | --------- | ------------------- |
      | draft     | Masih dibuat        |
      | submitted | Telah diajukan      |
      | reviewing | Sedang direview     |
      | revision  | Perlu revisi        |
      | approved  | Disetujui           |

      ### Upload Foto Dokumentasi
      Foto dapat diunggah setelah laporan dibuat. Setiap foto dapat disertai keterangan (caption). Format: gambar (jpg, jpeg, png, dll.), maksimal 3MB per file.

      ---

      ## 6.14 Surat Masuk

      ### Tujuan
      Mencatat dan mengelola surat-surat yang masuk ke organisasi.

      ### Hak Akses
      `manage_incoming_letters`. Dimiliki oleh: Sekretaris, Super Admin, Admin.

      ### Field Surat Masuk

      | Field          | Keterangan                              |
      | -------------- | --------------------------------------- |
      | letter_number  | Nomor surat (maks. 100 karakter)        |
      | letter_date    | Tanggal surat                           |
      | received_date  | Tanggal diterima                        |
      | sender         | Pengirim surat                          |
      | agenda_number  | Nomor agenda (opsional)                 |
      | subject        | Perihal surat                           |
      | letter_type    | Jenis surat (opsional)                  |
      | priority       | Prioritas: Biasa, Penting, Segera, Rahasia |
      | summary        | Ringkasan isi surat                     |
      | file           | File surat (pdf, doc, docx, jpg, jpeg, png, maks. 5MB) |

      ### Fitur Pencarian dan Filter
      - Pencarian berdasarkan nomor surat, pengirim, atau perihal.
      - Filter berdasarkan status, prioritas, dan rentang tanggal.

      ---

      ## 6.15 Surat Keluar

      ### Tujuan
      Mencatat surat-surat yang dikeluarkan oleh organisasi.

      ### Hak Akses
      `manage_outgoing_letters`. Dimiliki oleh: Sekretaris, Super Admin, Admin.

      ### Field Tambahan (khusus surat keluar)

      | Field           | Keterangan                |
      | --------------- | ------------------------- |
      | receiver        | Penerima surat            |
      | signer          | Penandatangan surat       |
      | signer_position | Jabatan penandatangan     |

      ---

      ## 6.16 Disposisi Surat

      ### Tujuan
      Mengelola disposisi (instruksi tindak lanjut) dari surat masuk kepada pihak yang berwenang.

      ### Hak Akses
      `manage_dispositions`. Dimiliki oleh: Sekretaris, Super Admin, Admin.

      ### Status Disposisi

      | Status    | Keterangan        |
      | --------- | ----------------- |
      | menunggu  | Belum ditindak    |
      | diproses  | Sedang diproses   |
      | selesai   | Telah diselesaikan |

      ---

      ## 6.17 Template Surat

      ### Tujuan
      Menyimpan template dokumen surat yang dapat diunduh dan digunakan sebagai acuan pembuatan surat.

      ### Hak Akses
      `manage_letter_templates`. Dimiliki oleh: Sekretaris, Super Admin, Admin.

      ### Fitur
      - Mengelola template surat (tambah, lihat, hapus).
      - Upload file template (docx, pdf, dll.).
      - Mengunduh template: `GET /admin/letter-templates/{id}/download`.

      ---

      ## 6.18 Agenda

      ### Tujuan
      Mencatat agenda-agenda kegiatan organisasi berdasarkan tanggal.

      ### Hak Akses
      `manage_agendas`. Dimiliki oleh: Sekretaris, Super Admin, Admin.

      ---

      ## 6.19 Rapat

      ### Tujuan
      Mencatat data rapat yang diselenggarakan oleh organisasi, termasuk jumlah peserta.

      ### Hak Akses
      `manage_meetings`. Dimiliki oleh: Sekretaris, Super Admin, Admin.

      ### Field Rapat

      | Field            | Keterangan                  |
      | ---------------- | --------------------------- |
      | title            | Judul/topik rapat           |
      | meeting_date     | Tanggal rapat               |
      | location         | Tempat rapat                |
      | attendance_count | Jumlah peserta yang hadir   |

      ---

      ## 6.20 Notulen Rapat

      ### Tujuan
      Mendokumentasikan hasil dan keputusan dari setiap rapat yang dilaksanakan.

      ### Hak Akses
      `manage_minutes`. Dimiliki oleh: Sekretaris, Super Admin, Admin.

      ### Catatan
      Setiap rapat hanya dapat memiliki satu notulen. Jika notulen sudah dibuat untuk suatu rapat, rapat tersebut tidak muncul lagi dalam pilihan saat membuat notulen baru.

      ### Field Notulen

      | Field               | Keterangan                                       |
      | ------------------- | ------------------------------------------------ |
      | meeting_id          | Rapat yang ditulis notulennya                    |
      | leader              | Pemimpin rapat (opsional)                        |
      | notulist            | Pencatat notulen (opsional)                      |
      | discussion_results  | Hasil pembahasan (wajib)                         |
      | decisions           | Keputusan rapat (opsional)                       |
      | follow_up           | Tindak lanjut (opsional)                         |
      | follow_up_deadline  | Batas waktu tindak lanjut (opsional)             |
      | attachment          | File lampiran (pdf, doc, docx, jpg, jpeg, png, maks. 5MB) |

      ### Ekspor PDF Notulen
      `GET /admin/minutes/{minute}/pdf`

      ---

      ## 6.21 Arsip Dokumen

      ### Tujuan
      Menyimpan dan mengelola dokumen-dokumen penting organisasi secara digital.

      ### Hak Akses
      `manage_archives`. Dimiliki oleh: Sekretaris, Super Admin, Admin.

      ### Tingkat Visibilitas

      | Visibilitas | Dapat Dilihat Oleh                           |
      | ----------- | -------------------------------------------- |
      | public      | Semua pengguna yang login                    |
      | internal    | Semua pengguna yang login                    |
      | private     | Hanya Super Admin, Ketua Umum, dan yang punya permission manage_archives |

      ### Fitur Soft Delete
      Arsip menggunakan soft delete — dokumen yang dihapus tidak langsung hilang dari database dan dapat dipulihkan. Terdapat fitur:
      - `POST /admin/archives/{archive}/restore` — memulihkan arsip yang dihapus
      - `DELETE /admin/archives/{archive}/force-delete` — menghapus permanen

      ---

      ## 6.22 Manajemen Pengguna

      ### Tujuan
      Mengelola akun pengguna yang dapat mengakses panel administrasi.

      ### Hak Akses
      `manage_users`. Dimiliki oleh: Super Admin, Admin, Ketua Umum.

      ### Field Pengguna

      | Field      | Keterangan                         |
      | ---------- | ---------------------------------- |
      | name       | Nama pengguna                      |
      | email      | Email (digunakan sebagai username) |
      | password   | Password (di-hash bcrypt)          |
      | is_active  | Status aktif akun                  |
      | division_id | Divisi (khusus untuk role Kabid)  |

      ### Menonaktifkan Pengguna
      `PATCH /admin/users/{user}/toggle-active` — mengaktifkan atau menonaktifkan akun pengguna.

      ---

      ## 6.23 Manajemen Role dan Permission

      ### Hak Akses
      `manage_roles`. Dimiliki oleh: Super Admin, Admin.

      ### Catatan
      Role dan permission dikelola menggunakan Spatie Laravel Permission. Perubahan pada role dan permission berlaku secara langsung pada seluruh pengguna yang memiliki role tersebut.

      ---

      ## 6.24 Pengaturan Sistem

      ### Hak Akses
      `manage_settings`. Dimiliki oleh: Super Admin, Admin.

      ### Tujuan
      Mengelola konfigurasi umum aplikasi yang tersimpan di tabel `settings` dalam database.

      ---

      ## 6.25 Notifikasi

      ### Tujuan
      Memberikan notifikasi real-time internal kepada pengguna yang relevan ketika terjadi peristiwa tertentu dalam sistem.

      ### Cara Kerja
      Notifikasi dikirim melalui `NotificationService::sendToRole()`. Sistem memeriksa notifikasi baru setiap 60 detik secara otomatis melalui polling di browser.

      ### Peristiwa yang Memicu Notifikasi

      | Peristiwa               | Penerima                      |
      | ----------------------- | ----------------------------- |
      | Pendaftaran anggota baru | Ketua Umum, Sekretaris        |
      | RAB baru dibuat          | Ketua Umum, Sekretaris        |
      | RAB difinalisasi         | Ketua Umum, Sekretaris        |
      | Laporan diajukan         | Ketua Umum                    |
      | Transaksi keuangan baru  | Bendahara                     |

      ---

      ## 6.26 Halaman Publik

      Sistem menyediakan antarmuka publik yang dapat diakses oleh siapapun tanpa login.

      | Halaman        | URL                     | Keterangan                                    |
      | -------------- | ----------------------- | --------------------------------------------- |
      | Beranda        | `/`                     | Statistik, berita, kegiatan, galeri, pengurus |
      | Tentang        | `/tentang`              | Profil dan sejarah organisasi                 |
      | Organisasi     | `/organisasi`           | Struktur kepengurusan periode aktif           |
      | Divisi         | `/divisi`               | Daftar seluruh divisi aktif                   |
      | Detail Divisi  | `/divisi/{slug}`        | Detail, program, kegiatan, dan anggota divisi |
      | Kegiatan       | `/kegiatan`             | Daftar kegiatan                               |
      | Detail Kegiatan | `/kegiatan/{slug}`     | Detail kegiatan                               |
      | Berita         | `/berita`               | Daftar artikel/berita                         |
      | Detail Berita  | `/berita/{slug}`        | Detail artikel                                |
      | Galeri         | `/galeri`               | Galeri foto                                   |
      | Kontak         | `/kontak`               | Formulir kontak                               |
      | Pendaftaran    | `/register`             | Formulir pendaftaran anggota baru             |

      ---

      ## 6.27 Countdown Kegiatan (Halaman Beranda)

      ### Tujuan
      Menginformasikan pengunjung mengenai kegiatan/acara organisasi terdekat yang akan datang, sehingga meningkatkan partisipasi.

      ### Fitur dan Mekanisme
      - **Sumber Data Terintegrasi:** Countdown mengambil data kegiatan secara langsung dari **database kegiatan** pada sistem, bukan data statis/hardcode.
      - **Deteksi Kegiatan Mendatang:** Sistem secara otomatis mencari kegiatan yang akan datang dengan kriteria: status `published` (dipublikasikan) dan tanggal kegiatan (`start_date`) lebih dari atau sama dengan hari ini, lalu mengurutkannya untuk mencari kegiatan terdekat.
      - **Real-time:** Hitungan mundur (countdown) diperbarui secara real-time di sisi *client* menggunakan JavaScript.
      - **Informasi yang Ditampilkan:** Section countdown di halaman Beranda menampilkan informasi meliputi:
      - Nama/judul kegiatan
      - Tanggal kegiatan
      - Waktu kegiatan (jika tersedia)
      - Lokasi kegiatan (jika tersedia)
      - Hitungan mundur aktual berupa **hari, jam, menit, dan detik**.
      - **Pergantian Otomatis:** Jika kegiatan yang sedang ditampilkan pada countdown telah selesai (waktunya berlalu), sistem akan secara otomatis menggunakan kegiatan berikutnya yang masih akan datang sesuai data di database.
      - **Fallback / Kondisi Kosong:** Jika tidak terdapat kegiatan mendatang di dalam database, sistem secara otomatis menangani kondisi ini dengan menampilkan kondisi kosong/fallback yang telah disesuaikan pada desain.

      ---

      ## 6.28 Linux Interactive Terminal (Halaman Beranda)

      ### Tujuan
      Terminal merupakan elemen antarmuka interaktif pada website (khususnya halaman Beranda) yang dirancang menyerupai terminal Linux. Fitur ini bertujuan untuk memperkenalkan dan mensimulasikan penggunaan perintah dasar Linux kepada pengunjung, sesuai dengan identitas UKM-IT Cyber Open Source.

      ### Fitur Utama
      - **Virtual Filesystem:** Simulasi hierarki direktori (seperti `~/Programming/Laravel`) lengkap dengan file di dalamnya.
      - **Autocomplete:** Mendukung tombol `Tab` untuk melengkapi perintah atau nama path/file.
      - **Riwayat Perintah (History):** Mendukung navigasi riwayat perintah yang pernah diketik menggunakan tombol panah atas (`↑`) dan bawah (`↓`).
      - **Navigasi Halaman:** Terminal terintegrasi dengan *router* website, sehingga pengunjung dapat berpindah halaman menggunakan perintah seperti `cd kegiatan`.

      ### Daftar Perintah (Command) yang Tersedia

      Berikut adalah seluruh perintah Linux yang didukung pada implementasi aktual:

      | Perintah | Contoh | Fungsi |
      | --- | --- | --- |
      | `cd` | `cd berita` | Berpindah ke direktori lain dalam filesystem virtual, **atau** melakukan navigasi halaman website (contoh: `cd kegiatan`, `cd galeri`, `cd tentang`). Jika direktori tujuan tidak ada, akan menampilkan error. |
      | `pwd` | `pwd` | Menampilkan jalur (*path*) direktori aktif tempat pengguna berada saat ini di virtual filesystem. |
      | `ls` | `ls -la` | Menampilkan daftar file dan direktori di dalam lokasi aktif. Mendukung parameter `-a` (tampilkan hidden file), `-l` (tampilkan detail size/permissions), atau gabungan `-la`. |
      | `cat` | `cat file.txt` | Membaca dan menampilkan isi teks dari suatu file yang ada di virtual filesystem. |
      | `head` | `head file.txt` | Membaca dan menampilkan isi file (disimulasikan sama seperti pembacaan file normal pada terminal ini). |
      | `tail` | `tail file.txt` | Membaca dan menampilkan isi file (disimulasikan sama seperti pembacaan file normal). |
      | `file` | `file file.txt` | Menampilkan informasi tipe dari suatu item (apakah sebuah direktori atau teks ASCII). |
      | `tree` | `tree` | Menampilkan struktur hierarki seluruh folder dan file dalam bentuk visual pohon. |
      | `clear` | `clear` | Membersihkan layar terminal dari seluruh output perintah sebelumnya. |
      | `history` | `history` | Menampilkan daftar riwayat perintah yang pernah dieksekusi pengguna pada sesi terminal saat ini. |
      | `echo` | `echo Hello World` | Menampilkan kembali (mencetak) argumen teks yang diberikan setelah perintah. |
      | `whoami` | `whoami` | Menampilkan identitas pengguna saat ini (mengembalikan output statis: `Cyber Open Source`). |
      | `id` | `id` | Menampilkan detail informasi *User ID* (UID), *Group ID* (GID), dan *Groups* pengguna virtual. |
      | `hostname` | `hostname` | Menampilkan nama *host* komputer/server (mengembalikan output statis: `unitama`). |
      | `uname` | `uname -a` | Menampilkan informasi kernel dan sistem operasi. Mendukung parameter `-a` untuk info lebih lengkap. |
      | `date` | `date` | Menampilkan tanggal dan waktu aktual saat ini secara *real-time* sesuai lokal ID. |
      | `uptime` | `uptime` | Menampilkan informasi durasi waktu aktif sistem (output simulasi statis). |
      | `free` | `free -h` | Menampilkan informasi penggunaan memori dan swap. Mendukung parameter `-h` agar *human readable*. |
      | `df` | `df -h` | Menampilkan informasi penggunaan kapasitas ruang disk (*filesystem*). Mendukung parameter `-h`. |
      | `neofetch` | `neofetch` | Menampilkan informasi sistem dalam tata letak grafis ASCII berbasis HTML yang estetis beserta spesifikasi OS, Host, Kernel, Shell, dll. |
      | `htop` | `htop` | Menampilkan pesan error *mock* bahwa antarmuka interaktif tidak tersedia di terminal web. |
      | `git` | `git status` | Mensimulasikan perintah dasar Git. Mendukung parameter `--version`, `status`, `log`, dan `branch` dengan pesan *mock* sesuai output Git asli. |
      | `help` / `man` | `help` | Menampilkan menu bantuan lengkap yang berisi daftar navigasi website, virtual filesystem, perintah sistem, dan perintah khusus COS. |
      | `cos` | `cos divisi` | Perintah kustom organisasi. Sub-command: <br>- `about` (Info organisasi)<br>- `divisi` / `divisions` (Daftar divisi)<br>- `motto` (Motto COS)<br>- `versi` / `version` (Versi terminal)<br>- `kontak` / `contact` (Info kontak)<br>- `kegiatan` / `activities` (Menampilkan daftar kegiatan mendatang yang **diambil langsung dari database via API**). |

      > **Catatan:** Terminal juga dilengkapi dengan efek animasi mengetik otomatis (*intro typewriter sequence*) saat halaman pertama kali dimuat. Namun, daftar tabel di atas merupakan perintah yang murni dapat diakses dan diinteraksikan secara langsung oleh pengguna.

      ---

      # BAB 7 — ALUR PROSES SISTEM

      ## 7.1 Alur Login

      ```text
      Pengguna mengakses /login
            │
            ▼
      Mengisi email dan password
            │
            ▼
      Sistem memvalidasi kredensial
            │
            ├── Tidak cocok → Pesan error, kembali ke form login
            │
            ▼
      Sistem memeriksa status is_active
            │
            ├── is_active = false → Logout paksa, pesan "akun dinonaktifkan"
            │
            ▼
      Sesi berhasil dibuat
            │
            ▼
      Redirect ke admin/dashboard
            │
            └── Dashboard berbeda sesuai role pengguna
      ```

      ## 7.2 Alur Pendaftaran Anggota Baru (Publik)

      ```text
      Calon Anggota membuka /register
            │
            ▼
      Mengisi formulir pendaftaran (nama, NIM, email, divisi, foto)
            │
            ▼
      Validasi data oleh sistem
            │
            ├── Tidak valid → Pesan error, kembali ke formulir
            │
            ▼
      Data tersimpan di tabel registrations
            │
            ▼
      Notifikasi dikirim ke Ketua Umum dan Sekretaris
            │
            ▼
      Calon anggota diarahkan ke halaman sukses
            │
            ▼
      Calon anggota dapat mengunduh bukti pendaftaran (PDF)
      ```

      ## 7.3 Alur Laporan Kegiatan Divisi

      ```text
      Kabid membuat laporan baru (status: draft)
            │
            ▼
      Mengisi data laporan (judul, tanggal, jenis, isi)
            │
            ▼
      Upload foto dokumentasi (opsional)
            │
            ▼
      Kabid mengajukan laporan (Submit)
            │     Status berubah → submitted
            ▼
      Notifikasi otomatis ke Ketua Umum
            │
            ▼
      Ketua Umum mereview laporan
            │
            ├── Laporan perlu revisi
            │       │
            │       └── Status → revision
            │               │
            │               └── Kabid merevisi dan mengajukan ulang
            │
            └── Laporan disetujui
                        │
                        └── Status → approved
      ```

      ## 7.4 Alur Pembuatan RAB

      ```text
      Bendahara membuka /admin/rabs/create
            │
            ▼
      Mengisi informasi RAB (nama kegiatan, periode, tanggal, PIC)
            │
            ▼
      Menambahkan item rincian anggaran (minimal 1 item)
            │
            ▼
      Sistem otomatis menghitung subtotal per item dan total anggaran
            │
            ▼
      Klik "Simpan RAB" → Status: draft
            │
            ▼
      Notifikasi ke Ketua Umum dan Sekretaris
            │
            ▼
      (Opsional) Bendahara klik "Finalisasi" → Status: final
            │
            ▼
      Notifikasi finalisasi ke Ketua Umum dan Sekretaris
            │
            ▼
      RAB dapat diekspor ke PDF
      ```

      ## 7.5 Alur Pengelolaan Surat Masuk

      ```text
      Surat fisik diterima
            │
            ▼
      Sekretaris membuka /admin/letters/incoming/create
            │
            ▼
      Mengisi data surat (nomor, tanggal, pengirim, perihal, prioritas)
            │
            ▼
      Upload file surat (opsional)
            │
            ▼
      Data tersimpan dengan status "baru"
            │
            ▼
      (Opsional) Buat disposisi untuk menindaklanjuti surat
            │
            ▼
      Update status disposisi sesuai perkembangan tindak lanjut
      ```

      ---

      # BAB 8 — MANAJEMEN DATA

      ## 8.1 Entitas Utama Sistem

      ### Entitas Member (Anggota)

      | Field     | Tipe    | Wajib | Keterangan                     |
      | --------- | ------- | :---: | ------------------------------ |
      | id        | integer | Ya    | Primary key                    |
      | user_id   | integer | Tidak | Relasi ke tabel users          |
      | status_id | integer | Ya    | Status keanggotaan             |
      | nim       | string  | Tidak | Nomor Induk Mahasiswa          |
      | nta       | string  | Tidak | Nomor Tanda Anggota            |
      | name      | string  | Ya    | Nama lengkap                   |
      | email     | string  | Tidak | Email                          |
      | phone     | string  | Tidak | Nomor telepon                  |
      | photo     | string  | Tidak | Path foto                      |
      | angkatan  | string  | Tidak | Angkatan                       |
      | generation| string  | Tidak | Generasi                       |
      | bio       | text    | Tidak | Biografi                       |
      | linkedin  | string  | Tidak | URL LinkedIn                   |
      | github    | string  | Tidak | URL GitHub                     |
      | is_founder| boolean | Tidak | Status anggota pendiri         |
      | deleted_at| datetime| Tidak | Soft delete timestamp          |

      ### Entitas Division (Divisi)

      | Field       | Tipe    | Wajib | Keterangan               |
      | ----------- | ------- | :---: | ------------------------ |
      | id          | integer | Ya    | Primary key              |
      | name        | string  | Ya    | Nama divisi              |
      | slug        | string  | Ya    | Slug URL                 |
      | description | text    | Tidak | Deskripsi                |
      | logo        | string  | Tidak | Path logo                |
      | cover_image | string  | Tidak | Path gambar sampul       |
      | focus_areas | json    | Tidak | Array bidang fokus       |
      | is_active   | boolean | Ya    | Status aktif             |

      ### Entitas Rab (Rencana Anggaran Biaya)

      | Field         | Tipe    | Wajib | Keterangan               |
      | ------------- | ------- | :---: | ------------------------ |
      | id            | integer | Ya    | Primary key              |
      | code          | string  | Ya    | Kode unik RAB            |
      | activity_name | string  | Ya    | Nama kegiatan            |
      | period_id     | integer | Ya    | Periode kepengurusan     |
      | date          | date    | Ya    | Tanggal RAB              |
      | pic_name      | string  | Ya    | Nama penanggung jawab    |
      | pic_position  | string  | Ya    | Jabatan PIC              |
      | description   | text    | Tidak | Keterangan               |
      | status        | string  | Ya    | draft / final            |
      | created_by    | integer | Ya    | User pembuat             |

      ---

      # BAB 9 — DATABASE

      ## 9.1 Daftar Tabel

      | No | Tabel                      | Fungsi                                             |
      | -- | -------------------------- | -------------------------------------------------- |
      | 1  | users                      | Data akun pengguna sistem                          |
      | 2  | member_statuses            | Master status keanggotaan                          |
      | 3  | members                    | Data anggota UKM                                   |
      | 4  | member_status_histories    | Histori perubahan status anggota                   |
      | 5  | periods                    | Periode kepengurusan                               |
      | 6  | positions                  | Master jabatan pengurus                            |
      | 7  | managements                | Struktur kepengurusan per periode                  |
      | 8  | divisions                  | Data divisi organisasi                             |
      | 9  | division_members           | Keanggotaan anggota dalam divisi per periode       |
      | 10 | programs                   | Program kerja divisi                               |
      | 11 | activities                 | Kegiatan/aktivitas divisi                          |
      | 12 | activity_photos            | Foto dokumentasi kegiatan                          |
      | 13 | gallery_photos             | Foto galeri publik                                 |
      | 14 | article_categories         | Kategori artikel/berita                            |
      | 15 | articles                   | Artikel/berita                                     |
      | 16 | article_images             | Gambar dalam artikel                               |
      | 17 | announcements              | Pengumuman                                         |
      | 18 | registrations              | Formulir pendaftaran calon anggota                 |
      | 19 | division_reports           | Laporan kegiatan divisi                            |
      | 20 | report_reviews             | Review laporan oleh Ketua Umum                     |
      | 21 | report_photos              | Foto dokumentasi laporan                           |
      | 22 | finance_categories         | Kategori transaksi keuangan                        |
      | 23 | finances                   | Transaksi keuangan                                 |
      | 24 | settings                   | Konfigurasi aplikasi                               |
      | 25 | contacts                   | Pesan kontak dari pengunjung                       |
      | 26 | letters                    | Surat masuk dan surat keluar                       |
      | 27 | dispositions               | Disposisi surat                                    |
      | 28 | letter_templates           | Template surat                                     |
      | 29 | agendas                    | Agenda kegiatan                                    |
      | 30 | meetings                   | Data rapat                                         |
      | 31 | meeting_minutes            | Notulen rapat                                      |
      | 32 | archives                   | Arsip dokumen (soft delete)                        |
      | 33 | achievements               | Prestasi divisi                                    |
      | 34 | rabs                       | Rencana Anggaran Biaya                             |
      | 35 | rab_items                  | Item rincian anggaran RAB                          |
      | 36 | notifications              | Notifikasi internal pengguna                       |
      | 37 | roles                      | Data role (Spatie Permission)                      |
      | 38 | permissions                | Data permission (Spatie Permission)                |
      | 39 | model_has_roles            | Pivot: user ↔ role                                 |
      | 40 | model_has_permissions      | Pivot: user ↔ permission                           |
      | 41 | role_has_permissions       | Pivot: role ↔ permission                           |
      | 42 | sessions                   | Sesi pengguna (driver database)                    |
      | 43 | cache                      | Cache aplikasi                                     |
      | 44 | jobs                       | Antrian pekerjaan (queue)                          |

      ## 9.2 Relasi Database

      ```text
      users
      │
      ├── hasOne ── members (satu user dapat memiliki satu data anggota)
      │
      ├── hasMany ── managements (satu user terlibat di banyak kepengurusan)
      │
      └── belongsTo ── divisions (Kabid terhubung ke divisi melalui division_id)

      members
      │
      ├── belongsTo ── member_statuses (status keanggotaan)
      │
      ├── hasMany ── member_status_histories (riwayat perubahan status)
      │
      ├── hasMany ── managements (jabatan yang pernah dipegang)
      │
      ├── hasMany ── division_members (keanggotaan divisi yang pernah diikuti)
      │
      └── hasOne ── division_members (primary division — divisi aktif saat ini)

      divisions
      │
      ├── hasMany ── division_members
      │
      ├── hasMany ── programs
      │
      ├── hasMany ── activities
      │
      ├── hasMany ── division_reports
      │
      ├── hasMany ── registrations
      │
      └── hasMany ── achievements

      managements
      │
      ├── belongsTo ── members
      │
      ├── belongsTo ── periods
      │
      ├── belongsTo ── positions
      │
      └── belongsTo ── users

      division_reports
      │
      ├── belongsTo ── divisions
      │
      ├── belongsTo ── periods
      │
      ├── belongsTo ── users (author)
      │
      ├── hasMany ── report_reviews
      │
      └── hasMany ── report_photos

      rabs
      │
      ├── belongsTo ── periods
      │
      ├── belongsTo ── users (creator)
      │
      └── hasMany ── rab_items

      letters
      │
      ├── belongsTo ── users (creator)
      │
      └── hasMany ── dispositions

      articles
      │
      ├── belongsTo ── article_categories
      │
      └── hasMany ── article_images

      meetings
      │
      └── hasOne ── meeting_minutes
      ```

      ---

      # BAB 10 — VALIDASI DAN KEAMANAN

      ## 10.1 Autentikasi

      Sistem menggunakan **Laravel Session Authentication** bawaan framework.

      - Kredensial: email dan password.
      - Password disimpan dengan hashing **bcrypt** (12 rounds) menggunakan `BCRYPT_ROUNDS=12`.
      - Session menggunakan **database driver** (`SESSION_DRIVER=database`), bukan file.
      - Durasi sesi: 120 menit (`SESSION_LIFETIME=120`).
      - Terdapat opsi **Remember Me** yang memperpanjang sesi melebihi durasi default.

      ## 10.2 Otorisasi

      Sistem menggunakan dua lapisan otorisasi:

      **1. Middleware Autentikasi (`auth`)**
      Seluruh route panel admin dilindungi oleh middleware `auth`. Pengguna yang tidak login akan dialihkan ke halaman login.

      **2. Role dan Permission (Spatie Laravel Permission)**
      Setiap aksi dalam controller divalidasi menggunakan `$this->authorize('nama_permission')` sebelum memproses request. Terdapat 45 permission yang terdefinisi dalam sistem.

      **3. Middleware Division Scope (`division.scope`)**
      Diterapkan pada route divisi di panel admin. Memastikan Kabid hanya dapat mengakses dan memodifikasi data divisinya sendiri.

      **4. Policy-based Authorization**
      Fitur Kabid Member menggunakan `KabidMemberPolicy` untuk memastikan Kabid hanya dapat melihat detail anggota dari divisinya sendiri (abort 403 jika bukan bidangnya).

      ## 10.3 Proteksi CSRF

      Semua form POST, PUT, PATCH, dan DELETE dilindungi oleh CSRF token Laravel (`@csrf`). Token divalidasi otomatis oleh middleware `VerifyCsrfToken`.

      ## 10.4 Rate Limiting

      Endpoint login dilindungi rate limiter:
      ```
      Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:6,1');
      ```
      Maksimal 6 percobaan login per menit. Jika melebihi batas, request ditolak sementara.

      ## 10.5 Validasi Form

      Setiap controller menggunakan validasi server-side melalui `$request->validate()` atau Form Request classes (contoh: `StoreRegistrationRequest`). Validasi mencakup:

      - Tipe data (string, integer, date, file, dll.)
      - Keberadaan data di database (`exists:table,column`)
      - Keunikan data (`unique:table,column`)
      - Batas ukuran file upload (`max:2048` dalam KB)
      - Format file (`mimes:jpg,jpeg,png,pdf`)

      ## 10.6 Upload File

      File yang diunggah disimpan di direktori `public/images/` dengan nama file yang di-random menggunakan `Str::random(40)` untuk mencegah konflik nama dan tebakan URL.

      | Jenis File         | Direktori Penyimpanan         |
      | ------------------ | ----------------------------- |
      | Foto anggota       | public/images/members/        |
      | Foto kegiatan      | public/images/activity_photos/ |
      | Foto laporan       | public/images/report_photos/  |
      | Foto pendaftaran   | public/images/registrations/  |
      | Kwitansi keuangan  | storage/app/public/receipts/  |
      | Notulen rapat      | storage/app/public/minutes/   |
      | Template surat     | storage/app/public/templates/ |

      ## 10.7 Keamanan SQL Injection dan XSS

      - **SQL Injection**: Dilindungi secara otomatis oleh Eloquent ORM yang menggunakan prepared statements.
      - **XSS**: Blade template secara default melakukan escape output HTML menggunakan `{{ }}`. Konten yang sengaja tidak di-escape menggunakan `{!! !!}` (hanya untuk konten yang sudah divalidasi).

      ---
      # BAB 11 — PENGELOLAAN ERROR DAN TROUBLESHOOTING

      ## 11.1 Logging Sistem

      Sistem mencatat seluruh error dan exception di log aplikasi yang berlokasi di `storage/logs/laravel.log`.

      Sistem juga telah mendukung **Laravel Pail** untuk pemantauan log secara real-time di terminal:
      ```bash
      php artisan pail
      ```

      ## 11.2 Penanganan Error Umum (Troubleshooting)

      ### 1. Pesan Error: "403 Forbidden - This action is unauthorized"
      **Penyebab:**
      - Pengguna mencoba mengakses URL atau fitur yang tidak diizinkan untuk rolenya (dibatasi oleh middleware permission).
      - Pengguna mencoba memodifikasi data yang bukan miliknya (misal: Kabid mencoba mengedit data divisi lain).

      **Solusi:**
      - Pastikan role pengguna memiliki permission yang sesuai (dapat dicek oleh Super Admin di menu Role).
      - Pastikan pengguna berinteraksi dengan data yang sesuai dengan scope-nya.

      ### 2. Halaman Kosong (Blank Page) atau Error 500
      **Penyebab:**
      - Kesalahan pada sintaks kode PHP/Blade.
      - Masalah konfigurasi .env.
      - Database tidak dapat diakses atau error migrasi.

      **Solusi:**
      - Periksa file `storage/logs/laravel.log`.
      - Pastikan konfigurasi di `.env` (khususnya DB_*) sudah benar.
      - Coba jalankan `php artisan cache:clear` dan `php artisan view:clear`.

      ### 3. Masalah Tampilan CSS/JS (Styling Berantakan)
      **Penyebab:**
      - Aset CSS/JS belum di-build (vite tidak berjalan).
      - Cache browser lama masih tersimpan.

      **Solusi:**
      - Pastikan telah menjalankan `npm run build` atau `npm run dev`.
      - Lakukan hard refresh pada browser (Ctrl + F5).

      ### 4. Gagal Ekspor PDF
      **Penyebab:**
      - Library `dompdf` tidak memiliki permission untuk menulis di direktori cache, atau
      - Template blade untuk PDF memiliki tag HTML yang tidak didukung atau error sintaks.

      **Solusi:**
      - Pastikan direktori `storage/` memiliki permission yang bisa ditulisi (chmod 775).
      - Periksa log untuk error spesifik pada file view PDF (misal: `rabs/pdf.blade.php`).

      ### 5. Masalah Duplikasi Perhitungan RAB
      **Penyebab:**
      (Bug versi sebelumnya yang telah diperbaiki) — Eksekusi ganda pada event listener saat input rincian anggaran ditambah secara dinamis.

      **Solusi:**
      - Sistem telah menggunakan teknik *event delegation* pada tingkat elemen `tbody` untuk menangkap event input secara efisien dan akurat tanpa duplikasi event handler.

      ### 6. Notifikasi Tidak Muncul
      **Penyebab:**
      - Background queue worker tidak berjalan.

      **Solusi:**
      - Pastikan menjalankan worker dengan perintah `php artisan queue:work` atau pastikan `composer run dev` sudah mencakup proses worker (melalui Laravel Sail/Supervisor jika di server).

      ---

      # BAB 12 — PANDUAN PENGEMBANGAN (UNTUK DEVELOPER)

      ## 12.1 Konvensi Penamaan (Naming Conventions)

      Sistem COS mengikuti standar PSR-12 dan konvensi penamaan Laravel:

      - **Model:** Singular, PascalCase (contoh: `MemberStatus`, `RabItem`)
      - **Controller:** PascalCase, diakhiri dengan `Controller` (contoh: `DivisionController`)
      - **Tabel Database:** Plural, snake_case (contoh: `member_statuses`, `rab_items`)
      - **Kolom/Field:** snake_case (contoh: `activity_name`, `started_at`)
      - **View:** snake_case (contoh: `create.blade.php`, `index.blade.php`)
      - **URL/Route:** kebab-case, plural/singular tergantung konteks (contoh: `/admin/divisions`, `/admin/rabs/{rab}/pdf`)

      ## 12.2 Menambah Fitur Baru

      Jika ingin menambahkan fitur baru, ikuti urutan berikut:

      1. Buat **Migration** dan **Model**:
      `php artisan make:model NamaModel -m`
      2. Tambahkan konstanta fillable/guarded dan relasi di **Model**.
      3. Jalankan migrasi: `php artisan migrate`
      4. Jika membutuhkan data dummy, buat **Seeder**:
      `php artisan make:seeder NamaModelSeeder`
      5. Buat **Controller**:
      `php artisan make:controller Admin/NamaModelController`
      6. Buat **Form Request** untuk validasi (opsional namun disarankan):
      `php artisan make:request StoreNamaModelRequest`
      7. Definisikan route di **routes/web.php**. Jangan lupa tambahkan middleware permission jika diperlukan.
      8. Buat view Blade di **resources/views/admin/namamodel/** (index, create, edit, show).
      9. Tambahkan permission baru di `RoleSeeder` dan jalankan seeder.
      10. Tambahkan link menu di sidebar admin (`resources/views/layouts/admin.blade.php`).

      ## 12.3 Menggunakan Ikon

      Sistem menggunakan paket `blade-lucide-icons` untuk ikon SVG yang konsisten dan ringan.
      Cara penggunaan dalam Blade:
      ```blade
      <x-lucide-users class="w-5 h-5 text-gray-500" />
      ```
      Nama ikon dapat dicari di dokumentasi resmi Lucide Icons. Gunakan prefix `x-lucide-`.

      ## 12.4 Penulisan Helper

      Sistem menyediakan fungsi helper global. Jika ingin menambahkan helper baru:
      1. Buat/edit file fungsi di `app/Helpers/` atau tambahkan di class Service.
      2. Pastikan file di-*autoload* melalui `composer.json` di bagian `files` jika berupa file procedural, lalu jalankan `composer dump-autoload`.

      ---

      # BAB 13 — LAMPIRAN

      ## 13.1 Perintah Artisan yang Sering Digunakan

      | Perintah                            | Fungsi                                            |
      | ----------------------------------- | ------------------------------------------------- |
      | `php artisan serve`                 | Menjalankan web server lokal                      |
      | `php artisan migrate:fresh --seed`  | Mereset seluruh database dan menjalankan seeder   |
      | `php artisan make:model Xyz -mcr`   | Membuat Model, Migration, dan Controller Resource |
      | `php artisan route:list`            | Melihat daftar seluruh rute yang tersedia         |
      | `php artisan optimize:clear`        | Menghapus semua cache (config, view, route, dll.) |
      | `php artisan storage:link`          | Membuat symbolic link untuk folder storage/public |

      ## 13.2 Format Tanggal

      Sistem menggunakan format tanggal standar:
      - Input/Database: `Y-m-d` (contoh: 2026-09-03)
      - Tampilan Admin: `d-m-Y` atau `d M Y` (contoh: 03 Sep 2026)
      - Tampilan Publik (Lokal Indonesia): `Carbon::parse($date)->translatedFormat('d F Y')` (contoh: 03 September 2026)

      ## 13.3 Daftar Middleware Bawaan

      | Nama Middleware | Fungsi                                                      |
      | --------------- | ----------------------------------------------------------- |
      | `auth`          | Memastikan pengguna telah login                             |
      | `guest`         | Memastikan pengguna belum login (hanya untuk halaman login) |
      | `permission`    | Memeriksa hak akses Spatie (contoh: `permission:view_rabs`) |
      | `role`          | Memeriksa role pengguna (contoh: `role:Super Admin`)        |
      | `division.scope`| Membatasi query agar Kabid hanya melihat data divisinya     |

      ---

      # PENUTUP

      Dokumentasi *Sistem Informasi Manajemen UKM-IT Cyber Open Source* (Versi 1.0) ini disusun berdasarkan analisis mendalam terhadap source code sistem terkini (September 2026). Buku panduan ini ditujukan sebagai referensi resmi bagi seluruh pemangku kepentingan organisasi, baik administrator, pengurus, maupun pengembang (developer) di masa yang akan datang.

      Dengan adanya sistem yang terintegrasi ini, diharapkan pengelolaan administrasi, kegiatan, dan keuangan UKM-IT Cyber Open Source dapat berjalan lebih efektif, transparan, dan akuntabel, serta mempermudah transisi pengetahuan antar generasi kepengurusan.

      ---
      *Dokumen ini digenerate secara otomatis berdasarkan instruksi Technical Writer Agent.*
