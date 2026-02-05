<?php
include('connection.php');
include('sessioncheck.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resident_id = $_SESSION['resident_id'];
    $form_type = $_POST['form_type'];
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $purpose = $_POST['purpose'];
    $date_needed = $_POST['date_needed'];
    $reason = $_POST['reason'];

    $valid_id_path = '';
    if (!empty($_FILES['valid_id']['name'])) {
        $targetDir = "uploads/";
        $valid_id_path = $targetDir . basename($_FILES["valid_id"]["name"]);
        move_uploaded_file($_FILES["valid_id"]["tmp_name"], $valid_id_path);
    }
    
    $stmt = $conn->prepare("INSERT INTO requests (resident_id, form_type, fullname, address, phone, purpose, date_needed, reason, valid_id_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $resident_id, $form_type, $fullname, $address, $phone, $purpose, $date_needed, $reason, $valid_id_path);
    $stmt->execute();
    $stmt->close();

    header("Location: userform.php?form_type=$form_type&success=1");
    exit;
}
?>
