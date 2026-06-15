document.querySelector('[data-nav]')?.addEventListener('click', (event) => {
    const header = document.querySelector('.site-header');

    if (!header) {
        return;
    }

    const isOpen = header.classList.toggle('open');
    event.currentTarget.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
});

const cookie = document.getElementById('cookie');

if (cookie && !localStorage.getItem('mmig46_cookie_ok')) {
    cookie.classList.add('show');
}

document.querySelector('[data-cookie]')?.addEventListener('click', () => {
    localStorage.setItem('mmig46_cookie_ok', '1');
    cookie?.classList.remove('show');
});