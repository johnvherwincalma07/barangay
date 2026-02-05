<?php 
include('connection.php');
session_start();

$modalMessage = '';
$redirectUrl = 'index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                $_SESSION['resident_id'] = null;
                $modalMessage = 'Logging in as Admin...';
                $redirectUrl = 'newadmin.php';
            } else {
                if (!empty($user['resident_id'])) {
                    $_SESSION['resident_id'] = $user['resident_id'];
                } else {
                    $user_id = $user['user_id'];
                    $stmt2 = $conn->prepare("SELECT resident_id FROM residents WHERE user_id = ?");
                    $stmt2->bind_param("i", $user_id);
                    $stmt2->execute();
                    $res = $stmt2->get_result();
                    if ($res->num_rows === 1) {
                        $resident = $res->fetch_assoc();
                        $_SESSION['resident_id'] = $resident['resident_id'];

                        // Update user table to link resident_id
                        $update = $conn->prepare("UPDATE users SET resident_id = ? WHERE user_id = ?");
                        $update->bind_param("ii", $resident['resident_id'], $user_id);
                        $update->execute();
                        $update->close();
                    } else {
                        $_SESSION['resident_id'] = null;
                    }
                    $stmt2->close();
                }

                $modalMessage = 'Logging in as Resident...';
                $redirectUrl = 'userpage.php';
            }
        } else {
            $modalMessage = 'Incorrect password.';
        }
    } else {
        $modalMessage = 'User not found.';
    }

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logging In</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-box {
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 0 15px rgba(0,0,0,0.25);
            text-align: center;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin: 20px auto;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<?php if (!empty($modalMessage)): ?>
    <div class="modal-overlay" id="customModal">
        <div class="modal-box">
            <h2><?= htmlspecialchars($modalMessage) ?></h2>
            <div class="loader"></div>
        </div>
    </div>
    <script>
        window.onload = function() {
            document.getElementById('customModal').style.display = 'flex';
            setTimeout(() => {
                window.location.href = '<?= $redirectUrl ?>';
            }, 2500);
        };
    </script>
<?php endif; ?>
</body>
</html>
