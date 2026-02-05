<?php 
include('connection.php');
include('sessioncheck.php');

// Redirect if no ID or invalid ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: newannounce.php");
    exit;
}

$id = intval($_GET['id']);

// Fetch current announcement
$stmt = $conn->prepare("SELECT * FROM announcements WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>❌ Announcement not found.</p>";
    exit;
}

$row = $result->fetch_assoc();

// Handle form submission before output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $date = $_POST['date'];
    $location = trim($_POST['location']);

    if ($title && $content && $date && $location) {
        $updateQuery = "UPDATE announcements SET title = ?, content = ?, date = ?, location = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ssssi", $title, $content, $date, $location, $id);

        if ($updateStmt->execute()) {
            header("Location: newannounce.php?update=success");
            exit;
        } else {
            $error = "❌ Failed to update the announcement.";
        }
    } else {
        $error = "❌ All fields are required.";
    }
}

include('newnavi.php'); // Include only after processing headers
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Announcement</title>
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

        .input-icon input,
        .input-icon textarea {
            width: 100%;
            padding: 10px 10px 10px 10px;
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

        .official-button {
            background: #0077b6;
            color: #fff;
            padding: 10px 18px;
            margin-top: 25px;
            margin-right: 10px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
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
            margin-top: 25px;
            margin-right: 10px;
            cursor: pointer;
            border: none;
        }

        .cancel-button:hover {
            background-color: #5a6268;
        }

        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row text-center">
            <div class="col-lg-12">
                <h1 class="page-header">Edit Announcement</h1>
                <?php if (isset($error)): ?>
                    <p class="error-message"><?= $error ?></p>
                <?php endif; ?>
            </div>
        </div>

        <form method="POST">
            <div class="form-group">
                <label for="title">Title:</label>
                <div class="input-icon">
                    <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($row['title']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="content">Content:</label>
                <div class="input-icon">
                    <textarea id="content" name="content" class="form-control" rows="5" required><?= htmlspecialchars($row['content']) ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="date">Event Date:</label>
                <div class="input-icon">
                    <input type="date" id="date" name="date" class="form-control" value="<?= $row['date'] ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <div class="input-icon">
                    <input type="text" id="location" name="location" class="form-control" value="<?= htmlspecialchars($row['location']) ?>" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="update" class="official-button">Update Announcement</button>
                <a href="newannounce.php" class="cancel-button">Cancel</a>
            </div>
        </form>
    </div>
</div>
<script src="js/sidebarToggle.js"></script>
</body>
</html>
