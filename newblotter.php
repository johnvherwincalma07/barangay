<?php
include('connection.php');
include('sessioncheck.php');
include('newnavi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['blotter_id'], $_POST['status'])) {
    $id = intval($_POST['blotter_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    mysqli_query($conn, "UPDATE blotter SET status = '$status' WHERE blotter_id = $id");
}

$result = mysqli_query($conn, "SELECT * FROM blotter ORDER BY date_filed DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Blotter</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <link rel="stylesheet" href="style/admin/style_blotter.css">
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="header-section">
            <h1>Barangay Blotter Records</h1>
            <p class="tagline">"Justice begins at the barangay."</p>
        </div>

        <div class="content-section">
            <h2>Blotter List:
                <a href="addblotter.php?action=add" class="btn btn-success btn-sm">Add Blotter</a>
            </h2>
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Blotter No.</th>
                            <th>Date Filed</th>
                            <th>Complainant</th>
                            <th>Complainant's Address</th>
                            <th>Complainant's Cellphone No.</th>
                            <th>Respondent</th>
                            <th>Respondent's Address</th>
                            <th>Respondent's Cellphone No.</th>
                            <th>About</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['blotter_id']) ?></td>
                                    <td><?= htmlspecialchars(date('M d, Y', strtotime($row['date_filed']))) ?></td>
                                    <td><?= htmlspecialchars($row['complainant']) ?></td>
                                    <td><?= htmlspecialchars($row['complainant_address']) ?></td>
                                    <td><?= htmlspecialchars($row['complainant_cellno']) ?></td>
                                    <td><?= htmlspecialchars($row['respondent']) ?></td>
                                    <td><?= htmlspecialchars($row['respondent_address']) ?></td>
                                    <td><?= htmlspecialchars($row['respondent_cellno']) ?></td>
                                    <td><?= htmlspecialchars($row['about']) ?></td>
                                    <td>
                                        <button 
                                            class="btn view-btn view-blotter-btn"
                                            data-date_filed="<?= htmlspecialchars(date('M d, Y', strtotime($row['date_filed']))) ?>"
                                            data-complainant="<?= htmlspecialchars($row['complainant']) ?>"
                                            data-complainant_address="<?= htmlspecialchars($row['complainant_address']) ?>"
                                            data-complainant_cellno="<?= htmlspecialchars($row['complainant_cellno']) ?>"
                                            data-respondent="<?= htmlspecialchars($row['respondent']) ?>"
                                            data-respondent_address="<?= htmlspecialchars($row['respondent_address']) ?>"
                                            data-respondent_cellno="<?= htmlspecialchars($row['respondent_cellno']) ?>"
                                            data-case_type="<?= htmlspecialchars($row['about']) ?>"
                                            data-status="<?= htmlspecialchars($row['status'] ?? 'Pending') ?>"
                                        >
                                            View
                                        </button>
                                        <button class="btn edit-btn edit-btn" data-id="<?= $row['blotter_id'] ?>">Edit</button>
                                        <button class="btn delete-btn delete-blotter-btn" data-id="<?= $row['blotter_id'] ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="10" class="no-records">No blotter records found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<div id="viewBlotterModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h3>Blotter Details</h3>
        <p><strong>Complainant:</strong> <span id="blotterComplainant"></span></p>
        <p><strong>Respondent:</strong> <span id="blotterRespondent"></span></p>
        <p><strong>Case Type:</strong> <span id="blotterCaseType"></span></p>
        <p><strong>Details:</strong></p>
        <pre id="blotterDetails" style="white-space:pre-wrap; font-family:inherit;"></pre>
        <p><strong>Date Filed:</strong> <span id="blotterDateFiled"></span></p>
        <p><strong>Status:</strong> <span id="blotterStatus"></span></p>
        <button id="cancelViewBlotterBtn" class="btn secondary-btn">Close</button>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteBlotterModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete this blotter record? This action cannot be undone.</p>
        <div class="modal-buttons">
            <a href="delete_blotter.php" id="confirmDeleteBlotterBtn" class="btn danger-btn">Delete</a>
            <button id="cancelBlotterBtn" class="btn secondary-btn">Cancel</button>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h2>Confirm Edit</h2>
        <p>Are you sure you want to edit this blotter record?</p>
        <div class="modal-buttons">
            <a href="edit_" id="confirmEditBtn" class="btn warning-btn">Edit</a>
            <button id="cancelEditBtn" class="btn secondary-btn">Cancel</button>
        </div>
    </div>
</div>

<script src="js/sidebarToggle.js"></script>
<script src="js/Edit_Modals.js"></script>
<script src="js/Delete_Modals.js"></script>
<script src="js/logout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const viewBlotterButtons = document.querySelectorAll('.view-blotter-btn');
    const blotterModal = document.getElementById('viewBlotterModal');
    const cancelBlotterBtn = document.getElementById('cancelViewBlotterBtn');

    viewBlotterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('blotterComplainant').textContent = btn.dataset.complainant || 'N/A';
            document.getElementById('blotterRespondent').textContent = btn.dataset.respondent || 'N/A';
            document.getElementById('blotterCaseType').textContent = btn.dataset.case_type || 'N/A';
            document.getElementById('blotterDateFiled').textContent = btn.dataset.date_filed || 'N/A';
            document.getElementById('blotterStatus').textContent = btn.dataset.status || 'Pending';
            document.getElementById('blotterDetails').textContent =
                `Complainant Address: ${btn.dataset.complainant_address || 'N/A'}\n` +
                `Complainant Cell No.: ${btn.dataset.complainant_cellno || 'N/A'}\n` +
                `Respondent Address: ${btn.dataset.respondent_address || 'N/A'}\n` +
                `Respondent Cell No.: ${btn.dataset.respondent_cellno || 'N/A'}`;

            blotterModal.style.display = 'flex';
        });
    });

    cancelBlotterBtn?.addEventListener('click', () => blotterModal.style.display = 'none');
    blotterModal?.addEventListener('click', (e) => {
        if (e.target === blotterModal) blotterModal.style.display = 'none';
    });
});
</script>
</body>
</html>
