<?php
include('connection.php');
include('sessioncheck.php');
include('usernavi.php');

$username = $_SESSION['username'] ?? null;
$resident_id = $_SESSION['resident_id'] ?? null;

if (!$resident_id && $username) {
    $stmt = $conn->prepare("SELECT resident_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $resident_id = $row['resident_id'];
        $_SESSION['resident_id'] = $resident_id;
    }
    $stmt->close();
}

if ($resident_id) {
    $stmt = $conn->prepare("SELECT residents.*, users.username 
                            FROM residents 
                            LEFT JOIN users ON users.resident_id = residents.resident_id 
                            WHERE residents.resident_id = ?");
    $stmt->bind_param("i", $resident_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()):
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Profile</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <style>
   
        .profile-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .custom-table th,
        .custom-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .custom-table th {
            background-color: #f0f0f0;
            color: #333;
            width: 30%;
        }

        .custom-table tr:hover {
            background-color: #f9f9f9;
        }

        @media screen and (max-width: 600px) {
            .custom-table th, .custom-table td {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }

            .custom-table th {
                background-color: transparent;
                font-weight: bold;
                padding-top: 15px;
            }

            .custom-table td {
                border-bottom: none;
                padding-bottom: 15px;
            }
        }
         .blurred #wrapper {
            filter: blur(5px);
            pointer-events: none;
        }

        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10000;
        }

        .modal-box {
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            font-family: Arial, sans-serif;
            box-shadow: 0 0 15px rgba(0,0,0,0.25);
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin: 20px auto;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .modal-buttons .yes {
            background-color: #dc3545;
            color: white;
        }

        .modal-buttons .cancel {
            background-color: #6c757d;
            color: white;
        }

        .modal-buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">

    <div class="profile-container">
        <h2>Welcome, <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></h2>
        <table class="custom-table">
            <tr><th>Username</th><td><?= htmlspecialchars($row['username']) ?></td></tr>
            <tr><th>Full Name</th><td><?= htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . ' ' . $row['name_extension']) ?></td></tr>
            <tr><th>Place of Birth</th><td><?= htmlspecialchars($row['place_of_birth']) ?></td></tr>
            <tr><th>Date of Birth</th><td><?= htmlspecialchars($row['date_of_birth']) ?></td></tr>
            <tr><th>Age</th><td><?= htmlspecialchars($row['age']) ?></td></tr>
            <tr><th>Sex</th><td><?= htmlspecialchars($row['sex']) ?></td></tr>
            <tr><th>Civil Status</th><td><?= htmlspecialchars($row['civil_status']) ?></td></tr>
            <tr><th>Citizenship</th><td><?= htmlspecialchars($row['citizenship']) ?></td></tr>
            <tr><th>Occupation</th><td><?= htmlspecialchars($row['occupation']) ?></td></tr>
            <tr><th>Employment Status</th><td><?= htmlspecialchars($row['employment_status']) ?></td></tr>
            <tr><th>Classification</th><td><?= htmlspecialchars($row['classification']) ?></td></tr>
            <tr><th>Current Address</th><td><?= htmlspecialchars($row['current_address']) ?></td></tr>
        </table>
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

    <script src="js/sidebarToggle.js"></script>
    <script src="js/logout.js"></script>
</body>
</html>

<?php
    else:
        echo "<p style='color:red; text-align:center;'>⚠️ No matching resident data found.</p>";
    endif;
} else {
    echo "<p style='color:red; text-align:center;'>⚠️ No resident ID linked to your account yet.</p>";
}
?>
