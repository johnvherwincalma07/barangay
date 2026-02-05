<?php 
include('connection.php');
include('sessioncheck.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM announcements WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: newannounce.php?message=deleted");
            exit();
        } else {
            echo "❌ Error executing delete: " . $stmt->error;
        }
    } else {
        echo "❌ Prepare failed: " . $conn->error;
    }
} else {
    echo "❗ Invalid or missing ID.";
}
$conn->close();
?>
