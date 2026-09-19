const MAX_HISTORY = 100;
const STORAGE_KEY = 'cos_terminal_history';

export class TerminalHistory {
    constructor() {
        this.commands = [];
        this.load();
    }

    load() {
        try {
            const saved = localStorage.getItem(STORAGE_KEY);
            if (saved) {
                this.commands = JSON.parse(saved);
            }
        } catch (e) {
            console.warn('Could not load terminal history', e);
        }
    }

    save() {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(this.commands));
        } catch (e) {
            console.warn('Could not save terminal history', e);
        }
    }

    add(cmd) {
        if (!cmd || cmd.trim() === '') return;
        
        // Remove duplicate if it's the same as the last command
        if (this.commands.length > 0 && this.commands[this.commands.length - 1] === cmd) {
            return;
        }

        this.commands.push(cmd);
        if (this.commands.length > MAX_HISTORY) {
            this.commands.shift(); // Remove oldest
        }
        this.save();
    }

    getAll() {
        return this.commands;
    }
}
