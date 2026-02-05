document.addEventListener('DOMContentLoaded', () => {

    // === Reusable: Edit Resident Modal ===
    const initEditResidentModal = () => {
        const editButtons = document.querySelectorAll('.edit-resident-btn');
        const editModal = document.getElementById('editResidentModal');
        const cancelEditBtn = document.getElementById('cancelEditResidentBtn');
        const confirmEditBtn = document.getElementById('confirmEditResidentBtn');
        const editModalText = document.getElementById('editResidentModalText');

        if (editButtons.length && editModal && cancelEditBtn && confirmEditBtn && editModalText) {
            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    const name = button.getAttribute('data-name') || 'this resident';
                    editModalText.textContent = `Are you sure you want to edit ${name}'s record?`;
                    confirmEditBtn.href = `edit_resident.php?id=${id}`;
                    editModal.style.display = 'flex';
                });
            });

            cancelEditBtn.addEventListener('click', () => {
                editModal.style.display = 'none';
            });

            window.addEventListener('click', (e) => {
                if (e.target === editModal) {
                    editModal.style.display = 'none';
                }
            });
        }
    };


    // === Reusable: Edit Announcement Modal ===
    const initEditAnnouncementModal = () => {
        const editButtons = document.querySelectorAll('.edit-announcement-btn');
        const editModal = document.getElementById('editAnnouncementModal');
        const cancelEditBtn = document.getElementById('cancelAnnouncementBtn');
        const confirmEditBtn = document.getElementById('confirmAnnouncementBtn');

        if (editButtons.length && editModal && cancelEditBtn && confirmEditBtn) {
            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    confirmEditBtn.href = `edit_announcement.php?id=${id}`;
                    editModal.style.display = 'flex';
                });
            });

            cancelEditBtn.addEventListener('click', () => {
                editModal.style.display = 'none';
            });

            window.addEventListener('click', (e) => {
                if (e.target === editModal) {
                    editModal.style.display = 'none';
                }
            });
        }
    };

    // === Reusable: Edit Official Modal ===
    const initEditOfficialModal = () => {
        const editButtons = document.querySelectorAll('.edit-official-btn');
        const editModal = document.getElementById('editOfficialModal');
        const cancelEditBtn = document.getElementById('cancelEditOfficialBtn'); // FIXED
        const confirmEditBtn = document.getElementById('confirmEditOfficialBtn'); // FIXED
        const editModalText = document.getElementById('editModalText');

        if (editButtons.length && editModal && cancelEditBtn && confirmEditBtn && editModalText) {
            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    const name = button.getAttribute('data-name') || 'this official';
                    editModalText.textContent = `Are you sure you want to edit ${name}'s record?`;
                    confirmEditBtn.href = `edit_official.php?id=${id}`;
                    editModal.style.display = 'flex';
                });
            });

            cancelEditBtn.addEventListener('click', () => {
                editModal.style.display = 'none';
            });

            window.addEventListener('click', (e) => {
                if (e.target === editModal) {
                    editModal.style.display = 'none';
                }
            });
        }
    };

    // === Reusable: Edit Blotter Modal ===
    const initEditBlotterModal = () => {
        const editButtons = document.querySelectorAll('.edit-btn');
        const editModal = document.getElementById('editModal');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const confirmEditBtn = document.getElementById('confirmEditBtn');

        if (editButtons.length && editModal && cancelEditBtn && confirmEditBtn) {
            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    confirmEditBtn.href = `edit_blotter.php?id=${id}`;
                    editModal.style.display = 'flex';
                });
            });

            cancelEditBtn.addEventListener('click', () => {
                editModal.style.display = 'none';
            });

            window.addEventListener('click', (e) => {
                if (e.target === editModal) {
                    editModal.style.display = 'none';
                }
            });
        }
    };

    // === Initialize All Modals ===
    initEditResidentModal();
    initEditAnnouncementModal();
    initEditOfficialModal();
    initEditBlotterModal();

});
