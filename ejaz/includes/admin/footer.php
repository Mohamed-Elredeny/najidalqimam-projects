<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    function toggleSidebar(){/*...*/}
    function toggleUserDropdown(){/*...*/}
    function confirmDelete(id){const m=new bootstrap.Modal(document.getElementById('deleteModal'));document.getElementById('deleteConfirmBtn').href='index.php?delete='+id;m.show();}
    window.addEventListener('click',e=>{if(!e.target.closest('.user-dropdown'))document.querySelector('.user-dropdown-menu').classList.remove('show');});
</script>
<script>
    // Toggle sidebar
    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('sidebar-collapsed');
        document.querySelector('.main-content').classList.toggle('main-content-expanded');
    }

    // Toggle user dropdown
    function toggleUserDropdown() {
        document.querySelector('.user-dropdown-menu').classList.toggle('show');
    }

    // Toggle submenu
    function toggleSubmenu(button) {
        const submenu = button.nextElementSibling;
        submenu.classList.toggle('active');
        button.querySelector('.menu-arrow').classList.toggle('rotate-180');
    }

    // Close dropdown when clicking outside
    window.addEventListener('click', function(e) {
        if (!e.target.closest('.user-dropdown')) {
            const dropdown = document.querySelector('.user-dropdown-menu');
            if (dropdown && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        }
    });
</script>