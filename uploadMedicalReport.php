<?php
include('db_config.php');

if (isset($_POST['add_report'])) {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $report_title = $_POST['report_title'];
    $report_details = $_POST['report_details'];


    
    // Insert the report into the medical_reports table
    $query = "INSERT INTO medical_reports (id, report_title, report_details, doctor_id) 
              VALUES ('$patient_id', '$report_title', '$report_details', '$doctor_id')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Medical report added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$query = "SELECT id, name, email FROM users WHERE role = 'patient'";
$patients_result = mysqli_query($conn, $query);

$query_doctors = "SELECT id, name FROM doctors";
$doctors_result = mysqli_query($conn, $query_doctors);

$query_reports = "SELECT mr.report_id, u.name AS patient_name, mr.doctor_id, mr.report_title, mr.report_details 
                  FROM medical_reports mr 
                  JOIN users u ON mr.id = u.id";
$reports_result = mysqli_query($conn, $query_reports);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #e9f7fc;
        }
        h2 {
            color: #333;
        }
        .container {
            margin-top: 20px;
        }
        .table th, .table td {
            text-align: center;
            background-color:#ffff;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
        }
    </style>
</head>
<body>
<a href="staff_dashboard.php" class="btn btn-secondary back-btn">Back to Dashboard</a>
<div class="container">
    <h2>Manage Medical Reports</h2>

    <!-- Form to Add Medical Report -->
    <div class="form-container">
        <form method="POST" action="uploadMedicalReport.php">
            <div class="mb-3">
                <label for="patient_id" class="form-label">Select Patient:</label>
                <select name="patient_id" class="form-select" required>
                    <option value="">Select Patient</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($patients_result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . " (" . $row['email'] . ")</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="doctor_id" class="form-label">Select Doctor:</label>
                <select name="doctor_id" class="form-select" required>
                    <option value="">Select Doctor</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($doctors_result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="report_title" class="form-label">Report Title:</label>
                <input type="text" name="report_title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="report_details" class="form-label">Report Details:</label>
                <textarea name="report_details" rows="5" class="form-control" required></textarea>
            </div>

            <button type="submit" name="add_report" class="btn btn-success">Add Report</button>
        </form>
    </div>

    <h3>All Medical Reports</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Report ID</th>
                <th>Patient Name</th>
                <th>Doctor Name</th>
                <th>Report Title</th>
                <th>Report Details</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display all medical reports
            while ($row = mysqli_fetch_assoc($reports_result)) {
                echo "<tr>";
                echo "<td>" . $row['report_id'] . "</td>";
                echo "<td>" . $row['patient_name'] . "</td>";

                $doctor_name = '';
                mysqli_data_seek($doctors_result, 0); 
                while ($doctor = mysqli_fetch_assoc($doctors_result)) {
                    if ($doctor['id'] == $row['doctor_id']) {
                        $doctor_name = $doctor['name'];
                        break;
                    }
                }
                echo "<td>" . $doctor_name . "</td>";
                echo "<td>" . $row['report_title'] . "</td>"; 
                echo "<td>" . $row['report_details'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
