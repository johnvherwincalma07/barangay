<?php
include('connection.php');
include('sessioncheck.php');

if (isset($_GET['id'])) {
    $residentId = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM residents WHERE resident_id = ?");
    $stmt->bind_param("i", $residentId);

    if ($stmt->execute()) {
        header("Location: newresident.php?message=deleted");
        exit;
    } else {
        echo "Error deleting resident.";
    }

    $stmt->close();
} else {
    echo "No resident ID specified.";
}

$conn->close();
?>
