function showLogoutModal() {
    document.getElementById('logoutModal').style.display = 'flex';
    document.body.classList.add('blurred');
}

function closeLogoutModal() {
    document.getElementById('logoutModal').style.display = 'none';
    document.body.classList.remove('blurred');
}

function confirmLogout() {
    const modalContent = document.getElementById('logoutModalContent');

    // Replace content with loading message
    modalContent.innerHTML = `
        <h3>Logging out...</h3>
        <div class="loader"></div>
    `;

    // Wait 2 seconds then redirect to index.php (login page)
    setTimeout(() => {
        window.location.href = 'logout.php';
    }, 2000);
}
