<?php      
include('connection.php');
include('sessioncheck.php');
include('usernavi.php');

$user = $_SESSION['username'] ?? '';

$query = "SELECT profile_photo FROM users WHERE username = '$user'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

$_SESSION['profile_image'] = !empty($data['profile_photo']) ? $data['profile_photo'] : 'default-avatar.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resident Dashboard - Barangay System</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <style>
        .profile-box {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
        }

        .profile-img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #007bff;
        }

        .welcome-text h3 {
            margin: 0;
            font-size: 32px;
            color: #555;
        }

        .welcome-text h1 {
            margin: 10px 0 0;
            font-size: 26px;
            color: #007bff;
        }

        .section-title {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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

        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .modal-box {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }
        .modal-buttons {
            margin-top: 20px;
        }
        .modal-buttons .btn {
            background: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

    </style>
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">
        <!-- Profile Section -->
        <div class="profile-box">
            <img src="uploads/<?= $_SESSION['profile_image'] ?>" alt="Profile" class="profile-img">
            <div class="welcome-text">
                <h3>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h3>
                <h1>Resident Portal</h1>
            </div>
        </div>

        <!-- Mission and Vision -->
        <div class="row-section">
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
