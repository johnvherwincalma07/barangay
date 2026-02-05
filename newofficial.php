<?php
include('connection.php');
include('sessioncheck.php');
include('newnavi.php');

$position_order = [
    'Barangay Captain',
    'Committee on Peace and Order',
    'Committee on Livelihood and Cooperative',
    'Committee on Environment and Natural Resources',
    'Committee on Health and Education',
    'Committee on Womens and Family',
    'Committee on Appropriation',
    'Committee on Infrastructure',
    'Sk Chairman',
    'Barangay Secretary',
    'Barangay Treasurer',
];

$query = "SELECT * FROM barangay_officials";
$result = mysqli_query($conn, $query);

$officials = [];
while ($row = mysqli_fetch_assoc($result)) {
    $officials[] = $row;
}

usort($officials, function($a, $b) use ($position_order) {
    return array_search($a['position'], $position_order) - array_search($b['position'], $position_order);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Officials</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <link rel="stylesheet" href="style/admin/style_official.css">
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">

        <div class="header">
            <h1 class="page-header">Barangay Officials</h1>
            <p class="tagline">Meet the public servants dedicated to leading our barangay toward unity and progress. </p>
        </div>

        <div class="sub-header">
            <h2> Barangay Officials: 
            <a href="addofficial.php?action=add" class="btn btn-success btn-sm">Add Official</a>
            </h2>
            <?php if (count($officials) > 0): ?>
                <?php foreach ($officials as $row): ?>
                    <div class="official-card">
                        <img src="<?= !empty($row['image_url']) ? htmlspecialchars($row['image_url']) : 'default-avatar.png' ?>" alt="Profile">
                        <h3><?= htmlspecialchars($row['name']) ?></h3>
                        <hr>
                        <h3><?= htmlspecialchars($row['position']) ?></h3>
                        <p>
                            <span class="status-dot <?= strtolower($row['status'] ?? 'active') === 'active' ? 'status-active' : 'status-inactive' ?>"></span>
                            <?= htmlspecialchars($row['status'] ?? 'Active') ?>
                        </p>
                        <p>Term: <?= !empty($row['term']) ? htmlspecialchars($row['term']) : 'N/A' ?></p>

                        <div class="official-card-buttons">
                            <button class="btn btn-primary btn-sm view-official-btn"
                                data-id="<?= $row['id'] ?>"
                                data-image="<?= htmlspecialchars($row['image_url'] ?: 'default-avatar.png') ?>"
                                data-name="<?= htmlspecialchars($row['name']) ?>"
                                data-age="<?= htmlspecialchars($row['age']) ?>"
                                data-sex="<?= htmlspecialchars($row['sex']) ?>"
                                data-birth_date="<?= htmlspecialchars($row['birth_date']) ?>"
                                data-birth_place="<?= htmlspecialchars($row['birth_place']) ?>"
                                data-civil_status="<?= htmlspecialchars($row['civil_status']) ?>"
                                data-email_address="<?= htmlspecialchars($row['email_address']) ?>"
                                data-position="<?= htmlspecialchars($row['position']) ?>"
                                data-contact_info="<?= htmlspecialchars($row['contact_info']) ?>"
                                data-status="<?= htmlspecialchars($row['status'] ?? 'Active') ?>"
                                data-term="<?= htmlspecialchars($row['term']) ?>"
                            >View</button>

                            <button class="btn btn-warning btn-sm edit-official-btn" data-id="<?= $row['id'] ?>" data-name="<?= htmlspecialchars($row['name']) ?>">Edit</button>

                            <button class="btn btn-danger btn-sm delete-official-btn" data-id="<?= $row['id'] ?>" data-name="<?= htmlspecialchars($row['name']) ?>">Delete</button>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-lg-12 text-center">
                    <p style="margin-top: 30px;">
                        🚫 No officials have been added yet. Use the <strong>"Add Official"</strong> button above to get started.
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- View Modal -->
<div id="viewOfficialModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <img id="viewOfficialImage" src="" alt="Profile">
        <h3 id="viewOfficialName"></h3>
        <p><strong>Age:</strong> <span id="viewOfficialAge"></span></p>
        <p><strong>Sex:</strong> <span id="viewOfficialSex"></span></p>
        <p><strong>Birth Date:</strong> <span id="viewOfficialBirthDate"></span></p>
        <p><strong>Birth Place:</strong> <span id="viewOfficialBirthPlace"></span></p>
        <p><strong>Civil Status:</strong> <span id="viewOfficialCivilStatus"></span></p>
        <p><strong>Email Address:</strong> <span id="viewOfficialEmail"></span></p>
        <p><strong>Position:</strong> <span id="viewOfficialPosition"></span></p>
        <p><strong>Contact Info:</strong> <span id="viewOfficialContactInfo"></span></p>
        <p><strong>Status:</strong> <span id="viewOfficialStatus"></span></p>
        <p><strong>Term:</strong> <span id="viewOfficialTerm"></span></p>
        <div class="modal-buttons">
            <button id="cancelViewOfficialBtn" class="btn btn-secondary btn-sm">Close</button>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteOfficialModal" class="modal-overlay" style="display:none;"> 
    <div class="modal-box">
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete this official record? This action cannot be undone.</p>
        <div class="modal-buttons">
            <a href="delete_official.php" id="confirmDeleteOfficialBtn" class="btn btn-danger btn-sm">Delete</a>
            <button id="cancelOfficialBtn" class="btn btn-secondary btn-sm">Cancel</button>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editOfficialModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h3>Confirm Edit</h3>
        <p id="editModalText">Are you sure you want to edit this official's record?</p>
        <div class="modal-buttons">
            <a href="edit_official.php" id="confirmEditOfficialBtn" class="btn btn-warning btn-sm">Edit</a>
            <button id="cancelEditOfficialBtn" class="btn btn-secondary btn-sm">Cancel</button>
        </div>
    </div>
</div>

<!-- logout.php -->
<div class="modal-overlay" id="logoutModal">
    <div class="modal-box" id="logoutModalContent">
        <h3>Are you sure you want to log out?</h3>
        <div class="modal-buttons">
            <button class="yes" onclick="confirmLogout()">Yes</button>
            <button class="cancel" onclick="closeLogoutModal()">Cancel</button>
        </div>
    </div>
</div>

    <script src="js/sidebarToggle.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const viewOfficialButtons = document.querySelectorAll('.view-official-btn');
    const officialModal = document.getElementById('viewOfficialModal');
    const cancelOfficialBtn = document.getElementById('cancelViewOfficialBtn');

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

    viewOfficialButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            img.src = btn.getAttribute('data-image') || '';
            nameElem.textContent = btn.getAttribute('data-name') || '';
            ageElem.textContent = btn.getAttribute('data-age') || '';
            sexElem.textContent = btn.getAttribute('data-sex') || '';
            birthDateElem.textContent = btn.getAttribute('data-birth_date') || '';
            birthPlaceElem.textContent = btn.getAttribute('data-birth_place') || '';
            civilStatusElem.textContent = btn.getAttribute('data-civil_status') || '';
            emailElem.textContent = btn.getAttribute('data-email_address') || '';
            positionElem.textContent = btn.getAttribute('data-position') || '';
            contactInfoElem.textContent = btn.getAttribute('data-contact_info') || '';
            statusElem.textContent = btn.getAttribute('data-status') || '';
            termElem.textContent = btn.getAttribute('data-term') || '';
            officialModal.style.display = 'flex';
        });
    });

    if (cancelOfficialBtn && officialModal) {
        cancelOfficialBtn.addEventListener('click', () => {
            officialModal.style.display = 'none';
        });

        officialModal.addEventListener('click', (e) => {
            if (e.target === officialModal) {
                officialModal.style.display = 'none';
            }
        });
    }
});
</script>

    <script src="js/Edit_Modals.js"></script>
    <script src="js/Delete_Modals.js"></script>
    <script src="js/logout.js"></script>
</body>
</html>
