<?php  
include('connection.php');
include('sessioncheck.php');
include('usernavi.php');

$form_type = isset($_GET['form_type']) ? htmlspecialchars($_GET['form_type']) : '';

$prompt = '';
$purposes = [];

switch ($form_type) {
    case 'clearance':
        $prompt = 'Common reasons: Employment, Job Requirement, Travel, ID Application.';
        break;
    case 'indigency':
        $prompt = 'Common reasons: Financial Assistance, Scholarship Application, Medical Aid.';
        break;
    case 'residency':
        $prompt = 'Common reasons: Proof of Address, School Enrollment, Legal Requirements.';
        break;
    default:
        $prompt = 'Please select a valid document type.';
        $purposes = ['Other'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reason for Request - Barangay System</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <style>
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .btn-submit {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-cancel:hover {
            background-color: #5a6268;
        }

        p {
            padding: 10px;
            border-left: 4px solid;
            font-style: italic;
        }

        @media screen and (max-width: 600px) {
            #page-wrapper {
                padding: 20px;
            }

            .btn-submit, .btn-cancel {
                width: 100%;
                margin-bottom: 10px;
            }
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
        <h2>Requesting: <?= ucfirst($form_type) ?></h2>

        <form action="request.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="form_type" value="<?= $form_type ?>">

            <p><strong>Note:</strong> <?= $prompt ?></p>

            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" id="fullname" required>

            <label for="address">Address:</label>
            <input type="text" name="address" id="address" required>

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" required>

            <label for="purpose">Purpose of Request:</label>
            <input type="text" name="purpose" id="purpose" required>

            <label for="date_needed">Date Needed:</label>
            <input type="date" name="date_needed" id="date_needed" required>

            <label for="reason">Please specify your reason:</label>
            <textarea name="reason" id="reason" rows="4" required></textarea>

            <label for="valid_id">Upload Valid ID (optional):</label>
            <input type="file" name="valid_id" id="valid_id" accept="image/*">

            <div style="margin-top: 10px;">
                <button type="submit" class="btn-submit">Submit Request</button>
                    <a href="userform.php" style="margin-left: 10px; text-decoration: none;">
                    <button type="button" class="btn-cancel">Cancel</button>
                </a>
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
