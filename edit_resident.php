<?php
ob_start();
include('connection.php');
include('sessioncheck.php');

if (!isset($_GET['id'])) {
    header("Location: newresident.php");
    exit;
}

$id = intval($_GET['id']);
$msg = "";

// Fetch resident data
$stmt = $conn->prepare("SELECT * FROM residents WHERE resident_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>❌ Resident not found.</p>";
    exit;
}

$resident = $result->fetch_assoc();

// Handle form submission
if (isset($_POST['update'])) {
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $name_extension = $_POST['name_extension'];
    $place_of_birth = $_POST['place_of_birth'];
    $date_of_birth = $_POST['date_of_birth'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $civil_status = $_POST['civil_status'];
    $citizenship = $_POST['citizenship'];
    $occupation = $_POST['occupation'];
    $employment_status = $_POST['employment_status'];
    $classification = $_POST['classification'];
    $current_address = $_POST['current_address'];

    $updateQuery = "UPDATE residents SET 
        last_name = ?, 
        first_name = ?, 
        middle_name = ?, 
        name_extension = ?, 
        place_of_birth = ?, 
        date_of_birth = ?, 
        age = ?, 
        sex = ?, 
        civil_status = ?, 
        citizenship = ?, 
        occupation = ?, 
        employment_status = ?, 
        classification = ?, 
        current_address = ?
        WHERE resident_id = ?";

    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssssisssssssi", 
        $last_name, $first_name, $middle_name, $name_extension, 
        $place_of_birth, $date_of_birth, $age, $sex, 
        $civil_status, $citizenship, $occupation, $employment_status, 
        $classification, $current_address, $id
    );

    if ($stmt->execute()) {
        header("Location: newresident.php?update=success");
        exit;
    } else {
        $msg = "❌ Failed to update resident.";
    }
}

// Include navigation only after header logic
include('newnavi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Resident Information</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <style>
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .input-icon input, .input-flex select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #f1f5ff;
            outline: none;
            box-sizing: border-box;
        }
        .input-flex {
            display: flex;
            align-items: center;
            background: #f1f5ff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 0 10px;
        }
        .form-actions {
            margin-top: 30px;
            text-align: center;
        }
        .official-button, .cancel-button {
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            margin: 10px;
            color: #fff;
        }
        .official-button { background: #0077b6; }
        .official-button:hover { background: #005f8d; }
        .cancel-button { background: #6c757d; }
        .cancel-button:hover { background-color: #5a6268; }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">
        <h2>Edit Resident Info</h2>
        <?php if ($msg): ?>
            <p style="color:red"><?= htmlspecialchars($msg) ?></p>
        <?php endif; ?>

        <form method="POST">
            <?php
            function input($id, $label, $value, $type = 'text', $required = true) {
                $req = $required ? 'required' : '';
                $value = htmlspecialchars($value);
                echo "
                <div class='form-group'>
                    <label for='$id'>$label:</label>
                    <div class='input-icon'>
                        <input type='$type' id='$id' name='$id' $req value='$value'>
                    </div>
                </div>";
            }

            input('last_name', 'Last Name', $resident['last_name']);
            input('first_name', 'First Name', $resident['first_name']);
            input('middle_name', 'Middle Name', $resident['middle_name'], 'text', false);
            input('name_extension', 'Name Extension', $resident['name_extension'], 'text', false);
            input('place_of_birth', 'Place of Birth', $resident['place_of_birth']);
            input('date_of_birth', 'Date of Birth', $resident['date_of_birth'], 'date');
            input('age', 'Age', $resident['age'], 'number');
            ?>

            <div class="form-group">
                <label for="sex">Sex:</label>
                <div class="input-flex">
                    <select name="sex" id="sex" required>
                        <option value="Male" <?= $resident['sex'] === 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $resident['sex'] === 'Female' ? 'selected' : '' ?>>Female</option>
                        <option value="Other" <?= $resident['sex'] === 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="civil_status">Civil Status:</label>
                <div class="input-flex">
                    <select name="civil_status" id="civil_status" required>
                        <option value="Single" <?= $resident['civil_status'] === 'Single' ? 'selected' : '' ?>>Single</option>
                        <option value="Married" <?= $resident['civil_status'] === 'Married' ? 'selected' : '' ?>>Married</option>
                        <option value="Widowed" <?= $resident['civil_status'] === 'Widowed' ? 'selected' : '' ?>>Widowed</option>
                        <option value="Separated" <?= $resident['civil_status'] === 'Separated' ? 'selected' : '' ?>>Separated</option>
                    </select>
                </div>
            </div>

            <?php
            input('citizenship', 'Citizenship', $resident['citizenship']);
            input('occupation', 'Occupation', $resident['occupation'], 'text', false);
            input('employment_status', 'Employment Status', $resident['employment_status'], 'text', false);
            input('classification', 'Classification', $resident['classification'], 'text', false);
            input('current_address', 'Current Address', $resident['current_address']);
            ?>

            <div class="form-actions">
                <button type="submit" name="update" class="official-button">Update Resident</button>
                <a href="newresident.php" class="cancel-button">Cancel</a>
            </div>
        </form>
    </div>
</div>
<script src="js/sidebarToggle.js"></script>
<script src="js/logout.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>
