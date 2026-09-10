const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');
const { marked } = require('marked');

const PROJECT_ROOT = 'd:\\SEMESTER 4\\PEMROGRAMAN WEB 2\\LARAVELL\\website-cos';
const DOCS_DIR     = path.join(PROJECT_ROOT, 'docs');
const MD_PATH      = path.join(DOCS_DIR, 'PANDUAN-SISTEM.md');
const PDF_PATH     = path.join(DOCS_DIR, 'PANDUAN-SISTEM.pdf');
const SS_DIR       = path.join(DOCS_DIR, 'assets', 'screenshots');

// Read markdown
const mdRaw = fs.readFileSync(MD_PATH, 'utf-8');

// Embed screenshots as base64 so PDF renders them regardless of path
function embedScreenshots(md) {
    return md.replace(/src="assets\/screenshots\/([\w\-\.]+\.png)"/g, (match, filename) => {
        const imgPath = path.join(SS_DIR, filename);
        if (fs.existsSync(imgPath)) {
            const data = fs.readFileSync(imgPath);
            const b64 = data.toString('base64');
            return `src="data:image/png;base64,${b64}"`;
        }
        console.warn(`  ⚠ Screenshot not found: ${filename}`);
        return match;
    });
}

// Embed logo as base64
function embedLogo(md) {
    // Replace the live URL with local file base64
    const logoPath = path.join(PROJECT_ROOT, 'storage', 'app', 'public', 'settings', 'vmgAhoXCcaO74HIOTBUjCTMk633sa77hdlRKm4AQ.png');
    if (fs.existsSync(logoPath)) {
        const data = fs.readFileSync(logoPath);
        const b64 = data.toString('base64');
        return md.replace(
            /src="http:\/\/127\.0\.0\.1:8000\/storage\/settings\/[^"]+\.png"/g,
            `src="data:image/png;base64,${b64}"`
        );
    }
    // Fallback: keep the URL (requires server running)
    return md;
}

async function run() {
    console.log('='.repeat(60));
    console.log('PDF GENERATOR — Buku Panduan Sistem COS');
    console.log('='.repeat(60));

    // Count screenshots
    const files = fs.readdirSync(SS_DIR).filter(f => f.endsWith('.png'));
    console.log(`Screenshots found: ${files.length} files`);

    // Embed screenshots as base64
    console.log('Embedding screenshots...');
    let processedMd = embedLogo(mdRaw);
    processedMd = embedScreenshots(processedMd);

    // Convert markdown to HTML
    console.log('Converting markdown to HTML...');
    const htmlBody = marked.parse(processedMd);

    // Full HTML document
    const fullHtml = `<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Buku Panduan Sistem COS</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  
  body {
    font-family: 'Inter', -apple-system, sans-serif;
    color: #334155;
    line-height: 1.7;
    font-size: 10.5pt;
    background: #fff;
  }

  /* ── Typography ── */
  h1, h2, h3, h4, h5, h6 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #0F172A;
    line-height: 1.3;
  }
  h1 { font-size: 22pt; font-weight: 800; margin-bottom: 1rem; }
  h2 { font-size: 16pt; font-weight: 700; margin: 2rem 0 0.75rem; border-bottom: 2px solid #E2E8F0; padding-bottom: 0.4rem; }
  h3 { font-size: 12pt; font-weight: 600; margin: 1.5rem 0 0.5rem; color: #1E3A5F; }
  h4 { font-size: 10.5pt; font-weight: 600; margin: 1rem 0 0.4rem; }
  p  { margin-bottom: 0.75rem; }
  
  code {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.82em;
    background: #F1F5F9;
    color: #2563EB;
    padding: 1px 5px;
    border-radius: 4px;
    border: 1px solid #E2E8F0;
  }
  
  pre {
    background: #0F172A;
    color: #E2E8F0;
    padding: 1rem;
    border-radius: 8px;
    overflow: hidden;
    margin: 1rem 0;
    font-size: 0.85em;
  }
  pre code { background: none; border: none; color: inherit; padding: 0; }

  /* ── Page Layout ── */
  .markdown-body {
    max-width: 100%;
    padding: 0;
  }

  /* ── Cover ── */
  .cover-container {
    height: 90vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    page-break-after: always;
  }
  .cover-logo { max-width: 120px; margin-bottom: 2rem; }
  .cover-title {
    font-size: 26pt;
    font-weight: 800;
    color: #0F172A;
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
  }
  .cover-subtitle {
    font-size: 16pt;
    color: #2563EB;
    font-weight: 600;
    margin-bottom: 2.5rem;
  }
  .cover-line {
    width: 60px; height: 4px;
    background: #2563EB;
    margin: 0 auto 2.5rem;
    border-radius: 2px;
  }
  .cover-footer {
    font-size: 9pt;
    color: #64748B;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    font-weight: 500;
    line-height: 1.8;
  }

  /* ── Screenshots ── */
  img.screenshot {
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
    max-width: 100%;
    margin: 1.5rem auto 0.5rem;
    display: block;
  }
  .caption {
    text-align: center;
    font-size: 8.5pt;
    color: #64748B;
    margin-bottom: 2rem;
    font-style: italic;
  }

  /* ── Callouts ── */
  .callout {
    border-left: 4px solid #2563EB;
    background: #F8FAFC;
    padding: 1rem 1.25rem;
    border-radius: 0 8px 8px 0;
    margin: 1.25rem 0;
    border: 1px solid #E2E8F0;
    border-left-width: 4px;
  }
  .callout-info  { border-left-color: #2563EB; }
  .callout-warning { border-left-color: #F59E0B; background: #FFFBEB; border-color: #FEF3C7; border-left-width: 4px; }
  .callout-success { border-left-color: #10B981; background: #ECFDF5; border-color: #D1FAE5; border-left-width: 4px; }
  .callout-title {
    font-weight: 700;
    font-size: 8pt;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #0F172A;
    margin-bottom: 0.25rem;
  }

  /* ── Tables ── */
  table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0 1.5rem;
    font-size: 9.5pt;
  }
  th {
    background: #0F172A;
    color: #fff;
    padding: 8px 12px;
    text-align: left;
    font-weight: 600;
  }
  td {
    padding: 7px 12px;
    border-bottom: 1px solid #E2E8F0;
    vertical-align: top;
  }
  tr:nth-child(even) td { background: #F8FAFC; }
  .role-table th { background: #0F172A; color: #fff; }

  /* ── Page Header/Footer markers ── */
  .doc-header {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #E2E8F0;
    padding-bottom: 0.75rem;
    margin-bottom: 2rem;
    font-size: 8pt;
    color: #94A3B8;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.06em;
  }
  .doc-footer {
    display: flex;
    justify-content: space-between;
    border-top: 1px solid #E2E8F0;
    padding-top: 0.75rem;
    margin-top: 3rem;
    font-size: 8pt;
    color: #94A3B8;
  }

  /* ── Section label ── */
  .section-label {
    font-size: 8pt;
    font-weight: 700;
    color: #2563EB;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    margin-bottom: 0.5rem;
    display: block;
  }

  /* ── Tags ── */
  .tag {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 8pt;
    font-weight: 600;
  }
  .tag-blue   { background: #DBEAFE; color: #1D4ED8; }
  .tag-green  { background: #D1FAE5; color: #065F46; }
  .tag-purple { background: #EDE9FE; color: #6D28D9; }
  .tag-orange { background: #FEF3C7; color: #92400E; }
  .tag-gray   { background: #F1F5F9; color: #475569; }

  /* ── Lists ── */
  ul, ol { padding-left: 1.5rem; margin-bottom: 0.75rem; }
  li { margin-bottom: 0.3rem; }

  /* ── HR ── */
  hr { border: none; border-top: 1px solid #E2E8F0; margin: 2rem 0; }

  /* ── Page break ── */
  .page-break { page-break-before: always; margin-top: 0; }

  /* ── Print media ── */
  @media print {
    .cover-container { page-break-after: always; }
    .page-break { page-break-before: always; }
    h2 { page-break-after: avoid; }
    img.screenshot { page-break-inside: avoid; }
  }
</style>
</head>
<body>
<div class="markdown-body">
${htmlBody}
</div>
</body>
</html>`;

    // Write temp HTML
    const tempHtml = path.join(DOCS_DIR, '_temp_render.html');
    fs.writeFileSync(tempHtml, fullHtml, 'utf-8');
    console.log(`Temp HTML written: ${tempHtml}`);

    // Launch Puppeteer & generate PDF
    console.log('Launching browser...');
    const browser = await puppeteer.launch({
        headless: 'new',
        args: ['--no-sandbox']
    });
    const page = await browser.newPage();

    console.log('Loading HTML (file://)...');
    await page.goto('file://' + tempHtml, { waitUntil: 'networkidle0', timeout: 60000 });

    // Wait extra for fonts & layout
    await new Promise(r => setTimeout(r, 2000));

    console.log('Generating PDF...');
    await page.pdf({
        path: PDF_PATH,
        format: 'A4',
        printBackground: true,
        margin: { top: '20mm', right: '18mm', bottom: '20mm', left: '18mm' },
        displayHeaderFooter: true,
        headerTemplate: `
            <div style="font-family:Inter,sans-serif;font-size:8px;color:#94A3B8;width:100%;display:flex;justify-content:space-between;padding:0 18mm;">
                <span>Buku Panduan Sistem COS</span>
                <span>UKM-IT COS — 2026</span>
            </div>`,
        footerTemplate: `
            <div style="font-family:Inter,sans-serif;font-size:8px;color:#94A3B8;width:100%;display:flex;justify-content:space-between;padding:0 18mm;">
                <span>Cyber Open Source (COS)</span>
                <span class="pageNumber"></span>
            </div>`,
    });

    await browser.close();

    // Cleanup
    fs.unlinkSync(tempHtml);

    // Verify
    const stats = fs.statSync(PDF_PATH);
    console.log('\n' + '='.repeat(60));
    console.log('PDF GENERATED SUCCESSFULLY');
    console.log('='.repeat(60));
    console.log(`  Path : ${PDF_PATH}`);
    console.log(`  Size : ${(stats.size / 1024 / 1024).toFixed(2)} MB`);
    console.log('='.repeat(60));
}

run().catch(err => {
    console.error('FATAL:', err.message);
    process.exit(1);
});
