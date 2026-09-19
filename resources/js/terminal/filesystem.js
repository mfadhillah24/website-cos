// ============================================================
//  Virtual Filesystem — struktur hierarki benar
// ============================================================

export const VirtualFileSystem = {
    type: 'dir',
    children: {
        'home': {
            type: 'dir',
            children: {
                'cos': {
                    type: 'dir',
                    children: {
                        'Programming': {
                            type: 'dir',
                            children: {
                                'Laravel': {
                                    type: 'dir',
                                    children: {
                                        'Aventra': {
                                            type: 'dir',
                                            children: {
                                                'README.md': { type: 'file', content: '# Aventra\nProyek web oleh COS Unitama.' }
                                            }
                                        },
                                        'website-cos': {
                                            type: 'dir',
                                            children: {
                                                'README.md': { type: 'file', content: '# website-cos\nWebsite resmi Cyber Open Source.' }
                                            }
                                        }
                                    }
                                },
                                'PHP': {
                                    type: 'dir',
                                    children: {
                                        'README.md': { type: 'file', content: '# PHP\nDivisi PHP — backend, scripting, dan OOP.' }
                                    }
                                },
                                'JavaScript': {
                                    type: 'dir',
                                    children: {
                                        'README.md': { type: 'file', content: '# JavaScript\nFrontend, Node.js, dan framework modern.' }
                                    }
                                },
                                'Python': {
                                    type: 'dir',
                                    children: {
                                        'README.md': { type: 'file', content: '# Python\nData science, scripting, dan otomasi.' }
                                    }
                                },
                                'README.md': { type: 'file', content: '# Programming\nDivisi yang berfokus pada pengembangan perangkat lunak.' }
                            }
                        },
                        'Networking': {
                            type: 'dir',
                            children: {
                                'Linux': {
                                    type: 'dir',
                                    children: {
                                        'README.md': { type: 'file', content: '# Linux\nAdministrasi sistem dan server Linux.' }
                                    }
                                },
                                'Cisco': {
                                    type: 'dir',
                                    children: {
                                        'README.md': { type: 'file', content: '# Cisco\nKonfigurasi router dan switch Cisco.' }
                                    }
                                },
                                'Mikrotik': {
                                    type: 'dir',
                                    children: {
                                        'README.md': { type: 'file', content: '# Mikrotik\nManajemen jaringan dengan RouterOS Mikrotik.' }
                                    }
                                },
                                'README.md': { type: 'file', content: '# Networking\nDivisi yang berfokus pada jaringan komputer.' }
                            }
                        },
                        'DKV': {
                            type: 'dir',
                            children: {
                                'UI-UX': {
                                    type: 'dir',
                                    children: {
                                        'README.md': { type: 'file', content: '# UI-UX\nDesain antarmuka dan pengalaman pengguna.' }
                                    }
                                },
                                'Design': {
                                    type: 'dir',
                                    children: {
                                        'README.md': { type: 'file', content: '# Design\nDesain grafis dan visual kreatif.' }
                                    }
                                },
                                'Multimedia': {
                                    type: 'dir',
                                    children: {
                                        'README.md': { type: 'file', content: '# Multimedia\nVideo, animasi, dan konten digital.' }
                                    }
                                },
                                'README.md': { type: 'file', content: '# DKV\nDesain Komunikasi Visual — kreativitas tanpa batas.' }
                            }
                        },
                        'OpenSource': {
                            type: 'dir',
                            children: {
                                'Linux': {
                                    type: 'dir',
                                    children: {
                                        'README.md': { type: 'file', content: '# Linux\nDistribusi Linux dan kontribusi open source.' }
                                    }
                                },
                                'Git': {
                                    type: 'dir',
                                    children: {
                                        'README.md': { type: 'file', content: '# Git\nVersion control dan kolaborasi kode.' }
                                    }
                                },
                                'Community': {
                                    type: 'dir',
                                    children: {
                                        'README.md': { type: 'file', content: '# Community\nKomunitas open source yang terbuka untuk semua.' }
                                    }
                                },
                                'README.md': { type: 'file', content: '# OpenSource\nDivisi open source — berbagi, belajar, dan berkolaborasi.' }
                            }
                        },
                        'README.md': {
                            type: 'file',
                            content: `# Selamat Datang di Cyber Open Source!

Kami adalah komunitas mahasiswa yang bersemangat belajar teknologi.

Direktori:
  Programming/   — Web, Laravel, PHP, Python, JavaScript
  Networking/    — Linux, Cisco, Mikrotik
  DKV/           — UI/UX, Desain, Multimedia
  OpenSource/    — Linux, Git, Komunitas

Motto: "Open Your Mind For The Future With Open Source"

Gunakan perintah 'help' untuk daftar perintah.`
                        },
                        '.profile': {
                            type: 'file',
                            content: 'export PATH=$HOME/.local/bin:$PATH\nexport EDITOR=vim\n# COS Terminal Profile'
                        },
                        '.bashrc': {
                            type: 'file',
                            content: '# ~/.bashrc — COS Terminal\nalias ll="ls -la"\nalias cls="clear"\necho "Welcome back, cos!"'
                        }
                    }
                }
            }
        }
    }
};

// ============================================================
//  Resolve path (absolut, relatif, atau ~)
// ============================================================
export function resolvePath(currentPath, targetPath) {
    if (!targetPath) return currentPath;

    let parts = [];

    if (targetPath === '~') {
        return '/home/cos';
    } else if (targetPath.startsWith('~/')) {
        parts = ['home', 'cos', ...targetPath.substring(2).split('/').filter(p => p)];
    } else if (targetPath.startsWith('/')) {
        parts = targetPath.split('/').filter(p => p);
    } else {
        // relatif terhadap current path
        parts = [...currentPath.split('/').filter(p => p), ...targetPath.split('/').filter(p => p)];
    }

    const resolved = [];
    for (const p of parts) {
        if (p === '.') continue;
        if (p === '..') {
            if (resolved.length > 0) resolved.pop();
        } else {
            resolved.push(p);
        }
    }

    return '/' + resolved.join('/');
}

// ============================================================
//  Ambil node di path tertentu dari VirtualFileSystem
// ============================================================
export function getNodeAtPath(path) {
    if (!path || path === '/') return VirtualFileSystem;

    const parts = path.split('/').filter(p => p);
    let current = VirtualFileSystem;

    for (const p of parts) {
        if (!current || current.type !== 'dir' || !current.children) return null;
        if (!(p in current.children)) return null;
        current = current.children[p];
    }

    return current;
}
