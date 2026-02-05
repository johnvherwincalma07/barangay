<?php 
include('connection.php');
include('sessioncheck.php');
include('usernavi.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form_type'];
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $purpose = $_POST['purpose'];
    $date_needed = $_POST['date_needed'];
    $reason = $_POST['reason'];
    $valid_id_path = null;

    // File upload handling
    if (isset($_FILES['valid_id']) && $_FILES['valid_id']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = time() . "_" . basename($_FILES['valid_id']['name']);
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['valid_id']['tmp_name'], $targetFile)) {
            $valid_id_path = $targetFile;
        } else {
            $valid_id_path = 'uploads/default.png'; // fallback image if needed
        }
    } else {
        $valid_id_path = 'uploads/default.png'; // fallback image if none uploaded
    }

    // Prepare insert query
    $stmt = $conn->prepare("INSERT INTO requests (form_type, fullname, address, phone, purpose, date_needed, reason, valid_id_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $form_type, $fullname, $address, $phone, $purpose, $date_needed, $reason, $valid_id_path);

    if ($stmt->execute()) {
        echo "<script>alert('Form request submitted successfully.'); window.location.href='userform.php';</script>";
    } else {
        echo "<script>alert('Failed to submit form: " . $conn->error . "');</script>";
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Request - Barangay System</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <style>
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        .input-icon input, .input-icon textarea, #form_type {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #f1f5ff;
            box-sizing: border-box;
        }
        .form-actions {
            text-align: center;
            margin-top: 30px;
        }
        .official-button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .official-button:hover {
            background-color: #0056b3;
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

        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="page-header">Form Requests</h1>
                <p class="tagline">"Request and print official barangay documents."</p>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="form_type">Form Type:</label>
                <select name="form_type" id="form_type" required>
                    <option value="">--Choose Form--</option>
                    <option value="clearance">Barangay Clearance</option>
                    <option value="indigency">Certificate of Indigency</option>
                    <option value="residency">Certificate of Residency</option>
                </select>
            </div>

            <div class="form-group">
                <label for="fullname">Full Name:</label>
                <div class="input-icon">
                    <input type="text" name="fullname" id="fullname" required>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <div class="input-icon">
                    <input type="text" name="address" id="address" required>
                </div>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <div class="input-icon">
                    <input type="text" name="phone" id="phone" required>
                </div>
            </div>

            <div class="form-group">
                <label for="purpose">Purpose of Request:</label>
                <div class="input-icon">
                    <input type="text" name="purpose" id="purpose" required>
                </div>
            </div>

            <div class="form-group">
                <label for="date_needed">Date Needed:</label>
                <div class="input-icon">
                    <input type="date" name="date_needed" id="date_needed" required>
                </div>
            </div>

            <div class="form-group">
                <label for="reason">Please specify your reason:</label>
                <div class="input-icon">
                    <textarea name="reason" id="reason" rows="4" required></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="valid_id_path">Upload Valid ID (optional):</label>
                <div class="input-icon">
                    <input type="file" name="valid_id_path" id="valid_id_path" accept="image/*">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="official-button">Submit Request</button>
            </div>
        </form>

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
