// generate_form.php snippet (assuming requester name from session)
<?php
include('connection.php');
session_start();

$form_type = $_GET['form_type'] ?? '';
$requester_name = $_SESSION['username'] ?? 'Guest';

if ($form_type) {
    // Insert the request into the DB
    $stmt = $conn->prepare("INSERT INTO form_requests (requester_name, form_type) VALUES (?, ?)");
    $stmt->bind_param("ss", $requester_name, $form_type);
    $stmt->execute();
    $stmt->close();

    // Proceed to generate form...
}
?>