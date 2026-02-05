<?php
include('connection.php');
include('sessioncheck.php');

// Redirect if no ID is set
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: newblotter.php");
    exit;
}

$blotter_id = intval($_GET['id']);

// Fetch blotter info
$stmt = $conn->prepare("SELECT * FROM blotter WHERE blotter_id = ?");
$stmt->bind_param("i", $blotter_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>❌ Blotter record not found.</p>";
    exit;
}

$row = $result->fetch_assoc();

// Update handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $complainant = $_POST['complainant'];
    $complainant_address = $_POST['complainant_address'];
    $complainant_cellno = $_POST['complainant_cellno'];
    $respondent = $_POST['respondent'];
    $respondent_address = $_POST['respondent_address'];
    $respondent_cellno = $_POST['respondent_cellno'];
    $about = $_POST['about'];
    $statement = $_POST['statement'];

    $update = $conn->prepare("UPDATE blotter SET 
        date_filed = ?, complainant = ?, complainant_address = ?, complainant_cellno = ?, 
        respondent = ?, respondent_address = ?, respondent_cellno = ?, about = ?, statement = ? 
        WHERE blotter_id = ?");
    $update->bind_param(
        "sssssssssi",
        $date, $complainant, $complainant_address, $complainant_cellno,
        $respondent, $respondent_address, $respondent_cellno, $about, $statement,
        $blotter_id
    );

    if ($update->execute()) {
        header("Location: newblotter.php?update=success");
        exit;
    } else {
        $error = "❌ Failed to update blotter.";
    }
}

include('newnavi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Blotter Information</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <style>
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .input-icon input, .input-icon textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #f1f5ff;
            box-sizing: border-box;
        }

        .form-actions {
            margin-top: 30px;
            text-align: center;
        }

        .official-button {
            background: #0077b6;
            color: #fff;
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            margin-right: 10px;
        }

        .official-button:hover {
            background: #005f8d;
        }

        .cancel-button {
            background-color: #6c757d;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 15px;
            text-decoration: none;
            margin-top: 25px;
            display: inline-block;
        }

        .cancel-button:hover {
            background-color: #5a6268;
        }

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">   
        <h2>Edit Blotter Info</h2>

        <?php if (isset($error)): ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="date">Date:</label>
                <div class="input-icon">
                    <input type="date" id="date" name="date" value="<?= htmlspecialchars($row['date_filed']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="complainant">Complainant:</label>
                <div class="input-icon">
                    <input type="text" id="complainant" name="complainant" value="<?= htmlspecialchars($row['complainant']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="complainant_address">Complainant's Address:</label>
                <div class="input-icon">
                    <input type="text" id="complainant_address" name="complainant_address" value="<?= htmlspecialchars($row['complainant_address']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="complainant_cellno">Complainant's Cellphone Number:</label>
                <div class="input-icon">
                    <input type="text" id="complainant_cellno" name="complainant_cellno" value="<?= htmlspecialchars($row['complainant_cellno']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="respondent">Respondent:</label>
                <div class="input-icon">
                    <input type="text" id="respondent" name="respondent" value="<?= htmlspecialchars($row['respondent']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="respondent_address">Respondent's Address:</label>
                <div class="input-icon">
                    <input type="text" id="respondent_address" name="respondent_address" value="<?= htmlspecialchars($row['respondent_address']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="respondent_cellno">Respondent's Cellphone Number:</label>
                <div class="input-icon">
                    <input type="text" id="respondent_cellno" name="respondent_cellno" value="<?= htmlspecialchars($row['respondent_cellno']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="about">About:</label>
                <div class="input-icon">
                    <input type="text" id="about" name="about" value="<?= htmlspecialchars($row['about']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="statement">Statement:</label>
                <div class="input-icon">
                    <textarea id="statement" name="statement" rows="5" required><?= htmlspecialchars($row['statement']) ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="official-button">Update Blotter</button>
                <a href="newblotter.php" class="cancel-button">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="js/sidebarToggle.js"></script>
<script src="js/logout.js"></script>
</body>
</html>
