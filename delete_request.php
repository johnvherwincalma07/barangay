<?php 
include('connection.php');
include('sessioncheck.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM requests WHERE request_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: newforms.php?message=deleted");
        exit;
    } else {
        echo "Error deleting request.";
    }

    $stmt->close();
} else {
    echo "No ID specified.";
}
$conn->close();
?>
