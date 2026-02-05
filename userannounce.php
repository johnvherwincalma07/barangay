<?php  
include('connection.php');
include('sessioncheck.php');
include('usernavi.php');

function getDateLabel($date) {
    $today = strtotime(date("Y-m-d"));
    $yesterday = strtotime("-1 day", $today);
    $posted = strtotime(date("Y-m-d", strtotime($date)));

    if ($posted == $today) {
        return "Today";
    } elseif ($posted == $yesterday) {
        return "Yesterday";
    } elseif ($posted >= strtotime("-7 days", $today)) {
        return "Last 7 Days";
    } else {
        return "Older";
    }
}

$ann_query = "SELECT * FROM announcements ORDER BY date_posted DESC LIMIT 50";
$ann_result = mysqli_query($conn, $ann_query);

$grouped_announcements = [];
while ($ann = mysqli_fetch_assoc($ann_result)) {
    $label = getDateLabel($ann['date_posted']);
    $grouped_announcements[$label][] = $ann;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resident Dashboard - Barangay System</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <link rel="stylesheet" href="style/user/style_user_announcement.css">
    <style>
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

        <div class="header-section">
            <div class="col-lg-12">
                <h1 class="page-header">Barangay Announcements</h1>
                <p class="tagline">"Stay updated with the latest info!"</p>
            </div>
        </div>

        <br>
        <div class="announcement-section">
            <div class="announcement-container">
                <div class="announcement-card">
                    <ul style="list-style-type: none; padding-left: 0;">
                        <?php if (!empty($grouped_announcements)): ?>
                            <?php foreach ($grouped_announcements as $label => $anns): ?>
                                <li class="announcement-label"><?= htmlspecialchars($label) ?></li>
                                <?php foreach ($anns as $ann): ?>
                                    <li class="announcement-item">
                                        <strong><?= htmlspecialchars($ann['title']) ?>:</strong>
                                        <div><?= nl2br(htmlspecialchars($ann['content'])) ?></div>
                                        <small><i>Posted on <?= date('F d, Y (l)', strtotime($ann['date_posted'])) ?></i></small>
                                    </li>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>No announcements at this time.</li>
                        <?php endif; ?>
                    </ul>
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
