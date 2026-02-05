<?php 
include('connection.php');
include('sessioncheck.php');

if (isset($_GET['household_id'])) {
    $householdId = intval($_GET['household_id']);

    // Delete all residents in this household
    $stmt = $conn->prepare("DELETE FROM residents WHERE household_id = ?");
    $stmt->bind_param("i", $householdId);

    if ($stmt->execute()) {
        header("Location: newresident.php?message=household_deleted");
        exit;
    } else {
        echo "Error deleting household residents.";
    }

    $stmt->close();
} else {
    echo "No household ID specified.";
}

$conn->close();
?>
