<?php 
include('connection.php');
include('sessioncheck.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM blotter WHERE blotter_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: newblotter.php?message=deleted");
    } else {
        echo "Error deleting record.";
    }

    $stmt->close();
} else {
    echo "No ID specified.";
}
$conn->close();
?>
