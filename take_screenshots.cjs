const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

const BASE_URL = 'http://127.0.0.1:8000';
const OUTPUT_DIR = path.join('d:\\', 'SEMESTER 4', 'PEMROGRAMAN WEB 2', 'LARAVELL', 'website-cos', 'docs', 'assets', 'screenshots');
const VIEWPORT = { width: 1440, height: 900 };

// FULL LIST: 31 screenshots sesuai Lampiran B + existing
const SCREENSHOTS = [
    // Halaman Publik & Auth
    { file: '01-login.png',             url: '/login',                        waitFor: null },
    { file: '02-dashboard.png',         url: '/admin/dashboard',              waitFor: null },
    { file: '03-data-anggota.png',      url: '/admin/members',               waitFor: null },
    { file: '04-tambah-anggota.png',    url: '/admin/members/create',        waitFor: null },
    { file: '05-data-divisi.png',       url: '/admin/divisions',             waitFor: null },
    { file: '06-data-kegiatan.png',     url: '/admin/activities',            waitFor: null },
    { file: '07-pengaturan.png',        url: '/admin/settings',              waitFor: null },
    { file: '08-laporan.png',           url: '/admin/reports/secretary',     waitFor: null },
    { file: '09-histori-status.png',    url: '/admin/member-statuses',       waitFor: null },
    { file: '10-periode.png',           url: '/admin/periods',               waitFor: null },
    { file: '11-jabatan.png',           url: '/admin/positions',             waitFor: null },
    { file: '12-struktur-pengurus.png', url: '/admin/managements',          waitFor: null },
    { file: '13-program-kerja.png',     url: '/admin/programs',              waitFor: null },
    { file: '14-galeri.png',            url: '/admin/gallery',               waitFor: null },
    { file: '15-surat-masuk.png',       url: '/admin/letters/incoming',      waitFor: null },
    { file: '16-surat-keluar.png',      url: '/admin/letters/outgoing',      waitFor: null },
    { file: '17-template-surat.png',    url: '/admin/letter-templates',      waitFor: null },
    { file: '18-agenda.png',            url: '/admin/agendas',               waitFor: null },
    { file: '19-rapat.png',             url: '/admin/meetings',              waitFor: null },
    { file: '20-notulen.png',           url: '/admin/minutes',               waitFor: null },
    { file: '21-artikel.png',           url: '/admin/articles',              waitFor: null },
    { file: '22-kategori-artikel.png',  url: '/admin/article-categories',   waitFor: null },
    { file: '23-pengumuman.png',        url: '/admin/announcements',         waitFor: null },
    { file: '24-data-pendaftar.png',    url: '/admin/registrations',         waitFor: null },
    { file: '25-laporan-bidang.png',    url: '/admin/division-reports',      waitFor: null },
    { file: '26-rekap-laporan.png',     url: '/admin/organization-reports',  waitFor: null },
    { file: '27-keuangan.png',          url: '/admin/finances',              waitFor: null },
    { file: '28-kategori-keuangan.png', url: '/admin/finance-categories',   waitFor: null },
    { file: '29-akun-pengguna.png',     url: '/admin/users',                 waitFor: null },
    { file: '30-role-permission.png',   url: '/admin/roles',                 waitFor: null },
    { file: '31-pesan-masuk.png',       url: '/admin/contacts',              waitFor: null },
];

async function waitForImages(page) {
    await page.evaluate(() => {
        return Promise.all(
            Array.from(document.images)
                .filter(img => !img.complete)
                .map(img => new Promise(resolve => {
                    img.addEventListener('load', resolve);
                    img.addEventListener('error', resolve);
                }))
        );
    });
}

async function validateLogo(page) {
    const logoStatus = await page.evaluate(() => {
        const imgs = document.querySelectorAll('img');
        let logoFound = false;
        let logoLoaded = false;
        for (const img of imgs) {
            // Check sidebar logo or any img in sidebar-brand area
            if (img.closest('.sidebar-brand') || img.closest('.brand-icon') || img.closest('.cover-logo')) {
                logoFound = true;
                if (img.naturalWidth > 0) logoLoaded = true;
            }
        }
        return { logoFound, logoLoaded };
    });
    return logoStatus;
}

async function run() {
    if (!fs.existsSync(OUTPUT_DIR)) {
        fs.mkdirSync(OUTPUT_DIR, { recursive: true });
    }

    console.log('='.repeat(60));
    console.log('SCREENSHOT AUTOMATION — Sistem COS');
    console.log('='.repeat(60));
    console.log(`Viewport: ${VIEWPORT.width}x${VIEWPORT.height}`);
    console.log(`Output: ${OUTPUT_DIR}`);
    console.log('');

    const browser = await puppeteer.launch({
        headless: 'new',
        defaultViewport: VIEWPORT,
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    });

    const page = await browser.newPage();

    // ── PHASE 2: VALIDATE LOGO via server ──
    console.log('PHASE 2 — Validating logo...');
    const logoTestUrl = BASE_URL + '/storage/settings/vmgAhoXCcaO74HIOTBUjCTMk633sa77hdlRKm4AQ.png';
    const logoResponse = await page.goto(logoTestUrl);
    if (logoResponse.status() === 200) {
        console.log('  ✓ Logo accessible via storage URL (HTTP 200)');
    } else {
        console.error(`  ✗ Logo NOT accessible! HTTP ${logoResponse.status()}`);
        await browser.close();
        process.exit(1);
    }

    // ── PHASE 3: LOGIN ──
    console.log('\nPHASE 3 — Login to system...');
    await page.goto(BASE_URL + '/login', { waitUntil: 'networkidle0' });
    await page.type('#email', 'superadmin@ukmitcos.org');
    await page.type('#password', 'password');
    await Promise.all([
        page.waitForNavigation({ waitUntil: 'networkidle0' }),
        page.click('button[type="submit"]')
    ]);

    const currentUrl = page.url();
    if (currentUrl.includes('/login')) {
        console.error('  ✗ Login failed! Still on login page.');
        await browser.close();
        process.exit(1);
    }
    console.log(`  ✓ Logged in. Now at: ${currentUrl}`);

    // ── PHASE 4: SCREENSHOT LOOP ──
    console.log('\nPHASE 4 — Taking screenshots...\n');
    const results = [];

    // Special: take login page screenshot first (without being logged in)
    console.log('[01/31] 01-login.png — /login (public)');
    const loginPage = await browser.newPage();
    await loginPage.setViewport(VIEWPORT);
    await loginPage.goto(BASE_URL + '/login', { waitUntil: 'networkidle0' });
    await waitForImages(loginPage);
    await new Promise(r => setTimeout(r, 500)); // small extra wait for fonts
    const loginPath = path.join(OUTPUT_DIR, '01-login.png');
    await loginPage.screenshot({ path: loginPath, fullPage: false }); // viewport only, not full
    await loginPage.close();
    console.log(`  ✓ Saved: 01-login.png`);
    results.push({ file: '01-login.png', status: '✓ UPDATED' });

    // Take all admin screenshots
    for (let i = 1; i < SCREENSHOTS.length; i++) {
        const item = SCREENSHOTS[i];
        const num = String(i + 1).padStart(2, '0');
        console.log(`[${num}/31] ${item.file} — ${item.url}`);

        try {
            await page.goto(BASE_URL + item.url, { waitUntil: 'networkidle0', timeout: 30000 });
            await waitForImages(page);
            await new Promise(r => setTimeout(r, 800)); // wait for animations

            // Validate logo in admin pages
            const logoStatus = await validateLogo(page);
            if (!logoStatus.logoLoaded) {
                console.log(`  ⚠ Logo not confirmed loaded (may be icon fallback)`);
            } else {
                console.log(`  ✓ Logo loaded`);
            }

            // Check for error page
            const pageTitle = await page.title();
            const bodyText = await page.evaluate(() => document.body ? document.body.innerText.substring(0, 200) : '');
            if (bodyText.toLowerCase().includes('whoops') || bodyText.toLowerCase().includes('error 500')) {
                console.log(`  ⚠ Page may have error: ${bodyText.substring(0, 100)}`);
            }

            const outPath = path.join(OUTPUT_DIR, item.file);
            await page.screenshot({ path: outPath, fullPage: true });
            console.log(`  ✓ Saved: ${item.file}`);
            results.push({ file: item.file, status: '✓ UPDATED' });

        } catch (err) {
            console.error(`  ✗ FAILED: ${err.message}`);
            results.push({ file: item.file, status: `✗ FAILED: ${err.message}` });
        }
    }

    await browser.close();

    // ── REPORT ──
    console.log('\n' + '='.repeat(60));
    console.log('SCREENSHOT REPORT');
    console.log('='.repeat(60));
    let success = 0, failed = 0;
    for (const r of results) {
        console.log(`  ${r.status.padEnd(10)} — ${r.file}`);
        if (r.status.startsWith('✓')) success++;
        else failed++;
    }
    console.log('-'.repeat(60));
    console.log(`  Total: ${results.length} | Success: ${success} | Failed: ${failed}`);
    console.log('='.repeat(60));
}

run().catch(err => {
    console.error('FATAL ERROR:', err);
    process.exit(1);
});
