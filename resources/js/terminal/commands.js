import { resolvePath, getNodeAtPath } from './filesystem.js';

// Peta navigasi halaman: cd <alias> → redirect ke URL
const PAGE_NAVIGATION = {
    'tentang': '/tentang',
    'organisasi': '/organisasi',
    'divisi': '/divisi',
    'kegiatan': '/kegiatan',
    'berita': '/berita',
    'galeri': '/galeri',
    'kontak': '/kontak',
    'daftar': '/register',
    'register': '/register',
    'beranda': '/',
    'home': '/',
    // Shortcut langsung ke halaman divisi
    'programming': '/divisi/programming',
    'networking': '/divisi/networking',
    'dkv': '/divisi/dkv',
    'divisi/programming': '/divisi/programming',
    'divisi/networking': '/divisi/networking',
    'divisi/dkv': '/divisi/dkv',
};

export async function executeCommand(commandStr, currentPath, engine) {
    const args = commandStr.trim().split(/\s+/);
    if (!args[0]) return { type: 'empty' };

    const cmd = args[0].toLowerCase();

    switch (cmd) {

        // ─── NAVIGASI ───────────────────────────────────────────────────
        case 'cd': {
            const targetCd = args[1] || '~';

            // Cek apakah target adalah alias halaman (navigasi)
            const pageUrl = PAGE_NAVIGATION[targetCd.toLowerCase()];
            if (pageUrl) {
                return {
                    type: 'redirect',
                    url: pageUrl,
                    message: `→ Berpindah ke halaman ${targetCd}...`
                };
            }

            // Navigasi filesystem virtual biasa
            if (targetCd === '~' || targetCd === '') {
                engine.setPath('/home/cos');
                return { type: 'empty' };
            }

            const resolvedCd = resolvePath(currentPath, targetCd);
            const cdNode = getNodeAtPath(resolvedCd);

            if (!cdNode) return { type: 'error', content: `cd: ${targetCd}: Direktori tidak ditemukan` };
            if (cdNode.type !== 'dir') return { type: 'error', content: `cd: ${targetCd}: Bukan direktori` };

            engine.setPath(resolvedCd);
            return { type: 'empty' };
        }

        // ─── FILESYSTEM ─────────────────────────────────────────────────
        case 'pwd':
            return { type: 'text', content: currentPath };

        case 'ls': {
            let targetPath = currentPath;
            let showHidden = false;
            let showDetails = false;

            for (let i = 1; i < args.length; i++) {
                if (args[i] === '-a') showHidden = true;
                else if (args[i] === '-l') showDetails = true;
                else if (args[i] === '-la' || args[i] === '-al') { showHidden = true; showDetails = true; }
                else targetPath = resolvePath(currentPath, args[i]);
            }

            const node = getNodeAtPath(targetPath);
            if (!node) return { type: 'error', content: `ls: tidak bisa akses '${targetPath}': Tidak ada file atau direktori` };
            if (node.type !== 'dir') return { type: 'text', content: args[args.length - 1] };

            const items = Object.keys(node.children).sort();
            const lsOutput = [];
            for (const item of items) {
                if (item.startsWith('.') && !showHidden) continue;
                const child = node.children[item];
                if (showDetails) {
                    const prefix = child.type === 'dir' ? 'drwxr-xr-x' : '-rw-r--r--';
                    const size = child.type === 'dir' ? '4096' : (child.content ? child.content.length : 0);
                    lsOutput.push({ text: `${prefix} 1 cos cos ${size} Jan  1 00:00 ${item}`, isDir: child.type === 'dir' });
                } else {
                    lsOutput.push({ text: item + (child.type === 'dir' ? '/' : ''), isDir: child.type === 'dir' });
                }
            }
            return { type: 'ls', items: lsOutput, showDetails };
        }

        case 'cat': {
            if (!args[1]) return { type: 'error', content: 'cat: kurang operand' };
            const catPath = resolvePath(currentPath, args[1]);
            const catNode = getNodeAtPath(catPath);
            if (!catNode) return { type: 'error', content: `cat: ${args[1]}: Tidak ada file atau direktori` };
            if (catNode.type === 'dir') return { type: 'error', content: `cat: ${args[1]}: Adalah direktori` };
            return { type: 'text', content: catNode.content || '(file kosong)' };
        }

        case 'head':
        case 'tail': {
            if (!args[1]) return { type: 'error', content: `${cmd}: kurang operand` };
            const hlPath = resolvePath(currentPath, args[1]);
            const hlNode = getNodeAtPath(hlPath);
            if (!hlNode || hlNode.type === 'dir') return { type: 'error', content: `${cmd}: tidak bisa membuka '${args[1]}'` };
            return { type: 'text', content: hlNode.content || '(file kosong)' };
        }

        case 'file': {
            if (!args[1]) return { type: 'error', content: 'file: kurang operand' };
            const filePath = resolvePath(currentPath, args[1]);
            const fileNode = getNodeAtPath(filePath);
            if (!fileNode) return { type: 'error', content: `${args[1]}: tidak dapat dibuka (tidak ada file)` };
            if (fileNode.type === 'dir') return { type: 'text', content: `${args[1]}: direktori` };
            return { type: 'text', content: `${args[1]}: teks ASCII` };
        }

        case 'tree': {
            const treeRoot = getNodeAtPath(currentPath);
            if (!treeRoot || treeRoot.type !== 'dir') return { type: 'error', content: 'tree: gagal membaca direktori' };
            let treeStr = currentPath + '\n';

            function buildTree(node, prefix = '') {
                const keys = Object.keys(node.children).sort();
                for (let i = 0; i < keys.length; i++) {
                    const key = keys[i];
                    const isLast = i === keys.length - 1;
                    treeStr += prefix + (isLast ? '└── ' : '├── ') + key + '\n';
                    if (node.children[key].type === 'dir') {
                        buildTree(node.children[key], prefix + (isLast ? '    ' : '│   '));
                    }
                }
            }
            buildTree(treeRoot);
            return { type: 'text', content: treeStr.trimEnd() };
        }

        // ─── UTILITAS DASAR ─────────────────────────────────────────────
        case 'clear':
            return { type: 'clear' };

        case 'history': {
            const history = engine.history.getAll();
            if (history.length === 0) return { type: 'text', content: '(riwayat kosong)' };
            const histOutput = history.map((h, i) => `  ${String(i + 1).padStart(3)}  ${h}`).join('\n');
            return { type: 'text', content: histOutput };
        }

        case 'echo':
            return { type: 'text', content: args.slice(1).join(' ') };

        // ─── SISTEM ─────────────────────────────────────────────────────
        case 'whoami':
            return { type: 'text', content: 'Cyber Open Source' };

        case 'id':
            return { type: 'text', content: 'uid=1000(cos) gid=1000(cos) groups=1000(cos),27(sudo)' };

        case 'hostname':
            return { type: 'text', content: 'unitama' };

        case 'uname':
            if (args[1] === '-a') return { type: 'text', content: 'Linux unitama 5.15.0-82-generic #91-Ubuntu SMP x86_64 x86_64 x86_64 GNU/Linux' };
            return { type: 'text', content: 'Linux' };

        case 'date':
            return { type: 'text', content: new Date().toLocaleString('id-ID', { dateStyle: 'full', timeStyle: 'long' }) };

        case 'uptime':
            return { type: 'text', content: 'up 3 hari, 4:20, 1 pengguna, rata beban: 0.05, 0.03, 0.00' };

        case 'free':
            if (args[1] === '-h') {
                return { type: 'text', content: '              total       terpakai      bebas\nMemori:         8.0G        2.0G        4.0G\nSwap:           2.0G        0.0G        2.0G' };
            }
            return { type: 'text', content: '              total        used        free      shared  buff/cache   available\nMem:        8192000     2048000     4096000           0     2048000     5000000' };

        case 'df':
            if (args[1] === '-h') {
                return { type: 'text', content: 'Filesystem      Ukuran Terpakai Tersisa Guna% Dipasang di\n/dev/sda1          50G      1.0G    49G    2% /' };
            }
            return { type: 'text', content: 'Filesystem     1K-blocks    Used Available Use% Mounted on\n/dev/sda1       50000000 1000000  49000000   2% /' };

        case 'neofetch':
            return {
                type: 'html',
                content: `<div style="display:flex;gap:24px;align-items:flex-start;font-family:monospace;font-size:12px;">
                    <div style="color:#38bdf8;font-size:36px;font-weight:900;letter-spacing:-2px;line-height:1;">COS</div>
                    <div style="color:#94a3b8;line-height:1.8;">
                        <span style="color:#38bdf8;font-weight:bold;">cos</span><span style="color:#e2e8f0;">@</span><span style="color:#38bdf8;font-weight:bold;">unitama</span><br>
                        <span style="color:#475569;">─────────────────────</span><br>
                        <span style="color:#38bdf8;">OS:</span> CyberOS Linux x86_64<br>
                        <span style="color:#38bdf8;">Host:</span> Unitama Web Environment<br>
                        <span style="color:#38bdf8;">Kernel:</span> 5.15.0-cos<br>
                        <span style="color:#38bdf8;">Uptime:</span> Aktif 24/7<br>
                        <span style="color:#38bdf8;">Shell:</span> bash 5.1.16<br>
                        <span style="color:#38bdf8;">Terminal:</span> COS WebTerm v1.0<br>
                        <span style="color:#38bdf8;">Tema:</span> COS-Dark<br>
                        <span style="color:#38bdf8;">Misi:</span> Open Your Mind 🔓
                    </div>
                </div>`
            };

        case 'htop':
            return { type: 'text', content: 'htop: tampilan interaktif tidak tersedia di terminal web.' };

        case 'git':
            if (args[1] === '--version') return { type: 'text', content: 'git versi 2.34.1' };
            if (args[1] === 'status') return { type: 'text', content: 'Pada cabang main\nCabang Anda sudah terkini dengan \'origin/main\'.\n\ntidak ada yang di-commit, direktori kerja bersih' };
            if (args[1] === 'log') return { type: 'text', content: 'commit 1a2b3c4d5e6f (HEAD -> main, origin/main)\nPenulis: COS <admin@cos.org>\nTanggal:   Hari ini\n\n    Commit pertama' };
            if (args[1] === 'branch') return { type: 'text', content: '* main\n  development' };
            return { type: 'text', content: 'penggunaan: git [--version] [--help] <perintah> [<argumen>]' };

        // ─── BANTUAN ────────────────────────────────────────────────────
        case 'help':
        case 'man':
            return {
                type: 'html',
                content: `<div style="font-family:monospace;font-size:12px;line-height:2;color:#94a3b8;">
                    <div style="color:#38bdf8;font-weight:bold;margin-bottom:8px;">── Navigasi Website (cd) ──</div>
                    <div><span style="color:#e2e8f0;">cd kegiatan</span>   → Halaman Kegiatan</div>
                    <div><span style="color:#e2e8f0;">cd berita</span>     → Halaman Berita</div>
                    <div><span style="color:#e2e8f0;">cd tentang</span>    → Halaman Tentang COS</div>
                    <div><span style="color:#e2e8f0;">cd organisasi</span> → Halaman Organisasi</div>
                    <div><span style="color:#e2e8f0;">cd divisi</span>     → Halaman Daftar Divisi</div>
                    <div><span style="color:#e2e8f0;">cd galeri</span>     → Halaman Galeri</div>
                    <div><span style="color:#e2e8f0;">cd kontak</span>     → Halaman Kontak</div>
                    <div><span style="color:#e2e8f0;">cd daftar</span>     → Halaman Pendaftaran</div>
                    <br>
                    <div style="color:#38bdf8;font-weight:bold;margin-bottom:8px;">── Shortcut Divisi ──</div>
                    <div><span style="color:#e2e8f0;">cd programming</span>  → Divisi Programming</div>
                    <div><span style="color:#e2e8f0;">cd networking</span>   → Divisi Networking</div>
                    <div><span style="color:#e2e8f0;">cd dkv</span>          → Divisi DKV</div>
                    <div style="color:#475569;font-size:11px;">  (atau: cd divisi/programming, cd divisi/networking, cd divisi/dkv)</div>
                    <br>
                    <div style="color:#38bdf8;font-weight:bold;margin-bottom:8px;">── Filesystem Virtual ──</div>
                    <div><span style="color:#e2e8f0;">ls, pwd, cd, tree, cat</span></div>
                    <div><span style="color:#e2e8f0;">head, tail, file</span></div>
                    <br>
                    <div style="color:#38bdf8;font-weight:bold;margin-bottom:8px;">── Sistem ──</div>
                    <div><span style="color:#e2e8f0;">whoami, hostname, uname, date</span></div>
                    <div><span style="color:#e2e8f0;">uptime, free -h, df -h, neofetch</span></div>
                    <div><span style="color:#e2e8f0;">git status, git log, git branch</span></div>
                    <br>
                    <div style="color:#38bdf8;font-weight:bold;margin-bottom:8px;">── Perintah COS ──</div>
                    <div><span style="color:#e2e8f0;">cos about, cos divisi</span></div>
                    <div><span style="color:#e2e8f0;">cos kegiatan</span>   → Daftar kegiatan mendatang</div>
                    <br>
                    <div style="color:#475569;font-size:11px;">Tab = autocomplete │ ↑↓ = riwayat │ clear = bersihkan layar</div>
                </div>`
            };

        // ─── PERINTAH COS ──────────────────────────────────────────────
        case 'cos':
            if (!args[1]) {
                return {
                    type: 'html',
                    content: `<div style="font-family:monospace;font-size:12px;color:#94a3b8;line-height:1.8;">
                        <span style="color:#38bdf8;font-weight:bold;">Penggunaan:</span> cos &lt;perintah&gt;<br>
                        <span style="color:#38bdf8;">kegiatan</span>  – Daftar kegiatan mendatang<br>
                        <span style="color:#38bdf8;">divisi</span>    – Daftar divisi COS<br>
                        <span style="color:#38bdf8;">about</span>     – Tentang COS<br>
                        <span style="color:#38bdf8;">motto</span>     – Motto COS<br>
                        <span style="color:#38bdf8;">kontak</span>    – Informasi kontak<br>
                        <span style="color:#38bdf8;">versi</span>     – Versi terminal
                    </div>`
                };
            }

            switch (args[1].toLowerCase()) {
                case 'about':
                    engine.setProcessing(true);
                    try {
                        const resAbout = await fetch('/api/terminal/about', {
                            headers: { 'Accept': 'application/json' }
                        });
                        if (!resAbout.ok) throw new Error(`HTTP ${resAbout.status}`);
                        const dataAbout = await resAbout.json();
                        engine.setProcessing(false);

                        if (dataAbout.success) {
                            return { type: 'text', content: dataAbout.data };
                        }
                        return { type: 'text', content: 'Gagal memuat informasi about.' };
                    } catch (e) {
                        engine.setProcessing(false);
                        console.error('Fetch about error:', e);
                        return { type: 'error', content: `Koneksi gagal: ${e.message}. (Pastikan controller dan route sudah diupload & migrate)` };
                    }

                case 'divisi':
                case 'divisions':
                    return {
                        type: 'html',
                        content: `<div style="font-family:monospace;font-size:12px;color:#94a3b8;line-height:2;">
                            <span style="color:#38bdf8;font-weight:bold;">Divisi COS:</span><br>
                            💻 <span style="color:#e2e8f0;">Programming</span>  – Web, Laravel, PHP, Python, JS<br>
                               <span style="color:#475569;font-size:11px;">  → ketik: <span style="color:#4ade80;">cd programming</span></span><br>
                            📡 <span style="color:#e2e8f0;">Networking</span>   – Linux, Cisco, Mikrotik<br>
                               <span style="color:#475569;font-size:11px;">  → ketik: <span style="color:#4ade80;">cd networking</span></span><br>
                            🎨 <span style="color:#e2e8f0;">DKV</span>          – UI/UX, Desain, Multimedia<br>
                               <span style="color:#475569;font-size:11px;">  → ketik: <span style="color:#4ade80;">cd dkv</span></span>
                        </div>`
                    };

                case 'motto':
                    return { type: 'text', content: '\"Open Your Mind For The Future With Open Source\"' };

                case 'versi':
                case 'version':
                    return { type: 'text', content: 'COS WebTerm v1.0.0 — Cyber Open Source © 2026' };

                case 'kontak':
                case 'contact':
                    engine.setProcessing(true);
                    try {
                        const resKontak = await fetch('/api/terminal/kontak', {
                            headers: { 'Accept': 'application/json' }
                        });
                        if (!resKontak.ok) throw new Error(`HTTP ${resKontak.status}`);
                        const dataKontak = await resKontak.json();
                        engine.setProcessing(false);

                        if (dataKontak.success) {
                            const k = dataKontak.data;
                            let kontakText = `Instagram : ${k.instagram}`;
                            if (k.email    && k.email    !== '-') kontakText += `\nEmail     : ${k.email}`;
                            if (k.whatsapp && k.whatsapp !== '-') kontakText += `\nWhatsApp  : ${k.whatsapp}`;
                            if (k.address  && k.address  !== '-') kontakText += `\nAlamat    : ${k.address}`;
                            return { type: 'text', content: kontakText };
                        }
                        return { type: 'text', content: 'Gagal memuat data kontak.' };
                    } catch (e) {
                        engine.setProcessing(false);
                        console.error('Fetch kontak error:', e);
                        return { type: 'error', content: `Koneksi gagal: ${e.message}. (Pastikan controller dan route sudah diupload & migrate)` };
                    }

                case 'kegiatan':
                case 'activities':
                    engine.setProcessing(true);
                    try {
                        const response = await fetch('/api/terminal/activities');
                        const data = await response.json();
                        engine.setProcessing(false);

                        if (data.success && data.data.length > 0) {
                            let actHtml = `<div style="font-family:monospace;font-size:12px;">
                                <div style="color:#38bdf8;font-weight:bold;margin-bottom:10px;">── Kegiatan Mendatang ──</div>`;
                            data.data.forEach((act, idx) => {
                                actHtml += `<div style="margin-bottom:8px;">
                                    <span style="color:#e2e8f0;">[${idx + 1}] ${act.title}</span><br>
                                    <span style="color:#64748b;padding-left:20px;">📅 ${act.date} &nbsp; 📍 ${act.location}</span>
                                </div>`;
                            });
                            actHtml += `</div>`;
                            return { type: 'html', content: actHtml };
                        } else {
                            return { type: 'text', content: 'Tidak ada kegiatan mendatang yang ditemukan.' };
                        }
                    } catch (e) {
                        engine.setProcessing(false);
                        return { type: 'error', content: 'Gagal mengambil data kegiatan: ' + e.message };
                    }

                default:
                    return { type: 'error', content: `cos: perintah tidak dikenal '${args[1]}'. Ketik 'cos' untuk bantuan.` };
            }

        // ─── TIDAK DIKENAL ──────────────────────────────────────────────
        default:
            return { type: 'error', content: `bash: ${cmd}: perintah tidak ditemukan. Ketik 'help' untuk bantuan.` };
    }
}
