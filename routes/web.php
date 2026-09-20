<?php

//⚠️ ROUTE SEMENTARA - HAPUS SETELAH DIGUNAKAN
Route::get('/clear-cache-now', function () {
    \Artisan::call('config:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    return '<h2 style="font-family:sans-serif;color:green;">✅ Cache berhasil di-clear!</h2>
            <ul style="font-family:sans-serif;">
                <li>config:clear ✓</li>
                <li>cache:clear ✓</li>
                <li>view:clear ✓</li>
                <li>route:clear ✓</li>
            </ul>
            <p style="font-family:sans-serif;color:red;"><strong>Jangan lupa hapus route ini setelah selesai!</strong></p>';
});

Route::get('/debug-about', function () {
    try {
        return app()->call([\App\Http\Controllers\Public\TerminalController::class, 'about']);
    } catch (\Throwable $e) {
        return '<pre style="color:red; font-size: 16px;"><strong>ERROR 500 DETAILS:</strong><br><br>' . 
               $e->getMessage() . '<br>in ' . $e->getFile() . ' on line ' . $e->getLine() . '</pre>';
    }
});

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\FinanceCategoryController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\ArticleCategoryController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KabidMemberController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\DivisionReportController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ManagementController;
use App\Http\Controllers\Admin\OrganizationReportController;
use App\Http\Controllers\Admin\PeriodController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\ReportReviewController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Public\RegistrationController as PublicRegistrationController;
use App\Http\Controllers\Public\ContactController as PublicContactController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\IncomingLetterController;
use App\Http\Controllers\Admin\OutgoingLetterController;
use App\Http\Controllers\Admin\DispositionController;
use App\Http\Controllers\Admin\LetterTemplateController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\Admin\MeetingMinuteController;
use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\SecretaryReportController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\OrganizationController;
use App\Http\Controllers\Public\DivisionController as PublicDivisionController;
use App\Http\Controllers\Public\ActivityController as PublicActivityController;
use App\Http\Controllers\Public\TerminalController;
use App\Http\Controllers\Public\ArticleController as PublicArticleController;
use App\Http\Controllers\Public\GalleryController as PublicGalleryController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [AboutController::class, 'index'])->name('public.tentang');
Route::get('/organisasi', [OrganizationController::class, 'index'])->name('public.organisasi');
Route::get('/organisasi/periode/{period}', [OrganizationController::class, 'period'])->name('public.organisasi.period');
Route::get('/divisi', [PublicDivisionController::class, 'index'])->name('public.divisi');
Route::get('/divisi/{division:slug}', [PublicDivisionController::class, 'show'])->name('public.divisi.show');
Route::get('/kegiatan', [PublicActivityController::class, 'index'])->name('public.kegiatan');
Route::get('/kegiatan/{activity:slug}', [PublicActivityController::class, 'show'])->name('public.kegiatan.show');
Route::get('/berita', [PublicArticleController::class, 'index'])->name('public.berita');
Route::get('/berita/{article:slug}', [PublicArticleController::class, 'show'])->name('public.berita.show');
Route::get('/galeri', [PublicGalleryController::class, 'index'])->name('public.galeri');
Route::get('/sitemap.xml', [\App\Http\Controllers\Public\SitemapController::class, 'index'])->name('sitemap');
Route::get('/kontak', [PublicContactController::class, 'showForm'])->name('public.kontak');
Route::post('/kontak', [PublicContactController::class, 'submitForm'])->name('public.kontak.store');

Route::get('/api/terminal/activities', [TerminalController::class, 'activities'])->name('api.terminal.activities');
Route::get('/api/terminal/kontak', [TerminalController::class, 'kontak'])->name('api.terminal.kontak');
Route::get('/api/terminal/about', [TerminalController::class, 'about'])->name('api.terminal.about');


Route::get('/register', [PublicRegistrationController::class, 'create'])->name('register');
Route::post('/register', [PublicRegistrationController::class, 'store'])->name('register.store');
Route::get('/register/success', [PublicRegistrationController::class, 'success'])->name('register.success');
Route::get('/register/download/{registration}', [PublicRegistrationController::class, 'downloadPdf'])->name('register.download');

Route::get('/contact', [PublicContactController::class, 'showForm'])->name('contact');
Route::post('/contact', [PublicContactController::class, 'submitForm'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Auth Routes (Guest only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:6,1');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Auth required)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Notifikasi
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/fetch', [NotificationController::class, 'fetchLatest'])->name('notifications.fetch');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('notifications.destroy-all');


        // Manajemen Pengguna
        Route::resource('users', UserController::class)->names('users');
        Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])
            ->name('users.toggle-active');

        // Manajemen Anggota
        Route::resource('members', \App\Http\Controllers\Admin\MemberController::class)->names('members');

        // Histori Status Keanggotaan
        Route::get('member-statuses', [\App\Http\Controllers\Admin\MemberStatusController::class, 'index'])
            ->name('member-statuses.index');

        // Manajemen Role & Permission
        Route::resource('roles', RoleController::class)->names('roles');

        // Manajemen Periode Kepengurusan
        Route::resource('periods', PeriodController::class)->names('periods');
        Route::patch('periods/{period}/close', [PeriodController::class, 'close'])->name('periods.close');

        // Manajemen Jabatan
        Route::resource('positions', PositionController::class)->names('positions');

        // Struktur Kepengurusan
        Route::resource('managements', ManagementController::class)->names('managements');

        // Divisi & Program Kerja
        Route::middleware(['division.scope'])->group(function () {
            Route::resource('divisions', DivisionController::class)->names('divisions');
            Route::post('divisions/{division}/members', [DivisionController::class, 'storeMember'])->name('divisions.members.store');
            Route::delete('divisions/{division}/members/{member}', [DivisionController::class, 'destroyMember'])->name('divisions.members.destroy');
            Route::resource('programs', ProgramController::class)->names('programs');
            Route::resource('achievements', AchievementController::class)->names('achievements');

            // Kegiatan & Galeri
            Route::resource('activities', ActivityController::class)->names('activities');
            Route::delete('activities/photos/{photo}', [ActivityController::class, 'destroyPhoto'])->name('activities.photos.destroy');
            Route::resource('gallery', GalleryController::class)->only(['index', 'create', 'store', 'destroy'])->names('gallery');
        });

        // Berita & Publikasi
        Route::resource('article-categories', ArticleCategoryController::class)
            ->names('article-categories')
            ->parameters(['article-categories' => 'article_category'])
            ->except(['show']);
        Route::post('articles/upload-image', [ArticleController::class, 'uploadImage'])->name('articles.upload-image');
        Route::resource('articles', ArticleController::class)->names('articles');
        Route::resource('announcements', AnnouncementController::class)->names('announcements')->except(['show']);

        // Pendaftaran
        // ⚠️ Route export HARUS di atas Route::resource agar tidak tertangkap sebagai parameter {registration}
        Route::get('registrations/export-pdf', [AdminRegistrationController::class, 'exportPdf'])
            ->name('registrations.export-pdf');
        Route::get('registrations/{registration}/export-single-pdf', [AdminRegistrationController::class, 'exportSinglePdf'])
            ->name('registrations.export-single-pdf');
        Route::resource('registrations', AdminRegistrationController::class)->only(['index', 'show', 'destroy'])->names('registrations');

        // Laporan Divisi
        Route::resource('division-reports', DivisionReportController::class)
            ->names('division-reports')
            ->parameters(['division-reports' => 'divisionReport']);
        Route::post('division-reports/{divisionReport}/submit', [DivisionReportController::class, 'submit'])
            ->name('division-reports.submit');
        Route::post('division-reports/{divisionReport}/photos', [DivisionReportController::class, 'uploadPhotos'])
            ->name('division-reports.photos.upload');
        Route::delete('division-reports/photos/{photo}', [DivisionReportController::class, 'destroyPhoto'])
            ->name('division-reports.photos.destroy');

        // Review Laporan (Ketua)
        Route::get('report-reviews', [ReportReviewController::class, 'index'])->name('report-reviews.index');
        Route::get('report-reviews/{divisionReport}', [ReportReviewController::class, 'show'])->name('report-reviews.show');
        Route::post('report-reviews/{divisionReport}', [ReportReviewController::class, 'store'])->name('report-reviews.store');

        // Laporan Organisasi (Rekap Final)
        Route::get('organization-reports', [OrganizationReportController::class, 'index'])->name('organization-reports.index');
        Route::get('organization-reports/{divisionReport}', [OrganizationReportController::class, 'show'])->name('organization-reports.show');

        // Manajemen Keuangan
        Route::resource('finance-categories', FinanceCategoryController::class)
            ->names('finance-categories')
            ->parameters(['finance-categories' => 'financeCategory'])
            ->except(['show']);
        Route::get('finances/export-pdf', [FinanceController::class, 'exportPdf'])->name('finances.export-pdf');
        Route::resource('finances', FinanceController::class)->names('finances')->except(['show']);

        // RAB
        Route::get('rabs/{rab}/pdf', [\App\Http\Controllers\Admin\RabController::class, 'exportPdf'])->name('rabs.pdf');
        Route::post('rabs/{rab}/finalize', [\App\Http\Controllers\Admin\RabController::class, 'finalize'])->name('rabs.finalize');
        Route::resource('rabs', \App\Http\Controllers\Admin\RabController::class)->names('rabs');

        // Pengaturan & Kontak
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy'])->names('contacts');

        // ─── MODUL SEKRETARIS ───────────────────────────────────────────────────

        // Surat Masuk
        // ⚠️ Route arsip HARUS di atas Route::resource agar tidak tertangkap sebagai parameter {incoming_letter}
        Route::get('letters/incoming-archive', [IncomingLetterController::class, 'archiveList'])
            ->name('letters.incoming.archive.index');
        Route::patch('letters/incoming/{incoming_letter}/archive', [IncomingLetterController::class, 'archive'])
            ->name('letters.incoming.archive');
        Route::patch('letters/incoming/{incoming_letter}/unarchive', [IncomingLetterController::class, 'unarchive'])
            ->name('letters.incoming.unarchive');
        Route::resource('letters/incoming', IncomingLetterController::class)
            ->names('letters.incoming')
            ->parameters(['incoming' => 'incoming_letter']);

        // Surat Keluar
        Route::resource('letters/outgoing', OutgoingLetterController::class)
            ->names('letters.outgoing')
            ->parameters(['outgoing' => 'outgoing_letter']);

        // Disposisi
        Route::resource('dispositions', DispositionController::class)->names('dispositions');
        Route::patch('dispositions/{disposition}/status', [DispositionController::class, 'updateStatus'])
            ->name('dispositions.update-status');

        // Template Surat
        Route::resource('letter-templates', LetterTemplateController::class)->names('letter-templates');
        Route::get('letter-templates/{letter_template}/download', [LetterTemplateController::class, 'download'])->name('letter-templates.download');

        // Agenda
        Route::resource('agendas', AgendaController::class)->names('agendas');

        // Rapat
        Route::resource('meetings', MeetingController::class)->names('meetings');

        // Notulen Rapat
        Route::get('minutes/{minute}/pdf', [MeetingMinuteController::class, 'downloadPdf'])->name('minutes.pdf');
        Route::resource('minutes', MeetingMinuteController::class)->names('minutes');

        // Arsip Dokumen
        Route::resource('archives', ArchiveController::class)->names('archives');
        Route::get('archives/{archive}/download', [ArchiveController::class, 'download'])->name('archives.download')->withTrashed();
        Route::post('archives/{archive}/restore', [ArchiveController::class, 'restore'])->name('archives.restore')->withTrashed();
        Route::delete('archives/{archive}/force-delete', [ArchiveController::class, 'forceDelete'])->name('archives.forceDelete')->withTrashed();

        // Laporan Sekretaris
        Route::get('reports/secretary', [SecretaryReportController::class, 'index'])->name('reports.secretary');

        // ─── KABID: Anggota Bidang ────────────────────────────────────────────────
        // Route khusus KABID untuk melihat anggota di bidang yang menjadi tanggung jawabnya.
        // Protected oleh permission middleware + KabidMemberPolicy (server-side authorization).
        Route::middleware(['permission:view_division_members'])->group(function () {
            Route::get('kabid/anggota-bidang', [KabidMemberController::class, 'index'])
                ->name('kabid.members.index');
            Route::get('kabid/anggota-bidang/{member}', [KabidMemberController::class, 'show'])
                ->name('kabid.members.show');
        });
    });

// Serve storage files via /file/ path (pengganti symlink di hosting)
// Menggunakan /file/ bukan /storage/ untuk menghindari blokir Apache di shared hosting
Route::get('/file/{path}', function (string $path) {
    $fullPath = storage_path('app/public/' . $path);

    if (!file_exists($fullPath)) {
        abort(404);
    }

    return response()->file($fullPath);
})->where('path', '.*')->name('file.serve');

// ⚠️ ROUTE SEMENTARA - HAPUS SETELAH DIPAKAI
// Jalankan migration di hosting via browser
Route::get('/run-migrate', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return '<pre style="font-family:monospace;padding:20px;">' . \Illuminate\Support\Facades\Artisan::output() . '</pre>';
    } catch (\Exception $e) {
        return '<pre style="color:red;padding:20px;">ERROR: ' . $e->getMessage() . '</pre>';
    }
});
