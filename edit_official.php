<?php
ob_start();
session_start();

include('connection.php');

// Get ID from query string and validate
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Redirect immediately if no valid ID
if ($id === 0) {
    header("Location: newofficial.php");
    exit;
}

// Fetch official data
$query = "SELECT * FROM barangay_officials WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    // No record found — no output before header, but since we want to show error, we echo and stop.
    echo "Record not found.";
    exit;
}

$official = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = intval($_POST['age']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
    $birth_place = mysqli_real_escape_string($conn, $_POST['birth_place']);
    $civil_status = mysqli_real_escape_string($conn, $_POST['civil_status']);
    $email_address = mysqli_real_escape_string($conn, $_POST['email_address']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $contact_info = mysqli_real_escape_string($conn, $_POST['contact_info']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $term = mysqli_real_escape_string($conn, $_POST['term']);

    // Handle image upload
    $image_url = $official['image_url'];
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        $filename = basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . time() . "_" . $filename;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image_url = $targetFile;
        }
    }

    // Update query
    $updateQuery = "
        UPDATE barangay_officials
        SET
            name='$name',
            age=$age,
            sex='$sex',
            birth_date='$birth_date',
            birth_place='$birth_place',
            civil_status='$civil_status',
            email_address='$email_address',
            position='$position',
            contact_info='$contact_info',
            status='$status',
            term='$term',
            image_url='$image_url'
        WHERE id=$id
    ";

    if (mysqli_query($conn, $updateQuery)) {
        // Redirect immediately after successful update
        header("Location: newofficial.php?msg=updated");
        exit;
    } else {
        // Show error if update failed (no output before header)
        echo "Update failed: " . mysqli_error($conn);
        exit;
    }
}

// Now safe to include newnavi.php (outputs HTML)
include('newnavi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Barangay Official</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <style>
        /* Your CSS styles here */
        h2 { margin-top: 30px; }
        label {
            font-weight: 600;
            display: block;
            margin-top: 15px;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="file"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-top: 10px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        .official-button {
            display: inline-block;
            background: #0077b6;
            color: #fff;
            padding: 10px 18px;
            margin-top: 25px;
            margin-right: 10px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }
        .official-button:hover { background: #005f8d; }
        .cancel-button {
            background-color: #6c757d;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            display: inline-block;
            margin-top: 25px;
            margin-right: 10px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }
        .cancel-button:hover { background-color: #5a6268; }
        .official-photo {
            margin-top: 15px;
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            display: block;
        }
        .form-actions {
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">
        <h2>Edit Barangay Official</h2>

        <form method="POST" enctype="multipart/form-data">
            <label>Name:</label>
            <input type="text" name="name" required value="<?= htmlspecialchars($official['name']) ?>">

            <label>Age:</label>
            <input type="number" name="age" required value="<?= htmlspecialchars($official['age']) ?>">

            <label>Sex:</label>
            <select name="sex" required>
                <option value="Male" <?= $official['sex'] === 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $official['sex'] === 'Female' ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= $official['sex'] === 'Other' ? 'selected' : '' ?>>Other</option>
            </select>

            <label>Birth Date:</label>
            <input type="date" name="birth_date" required value="<?= htmlspecialchars($official['birth_date']) ?>">

            <label>Birth Place:</label>
            <input type="text" name="birth_place" required value="<?= htmlspecialchars($official['birth_place']) ?>">

            <label>Civil Status:</label>
            <select name="civil_status" required>
                <option value="Single" <?= $official['civil_status'] === 'Single' ? 'selected' : '' ?>>Single</option>
                <option value="Married" <?= $official['civil_status'] === 'Married' ? 'selected' : '' ?>>Married</option>
                <option value="Widowed" <?= $official['civil_status'] === 'Widowed' ? 'selected' : '' ?>>Widowed</option>
                <option value="Separated" <?= $official['civil_status'] === 'Separated' ? 'selected' : '' ?>>Separated</option>
            </select>

            <label>Email Address:</label>
            <input type="text" name="email_address" required value="<?= htmlspecialchars($official['email_address']) ?>">

            <label>Position:</label>
            <input type="text" name="position" required value="<?= htmlspecialchars($official['position']) ?>">

            <label>Contact Info:</label>
            <input type="text" name="contact_info" required value="<?= htmlspecialchars($official['contact_info']) ?>">

            <label>Status:</label>
            <select name="status" required>
                <option value="Active" <?= $official['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
                <option value="Inactive" <?= $official['status'] === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>

            <label>Term:</label>
            <input type="text" name="term" value="<?= htmlspecialchars($official['term']) ?>">

            <label>Photo:</label>
            <input type="file" name="image">
            <?php if (!empty($official['image_url'])): ?>
                <img class="official-photo" src="<?= htmlspecialchars($official['image_url']) ?>" alt="Profile Image">
            <?php endif; ?>

            <div class="form-actions">
                <button type="submit" class="official-button">Update Official</button>
                <a href="newofficial.php" class="cancel-button">Cancel</a>
            </div>
        </form>

    </div>
</div>

<script src="js/sidebarToggle.js"></script>
</body>
</html>

<?php
// Flush output buffer and send output
ob_end_flush();
