<?php
session_start();

include('db_config.php');

if (!isset($_SESSION['user_id'])) {
    die("You need to be logged in to view your medical reports.");
}

$patient_id = $_SESSION['user_id'];

// Query to fetch patient details
$patient_sql = "SELECT * FROM users WHERE id = ?";
$patient_stmt = $conn->prepare($patient_sql);
$patient_stmt->bind_param("i", $patient_id); 
$patient_stmt->execute();
$patient_result = $patient_stmt->get_result();
$patient = $patient_result->fetch_assoc();

// Query to fetch reports for the current patient
$sql = "SELECT * FROM medical_reports WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id); 
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Medical Reports</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css"> 

    <style>
        body {
            background-color: #f4f7fc; 
        }

        .back-button {
            margin-bottom: 20px;
            background-color: #65befd;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            
        }

        .back-button:hover {
            background-color: #4ca3d3;
        }

        table th {
            background-color: #65befd; 
            color: white;
        }

        table td a {
            color: #007bff;
        }

        table td a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <h2 class="text-center">Your Medical Reports</h2>

    <div >
        <a href="patient_dashboard.php" class="btn back-button">Back to Dashboard</a>
    </div>

    <!-- Display Patient Details -->
    <div class="row">
        <div class="col-md-6">
            <h4>Patient Details</h4>
            <ul>
                <li><strong>Name:</strong> <?php echo $patient['name']; ?></li>
                <li><strong>Email:</strong> <?php echo $patient['email']; ?></li>
                <li><strong>Phone:</strong> <?php echo $patient['phone']; ?></li>
            </ul>
        </div>
    </div>

    <!-- Display Reports -->
    <?php
    if ($result->num_rows > 0) {
        echo "<table class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Report Title</th>
                        <th>Report File</th>
                        <th>Report Date</th>
                        <th>Doctor ID</th>
                        <th>Report Details</th>
                    </tr>
                </thead>
                <tbody>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["report_id"] . "</td>
                    <td>" . $row["report_title"] . "</td>
                    <td><a href='reports/" . $row["report_file"] . "' target='_blank'>" . $row["report_file"] . "</a></td>
                    <td>" . $row["report_date"] . "</td>
                    <td>" . $row["doctor_id"] . "</td>
                    <td>" . $row["report_details"] . "</td>
                </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p class='text-center'>No reports found for this patient.</p>";
    }

    $stmt->close();
    $patient_stmt->close();
    $conn->close();
    ?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

</body>
</html>
