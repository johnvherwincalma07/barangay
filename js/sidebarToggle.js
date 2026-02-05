document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById('toggleBtn');
    const sidebar = document.getElementById('sidebar');
    const wrapper = document.getElementById('wrapper');

    function updateWrapperMargin() {
        if (sidebar.classList.contains('collapsed')) {
            wrapper.style.marginLeft = '90px'; // collapsed sidebar width
        } else {
            wrapper.style.marginLeft = '250px'; // expanded sidebar width
        }
    }

    // Load saved sidebar state on page load
    if (sidebar && localStorage.getItem('sidebar-collapsed') === 'true') {
        sidebar.classList.add('collapsed');
    }

    updateWrapperMargin();

    if (toggleBtn && sidebar && wrapper) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
            updateWrapperMargin();
        });
    }
});



