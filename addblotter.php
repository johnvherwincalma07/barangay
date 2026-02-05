<?php
include('connection.php');
include('sessioncheck.php');
include('newnavi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date_filed = mysqli_real_escape_string($conn, $_POST['date_filed']);
    $complainant = mysqli_real_escape_string($conn, $_POST['complainant']);
    $complainant_address = mysqli_real_escape_string($conn, $_POST['complainant_address']);
    $complainant_cellno = mysqli_real_escape_string($conn, $_POST['complainant_cellno']);
    $respondent = mysqli_real_escape_string($conn, $_POST['respondent']);
    $respondent_address = mysqli_real_escape_string($conn, $_POST['respondent_address']);
    $respondent_cellno = mysqli_real_escape_string($conn, $_POST['respondent_cellno']);
    $about = mysqli_real_escape_string($conn, $_POST['about']);

    $sql = "INSERT INTO blotter (date_filed, complainant, complainant_address, complainant_cellno, respondent, respondent_address, respondent_cellno, about) 
            VALUES ('$date_filed', '$complainant', '$complainant_address', '$complainant_cellno', '$respondent', '$respondent_address', '$respondent_cellno', '$about')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('✅ Blotter added successfully!'); window.location='newblotter.php';</script>";
    } else {
        echo "<p style='color:red;'>❌ Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Blotter</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <style>
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .input-icon input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #f1f5ff;
            outline: none;
            box-sizing: border-box;
        }

        .form-actions {
            margin-top: 30px;
            text-align: center;
        }

        .blotter-button {
            background: #0077b6;
            color: #fff;
            padding: 10px 18px;
            margin-top: 25px;
            margin-right: 10px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .blotter-button:hover {
            background: #005f8d;
        }

        .cancel-button {
            background-color: #6c757d;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 15px;
            margin-top: 25px;
            margin-right: 10px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        .cancel-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">
        <h2>Add Blotter</h2>
        <form method="POST">

            <div class="form-group">
                <label for="date_filed">Date Filed:</label>
                <div class="input-icon">
                    <input type="date" id="date_filed" name="date_filed" required>
                </div>
            </div>

            <div class="form-group">
                <label for="complainant">Complainant:</label>
                <div class="input-icon">
                    <input type="text" id="complainant" name="complainant" required>
                </div>
            </div>

            <div class="form-group">
                <label for="complainant_address">Complainant's Address:</label>
                <div class="input-icon">
                    <input type="text" id="complainant_address" name="complainant_address" required>
                </div>
            </div>

            <div class="form-group">
                <label for="complainant_cellno">Complainant's Cellphone No.:</label>
                <div class="input-icon">
                    <input type="text" id="complainant_cellno" name="complainant_cellno" required>
                </div>
            </div>

            <div class="form-group">
                <label for="respondent">Respondent:</label>
                <div class="input-icon">
                    <input type="text" id="respondent" name="respondent" required>
                </div>
            </div>

            <div class="form-group">
                <label for="respondent_address">Respondent's Address:</label>
                <div class="input-icon">
                    <input type="text" id="respondent_address" name="respondent_address" required>
                </div>
            </div>

            <div class="form-group">
                <label for="respondent_cellno">Respondent's Cellphone No.:</label>
                <div class="input-icon">
                    <input type="text" id="respondent_cellno" name="respondent_cellno" required>
                </div>
            </div>

            <div class="form-group">
                <label for="about">About:</label>
                <div class="input-icon">
                    <input type="text" id="about" name="about" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="blotter-button">Submit</button>
                <a href="newblotter.php" class="cancel-button">Cancel</a>
            </div>
        </form>
    </div>
</div>
<script src="js/sidebarToggle.js"></script>
<script src="js/logout.js"></script>
</body>
</html>
