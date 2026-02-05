<?php  
include('connection.php');
include('sessioncheck.php');
include('newnavi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
    $birth_place = mysqli_real_escape_string($conn, $_POST['birth_place']);
    $civil_status = mysqli_real_escape_string($conn, $_POST['civil_status']);
    $email_address = mysqli_real_escape_string($conn, $_POST['email_address']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $term = mysqli_real_escape_string($conn, $_POST['term']);

    $target_dir = "uploads/";
    if (!empty($_FILES['image']['name'])) {
        $filename = basename($_FILES["image"]["name"]);
        $image_url = $target_dir . time() . "_" . $filename;
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image_url)) {
            $image_url = $target_dir . "default.png";
        }
    } else {
        $image_url = $target_dir . "default.png";
    }

    $sql = "INSERT INTO barangay_officials 
        (name, age, sex, birth_date, birth_place, civil_status, email_address, position, contact_info, status, term, image_url) 
        VALUES 
        ('$name', '$age', '$sex', '$birth_date', '$birth_place', '$civil_status', '$email_address', '$position', '$contact', '$status', '$term', '$image_url')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Official added successfully!'); window.location='newofficial.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Officials</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <style>
        h2.text-center {
            font-size: 24px;
            margin-bottom: 25px;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="date"],
        input[type="file"],
        select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        input:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn {
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }

        .btn-success {
            background-color: #17a2b8;
            color: white;
        }

        .btn-success:hover {
            background-color: #117a8b;
        }

        .btn-info {
            background-color: #6c757d;
            color: white;
        }

        .btn-info:hover {
            background-color: #5a6268;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            h2.text-center {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">
        <h2 class="text-center">Add Barangay Official</h2>
        <form method="POST" enctype="multipart/form-data">

            <label>Name:</label>
            <input type="text" name="name" required class="form-control" style="margin-bottom:10px;">

            <label>Age:</label>
            <input type="number" name="age" required min="1" max="120" class="form-control" style="margin-bottom:10px;">

            <label>Sex:</label>
            <select name="sex" required class="form-control" style="margin-bottom:10px;">
                <option value="">-- Select Sex --</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>

            </select>

            <label>Birth Date:</label>
            <input type="date" name="birth_date" required class="form-control" style="margin-bottom:10px;">

            <label>Birth Place:</label>
            <input type="text" name="birth_place" required class="form-control" style="margin-bottom:10px;">

            <label>Civil Status:</label>
            <select name="civil_status" required class="form-control" style="margin-bottom:10px;">
                <option value="">-- Select Civil Status --</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Widowed">Widowed</option>
                <option value="Divorced">Divorced</option>
            </select>

            <label>Email Address:</label>
            <input type="email" name="email_address" required class="form-control" style="margin-bottom:10px;">

            <label>Position:</label>
            <select name="position" required class="form-control" style="margin-bottom:10px;">
                <option value="">-- Select Position --</option>
                <option value="Barangay Captain">Barangay Captain</option>
                <option value="Order">Committee on Peace and Order</option>
                <option value="Cooperative">Committee on Livelihood and Cooperative</option>
                <option value="Resources">Committee on Environment and Natural Resources</option>
                <option value="Education">Committee on Health and Education</option>
                <option value="Family">Committee on Womens and Family</option>
                <option value="Appropriation">Committee on Appropriation</option>
                <option value="Infrastructure">Committee on Infrastructure</option>
                <option value="Chairaman">Sk Chairman</option>
                <option value="Barangay Secretary">Barangay Secretary</option>
                <option value="Barangay Treasurer">Barangay Treasurer</option>
            </select>
            
            <label>Contact Info:</label>
            <input type="text" name="contact" class="form-control" style="margin-bottom:10px;">

            <label>Status:</label>
            <select name="status" class="form-control" style="margin-bottom:10px;">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>

            <label>Term:</label>
            <input type="text" name="term" required placeholder="e.g., 2023-2026" class="form-control" style="margin-bottom:10px;">

            <label>Upload Image:</label>
            <input type="file" name="image" accept="image/*" class="form-control" style="margin-bottom:10px;">

            <button type="submit" class="btn btn-success btn-block">Save Official</button>
            <a href="newofficial.php" class="btn btn-info">Back</a>
        </form>
    </div>
</div>
<script src="js/sidebarToggle.js"></script>
</body>
</html>
