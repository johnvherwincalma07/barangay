<?php  
include('connection.php');
include('sessioncheck.php');
include('newnavi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Admin Page</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <link rel="stylesheet" href="style/admin/style_resident.css">
    
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">

        <div class="row">
            <div class="col-full">
                <h1 class="page-header">Barangay Residents</h1>
            </div>
        </div>

        <div class="col-full">
            <h2 class="flex-between-header">
                <span>List of Resident Records: </span>
            </h2>

            <form method="get" class="actions">
                <label for="search">Search:</label>
                <input type="text" id="search" name="search" class="form-control" placeholder="Search name..." 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="<?php echo basename($_SERVER['PHP_SELF']); ?>" class="btn btn-secondary">Reset</a>
            </form>

            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Username</th>    
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Extension</th>
                            <th>Place of Birth</th>
                            <th>Date of Birth</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th>Civil Status</th>
                            <th>Citizenship</th>
                            <th>Occupation</th>
                            <th>Employment Status</th>
                            <th>Classification</th>
                            <th>Current Address</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        $sql = "SELECT residents.*, users.username 
                                FROM residents 
                                LEFT JOIN users ON users.resident_id = residents.resident_id 
                                WHERE CONCAT(residents.last_name, ' ', residents.first_name, ' ', residents.middle_name) LIKE ? 
                                ORDER BY residents.last_name ASC";
                        $stmt = $conn->prepare($sql);
                        $searchTerm = '%' . $search . '%';
                        $stmt->bind_param("s", $searchTerm);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0):
                            while ($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['last_name']) ?></td>
                            <td><?= htmlspecialchars($row['first_name']) ?></td>
                            <td><?= htmlspecialchars($row['middle_name']) ?></td>
                            <td><?= htmlspecialchars($row['name_extension']) ?></td>
                            <td><?= htmlspecialchars($row['place_of_birth']) ?></td>
                            <td><?= htmlspecialchars($row['date_of_birth']) ?></td>
                            <td><?= htmlspecialchars($row['age']) ?></td>
                            <td><?= htmlspecialchars($row['sex']) ?></td>
                            <td><?= htmlspecialchars($row['civil_status']) ?></td>
                            <td><?= htmlspecialchars($row['citizenship']) ?></td>
                            <td><?= htmlspecialchars($row['occupation']) ?></td>
                            <td><?= htmlspecialchars($row['employment_status']) ?></td>
                            <td><?= htmlspecialchars($row['classification']) ?></td>
                            <td><?= htmlspecialchars($row['current_address']) ?></td>
                            <td>
                                <button class="btn btn-info view-resident-btn"
                                    data-id="<?= $row['resident_id'] ?>"
                                    data-username="<?= htmlspecialchars($row['username']) ?>"
                                    data-last_name="<?= htmlspecialchars($row['last_name']) ?>"
                                    data-first_name="<?= htmlspecialchars($row['first_name']) ?>"
                                    data-middle_name="<?= htmlspecialchars($row['middle_name']) ?>"
                                    data-extension="<?= htmlspecialchars($row['name_extension']) ?>"
                                    data-place_of_birth="<?= htmlspecialchars($row['place_of_birth']) ?>"
                                    data-date_of_birth="<?= htmlspecialchars($row['date_of_birth']) ?>"
                                    data-age="<?= htmlspecialchars($row['age']) ?>"
                                    data-sex="<?= htmlspecialchars($row['sex']) ?>"
                                    data-civil_status="<?= htmlspecialchars($row['civil_status']) ?>"
                                    data-citizenship="<?= htmlspecialchars($row['citizenship']) ?>"
                                    data-occupation="<?= htmlspecialchars($row['occupation']) ?>"
                                    data-employment_status="<?= htmlspecialchars($row['employment_status']) ?>"
                                    data-classification="<?= htmlspecialchars($row['classification']) ?>"
                                    data-current_address="<?= htmlspecialchars($row['current_address']) ?>"
                                > View
                                </button>

                                <button 
                                    class="btn btn-warning edit-resident-btn" 
                                    data-id="<?= $row['resident_id'] ?>"
                                > Edit
                                </button>

                                <button 
                                    class="btn btn-danger delete-resident-btn" 
                                    data-id="<?= $row['resident_id'] ?>"
                                > Delete
                                </button>

                            </td>

                        </tr>
                        <?php
                            endwhile;
                        else:
                        ?>
                        <tr>
                            <td colspan="15">No residents found.</td>
                        </tr>
                        <?php endif; ?>   
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<div id="viewResidentModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h3>Resident Details</h3>
        <p><strong>Username:</strong> <span id="residentUsername"></span></p>
        <p><strong>Last Name:</strong> <span id="residentLastName"></span></p>
        <p><strong>First Name:</strong> <span id="residentFirstName"></span></p>
        <p><strong>Middle Name:</strong> <span id="residentMiddleName"></span></p>
        <p><strong>Extension:</strong> <span id="residentExtension"></span></p>
        <p><strong>Place of Birth:</strong> <span id="residentPlaceOfBirth"></span></p>
        <p><strong>Date of Birth:</strong> <span id="residentDateOfBirth"></span></p>
        <p><strong>Age:</strong> <span id="residentAge"></span></p>
        <p><strong>Sex:</strong> <span id="residentSex"></span></p>
        <p><strong>Civil Status:</strong> <span id="residentCivilStatus"></span></p>
        <p><strong>Citizenship:</strong> <span id="residentCitizenship"></span></p>
        <p><strong>Occupation:</strong> <span id="residentOccupation"></span></p>
        <p><strong>Employment Status:</strong> <span id="residentEmploymentStatus"></span></p>
        <p><strong>Classification:</strong> <span id="residentClassification"></span></p>
        <p><strong>Current Address:</strong> <span id="residentCurrentAddress"></span></p>
        <button id="closeViewResidentBtn" class="btn btn-secondary">Close</button>
    </div>
</div>

<div id="deleteResidentModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete this resident?</p>
        <div class="modal-buttons">
            <a href="#" id="confirmDeleteResidentBtn" class="btn btn-danger">Delete</a>
            <button id="cancelDeleteResidentBtn" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</div>

<div id="editResidentModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h2>Confirm Edit</h2>
        <p>Are you sure you want to edit this resident?</p>
        <div class="modal-buttons">
            <a href="#" id="confirmEditResidentBtn" class="btn btn-warning">Edit</a>
            <button id="cancelEditResidentBtn" class="btn btn-secondary">Cancel</button>
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


<script>
document.addEventListener("DOMContentLoaded", function () {
 
    const viewButtons = document.querySelectorAll('.view-resident-btn');
    const viewModal = document.getElementById('viewResidentModal');
    const closeViewBtn = document.getElementById('closeViewResidentBtn');

    viewButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('residentUsername').textContent = button.getAttribute('data-username');
            document.getElementById('residentLastName').textContent = button.getAttribute('data-last_name');
            document.getElementById('residentFirstName').textContent = button.getAttribute('data-first_name');
            document.getElementById('residentMiddleName').textContent = button.getAttribute('data-middle_name');
            document.getElementById('residentExtension').textContent = button.getAttribute('data-extension');
            document.getElementById('residentPlaceOfBirth').textContent = button.getAttribute('data-place_of_birth');
            document.getElementById('residentDateOfBirth').textContent = button.getAttribute('data-date_of_birth');
            document.getElementById('residentAge').textContent = button.getAttribute('data-age');
            document.getElementById('residentSex').textContent = button.getAttribute('data-sex');
            document.getElementById('residentCivilStatus').textContent = button.getAttribute('data-civil_status');
            document.getElementById('residentCitizenship').textContent = button.getAttribute('data-citizenship');
            document.getElementById('residentOccupation').textContent = button.getAttribute('data-occupation');
            document.getElementById('residentEmploymentStatus').textContent = button.getAttribute('data-employment_status');
            document.getElementById('residentClassification').textContent = button.getAttribute('data-classification');
            document.getElementById('residentCurrentAddress').textContent = button.getAttribute('data-current_address');

            viewModal.style.display = 'flex';
        });
    });

    closeViewBtn.addEventListener('click', () => {
        viewModal.style.display = 'none';
    });

    viewModal.addEventListener('click', (e) => {
        if (e.target === viewModal) viewModal.style.display = 'none';
    });

    const deleteButtons = document.querySelectorAll('.delete-resident-btn');
    const deleteModal = document.getElementById('deleteResidentModal');
    const confirmDeleteBtn = document.getElementById('confirmDeleteResidentBtn');
    const cancelDeleteBtn = document.getElementById('cancelDeleteResidentBtn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            const residentId = button.getAttribute('data-id');
            confirmDeleteBtn.href = `delete_resident.php?id=${residentId}`;
            deleteModal.style.display = 'flex';
        });
    });

    cancelDeleteBtn.addEventListener('click', () => {
        deleteModal.style.display = 'none';
    });

    deleteModal.addEventListener('click', (e) => {
        if (e.target === deleteModal) deleteModal.style.display = 'none';
    });

    const editButtons = document.querySelectorAll('.edit-resident-btn');
    const editModal = document.getElementById('editResidentModal');
    const confirmEditBtn = document.getElementById('confirmEditResidentBtn');
    const cancelEditBtn = document.getElementById('cancelEditResidentBtn');

    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            const residentId = button.getAttribute('data-id');
            confirmEditBtn.href = `edit_resident.php?id=${residentId}`;
            editModal.style.display = 'flex';
        });
    });

    cancelEditBtn.addEventListener('click', () => {
        editModal.style.display = 'none';
    });

    editModal.addEventListener('click', (e) => {
        if (e.target === editModal) editModal.style.display = 'none';
    });

    const logoutModal = document.getElementById("logoutModal");
    window.confirmLogout = function () {
        window.location.href = "logout.php";
    }
    window.closeLogoutModal = function () {
        logoutModal.style.display = "none";
    }
});
</script>

    <script src="js/sidebarToggle.js"></script>
    <!-- <script src="js/View_Modals.js"></script>
    <script src="js/Edit_Modals.js"></script>
    <script src="js/Delete_Modals.js"></script> -->
    <script src="js/logout.js"></script>

</body>
</html>
