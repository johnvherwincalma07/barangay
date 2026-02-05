<?php 
include('connection.php');

$resident_id = $_SESSION['resident_id'] ?? 0;
$username = $_SESSION['username'] ?? '';
$msg = "";

// Fetch user profile info
$query = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$profilePic = !empty($data['profile_photo']) ? $data['profile_photo'] : 'default.png';

// Fetch unread notifications
$notifCount = 0;
$notifResult = null;
if ($resident_id) {
    $notifQuery = $conn->prepare("SELECT * FROM notifications WHERE resident_id = ? AND status = 'unread' ORDER BY created_at DESC");
    $notifQuery->bind_param("i", $resident_id);
    $notifQuery->execute();
    $notifResult = $notifQuery->get_result();

    $countQuery = $conn->prepare("SELECT COUNT(*) AS total FROM notifications WHERE resident_id = ? AND status = 'unread'");
    $countQuery->bind_param("i", $resident_id);
    $countQuery->execute();
    $countRow = $countQuery->get_result()->fetch_assoc();
    $notifCount = $countRow['total'];
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "uploads/";
    $csrfToken = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? '';

    if (hash_equals($_SESSION['csrf_token'], $csrfToken)) {
        if (isset($_FILES["cropped_image"])) {
            $imgName = 'profile_' . time() . '.png';
            $targetPath = $targetDir . $imgName;

            if (move_uploaded_file($_FILES['cropped_image']['tmp_name'], $targetPath)) {
                $update = "UPDATE users SET profile_photo='$imgName' WHERE username='$username'";
                mysqli_query($conn, $update);
                $msg = "Profile photo updated!";
            }
            else {
                $msg = "Error uploading cropped image.";
            }
        } elseif (isset($_FILES["profile_photo"])) {
            $fileType = strtolower(pathinfo($_FILES["profile_photo"]["name"], PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($fileType, $allowedTypes)) {
                $imgName = 'profile_' . time() . '.' . $fileType;
                $targetPath = $targetDir . $imgName;

                if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $targetPath)) {
                    $update = "UPDATE users SET profile_photo='$imgName' WHERE username='$username'";
                    mysqli_query($conn, $update);
                    $msg = "Profile photo updated!";
                }
                else {
                    $msg = "Error uploading image.";
                }
            } else {
                $msg = "Invalid file type.";
            }
        }
    } else {
        $msg = "Invalid CSRF token.";
    }
}

$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$profilePic = !empty($data['profile_photo']) ? $data['profile_photo'] : 'default.png';
?>

<link rel="stylesheet" href="css/font_awesome.min.css">
<link rel="stylesheet" href="css/cropper.min.css">
    <style>
        #imagePreviewModal {
        display: none;
        position: fixed;
        z-index: 1050;
        background: rgba(0,0,0,0.8);
        top: 0; left: 0; right: 0; bottom: 0;
        justify-content: center;
        align-items: center;
        }
        #cropArea img {
        max-width: 100%;
        max-height: 80vh;
        }

        .navbar { 
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background-color: #1e1e88;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 17px;
            z-index: 1000;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            color: white;
        }

        .navbar-left img {
            max-width: 30px;
            height: 30px;
            margin-right: 10px;
        }

        .barangay-name {
            font-weight: bold;
            font-size: 16px;
            color: white;
        }


        #toggleBtn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            margin-right: 15px;
            cursor: pointer;
        }

        #sidebar {
            background-color: #2c2c6c;
            padding-top: 20px;
            margin-top: 60px;
            color: white;
            height: 100vh;
            transition: width 0.6s ease-in-out;
            overflow: hidden;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 900;
        }

        #sidebar.collapsed {
            width: 60px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            white-space: nowrap;
            position: relative;
        }

        .sidebar ul li a i {
            margin-right: 10px;
            min-width: 20px;
            text-align: center;
        }

        .sidebar.collapsed ul li a span {
            display: none;
        }

        .sidebar ul li a:hover {
            background-color: #4040a0;
            border-radius: 6px;
        }

        .navbar-right {
            position: relative;
        }

        .profile-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 25px;
            background-color: #2c2c6c;
            color: #fff;
            transition: background-color 0.3s;
        }

        .profile-wrapper:hover {
            background-color: #3a3a8c;
        }

        .profile-pic {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
        }

        .username {
            color: #fff;
            font-weight: 500;
            font-size: 14px;
        }

        .dropdown-icon {
            color: #fff;
            font-size: 14px;
        }

        .dropdown-panel {
            position: absolute;
            top: 60px;
            right: 0;
            background-color: #2c2c6c;
            width: 250px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            display: none;
            flex-direction: column;
            z-index: 999;
            overflow: hidden;
            color: white;
        }


        .profile-pic-container {
            position: relative;
            width: 110px;
            height: 110px;    
        }

        .dropdown-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px 0;
            text-align: center;
        }


        .dropdown-profile-pic {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            overflow: hidden;
        }

        .camera-icon {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 6px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-info strong {
            display: block;
            font-size: 18px;
            color: white;
        }

        #profileUpload {
            display: none;
        }

        .dropdown-divider {
            border: none;
            height: 1px;
            background-color: white;
            margin: 5px 0;
        }

        .dropdown-panel a {
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            transition: background 0.3s;
            margin-bottom: 5px;

        }
        .dropdown-panel a:hover {
            background-color: #4040a0;
        }

        .notif-icon {
    position: relative;
    cursor: pointer;
    margin-right: 15px;
}
.notif-icon .fa-bell {
    font-size: 20px;
    color: white;
}
.notif-badge {
    position: absolute;
    top: -5px;
    right: -8px;
    background: red;
    color: white;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 50%;
}
#notificationModal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 3000;
    align-items: center;
    justify-content: center;
}
.notif-box {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    width: 400px;
    max-height: 80vh;
    overflow-y: auto;
}
.notif-box button {
    margin-top: 5px;
    padding: 5px 10px;
}

    </style>

<nav class="navbar">

    <div class="navbar-left">
       <button id="toggleBtn"><i class="fa fa-bars"></i></button>
        <div class="separator"></div>
        <img src="images/bgLogo.png" alt="Barangay Amaya I Logo">
        <span class="barangay-name">Resident Portal</span>
    </div>

    <div class="navbar-right">
        <div class="profile-wrapper" onclick="toggleDropdown()">
            <img src="uploads/<?php echo $profilePic; ?>" alt="Profile" class="profile-pic" />
            <span class="username"><?php echo htmlspecialchars($data['username']); ?></span>
            <i class="fa fa-caret-down dropdown-icon"></i>
        </div>

        <div class="dropdown-panel" id="dropdownMenu">
            <div class="dropdown-header">
                <form method="POST" enctype="multipart/form-data" id="profilePicForm">
                    <label for="profileUpload" class="profile-pic-container" style="cursor: pointer;">
                        <img src="uploads/<?php echo $profilePic; ?>" alt="Profile" class="dropdown-profile-pic">
                        <div class="camera-icon"><i class="fa fa-camera"></i></div>
                        <input type="file" name="profile_photo" id="profileUpload" accept="image/*" style="display: none;">
                    </label>
                </form>
                <div class="user-info">
                    <strong><?php echo htmlspecialchars($data['username']); ?></strong>
                </div>
            </div>
            <hr class="dropdown-divider">
            <a href="#" onclick="showNotifModal()"><i class="fa fa-bell"></i> Notifications</a>
            <a href="#" onclick="showLogoutModal()"><i class="fa fa-sign-out"></i> Logout</a>
        </div>
        


    </div>   
</nav>


<div class="sidebar" id="sidebar">
    <ul class="sidebar-menu">
        <li><a href="userpage.php" data-label="Home"><i class="fa fa-fw fa-home"></i> <span>Home</span></a></li>
        <li><a href="profile.php" data-label="Profile"><i class="fa fa-fw fa-user"></i> <span>Resident Info</span></a></li>
        <li><a href="userofficial.php" data-label="Barangay Officials"><i class="fa fa-fw fa-group"></i> <span>Barangay Officials</span></a></li>
        <li><a href="userannounce.php" data-label="Announcements"><i class="fa fa-fw fa-bullhorn"></i> <span>Announcements</span></a></li>
        <li><a href="userform.php" data-label="Document Requests"><i class="fa fa-fw fa-folder"></i> <span>Document Requests</span></a></li>
    </ul>
</div>

<div id="imagePreviewModal">
    <div id="cropArea">
        <img id="imageToCrop" src="">
        <br>
        <form method="POST" enctype="multipart/form-data" id="croppedImageForm">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <button type="button" onclick="cropAndUpload()">Crop & Upload</button>
            <button type="button" onclick="closeModal()">Cancel</button>
        </form>
    </div>
</div>

<div id="changeCredentialsModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:2000; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:20px; border-radius:10px; width:400px; max-width:90%;">
        <h3>Update Credentials</h3>
        <form method="POST" action="update_credentials.php">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div>
                <label>New Username</label>
                <input type="text" name="new_username" required class="form-control">
            </div>
            <div>
                <label>New Password</label>
                <input type="password" name="new_password" required class="form-control">
            </div>
            <div style="margin-top:10px; display:flex; justify-content:end; gap:10px;">
                <button type="button" onclick="closeCredentialModal()" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Notification Modal -->
<div id="notificationModal">
    <div class="notif-box">
        <h3>Notifications</h3>
        <hr>
        <?php if ($notifResult && $notifResult->num_rows > 0): ?>
            <?php while ($notif = $notifResult->fetch_assoc()): ?>
                <div style="margin-bottom: 10px;">
                    <p><?= htmlspecialchars($notif['message']) ?></p>
                    <small><?= date("F j, Y, g:i A", strtotime($notif['created_at'])) ?></small>
                    <form method="POST" action="mark_read.php">
                        <input type="hidden" name="notification_id" value="<?= $notif['notification_id'] ?>">
                        <button type="submit">Mark as Read</button>
                    </form>
                </div>
                <hr>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No new notifications.</p>
        <?php endif; ?>
        <button onclick="closeNotifModal()">Close</button>
    </div>
</div>

<script>
function showNotifModal() {
    document.getElementById("notificationModal").style.display = "flex";
}
function closeNotifModal() {
    document.getElementById("notificationModal").style.display = "none";
}
function toggleDropdown() {
    // implement dropdown logic if needed
}
</script>

<script src="js/cropper.min.js"></script>
<script>
let cropper;

    document.getElementById('profileUpload').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function () {
        document.getElementById('imageToCrop').src = reader.result;
        document.getElementById('imagePreviewModal').style.display = 'flex';
        if (cropper) cropper.destroy();
        cropper = new Cropper(document.getElementById('imageToCrop'), {
            aspectRatio: 1,
            viewMode: 1
        });
        };
        reader.readAsDataURL(file);
    }
    });

    function cropAndUpload() {
    const canvas = cropper.getCroppedCanvas({
        width: 300,
        height: 300,
    });

    canvas.toBlob(function (blob) {
        const formData = new FormData(document.getElementById('croppedImageForm'));
        formData.append('cropped_image', blob);

        fetch('', {
        method: 'POST',
        body: formData,
        }).then(res => res.text())
        .then(data => {
            alert('Profile updated!');
            window.location.reload();
        });
    });
    }

    function closeModal() {
    document.getElementById('imagePreviewModal').style.display = 'none';
    if (cropper) cropper.destroy();
    }

    function toggleDropdown() {
        const menu = document.getElementById("dropdownMenu");
        menu.style.display = menu.style.display === "flex" ? "none" : "flex";
    }

    window.addEventListener('click', function(e) {
        const menu = document.getElementById("dropdownMenu");
        const profileWrapper = document.querySelector(".profile-wrapper");
        if (!profileWrapper.contains(e.target) && !menu.contains(e.target)) {
            menu.style.display = "none";
        }
    });

</script>

<script>
function showNotifModal() {
    document.getElementById('notificationModal').style.display = 'flex';
}

function closeNotifModal() {
    document.getElementById('notificationModal').style.display = 'none';
}
</script>


