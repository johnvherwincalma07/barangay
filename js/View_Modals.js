document.addEventListener('DOMContentLoaded', () => {

    // === View Official Modal ===
    const initOfficialModal = () => {
        const modal = document.getElementById('viewOfficialModal');
        const img = document.getElementById('viewOfficialImage');
        const nameElem = document.getElementById('viewOfficialName');
        const ageElem = document.getElementById('viewOfficialAge');
        const sexElem = document.getElementById('viewOfficialSex');
        const birthDateElem = document.getElementById('viewOfficialBirthDate');
        const birthPlaceElem = document.getElementById('viewOfficialBirthPlace');
        const civilStatusElem = document.getElementById('viewOfficialCivilStatus');
        const emailElem = document.getElementById('viewOfficialEmail');
        const positionElem = document.getElementById('viewOfficialPosition');
        const contactInfoElem = document.getElementById('viewOfficialContactInfo');
        const statusElem = document.getElementById('viewOfficialStatus');
        const termElem = document.getElementById('viewOfficialTerm');
        const closeBtn = document.getElementById('cancelViewOfficialBtn');

        const viewButtons = document.querySelectorAll('.view-official-btn');

        viewButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                if (img) img.src = btn.getAttribute('data-image') || '';
                if (nameElem) nameElem.textContent = btn.getAttribute('data-name') || '';
                if (ageElem) ageElem.textContent = btn.getAttribute('data-age') || '';
                if (sexElem) sexElem.textContent = btn.getAttribute('data-sex') || '';
                if (birthDateElem) birthDateElem.textContent = btn.getAttribute('data-birth_date') || '';
                if (birthPlaceElem) birthPlaceElem.textContent = btn.getAttribute('data-birth_place') || '';
                if (civilStatusElem) civilStatusElem.textContent = btn.getAttribute('data-civil_status') || '';
                if (emailElem) emailElem.textContent = btn.getAttribute('data-email_address') || '';
                if (positionElem) positionElem.textContent = btn.getAttribute('data-position') || '';
                if (contactInfoElem) contactInfoElem.textContent = btn.getAttribute('data-contact_info') || '';
                if (statusElem) statusElem.textContent = btn.getAttribute('data-status') || '';
                if (termElem) termElem.textContent = btn.getAttribute('data-term') || '';

                if (modal) modal.style.display = 'flex';
            });
        });

        if (closeBtn && modal) {
            closeBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });
        }

        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }
    };

    // === View Announcement Modal ===
    const initAnnouncementModal = () => {
        const viewAnnouncementButtons = document.querySelectorAll('.view-announcement-btn');
        const viewModal = document.getElementById('viewAnnouncementModal');
        const cancelViewBtn = document.getElementById('cancelViewBtn');

        const modalTitle = document.getElementById('modalTitle');
        const modalContent = document.getElementById('modalContent');
        const modalDate = document.getElementById('modalDate');
        const modalLocation = document.getElementById('modalLocation');
        const modalDatePosted = document.getElementById('modalDatePosted');

        if (viewAnnouncementButtons.length > 0 && viewModal && cancelViewBtn) {
            viewAnnouncementButtons.forEach(button => {
                button.addEventListener('click', () => {
                    if (modalTitle) modalTitle.textContent = button.getAttribute('data-title') || 'N/A';
                    if (modalContent) modalContent.textContent = button.getAttribute('data-content') || 'N/A';
                    if (modalDate) modalDate.textContent = button.getAttribute('data-date') || 'N/A';
                    if (modalLocation) modalLocation.textContent = button.getAttribute('data-location') || 'N/A';
                    if (modalDatePosted) modalDatePosted.textContent = button.getAttribute('data-dateposted') || 'N/A';

                    viewModal.style.display = 'flex';
                });
            });

            cancelViewBtn.addEventListener('click', () => {
                viewModal.style.display = 'none';
            });

            viewModal.addEventListener('click', (e) => {
                if (e.target === viewModal) {
                    viewModal.style.display = 'none';
                }
            });
        }
    };

    // === View Blotter Modal ===
    const initBlotterModal = () => {
        const viewBlotterButtons = document.querySelectorAll('.view-blotter-btn');
        const blotterModal = document.getElementById('viewBlotterModal');
        const cancelBlotterBtn = document.getElementById('cancelViewBlotterBtn');

        const blotterComplainant = document.getElementById('blotterComplainant');
        const blotterRespondent = document.getElementById('blotterRespondent');
        const blotterCaseType = document.getElementById('blotterCaseType');
        const blotterDetails = document.getElementById('blotterDetails');
        const blotterDateFiled = document.getElementById('blotterDateFiled');
        const blotterStatus = document.getElementById('blotterStatus');

        if (viewBlotterButtons.length > 0 && blotterModal && cancelBlotterBtn) {
            viewBlotterButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    if (blotterComplainant) blotterComplainant.textContent = btn.getAttribute('data-complainant') || 'N/A';
                    if (blotterRespondent) blotterRespondent.textContent = btn.getAttribute('data-respondent') || 'N/A';
                    if (blotterCaseType) blotterCaseType.textContent = btn.getAttribute('data-case_type') || 'N/A';
                    if (blotterDetails) blotterDetails.textContent = btn.getAttribute('data-details') || 'N/A';
                    if (blotterDateFiled) blotterDateFiled.textContent = btn.getAttribute('data-date_filed') || 'N/A';
                    if (blotterStatus) blotterStatus.textContent = btn.getAttribute('data-status') || 'N/A';

                    blotterModal.style.display = 'flex';
                });
            });

            cancelBlotterBtn.addEventListener('click', () => {
                blotterModal.style.display = 'none';
            });

            blotterModal.addEventListener('click', (e) => {
                if (e.target === blotterModal) {
                    blotterModal.style.display = 'none';
                }
            });
        }
    };

    // === Initialize all modals ===
    initOfficialModal();
    initAnnouncementModal();
    initBlotterModal();
});
