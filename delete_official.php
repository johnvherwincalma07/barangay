<?php
include('connection.php');
include('sessioncheck.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: newofficial.php?msg=invalid_id");
    exit;
}

$id = intval($_GET['id']);

$query = "DELETE FROM barangay_officials WHERE id = $id";
if (mysqli_query($conn, $query)) {
    header("Location: newofficial.php?msg=deleted");
    exit;
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
