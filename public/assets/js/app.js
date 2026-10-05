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

    const dialogOpeners = new WeakMap();

    document.querySelectorAll('[data-admin-dialog-open]').forEach((button) => {
        button.addEventListener('click', () => {
            const dialog = document.getElementById(button.dataset.adminDialogOpen || '');
            if (dialog instanceof HTMLDialogElement) {
                dialogOpeners.set(dialog, button);
                dialog.showModal();
                document.body.classList.add('admin-dialog-open');
            }
        });
    });

    document.querySelectorAll('.admin-edit-dialog').forEach((dialog) => {
        if (!(dialog instanceof HTMLDialogElement)) {
            return;
        }

        dialog.querySelectorAll('[data-admin-dialog-close]').forEach((button) => {
            button.addEventListener('click', () => dialog.close());
        });

        dialog.addEventListener('click', (event) => {
            const bounds = dialog.getBoundingClientRect();
            const outside = event.clientX < bounds.left
                || event.clientX > bounds.right
                || event.clientY < bounds.top
                || event.clientY > bounds.bottom;
            if (outside) {
                dialog.close();
            }
        });

        dialog.addEventListener('close', () => {
            if (!document.querySelector('.admin-edit-dialog[open]')) {
                document.body.classList.remove('admin-dialog-open');
            }
            const opener = dialogOpeners.get(dialog);
            if (opener instanceof HTMLElement) {
                opener.focus();
            }
        });
    });
});

// Native dialog with ordinary image links as a no-JavaScript fallback.
document.addEventListener('DOMContentLoaded', () => {
    const viewer = document.querySelector('.recap-viewer');
    const links = Array.from(document.querySelectorAll('[data-recap-photo]'));
    if (!(viewer instanceof HTMLDialogElement) || !links.length || typeof viewer.showModal !== 'function') return;
    const image = viewer.querySelector('[data-recap-image]');
    const caption = viewer.querySelector('[data-recap-caption]');
    const counter = viewer.querySelector('[data-recap-counter]');
    let current = 0;
    let opener;
    let touchStartX;
    const show = (index) => {
        current = (index + links.length) % links.length;
        const thumbnail = links[current].querySelector('img');
        image.src = links[current].href;
        image.alt = thumbnail.alt;
        caption.textContent = thumbnail.alt;
        counter.textContent = `${current + 1} / ${links.length}`;
    };
    links.forEach((link, index) => {
        link.addEventListener('click', (event) => {
            if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey || event.button !== 0) return;
            event.preventDefault();
            opener = link;
            show(index);
            viewer.showModal();
            document.body.classList.add('recap-viewer-open');
        });
    });
    viewer.querySelector('[data-recap-close]').addEventListener('click', () => viewer.close());
    viewer.querySelector('[data-recap-prev]').addEventListener('click', () => show(current - 1));
    viewer.querySelector('[data-recap-next]').addEventListener('click', () => show(current + 1));
    viewer.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
            event.preventDefault();
            show(current + (event.key === 'ArrowLeft' ? -1 : 1));
        }
    });
    viewer.addEventListener('click', (event) => {
        if (event.target === viewer) {
            const bounds = viewer.getBoundingClientRect();
            if (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom) viewer.close();
        }
    });
    image.addEventListener('touchstart', (event) => {
        touchStartX = event.changedTouches[0].clientX;
    }, { passive: true });
    image.addEventListener('touchend', (event) => {
        if (touchStartX === undefined) return;
        const distance = event.changedTouches[0].clientX - touchStartX;
        if (Math.abs(distance) > 60) show(current + (distance > 0 ? -1 : 1));
        touchStartX = undefined;
    }, { passive: true });
    viewer.addEventListener('close', () => {
        document.body.classList.remove('recap-viewer-open');
        if (opener) opener.focus({ preventScroll: true });
    });
});
