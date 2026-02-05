<?php   
include('connection.php');
include('sessioncheck.php');
include('usernavi.php');

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
    <title>Resident Dashboard - Barangay System</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <link rel="stylesheet" href="style/user/style_user_official.css">
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">
        <h1 class="page-header">Barangay Officials</h1>
        <p class="description">
            Meet the dedicated public servants who lead our barangay. From the Barangay Captain to the council members, each official plays a vital role in ensuring the welfare, order, and progress of our community.
        </p>
        <h2>Here's the Barangay Officials of Barangay Bunga, Tanza, Cavite</h2>

        <div class="officials-container">
            <?php if (count($officials) > 0): ?>
                <?php foreach ($officials as $row): ?>
                    <div class="official-card">
                        <img src="<?= !empty($row['image_url']) ? $row['image_url'] : 'default-avatar.png' ?>" alt="Profile Picture">
                        <p><strong><?= htmlspecialchars($row['position']) ?></strong></p>
                        <h3><?= htmlspecialchars($row['name']) ?></h3>
                        <p>
                            <span class="status-dot <?= strtolower($row['status'] ?? 'active') === 'active' ? 'status-active' : 'status-inactive' ?>"></span>
                            <?= htmlspecialchars($row['status'] ?? 'Active') ?>
                        </p>
                        <p><strong>Term:</strong><br><?= htmlspecialchars($row['term']) ?  : 'N/A' ?></p>
                        
                        <a href="#" class="btn btn-primary btn-sm view-official-btn"
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
                        >View</a>
                        
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-data">
                    🚫 No officials have been added yet. Use the <strong>"Add Official"</strong> button above to get started.
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<div id="viewOfficialModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <img id="viewOfficialImage" src="" alt="Profile">
        <h3 id="viewOfficialName"></h3>
        <p><strong>Position:</strong> <span id="viewOfficialPosition"></span></p>
        <p><strong>Status:</strong> <span id="viewOfficialStatus"></span></p>
        <p><strong>Term:</strong> <span id="viewOfficialTerm"></span></p>
        <div class="modal-buttons">
            <button id="cancelViewOfficialBtn" class="btn btn-secondary btn-sm">Close</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="logoutModal">
    <div class="modal-box" id="logoutModalContent">
        <h3>Are you sure you want to log out?</h3>
        <div class="modal-buttons">
            <button class="yes" onclick="confirmLogout()">Yes</button>
            <button class="cancel" onclick="closeLogoutModal()">Cancel</button>
        </div>
    </div>
</div>

    <script src="js/View_Modals.js"></script>
    <script src="js/sidebarToggle.js"></script>
    <script src="js/logout.js"></script>

</body>
</html>
