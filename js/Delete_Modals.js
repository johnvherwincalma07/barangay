document.addEventListener('DOMContentLoaded', () => {

  // Delete Resident Modal
const initDeleteResidentModal = () => {
  const deleteButtons = document.querySelectorAll('.delete-resident-btn');
  const modal = document.getElementById('deleteResidentModal');
  const cancelBtn = document.getElementById('cancelResidentBtn');
  const confirmDeleteBtn = document.getElementById('confirmDeleteResidentBtn');

  if (deleteButtons.length && modal && cancelBtn && confirmDeleteBtn) {
    deleteButtons.forEach(button => {
      button.addEventListener('click', () => {
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name') || 'this resident';
        modal.querySelector('p').textContent = `Are you sure you want to delete ${name}? This action cannot be undone.`;
        confirmDeleteBtn.href = `delete_resident.php?id=${id}`;
        modal.style.display = 'flex';
      });
    });

    cancelBtn.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });
  }
};





  // Delete Blotter Modal
  const initDeleteBlotterModal = () => {
    const deleteButtons = document.querySelectorAll('.delete-blotter-btn');
    const modal = document.getElementById('deleteBlotterModal');
    const cancelBtn = document.getElementById('cancelBlotterBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBlotterBtn');

    if (deleteButtons.length && modal && cancelBtn && confirmDeleteBtn) {
      deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
          const id = button.getAttribute('data-id');
          confirmDeleteBtn.href = `delete_blotter.php?id=${id}`;
          modal.style.display = 'flex';
        });
      });

      cancelBtn.addEventListener('click', () => {
        modal.style.display = 'none';
      });

      window.addEventListener('click', (e) => {
        if (e.target === modal) {
          modal.style.display = 'none';
        }
      });
    }
  };

  // Delete Official Modal
  const initDeleteOfficialModal = () => {
    const deleteButtons = document.querySelectorAll('.delete-official-btn');
    const modal = document.getElementById('deleteOfficialModal');
    const cancelBtn = document.getElementById('cancelOfficialBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteOfficialBtn');

    if (deleteButtons.length && modal && cancelBtn && confirmDeleteBtn) {
      deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
          const id = button.getAttribute('data-id');
          const name = button.getAttribute('data-name') || 'this official';
          modal.querySelector('p').textContent = `Are you sure you want to delete ${name}? This action cannot be undone.`;
          confirmDeleteBtn.href = `delete_official.php?id=${id}`;
          modal.style.display = 'flex';
        });
      });

      cancelBtn.addEventListener('click', () => {
        modal.style.display = 'none';
      });

      window.addEventListener('click', (e) => {
        if (e.target === modal) {
          modal.style.display = 'none';
        }
      });
    }
  };

  // Delete Announcement Modal
  const initDeleteAnnouncementModal = () => {
    const deleteButtons = document.querySelectorAll('.delete-announcement-btn');
    const modal = document.getElementById('deleteAnnouncementModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    if (deleteButtons.length && modal && cancelBtn && confirmDeleteBtn) {
      deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
          const id = button.getAttribute('data-id');
          confirmDeleteBtn.href = `delete_announcement.php?id=${id}`;
          modal.style.display = 'flex';
        });
      });

      cancelBtn.addEventListener('click', () => {
        modal.style.display = 'none';
      });

      window.addEventListener('click', (e) => {
        if (e.target === modal) {
          modal.style.display = 'none';
        }
      });
    }
  };

  // Initialize all modals
  initDeleteResidentModal();
  initDeleteBlotterModal();
  initDeleteOfficialModal();
  initDeleteAnnouncementModal();

});
