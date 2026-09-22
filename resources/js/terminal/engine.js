import { TerminalHistory } from './history.js';
import { getAutocomplete } from './autocomplete.js';
import { executeCommand } from './commands.js';

const STORAGE_KEY_PATH = 'cos_terminal_path';

// Intro sequences yang dimainkan saat pertama kali load (hanya di homepage)
const INTRO_SEQUENCES = [
    {
        cmd: 'whoami',
        output: { type: 'text', content: 'Cyber Open Source' }
    },
    {
        cmd: 'ls',
        output: {
            type: 'ls',
            items: [
                { text: 'Programming/', isDir: true },
                { text: 'Networking/', isDir: true },
                { text: 'DKV/', isDir: true },
                { text: 'OpenSource/', isDir: true },
            ],
            showDetails: false
        }
    },
    {
        cmd: './start-cos.sh',
        output: { type: 'text', content: 'Open Your Mind for The Future With Open Source' }
    }
];

// Placeholder terminal — tetap, tidak berganti
const PLACEHOLDER_HINT = 'ketik "help" untuk daftar perintah...';

export class TerminalEngine {
    constructor(containerElement, options = {}) {
        this.container = containerElement;
        this.body = containerElement.querySelector('.cos-terminal-body');

        if (!this.body) {
            console.error('Terminal body not found in container');
            return;
        }

        this.history = new TerminalHistory();
        this.historyIndex = this.history.commands.length;

        // Restore path atau default
        this.currentPath = localStorage.getItem(STORAGE_KEY_PATH) || '/home/cos';
        this.isProcessing = false;
        this.introPlayed = false;

        this.options = Object.assign({
            isMini: false,
            autoFocus: true,
            playIntro: false // hanya homepage yang play intro
        }, options);

        this.input = null;
        this.activePromptLine = null;

        this.initDOM();
        this.bindEvents();

        if (this.options.playIntro) {
            this._playIntro();
        } else {
            this.createNewPrompt();
        }
    }

    // ─── Path Management ────────────────────────────────────────────

    setPath(newPath) {
        this.currentPath = newPath;
        localStorage.setItem(STORAGE_KEY_PATH, newPath);
    }

    setProcessing(isProcessing) {
        this.isProcessing = isProcessing;

        if (this.input) {
            this.input.disabled = isProcessing;

            if (!isProcessing && this.options.autoFocus) {
                this.input.focus();
            }
        }
    }

    getPromptString() {
        let displayPath = this.currentPath;

        if (displayPath.startsWith('/home/cos')) {
            displayPath = '~' + displayPath.substring(9);
        }

        return `<span class="terminal-prompt-user">cos</span>` +
            `<span class="terminal-prompt-sep">@</span>` +
            `<span class="terminal-prompt-host">unitama</span>` +
            `<span class="terminal-prompt-sep">:</span>` +
            `<span class="terminal-prompt-path">${displayPath}</span>` +
            `<span class="terminal-prompt-sep">$ </span>`;
    }

    // ─── DOM Init ───────────────────────────────────────────────────

    initDOM() {
        this.body.addEventListener('click', () => {
            if (this.input && !this.isProcessing) {
                this.input.focus();
            }
        });
    }

    // ─── Intro Typewriter ───────────────────────────────────────────

    _playIntro() {
        const CHAR_SPEED = 50;
        const OUTPUT_DELAY = 180;
        const SEQ_DELAY = 500;

        let seqIdx = 0;

        const runNext = () => {
            if (seqIdx >= INTRO_SEQUENCES.length) {
                // Intro selesai → aktifkan prompt interaktif
                this.introPlayed = true;
                this.createNewPrompt();
                return;
            }

            const seq = INTRO_SEQUENCES[seqIdx];

            // Buat baris prompt statis + typing target
            const promptLine = document.createElement('div');
            promptLine.className = 'terminal-line';
            promptLine.innerHTML = this.getPromptString();

            const cmdSpan = document.createElement('span');
            cmdSpan.className = 'terminal-cmd';

            promptLine.appendChild(cmdSpan);
            this.body.appendChild(promptLine);
            this.scrollToBottom();

            // Type karakter satu per satu
            let charIdx = 0;

            const typeInterval = setInterval(() => {
                if (charIdx <= seq.cmd.length) {
                    cmdSpan.textContent = seq.cmd.slice(0, charIdx);
                    charIdx++;
                    this.scrollToBottom();
                } else {
                    clearInterval(typeInterval);

                    // Tampilkan output setelah delay
                    setTimeout(() => {
                        this.printOutput(seq.output);
                        seqIdx++;

                        setTimeout(runNext, SEQ_DELAY);
                    }, OUTPUT_DELAY);
                }
            }, CHAR_SPEED);
        };

        // Delay awal sebelum mulai animasi
        setTimeout(runNext, 400);
    }

    // ─── Prompt & Input ─────────────────────────────────────────────

    createNewPrompt() {
        if (this.activePromptLine) {
            const oldInput = this.activePromptLine.querySelector('input');

            if (oldInput) {
                const staticSpan = document.createElement('span');
                staticSpan.className = 'terminal-cmd';
                staticSpan.textContent = oldInput.value;

                oldInput.replaceWith(staticSpan);
            }
        }

        this.activePromptLine = document.createElement('div');
        this.activePromptLine.className = 'terminal-line active-line';
        this.activePromptLine.innerHTML = this.getPromptString();

        this.input = document.createElement('input');
        this.input.type = 'text';
        this.input.className = 'terminal-input';
        this.input.autocomplete = 'off';
        this.input.spellcheck = false;
        this.input.setAttribute('aria-label', 'Terminal input');

        // Placeholder tetap
        this.input.placeholder = PLACEHOLDER_HINT;

        this.activePromptLine.appendChild(this.input);
        this.body.appendChild(this.activePromptLine);

        if (this.options.autoFocus) {
            this.input.focus();
        }

        this.scrollToBottom();
    }

    // ─── Event Handlers ─────────────────────────────────────────────

    bindEvents() {
        this.body.addEventListener('keydown', (e) => {
            if (e.target !== this.input) return;

            if (e.key === 'Enter') {
                e.preventDefault();
                this.handleEnter();

            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                this.handleHistory(-1);

            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                this.handleHistory(1);

            } else if (e.key === 'Tab') {
                e.preventDefault();
                this.handleTab();
            }
        });
    }

    handleHistory(direction) {
        const cmds = this.history.getAll();

        if (cmds.length === 0) return;

        this.historyIndex += direction;

        if (this.historyIndex < 0) {
            this.historyIndex = 0;
        }

        if (this.historyIndex > cmds.length) {
            this.historyIndex = cmds.length;
        }

        if (this.historyIndex === cmds.length) {
            this.input.value = '';
        } else {
            this.input.value = cmds[this.historyIndex];
        }
    }

    handleTab() {
        const currentVal = this.input.value;

        const {
            matches,
            prefix,
            isPath
        } = getAutocomplete(this.currentPath, currentVal);

        if (matches.length === 1) {
            const completion = matches[0].substring(prefix.length);

            this.input.value += completion;

            if (!isPath || !matches[0].endsWith('/')) {
                this.input.value += ' ';
            }

        } else if (matches.length > 1) {
            this.printOutput({
                type: 'text',
                content: matches.join('  ')
            });

            this.createNewPrompt();
            this.input.value = currentVal;
        }
    }

    async handleEnter() {
        const commandStr = this.input.value;

        const currentInput = this.input;

        const staticSpan = document.createElement('span');
        staticSpan.className = 'terminal-cmd';
        staticSpan.textContent = commandStr;

        currentInput.replaceWith(staticSpan);
        this.activePromptLine = null;

        if (commandStr.trim() !== '') {
            this.history.add(commandStr);
            this.historyIndex = this.history.getAll().length;

            const result = await executeCommand(
                commandStr,
                this.currentPath,
                this
            );

            if (result.type === 'redirect') {
                this.printOutput({
                    type: 'info',
                    content: `→ Membuka ${result.url}...`
                });

                setTimeout(() => {
                    window.location.href = result.url;
                }, 400);

                return;
            }

            if (result.type === 'clear') {
                this.body.innerHTML = '';

            } else if (result.type !== 'empty') {
                this.printOutput(result);
            }
        }

        this.createNewPrompt();
    }

    // ─── Output Renderer ────────────────────────────────────────────

    printOutput(result) {
        if (!result) return;

        const outDiv = document.createElement('div');
        outDiv.className = 'terminal-output';

        if (result.type === 'error') {
            outDiv.classList.add('error');
            outDiv.textContent = result.content;

        } else if (result.type === 'info') {
            outDiv.classList.add('info');
            outDiv.textContent = result.content;

        } else if (result.type === 'html') {
            outDiv.innerHTML = result.content;

        } else if (result.type === 'ls') {
            const grid = document.createElement('div');
            grid.className = 'terminal-ls-grid';

            result.items.forEach(item => {
                const span = document.createElement('span');

                span.className =
                    'terminal-ls-item' +
                    (item.isDir ? ' dir' : '');

                span.textContent = item.text;

                if (result.showDetails) {
                    span.style.display = 'block';
                }

                grid.appendChild(span);
            });

            outDiv.appendChild(grid);

        } else if (result.type === 'text') {
            outDiv.textContent = result.content;
            outDiv.style.whiteSpace = 'pre-wrap';
        }

        this.body.appendChild(outDiv);
        this.scrollToBottom();
    }

    scrollToBottom() {
        this.body.scrollTop = this.body.scrollHeight;
    }
}