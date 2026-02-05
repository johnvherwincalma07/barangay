<?php 
include('connection.php');
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['consent'])) {
    // USER INFO
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.'); window.location.href='registerform.php';</script>";
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // HOUSEHOLD INFO
    $region = $_POST['region'];
    $province = $_POST['province'];
    $city_municipality = $_POST['city_municipality'];
    $barangay = $_POST['barangay'];
    $household_address = $_POST['household_address'];
    $no_of_members = $_POST['no_of_members'];

    // RESIDENT INFO
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'] ?? '';
    $name_extension = $_POST['name_extension'] ?? '';
    $place_of_birth = $_POST['place_of_birth'];
    $date_of_birth = $_POST['date_of_birth'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $civil_status = $_POST['civil_status'];
    $citizenship = $_POST['citizenship'];
    $occupation = $_POST['occupation'] ?? '';
    $employment_status = $_POST['employment_status'] ?? '';
    $classification = $_POST['classification'];
    $current_address = $_POST['current_address'];

    mysqli_begin_transaction($conn);

    try {
        // 1. Insert into users (initially without resident_id)
        $stmt1 = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'resident')");
        $stmt1->bind_param("sss", $username, $email, $hashedPassword);
        $stmt1->execute();
        $user_id = $stmt1->insert_id;

        // 2. Insert into households
        $stmt2 = $conn->prepare("INSERT INTO households (region, province, city_municipality, barangay, household_address, no_of_members) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param("sssssi", $region, $province, $city_municipality, $barangay, $household_address, $no_of_members);
        $stmt2->execute();
        $household_id = $stmt2->insert_id;

        // 3. Insert into residents and use user_id to link
        $stmt3 = $conn->prepare("INSERT INTO residents (id, household_id, last_name, first_name, middle_name, name_extension, place_of_birth, date_of_birth, age, sex, civil_status, citizenship, occupation, employment_status, classification, current_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt3->bind_param("iissssssssisssss", $user_id, $household_id, $last_name, $first_name, $middle_name, $name_extension, $place_of_birth, $date_of_birth, $age, $sex, $civil_status, $citizenship, $occupation, $employment_status, $classification, $current_address);
        $stmt3->execute();
        $resident_id = $stmt3->insert_id;

        // 4. Update users table with the resident_id
        $stmt4 = $conn->prepare("UPDATE users SET resident_id = ? WHERE id = ?");
        $stmt4->bind_param("ii", $resident_id, $user_id);
        $stmt4->execute();

        mysqli_commit($conn);
        echo "<script>alert('Registration successful!'); window.location.href='loginpage.php';</script>";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='registerform.php';</script>";
    }
}
?>
