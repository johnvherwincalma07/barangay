<?php
include('connection.php');
include('sessioncheck.php');
include('newnavi.php');

$request_id = $_GET['request_id'] ?? '';

$query = "SELECT * FROM requests WHERE request_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $request_id);
$stmt->execute();
$result = $stmt->get_result();
$request = $result->fetch_assoc();

if (!$request) {
    echo "Request not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Request Details:</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <style>
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: bold;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #0056b3;
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
        <h2>Request #<?= $request['request_id'] ?></h2>
        <p><strong>Full Name:</strong> <?= htmlspecialchars($request['fullname']) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($request['address']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($request['phone']) ?></p>
        <p><strong>Form Type:</strong> <?= htmlspecialchars($request['form_type']) ?></p>
        <p><strong>Purpose:</strong> <?= htmlspecialchars($request['purpose']) ?></p>
        <p><strong>Date Needed:</strong> <?= htmlspecialchars($request['date_needed']) ?></p>
        <p><strong>Reason:</strong> <?= htmlspecialchars($request['reason']) ?></p>
        <p><strong>Request Date:</strong> <?= htmlspecialchars($request['request_date']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($request['status']) ?></p>
        <a href="newforms.php" class="back-btn">Back to Requests</a>
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
