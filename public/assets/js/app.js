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

document.addEventListener('DOMContentLoaded', () => {
    const popup = document.getElementById('training-weekend-popup');

    if (!popup) {
        return;
    }

    const storageKey = 'mmig46_training_weekend_popup_2026';

    try {
        if (sessionStorage.getItem(storageKey) === 'closed') {
            return;
        }
    } catch (error) {
        // Das Popup funktioniert auch ohne Web Storage.
    }

    popup.hidden = false;
    document.body.classList.add('has-modal');

    const closePopup = () => {
        popup.hidden = true;
        document.body.classList.remove('has-modal');

        try {
            sessionStorage.setItem(storageKey, 'closed');
        } catch (error) {
            // Keine weitere Aktion erforderlich.
        }
    };

    popup
        .querySelectorAll('[data-close-training-popup]')
        .forEach((element) => {
            element.addEventListener('click', closePopup);
        });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !popup.hidden) {
            closePopup();
        }
    });
});
