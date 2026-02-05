<?php
include('connection.php');
include('sessioncheck.php');
include('header.php');
include('navi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Resident</title>
</head>
<body>

<div id="wrapper">
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="page-header">💿 Add New Resident ✨</h1>
                    <p class="tagline">"Every resident has a story."</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                    <div class="form-wrapper p-4 shadow rounded bg-light">

                        <form action="insert.php" method="POST">
                            <!-- Household Selector -->
                            <div class="form-group">
                                <label for="household_id">Household:</label>
                                <select name="household_id" class="form-control" required>
                                    <option value="">-- Select Household --</option>
                                    <?php
                                    $householdQuery = "SELECT id, head_name, household_address FROM households";
                                    $result = mysqli_query($conn, $householdQuery);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['head_name']) . ' - ' . htmlspecialchars($row['household_address']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="middle_name" class="form-control" placeholder="Middle Name">
                            </div>
                            <div class="form-group">
                                <input type="text" name="extension_name" class="form-control" placeholder="Extension Name (e.g., Jr., III)">
                            </div>
                            <div class="form-group">
                                <input type="text" name="place_of_birth" class="form-control" placeholder="Place of Birth">
                            </div>
                            <div class="form-group">
                                <input type="date" name="date_of_birth" class="form-control" placeholder="Date of Birth">
                            </div>
                            <div class="form-group">
                                <input type="number" name="age" class="form-control" placeholder="Age" min="0">
                            </div>
                            <div class="form-group">
                                <select name="sex" class="form-control" required>
                                    <option value="">Select Sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="civil_status" class="form-control" required>
                                    <option value="">Select Civil Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Separated">Separated</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" name="citizenship" class="form-control" placeholder="Citizenship">
                            </div>
                            <div class="form-group">
                                <input type="text" name="occupation" class="form-control" placeholder="Occupation">
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" name="submit" class="btn btn-success">💾 Save</button>
                                <a href="residentpage.php" class="btn btn-info">Back to Resident List</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
