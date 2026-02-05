<?php
include('connection.php');
session_start();

if (isset($_GET['id'], $_GET['status'])) {
    $request_id = (int)$_GET['id'];
    $new_status = trim($_GET['status']);

    // Define allowed statuses
    $allowed_statuses = ['Pending', 'Approved', 'Sent', 'Done'];

    if (in_array($new_status, $allowed_statuses)) {
        // Update the request status
        $stmt = $conn->prepare("UPDATE requests SET status = ? WHERE request_id = ?");
        $stmt->bind_param("si", $new_status, $request_id);

        if ($stmt->execute()) {
            header("Location: newforms.php?success=1");
            exit;
        } else {
            echo "Error updating status.";
        }
    } else {
        echo "Invalid status.";
    }
} else {
    echo "Missing parameters.";
}
