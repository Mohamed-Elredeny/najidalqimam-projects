// assets/js/dashboard.js
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle
    document.querySelectorAll('.menu-toggle').forEach(toggle => {
        toggle.addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('sidebar-collapsed');
            document.querySelector('.main-content').classList.toggle('main-content-expanded');
        });
    });

    // Submenu toggle
    document.querySelectorAll('.submenu-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            let submenu = btn.nextElementSibling;
            submenu.classList.toggle('active');
            btn.querySelector('.menu-arrow').classList.toggle('rotate-180');
        });
    });

    // User dropdown
    const userToggle = document.querySelector('.user-dropdown-toggle');
    const userMenu = document.querySelector('.user-dropdown-menu');
    if (userToggle) {
        userToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenu.classList.toggle('show');
        });
        document.addEventListener('click', () => {
            userMenu.classList.remove('show');
        });
    }
});
