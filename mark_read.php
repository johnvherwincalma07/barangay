<?php
include('connection.php');
session_start();

// Ensure resident is logged in
if (!isset($_SESSION['resident_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notification_id'])) {
    $notif_id = (int)$_POST['notification_id'];
    $resident_id = $_SESSION['resident_id'];

    // Only mark notifications belonging to the current user
    $stmt = $conn->prepare("UPDATE notifications SET status = 'read' WHERE notification_id = ? AND resident_id = ?");
    $stmt->bind_param("ii", $notif_id, $resident_id);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to the referring page
header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'userpage.php'));
exit;
?>
