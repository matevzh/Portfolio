const root = document.documentElement;
const themeToggle = document.getElementById('theme-toggle');
const copyEmail = document.getElementById('copy-email');

const THEME_KEY = 'theme';
const THEME_MAX_AGE = 60 * 60 * 24 * 365;

function cookieDomain() {
    const host = location.hostname;
    if (host === 'matevz.tech' || host.endsWith('.matevz.tech')) {
        return '; domain=.matevz.tech';
    }
    return '';
}

function readCookie(name) {
    const prefix = `${name}=`;
    for (const part of document.cookie.split(';')) {
        const value = part.trim();
        if (value.startsWith(prefix)) {
            return decodeURIComponent(value.slice(prefix.length));
        }
    }
    return null;
}

function writeTheme(theme) {
    localStorage.setItem(THEME_KEY, theme);
    document.cookie = `${THEME_KEY}=${encodeURIComponent(theme)}; path=/; max-age=${THEME_MAX_AGE}; SameSite=Lax${cookieDomain()}`;
}

function readTheme() {
    const fromCookie = readCookie(THEME_KEY);
    if (fromCookie === 'dark' || fromCookie === 'light') {
        return fromCookie;
    }
    const fromStorage = localStorage.getItem(THEME_KEY);
    if (fromStorage === 'dark' || fromStorage === 'light') {
        return fromStorage;
    }
    return null;
}

const saved = readTheme();
if (saved) {
    root.setAttribute('data-theme', saved);
    writeTheme(saved);
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
        writeTheme(next);
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
