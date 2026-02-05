<?php
include('connection.php');
include('sessioncheck.php');
include('newnavi.php');

$query = "SELECT * FROM requests ORDER BY request_id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Form Requests</title>
    <link rel="stylesheet" href="style/user/personstyle.css">
    <link rel="stylesheet" href="style/admin/style_docu.css">
    <style>
        .btn {
            display: inline-block;
            padding: 7px 12px;
            font-size: 13px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            cursor: pointer;
            color: #fff;
        }

        .btn-approve { background-color: #28a745; }
        .btn-approve:hover { background-color: #218838; }

        .btn-send { background-color: #ffc107; color: #000; }
        .btn-send:hover { background-color: #e0a800; color: #000; }

        .btn-done { background-color: #007bff; }
        .btn-done:hover { background-color: #0069d9; }

        .btn-view { background-color: #17a2b8; }
        .btn-view:hover { background-color: #138496; }

        .status-badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 13px;
            color: #fff;
        }

        .status-pending { background-color: #6c757d; }
        .status-approved { background-color: #28a745; }
        .status-sent { background-color: #ffc107; color: #000; }
        .status-done { background-color: #007bff; }

        .custom-table th, .custom-table td {
            padding: 8px 10px;
            font-size: 14px;
            text-align: left;
        }

        .table-container {
            overflow-x: auto;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="text-center mb-4">
            <h1>Barangay Form Requests</h1>
            <p class="tagline">Catch the vibe, stay for the sparkle.</p>
        </div>

        <div class="table-container">
            <table class="custom-table" border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Form Type</th>
                        <th>Purpose</th>
                        <th>Date Needed</th>
                        <th>Requested On</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['request_id'] ?></td>
                        <td><?= htmlspecialchars($row['fullname']) ?></td>
                        <td><?= htmlspecialchars($row['form_type']) ?></td>
                        <td><?= htmlspecialchars($row['purpose']) ?></td>
                        <td><?= htmlspecialchars($row['date_needed']) ?></td>
                        <td><?= date('F j, Y g:i A', strtotime($row['request_date'])) ?></td>
                        <td>
                            <?php
                            $status = $row['status'] ?? 'Pending';
                            $badgeClass = match ($status) {
                                'Approved' => 'status-approved',
                                'Sent'     => 'status-sent',
                                'Done'     => 'status-done',
                                default    => 'status-pending',
                            };
                            ?>
                            <span class="status-badge <?= $badgeClass ?>"><?= $status ?></span>
                        </td>
                        <td>
                            <a href="view_form.php?request_id=<?= $row['request_id'] ?>" class="btn btn-view">View</a>

                            <?php if ($status === 'Pending'): ?>
                                <a href="update_status.php?id=<?= $row['request_id'] ?>&status=Approved" class="btn btn-approve">Approve</a>
                            <?php elseif ($status === 'Approved'): ?>
                                <a href="update_status.php?id=<?= $row['request_id'] ?>&status=Sent" class="btn btn-send">Send</a>
                            <?php elseif ($status === 'Sent'): ?>
                                <a href="update_status.php?id=<?= $row['request_id'] ?>&status=Done" class="btn btn-done">Done</a>
                            <?php else: ?>
                                <span style="color: gray;">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="js/sidebarToggle.js"></script>
<script src="js/logout.js"></script>
</body>
</html>
