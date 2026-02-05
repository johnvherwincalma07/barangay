<?php       
include('connection.php');
include('sessioncheck.php');
include('newnavi.php');

$query = "SELECT * FROM announcements ORDER BY date_posted DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Announcements</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <link rel="stylesheet" href="style/admin/style_announcement.css">
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">
        
        <div class="header">
            <h1 class="page-header">Barangay Announcements</h1>
            <p class="tagline">"Stay updated with the latest info!"</p>
        </div>

        <div class="sub-header">
            <div class="table-container">
                <h2>
                    List of Announcements:
                    <a href="add_announcement.php?action=add" class="btn btn-success btn-sm">Add Announcements</a>
                </h2>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Date Posted</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['title']) ?></td>
                                        <td><?= nl2br(htmlspecialchars($row['content'])) ?></td>
                                        <td><?= htmlspecialchars(date('M d, Y', strtotime($row['date']))) ?></td>
                                        <td><?= htmlspecialchars($row['location']) ?></td>
                                        <td><?= htmlspecialchars(date('M d, Y', strtotime($row['date_posted']))) ?></td>
                                        <td>
                                            <button class="btn btn-info btn-sm view-announcement-btn"
                                                data-title="<?= htmlspecialchars($row['title']) ?>"
                                                data-content="<?= htmlspecialchars($row['content']) ?>"
                                                data-date="<?= htmlspecialchars(date('M d, Y', strtotime($row['date']))) ?>"
                                                data-location="<?= htmlspecialchars($row['location']) ?>"
                                                data-dateposted="<?= htmlspecialchars(date('M d, Y', strtotime($row['date_posted']))) ?>"
                                            >View</button>

                                            <button 
                                                class="btn btn-warning btn-sm edit-announcement-btn"
                                                data-id="<?= $row['id'] ?>"
                                            >Edit</button>

                                            <button 
                                                class="btn btn-danger btn-sm delete-announcement-btn"
                                                data-id="<?= $row['id'] ?>"
                                            >Delete</button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center">No announcements found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Delete Modal -->
<div id="deleteAnnouncementModal" class="modal-overlay" style="display:none;"> 
    <div class="modal-box">
        <h3>Confirm Delete</h3>
        <p>Are you sure you want to delete this announcement?</p>
        <div class="modal-buttons">
            <a href="#" id="confirmDeleteBtn" class="btn btn-danger btn-sm">Delete</a>
            <button id="cancelBtn" class="btn btn-secondary btn-sm">Cancel</button>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editAnnouncementModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h3>Confirm Edit</h3>
        <p>Are you sure you want to edit this announcement?</p>
        <div class="modal-buttons">
            <a href="#" id="confirmEditBtn" class="btn btn-warning btn-sm">Edit</a>
            <button id="cancelEditBtn" class="btn btn-secondary btn-sm">Cancel</button>
        </div>
    </div>
</div>

<!-- View Modal -->
<div id="viewAnnouncementModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h3 id="modalTitle">Announcement Title</h3>
        <p><strong>Date:</strong> <span id="modalDate"></span></p>
        <p><strong>Content:</strong> <span id="modalContent"></span></p>
        <p><strong>Location:</strong> <span id="modalLocation"></span></p>
        <p><strong>Date Posted:</strong> <span id="modalDatePosted"></span></p>
        <div class="modal-buttons">
            <button id="cancelViewBtn" class="btn btn-secondary btn-sm">Close</button>
        </div>
    </div>
</div>

<!-- Logout Modal -->
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
    const viewModal = document.getElementById('viewAnnouncementModal');
    const editModal = document.getElementById('editAnnouncementModal');
    const deleteModal = document.getElementById('deleteAnnouncementModal');

    const cancelViewBtn = document.getElementById('cancelViewBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    const cancelDeleteBtn = document.getElementById('cancelBtn');

    const modalTitle = document.getElementById('modalTitle');
    const modalContent = document.getElementById('modalContent');
    const modalDate = document.getElementById('modalDate');
    const modalLocation = document.getElementById('modalLocation');
    const modalDatePosted = document.getElementById('modalDatePosted');

    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const confirmEditBtn = document.getElementById('confirmEditBtn');

    // View
    document.querySelectorAll('.view-announcement-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            modalTitle.textContent = btn.dataset.title;
            modalContent.textContent = btn.dataset.content;
            modalDate.textContent = btn.dataset.date;
            modalLocation.textContent = btn.dataset.location;
            modalDatePosted.textContent = btn.dataset.dateposted;
            viewModal.style.display = 'flex';
        });
    });

    cancelViewBtn.addEventListener('click', () => viewModal.style.display = 'none');

    // Edit
    document.querySelectorAll('.edit-announcement-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            confirmEditBtn.href = `edit_announcement.php?id=${id}`;
            editModal.style.display = 'flex';
        });
    });

    cancelEditBtn.addEventListener('click', () => editModal.style.display = 'none');

    // Delete
    document.querySelectorAll('.delete-announcement-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            confirmDeleteBtn.href = `delete_announce.php?id=${id}`;
            deleteModal.style.display = 'flex';
        });
    });

    cancelDeleteBtn.addEventListener('click', () => deleteModal.style.display = 'none');

    // Close modals when clicking outside
    [viewModal, editModal, deleteModal].forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
});
</script>

<script src="js/logout.js"></script>
</body>
</html>
