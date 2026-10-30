const root = document.documentElement;
const themeToggle = document.getElementById('theme-toggle');
const copyEmail = document.getElementById('copy-email');

const saved = localStorage.getItem('theme');
if (saved === 'dark' || saved === 'light') {
    root.setAttribute('data-theme', saved);
}

function syncThemeLabel() {
    if (!themeToggle) return;
    const dark = root.getAttribute('data-theme') === 'dark';
    themeToggle.setAttribute('aria-label', dark ? 'Switch to light mode' : 'Switch to dark mode');
}

syncThemeLabel();

if (themeToggle) {
    themeToggle.addEventListener('click', () => {
        const next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        root.setAttribute('data-theme', next);
        localStorage.setItem('theme', next);
        syncThemeLabel();
    });
}

if (copyEmail) {
    copyEmail.addEventListener('click', async () => {
        const email = copyEmail.dataset.email;
        try {
            await navigator.clipboard.writeText(email);
            copyEmail.dataset.copied = 'true';
            setTimeout(() => {
                copyEmail.dataset.copied = 'false';
            }, 1600);
        } catch {
            window.location.href = `mailto:${email}`;
        }
    });
}
