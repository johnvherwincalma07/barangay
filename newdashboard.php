<?php     
include('connection.php');
include('sessioncheck.php');
include('newnavi.php');

$households = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM households"))['total'];
$residents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM residents"))['total'];
$blotters = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM blotter"))['total'];
$documents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM requests"))['total'];

$male_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM residents WHERE sex = 'Male'"))['total'];
$female_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM residents WHERE sex = 'Female'"))['total'];

$age_groups = [
    '0-17' => "age BETWEEN 0 AND 17",
    '18-35' => "age BETWEEN 18 AND 35",
    '36-59' => "age BETWEEN 36 AND 59",
    '60+' => "age >= 60"
];
$age_data = [];
foreach ($age_groups as $label => $condition) {
    $age_data[$label] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM residents WHERE $condition"))['total'];
}

$employment_statuses = ['Employed', 'Unemployed', 'Student', 'Retired'];
$employment_data = [];
foreach ($employment_statuses as $status) {
    $employment_data[$status] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM residents WHERE employment_status = '$status'"))['total'];
}

$classification_data = [
    'OFW' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM residents WHERE classification = 'OFW'"))['total'],
    'Solo Parent' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM residents WHERE classification = 'Solo Parent'"))['total'],
    'Out-of-School Youth' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM residents WHERE classification = 'Out-of-School Youth'"))['total'],
    'Out-of-School Children' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM residents WHERE classification = 'Out-of-School Children'"))['total'],
    'PWD' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM residents WHERE classification = 'PWD'"))['total']
];

$doc_type_counts = [
    'Barangay Clearance' => 0,
    'Residency Certificate' => 0,
    'Indigency Certificate' => 0
];

foreach ($doc_type_counts as $type => &$count) {
    $escaped_type = mysqli_real_escape_string($conn, $type);
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM requests WHERE form_type = '$escaped_type'");
    $count = mysqli_fetch_assoc($result)['total'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/font_awesome.min.css">
    <link rel="stylesheet" href="style/user/personstyle.css">
    <link rel="stylesheet" href="style/admin/style_dashboard.css">
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">

        <div class="text-center mb-4">
            <h1>Barangay Dashboard</h1>
            <p class="tagline">Catch the vibe, stay for the sparkle.</p>
        </div>

        <div class="flex-row">
            <div class="flex-column quarter">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $households ?></h3>
                        <p>Households</p>
                    </div>
                    <div class="icon"><i class="fa fa-home"></i></div>
                </div>
            </div>
            <div class="flex-column quarter">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $residents ?></h3>
                        <p>Residents</p>
                    </div>
                    <div class="icon"><i class="fa fa-users"></i></div>
                </div>
            </div>
            <div class="flex-column quarter">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $blotters ?></h3>
                        <p>Blotter Reports</p>
                    </div>
                    <div class="icon"><i class="fa fa-file-text"></i></div>
                </div>
            </div>
            <div class="flex-column quarter">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $documents ?></h3>
                        <p>Document Requests</p>
                    </div>
                    <div class="icon"><i class="fa fa-file"></i></div>
                </div>
            </div>
        </div> 


        <h2>🏠 All Incoming Datas</h2>
        <div class="flex-row">
            <div class="summary-chart-column">
                <div class="card">
                    <h4 class="text-center">📊 Summary Chart</h4>
                    <canvas id="summaryChart"></canvas>
                </div>
            </div>
        </div>

        <h2>🏠 Household & Resident Data</h2>
        <div class="flex-row">
            <div class="flex-column half">
                <div class="card">
                    <h4 class="text-center">👫 Sex Distribution</h4>
                    <canvas id="genderChart"></canvas>
                </div>
            </div>

            <div class="flex-column half">
                <div class="card">
                    <h4 class="text-center">📈 Age Distribution</h4>
                    <canvas id="ageChart"></canvas>
                </div>
            </div>
        </div>

        <div class="flex-row">
            <div class="flex-column half">
                <div class="card">
                    <h4 class="text-center">💼 Employment Status</h4>
                    <canvas id="employmentChart"></canvas>
                </div>
            </div>

            <div class="flex-column half">
                <div class="card">
                    <h4 class="text-center">🧬 Resident Classification</h4>
                    <canvas id="classificationChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Document Requests Charts -->
        <h2>📄 Document Requests</h2>
        <div class="flex-row">
            <div class="document-chart-column">
                <div class="card">
                    <h4 class="text-center">📄 Document Request Status</h4>
                    <canvas id="documentChart"></canvas>
                </div>
            </div>
        </div>


    </div>
</div>

<div class="modal-overlay" id="logoutModal">
    <div class="modal-box" id="logoutModalContent">
        <h3>Are you sure you want to log out?</h3>
        <div class="modal-buttons">
            <button class="yes" onclick="confirmLogout()">Yes</button>
            <button class="cancel" onclick="closeLogoutModal()">Cancel</button>
        </div>
    </div>
</div>

<!-- Chart Scripts -->
<script>
    const summaryChartData = {
        labels: ['Households', 'Residents', 'Blotters', 'Document Requests'],
        datasets: [{
            label: 'Total Records',
            data: [<?= $households ?>, <?= $residents ?>, <?= $blotters ?>, <?= $documents ?>],
            backgroundColor: ['#17a2b8', '#28a745', '#dc3545', '#f59f00']
        }]
    };
    
    const genderChartData = {
        labels: ['Male', 'Female'],
        datasets: [{
            data: [<?= $male_count ?>, <?= $female_count ?>],
            backgroundColor: ['#36A2EB', '#FF6384']
        }]
    };

    const ageChartData = {
        labels: ['0-17', '18-35', '36-59', '60+'],
        datasets: [{
            data: [<?= $age_data['0-17'] ?>, <?= $age_data['18-35'] ?>, <?= $age_data['36-59'] ?>, <?= $age_data['60+'] ?>],
            backgroundColor: ['#FFCE56', '#36A2EB', '#FF6384', '#8BC34A']
        }]
    };

    const employmentChartData = {
        labels: ['Employed', 'Unemployed', 'Student', 'Retired'],
        datasets: [{
            data: [
                <?= $employment_data['Employed'] ?>,
                <?= $employment_data['Unemployed'] ?>,
                <?= $employment_data['Student'] ?>,
                <?= $employment_data['Retired'] ?>
            ],
            backgroundColor: ['#4BC0C0', '#FF9F40', '#9966FF', '#C9CBCF']
        }]
    };

        const classificationChartData = {
        labels: ['OFW', 'Solo Parent', 'Out-of-School Youth', 'Out-of-School Children', 'PWD'],
        datasets: [{
            data: [
                <?= $classification_data['OFW'] ?>,
                <?= $classification_data['Solo Parent'] ?>,
                <?= $classification_data['Out-of-School Youth'] ?>,
                <?= $classification_data['Out-of-School Children'] ?>,
                <?= $classification_data['PWD'] ?>
            ],
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#8BC34A', '#9966FF']
        }]
    };


        const documentChartData = {
        labels: ['Barangay Clearance', 'Residency Certificate', 'Indigency Certificate'],
        datasets: [{
            data: [<?= $doc_type_counts['Barangay Clearance'] ?>, <?= $doc_type_counts['Residency Certificate'] ?>, <?= $doc_type_counts['Indigency Certificate'] ?>],
            backgroundColor: ['#36A2EB', '#FFCE56', '#FF6384']
        }]
    };
    

</script>
    <script src="js/sidebarToggle.js"></script>
    <script src="js/Charts.js"></script>
    <script src="js/chart.min.js"></script>
    <script src="js/logout.js"></script>
</body>
</html>
