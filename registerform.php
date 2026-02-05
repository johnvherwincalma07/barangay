<?php   
    session_start();

    if (isset($_SESSION['username'])) {
        header("Location: admin.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Portal - Register</title>
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="style/home/registerstyle.css">
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
        <h2>Register Residents</h2>
        <h2>RBI Form A (Revised 2024)</h2>

    <form action="register.php" method="post">
        <h3>User Account</h3>

        <div class="form-group">
            <label for="username">Username:</label>
            <div class="input-icon">
                <i class="fas fa-user"></i>
                <input type="text" id="username" name="username" required>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <div class="input-icon">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" required>
            </div>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <div class="input-icon">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" required>
            </div>
        </div>

        <div class="form-group">
            <label for="password">Confirm Password:</label>
            <div class="input-icon">
                <i class="fas fa-lock"></i>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
        </div>

        <h3>Household Information</h3>

        <div class="form-group">
            <label for="region">Region:</label>
            <div class="input-icon">
                <i class="fas fa-home"></i>
                <input type="text" id="region" name="region" required>
            </div>
        </div>

        <div class="form-group">
            <label for="province">Province:</label>
            <div class="input-icon">
                <i class="fas fa-home"></i>
                <input type="text" id="province" name="province" required>
            </div>
        </div>

        <div class="form-group">
            <label for="municipality">City/Municipality:</label>
            <div class="input-icon">
                <i class="fas fa-home"></i>
                <input type="text" id="city_municipality" name="city_municipality" required>
            </div>
        </div>

        <div class="form-group">
            <label for="barangay">Barangay:</label>
            <div class="input-icon">
                <i class="fas fa-home"></i>
                <input type="text" id="barangay" name="barangay" required>
            </div>
        </div>

        <div class="form-group">
            <label for="household_address">Household Address:</label>
            <div class="input-icon">
                <i class="fas fa-home"></i>
                <input type="text" id="household_address" name="household_address" required>
            </div>
        </div>

        <div class="form-group">
            <label for="no_of_members">No. of Household Members:</label>
            <div class="input-icon">
                <i class="fas fa-hashtag"></i>
                <input type="number" id="no_of_members" name="no_of_members" required>
            </div>
        </div>

        <h3>Basic Information</h3>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <div class="input-icon">
                <i class="fas fa-user-tag"></i>
                <input type="text" id="last_name" name="last_name" required>
            </div>
        </div>

        <div class="form-group">
            <label for="first_name">First Name:</label>
            <div class="input-icon">
                <i class="fas fa-user-tag"></i>
                <input type="text" id="first_name" name="first_name" required>
            </div>
        </div>

        <div class="form-group">
            <label for="middle_name">Middle Name:</label>
            <div class="input-icon">
                <i class="fas fa-user-tag"></i>
                <input type="text" id="middle_name" name="middle_name">
            </div>
        </div>

        <div class="form-group">
            <label for="name_extension">Name Extension (e.g., Jr.):</label>
            <div class="input-icon">
                <i class="fas fa-user-plus"></i>
                <input type="text" id="name_extension" name="name_extension">
            </div>
        </div>

        <div class="form-group">
            <label for="place_of_birth">Place of Birth;</label>
            <div class="input-icon">
                <i class="fas fa-globe"></i>
                <input type="text" id="place_of_birth" name="place_of_birth" required>
            </div>
        </div>

        <div class="form-group">
            <label for="date_of_birth">Date of Birth:</label>
            <div class="input-icon">
                <i class="fas fa-calendar"></i>
                <input type="date" id="date_of_birth" name="date_of_birth" required>
            </div>
        </div>

        <div class="form-group">
            <label for="age">Age:</label>
            <div class="input-icon">
                <i class="fas fa-hourglass-half"></i>
                <input type="number" id="age" name="age" min="0" required>
            </div>
        </div>

        <div class="form-group">
            <label for="sex">Sex:</label>
            <div class="input-flex">
                <i class="fas fa-venus-mars"></i>
                <select name="sex" id="sex" required>
                    <option value="">Select Sex</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="civil_status">Civil Status:</label>
            <div class="input-flex">
                <i class="fas fa-ring"></i>
                <select name="civil_status" id="civil_status" required>
                    <option value="">Select Status</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Separated">Separated</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="citizenship">Citizenship:</label>
            <div class="input-icon">
                <i class="fas fa-flag"></i>
                <input type="text" id="citizenship" name="citizenship" required>
            </div>
        </div>

        <div class="form-group">
            <label for="occupation">Occupation:</label>
            <div class="input-icon">
                <i class="fas fa-briefcase"></i>
                <input type="text" id="occupation" name="occupation">
            </div>
        </div>

        <div class="form-group">
            <label for="employment_status">Employment Status:</label>
            <div class="input-flex">
                <i class="fas fa-id-badge"></i>
                <select name="employment_status" id="employment_status">
                    <option value="">Select Employment</option>
                    <option value="Employed">Employed</option>
                    <option value="Unemployed">Unemployed</option>
                    <option value="Self-employed">Self-employed</option>
                    <option value="Student">Student</option>
                    <option value="Retired">Retired</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="classification">Classification (e.g. OFW, PWD, Out of school youth):</label>
            <div class="input-icon">
                <i class="fas fa-layer-group"></i>
                <input type="text" id="classification" name="classification" required>
            </div>
        </div>

        <div class="form-group">
            <label for="current_address">Address:</label>
            <div class="input-icon">
                <i class="fas fa-map-marker-alt"></i>
                <input type="text" id="current_address" name="current_address" required>
            </div>
        </div>

        <div class="form-group" style="margin-top: 20px; background: #f0f8ff; padding: 15px; border-left: 4px solid #007BFF; font-size: 14px;">
            <strong>RBI Form A (Revised 2024):</strong><br>
            I hereby certify that the above information are true and correct to the best of my knowledge. I understand that for the Barangay to carry out its mandate pursuant to Section 394 (d)(6) of the Local Government Code of 1991, they must necessarily process my personal information for easy identification of inhabitants, as a basis in local planning, and as an updated reference in the number of inhabitants of the Barangay. Therefore, I grant my consent and recognize the authority of the Barangay to process my personal information, subject to the provision of the Philippine Data Privacy Act of 2012.
        </div>

        <div class="form-group" style="margin-top: 10px;">
            <label style="font-size: 14px;">
                <input type="checkbox" name="consent" required>
                I agree to the above terms and certify the information provided.
            </label>
        </div>

        <button type="submit">Register</button>
        <a href="loginpage.php" class="btn-back">Back to Login</a>
    </form>

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
