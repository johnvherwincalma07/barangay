<?php
include('connection.php');
include('sessioncheck.php');

$resident_id = $_SESSION['resident_id'] ?? 0;

$notifModalQuery = $conn->prepare("SELECT * FROM notifications WHERE resident_id = ? AND status = 'unread' ORDER BY created_at DESC LIMIT 1");
$notifModalQuery->bind_param("i", $resident_id);
$notifModalQuery->execute();
$notifResult = $notifModalQuery->get_result();
$notifData = $notifResult->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resident Dashboard</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <style>
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
            padding: 25px 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .modal-box h3 {
            margin-bottom: 15px;
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
            font-size: 14px;
            cursor: pointer;
        }

        .modal-buttons .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<!-- Your Page Content -->
<h1>Welcome to Resident Dashboard</h1>
<p>This is your dashboard content.</p>

<!-- Notification Modal -->
<?php if ($notifData): ?>
<div id="notifModal" class="modal-overlay">
    <div class="modal-box">
        <h3>📢 Notification</h3>
        <p><?= htmlspecialchars($notifData['message']) ?></p>
        <small><?= date("F j, Y g:i A", strtotime($notifData['created_at'])) ?></small>
        <div class="modal-buttons">
            <button class="btn" onclick="closeNotifModal()">Close</button>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
    // Show modal after page fully loads
    window.onload = function() {
        const notif = document.getElementById("notifModal");
        if (notif) notif.style.display = "flex";
    };

    function closeNotifModal() {
        document.getElementById("notifModal").style.display = "none";

    
        fetch('mark_read.php')
            .then(response => response.text());
    }
</script>

</body>
</html>
