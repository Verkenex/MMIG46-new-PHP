document.addEventListener('DOMContentLoaded', () => {
    const navButton = document.querySelector('[data-nav]');
    const header = document.querySelector('.site-header');

    if (navButton && header) {
        navButton.addEventListener('click', () => {
            const isOpen = header.classList.toggle('open');
            navButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    const cookie = document.getElementById('cookie');
    const cookieButton = document.querySelector('[data-cookie]');

    if (cookie && !localStorage.getItem('mmig46_cookie_ok')) {
        cookie.classList.add('show');
    }

    if (cookieButton) {
        cookieButton.addEventListener('click', () => {
            localStorage.setItem('mmig46_cookie_ok', '1');
            if (cookie) {
                cookie.classList.remove('show');
            }
        });
    }
});