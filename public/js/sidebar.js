document.addEventListener('DOMContentLoaded', function() {
    // Handle mobile sidebar toggle
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            document.querySelector('#sidebarMenu').classList.toggle('show');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.querySelector('#sidebar');
        const sidebarMenu = document.querySelector('#sidebarMenu');
        const toggle = document.querySelector('.sidebar-toggle');
        
        if (window.innerWidth < 768 && 
            !sidebar.contains(event.target) && 
            !toggle.contains(event.target) &&
            sidebarMenu.classList.contains('show')) {
            sidebarMenu.classList.remove('show');
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            document.querySelector('#sidebarMenu').classList.add('show');
        }
    });
});