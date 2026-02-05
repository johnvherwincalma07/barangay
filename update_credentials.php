<?php
include('connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF token mismatch.");
    }

    $newUsername = trim($_POST['new_username']);
    $newPassword = password_hash(trim($_POST['new_password']), PASSWORD_DEFAULT);
    $currentUser = $_SESSION['username'];

    $stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE username = ?");
    $stmt->bind_param("sss", $newUsername, $newPassword, $currentUser);

    if ($stmt->execute()) {
        $_SESSION['username'] = $newUsername;
        echo "<script>alert('Credentials updated. Please log in again.'); window.location='logout.php';</script>";
    } else {
        echo "Error updating credentials.";
    }

    $stmt->close();
    $conn->close();
}
?>
