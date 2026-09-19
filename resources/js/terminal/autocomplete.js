import { resolvePath, getNodeAtPath } from './filesystem.js';

export function getAutocomplete(currentPath, currentInput) {
    if (!currentInput || currentInput.trim() === '') return { matches: [], prefix: '' };

    const parts = currentInput.split(' ');
    const lastPart = parts[parts.length - 1];
    
    // Command autocomplete
    if (parts.length === 1) {
        const commands = ['pwd', 'ls', 'cd', 'tree', 'cat', 'head', 'tail', 'file', 'clear', 'history', 'echo', 'help', 'man', 'whoami', 'id', 'hostname', 'uname', 'date', 'uptime', 'free', 'df', 'neofetch', 'htop', 'git', 'cos'];
        const matches = commands.filter(c => c.startsWith(lastPart));
        return { matches, prefix: lastPart, isCommand: true };
    }

    // Argument autocomplete (Filesystem + Page navigation)
    const cmd = parts[0];
    if (['cd', 'ls', 'cat', 'file', 'head', 'tail'].includes(cmd)) {
        // Page navigation aliases for cd
        const pageAliases = ['tentang', 'organisasi', 'divisi', 'kegiatan', 'berita', 'galeri', 'kontak', 'daftar', 'beranda'];
        if (cmd === 'cd') {
            const pageMatches = pageAliases.filter(p => p.startsWith(lastPart));
            if (pageMatches.length > 0) {
                return { matches: pageMatches, prefix: lastPart, isPath: false };
            }
        }
        
        let targetDir = currentPath;
        let filePrefix = lastPart;
        
        const lastSlashIndex = lastPart.lastIndexOf('/');
        if (lastSlashIndex !== -1) {
            const dirPart = lastPart.substring(0, lastSlashIndex);
            filePrefix = lastPart.substring(lastSlashIndex + 1);
            targetDir = resolvePath(currentPath, dirPart);
        } else if (lastPart === '~') {
            return { matches: ['/'], prefix: '', isPath: true };
        }

        const node = getNodeAtPath(targetDir);
        if (node && node.type === 'dir' && node.children) {
            const matches = Object.keys(node.children)
                .filter(name => name.startsWith(filePrefix))
                .map(name => {
                    const isDir = node.children[name].type === 'dir';
                    return isDir ? name + '/' : name;
                });
            return { matches, prefix: filePrefix, isPath: true };
        }
    }
    
    // Autocomplete for cos commands
    if (cmd === 'cos' && parts.length === 2) {
        const subCommands = ['about', 'divisions', 'activities', 'members', 'contact', 'motto', 'version', 'open'];
        const matches = subCommands.filter(c => c.startsWith(lastPart));
        return { matches, prefix: lastPart, isSubCommand: true };
    }
    
    // Autocomplete for cos open
    if (cmd === 'cos' && parts[1] === 'open' && parts.length === 3) {
        const routes = ['activities', 'registration', 'articles', 'about'];
        const matches = routes.filter(c => c.startsWith(lastPart));
        return { matches, prefix: lastPart, isSubCommand: true };
    }

    return { matches: [], prefix: '' };
}
