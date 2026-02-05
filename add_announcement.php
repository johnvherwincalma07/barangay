<?php
include('connection.php');
include('sessioncheck.php');
include('newnavi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $message = mysqli_real_escape_string($conn, $_POST['content']);
    $event_date = mysqli_real_escape_string($conn, $_POST['date']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    $sql = "INSERT INTO announcements (title, content, date, location) 
            VALUES ('$title', '$message', '$event_date', '$location')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('✅ Announcement posted successfully!'); window.location='newannounce.php';</script>";
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Announcement</title>
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
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
            resize: vertical;
            transition: border-color 0.2s;
        }

        input:focus,
        textarea:focus {
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
            background-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
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
        <h2 class="text-center">Add Announcement</h2>
        <form method="POST">

            <label>Title:</label>
            <input type="text" name="title" required class="form-control">

            <label>Content:</label>
            <textarea name="content" rows="5" required class="form-control"></textarea>

            <label>Date:</label>
            <input type="date" name="date" required class="form-control">

            <label>Location:</label>
            <input type="text" name="location" required class="form-control">


            <button type="submit" class="btn btn-success">Post Announcement</button>
            <a href="newannounce.php" class="btn btn-info">Back</a>
        </form>
    </div>
</div>
<script src="js/sidebarToggle.js"></script>
</body>
</html>
