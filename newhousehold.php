<?php  
include('connection.php');
include('sessioncheck.php');
include('newnavi.php');

$query = "
    SELECT households.household_id, households.household_address,
           residents.resident_id, residents.first_name, residents.middle_name, residents.last_name, residents.age, residents.sex
    FROM households
    LEFT JOIN residents ON households.household_id = residents.household_id
    ORDER BY households.household_id, residents.last_name
";

$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}

$households = [];

while ($row = $result->fetch_assoc()) {
    $hid = $row['household_id'];
    if (!isset($households[$hid])) {
        $households[$hid] = [
            'address' => $row['household_address'],
            'residents' => []
        ];
    }

    if (!empty($row['resident_id'])) {
        $households[$hid]['residents'][] = [
            'name' => $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'],
            'age' => $row['age'],
            'sex' => $row['sex']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Households</title>
    <link rel="stylesheet" href="style/admin/style_household.css">
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">
          
            <div class="row">
                <div class="column">
                    <h1 class="page-header">Barangay Households</h1>
                    <p class="tagline">"Families make the community whole."</p>
                </div>
            </div>
        
            <div class="column">
                <h2 class="flex-between-header">
                    List of Households Records:
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
                                <th>Household No.</th>
                                <th>Residents</th>
                                <th>Address</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($households as $hid => $data): ?>
                                <tr>
                                    <td><?= htmlspecialchars($hid) ?></td>
                                    <td>
                                        <?php if (!empty($data['residents'])): ?>
                                            <ul>
                                                <?php foreach ($data['residents'] as $res): ?>
                                                    <li><?= htmlspecialchars($res['name']) ?> (<?= $res['sex'] ?>, <?= $res['age'] ?>)</li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <i>No registered residents</i>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($data['address']) ?></td>
                                    <td>
                                        <button 
                                            class="btn btn-info btn-sm view-household-btn"
                                            data-id="<?= $hid ?>"
                                            data-address="<?= htmlspecialchars($data['address']) ?>"
                                        >View</button>

                                        <button 
                                            class="btn btn-warning btn-sm edit-household-btn"
                                            data-id="<?= $hid ?>"
                                        >Edit</button>

                                        <button 
                                            class="btn btn-danger btn-sm delete-household-btn"
                                            data-id="<?= $hid ?>"
                                        >Delete</button>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

    </div>
</div>

<div id="viewHouseholdModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h3>Household Info</h3>
        <p><strong>ID:</strong> <span id="viewHID"></span></p>
        <p><strong>Address:</strong> <span id="viewAddress"></span></p>
        <div class="modal-buttons">
            <button id="closeViewHouseholdBtn" class="btn btn-secondary btn-sm">Close</button>
        </div>
    </div>
</div>

<div id="editHouseholdModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h3>Edit Household</h3>
        <p>Are you sure you want to edit this household?</p>
        <div class="modal-buttons">
            <a href="#" id="confirmEditHouseholdBtn" class="btn btn-warning btn-sm">Edit</a>
            <button class="btn btn-secondary btn-sm" onclick="closeModal('editHouseholdModal')">Cancel</button>
        </div>
    </div>
</div>

<div id="deleteHouseholdModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h3>Delete Household</h3>
        <p>Are you sure you want to delete this household? This cannot be undone.</p>
        <div class="modal-buttons">
            <a href="#" id="confirmDeleteHouseholdBtn" class="btn btn-danger btn-sm">Delete</a>
            <button class="btn btn-secondary btn-sm" onclick="closeModal('deleteHouseholdModal')">Cancel</button>
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
  
    document.querySelectorAll('.view-household-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const address = btn.dataset.address;

            document.getElementById('viewHID').textContent = id;
            document.getElementById('viewAddress').textContent = address;
            document.getElementById('viewHouseholdModal').style.display = 'flex';
        });
    });

    document.getElementById('closeViewHouseholdBtn').addEventListener('click', () => {
        document.getElementById('viewHouseholdModal').style.display = 'none';
    });

  
    document.querySelectorAll('.edit-household-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            document.getElementById('confirmEditHouseholdBtn').href = 'edit_household.php?id=' + id;
            document.getElementById('editHouseholdModal').style.display = 'flex';
        });
    });

    document.querySelectorAll('.delete-household-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            document.getElementById('confirmDeleteHouseholdBtn').href = 'del_household.php?id=' + id;
            document.getElementById('deleteHouseholdModal').style.display = 'flex';
        });
    });
});

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

</script>


    <script src="js/sidebarToggle.js"></script>
    <!-- <script src="js/View_Modals.js"></script>
    <script src="js/Edit_Modals.js"></script>
    <script src="js/Delete_Modals.js"></script> -->
    <script src="js/logout.js"></script>

</body>
</html>
