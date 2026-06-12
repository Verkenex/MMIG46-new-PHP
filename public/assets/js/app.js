document.querySelector('[data-nav]')?.addEventListener('click', () => {
    document.querySelector('.site-header')?.classList.toggle('open');
});

const cookie = document.getElementById('cookie');

if (cookie && !localStorage.getItem('mmig46_cookie_ok')) {
    cookie.classList.add('show');
}

document.querySelector('[data-cookie]')?.addEventListener('click', () => {
    localStorage.setItem('mmig46_cookie_ok', '1');
    cookie?.classList.remove('show');
});