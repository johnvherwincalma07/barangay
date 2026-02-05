<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: newadmin.php");
    exit();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Amaya Uno Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="style/loginstyles.css">
</head>
<body>
<nav class="navbar">
    <a href="index.php" class="navbar-left">
        <img src="images/bgLogo.png" alt="Barangay Amaya I Logo">
        <span class="barangay-name">Barangay Portal - Bunga, Tanza, Cavite</span>
    </a>

    <div class="navbar-right">
        <a href="index.php">HOME</a>
        <a href="index.php#about">ABOUT</a>
        <a href="registerform.php">REGISTER</a>
        <a href="loginpage.php">LOGIN</a>
    </div>
</nav>
<div class="panel-container">
    <div class="panel-left">
        <img src="images/bgLogo.png" alt="Barangay Amaya I Logo">
        <h1>Barangay Bunga, Tanza, Cavite</h1>
        <p>Welcome to the portal!</p>
    </div>
    <div class="panel-right">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username" placeholder="Enter username" autocomplete="username" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Enter password" autocomplete="current-password" required>
                </div>
            </div>

            <button type="submit">Login</button>
            <hr>

            <div class="register-link">
                <p>Don't have an account? <a href="registerform.php" class="btn-register">Register</a></p>
            </div>
        </form>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
    const animatedElement = document.querySelector('.panel-container');
    if (animatedElement) {
        animatedElement.classList.add('start-animation');
    }
});
</script>

</body>
</html>
