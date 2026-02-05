<?php
include('connection.php');
include('sessioncheck.php');
include('newnavi.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Barangay Management System - Admin Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style/user/personstyle.css"> -->
    <link rel="stylesheet" href="style/admin/style_home.css">
    <style>
        body { 
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #9bbced;
            overflow-x: auto; 
        }
        #wrapper {
            animation: fadeIn 1s ease-in-out;
            background-image: 
                linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)),
                url('images/brgy.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin-top: 80px;
            margin-right: 30px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            transition: margin-left 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #page-wrapper {
            min-height: 100vh;
            padding: 30px;
            box-sizing: border-box;
            color: white;
        }

    </style>
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">

        <div class="row">
            <div class="text">
                <h1 class="page-header">Barangay Bunga Management System</h1>
                <p class="tagline">Serving the community with speed, order, and care.</p>
            </div>
        </div>

        <div class="section">
            <div class="text">
                <h2 class="section-title">Mission and Vision</h2>
                <div class="card">
                    <p><strong>Mission:</strong> To serve the community efficiently, promote peace, and improve the quality of life for all residents.</p>
                    <p><strong>Vision:</strong> A safe, progressive, and unified barangay driven by transparency and active citizen participation.</p>
                </div>
            </div>
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