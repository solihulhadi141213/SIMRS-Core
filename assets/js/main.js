(() => {
    'use strict';

    // Menyiapkan perilaku header, navigasi, dropdown, dan preloader setelah HTML siap.
    const initializeLayout = () => {
        const layout = document.getElementById('pcoded');

        // Hentikan inisialisasi pada halaman yang tidak menggunakan kerangka aplikasi.
        if (!layout) {
            return;
        }

        const mobileBreakpoint = window.matchMedia('(max-width: 991.98px)');
        const navigation = document.getElementById('main-navigation');
        const menuToggles = document.querySelectorAll('[data-layout-toggle="sidebar"]');
        const overlay = layout.querySelector('.pcoded-overlay-box');
        const dropdowns = layout.querySelectorAll('.header-notification');
        const themeToggle = document.querySelector('[data-theme-toggle]');

        navigation?.querySelectorAll('.pcoded-mtext').forEach((label) => {
            const link = label.closest('a');
            const text = label.textContent.trim();

            if (link && text && !link.hasAttribute('aria-label')) {
                link.setAttribute('aria-label', text);
            }
        });

        // Memulihkan tema pilihan pengguna dan menyelaraskan label kontrolnya.
        const applyTheme = (theme) => {
            const isDark = theme === 'dark';
            document.body.dataset.theme = isDark ? 'dark' : 'light';

            if (themeToggle) {
                themeToggle.setAttribute('aria-label', isDark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap');
                themeToggle.setAttribute('title', isDark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap');
                themeToggle.querySelector('i')?.classList.toggle('bi-moon-stars', isDark);
                themeToggle.querySelector('i')?.classList.toggle('bi-sun', !isDark);
            }
        };

        applyTheme(localStorage.getItem('simrs-core-theme') || 'light');

        themeToggle?.addEventListener('click', () => {
            const nextTheme = document.body.dataset.theme === 'dark' ? 'light' : 'dark';
            localStorage.setItem('simrs-core-theme', nextTheme);
            applyTheme(nextTheme);
        });

        // Menjaga label aksesibilitas tombol menu sesuai kondisi sidebar.
        const updateMenuState = () => {
            const isOpen = mobileBreakpoint.matches
                ? layout.classList.contains('sidebar-open')
                : !layout.classList.contains('sidebar-compact');

            menuToggles.forEach((toggle) => {
                toggle.setAttribute('aria-expanded', String(isOpen));
                toggle.setAttribute(
                    'aria-label',
                    mobileBreakpoint.matches
                        ? isOpen ? 'Tutup menu' : 'Buka menu'
                        : isOpen ? 'Ciutkan menu' : 'Perluas menu'
                );

                if (!mobileBreakpoint.matches && toggle.classList.contains('sidebar_toggle')) {
                    const icon = toggle.querySelector('i');
                    icon?.classList.toggle('bi-arrow-bar-left', isOpen);
                    icon?.classList.toggle('bi-arrow-bar-right', !isOpen);
                }
            });

            navigation?.querySelectorAll('.pcoded-mtext').forEach((label) => {
                const link = label.closest('a');
                if (link) {
                    link.title = isOpen || mobileBreakpoint.matches ? '' : label.textContent.trim();
                }
            });
        };

        // Menentukan tipe perangkat dan mengatur ulang sidebar saat ukuran layar berubah.
        const setDeviceType = () => {
            layout.setAttribute(
                'pcoded-device-type',
                window.innerWidth <= 767 ? 'phone' : mobileBreakpoint.matches ? 'tablet' : 'desktop'
            );

            if (mobileBreakpoint.matches) {
                layout.classList.remove('sidebar-compact');
                layout.classList.remove('sidebar-hidden');
                layout.classList.remove('sidebar-open');
            } else {
                layout.classList.remove('sidebar-open');
            }

            updateMenuState();
        };

        // Menutup dropdown lain, atau semua dropdown jika tidak ada pengecualian.
        const closeDropdowns = (except = null) => {
            dropdowns.forEach((dropdown) => {
                if (dropdown === except) {
                    return;
                }

                dropdown.classList.remove('active');
                dropdown.querySelector(':scope > a')?.setAttribute('aria-expanded', 'false');
            });
        };

        // Tombol header dan tombol di sidebar membuka atau menutup navigasi.
        menuToggles.forEach((toggle) => {
            toggle.addEventListener('click', () => {
                if (mobileBreakpoint.matches) {
                    layout.classList.toggle('sidebar-open');
                } else {
                    layout.classList.toggle('sidebar-compact');
                }

                updateMenuState();
            });
        });

        // Pada layar kecil, klik area gelap di luar sidebar menutup navigasi.
        overlay?.addEventListener('click', () => {
            layout.classList.remove('sidebar-open');
            updateMenuState();
        });

        // Mengatur submenu; tautan navigasi biasa tetap mengikuti tujuan aslinya.
        navigation?.addEventListener('click', (event) => {
            const link = event.target.closest('a');

            if (!link || !navigation.contains(link)) {
                return;
            }

            const menuItem = link.parentElement;
            if (menuItem?.classList.contains('pcoded-hasmenu')) {
                const destination = link.getAttribute('href') || '';

                if (destination.startsWith('javascript:') || destination === '#') {
                    event.preventDefault();
                    const willOpen = !menuItem.classList.contains('pcoded-trigger');

                    Array.from(menuItem.parentElement.children).forEach((sibling) => {
                        if (sibling === menuItem || !sibling.classList.contains('pcoded-hasmenu')) {
                            return;
                        }

                        sibling.classList.remove('pcoded-trigger');
                        sibling.querySelector(':scope > a')?.setAttribute('aria-expanded', 'false');
                    });

                    menuItem.classList.toggle('pcoded-trigger', willOpen);
                    link.setAttribute('aria-expanded', String(willOpen));
                }
            } else if (mobileBreakpoint.matches && !link.closest('.pcoded-submenu a[href^="javascript:"]')) {
                layout.classList.remove('sidebar-open');
                updateMenuState();
            }
        });

        // Membuka satu dropdown notifikasi/profil pada satu waktu.
        dropdowns.forEach((dropdown) => {
            const toggle = dropdown.querySelector(':scope > a');

            if (!toggle) {
                return;
            }

            toggle.setAttribute('aria-haspopup', 'true');

            toggle.addEventListener('click', (event) => {
                event.preventDefault();
                const willOpen = !dropdown.classList.contains('active');

                closeDropdowns(dropdown);
                dropdown.classList.toggle('active', willOpen);
                toggle.setAttribute('aria-expanded', String(willOpen));
            });
        });

        // Tutup dropdown saat klik di luar area header-notification.
        document.addEventListener('click', (event) => {
            if (!event.target.closest('.header-notification')) {
                closeDropdowns();
            }
        });

        // Tombol Escape menutup dropdown dan sidebar yang sedang terbuka.
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeDropdowns();
                layout.classList.remove('sidebar-open');
                updateMenuState();
            }
        });

        // Mengaktifkan atau keluar dari mode layar penuh melalui tombol header.
        document.querySelector('[data-fullscreen-toggle]')?.addEventListener('click', async () => {
            try {
                if (document.fullscreenElement) {
                    await document.exitFullscreen();
                } else {
                    await document.documentElement.requestFullscreen();
                }
            } catch (error) {
                console.error('Tidak dapat mengubah mode layar penuh.', error);
            }
        });

        // Terapkan tata letak awal dan perbarui ketika melewati breakpoint perangkat.
        setDeviceType();
        mobileBreakpoint.addEventListener('change', setDeviceType);

        // Menandai status submenu untuk pembaca layar dan menghubungkan tombol ke submenu.
        document.querySelectorAll('.pcoded-hasmenu').forEach((menuItem, index) => {
            const toggle = menuItem.querySelector(':scope > a');
            const submenu = menuItem.querySelector(':scope > .pcoded-submenu');

            if (toggle) {
                toggle.setAttribute('aria-expanded', String(menuItem.classList.contains('pcoded-trigger')));
                toggle.setAttribute('aria-haspopup', 'true');
            }

            if (toggle && submenu) {
                if (!submenu.id) {
                    submenu.id = `pcoded-submenu-${index + 1}`;
                }
                toggle.setAttribute('aria-controls', submenu.id);
            }
        });

        // Hilangkan preloader setelah tampilan dan perilaku global siap.
        const preloader = document.querySelector('.theme-loader');
        if (preloader) {
            preloader.classList.add('is-hidden');
            window.setTimeout(() => preloader.remove(), 220);
        }
    };

    // Tunggu DOM selesai dibentuk agar elemen halaman dapat ditemukan.
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeLayout, { once: true });
    } else {
        initializeLayout();
    }
})();