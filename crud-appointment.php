<?php
include('db_config.php'); 

if (isset($_POST['update_status'])) {
    $appointment_id = $_POST['appointment_id'];
    $status = $_POST['status'];

    $appointment_id = mysqli_real_escape_string($conn, $appointment_id);
    $status = mysqli_real_escape_string($conn, $status);

    // Update the status of the appointment in the database
    $query = "UPDATE appointments SET status = '$status' WHERE id = '$appointment_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Status updated successfully.'); window.location.href='crud-appointment.php';</script>";
    } else {
        echo "<script>alert('Error updating status: " . mysqli_error($conn) . "'); window.location.href='crud-appointment.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments - Care Compass Hospitals</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e9f7fc;  
            font-family: 'Roboto', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .table th, .table td {
            text-align: center;
            background-color:#ffff;
        }

        .back-btn {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>


<div class="container mt-5">
    <a href="admin_dashboard.php" class="btn btn-secondary back-btn">Back to Dashboard</a>

    <h2>Manage Appointments</h2>

    <!-- Table displaying appointments -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Patient Email</th>
                <th>Doctor ID</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch all appointments from the database
            $query = "SELECT * FROM appointments";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['patient_name'] . "</td>";
                echo "<td>" . $row['patient_email'] . "</td>";
                echo "<td>" . $row['doctor_id'] . "</td>";
                echo "<td>" . $row['appointment_date'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>
                        <form method='POST' action='crud-appointment.php'>
                            <select name='status' class='form-select'>
                                <option value='Pending' " . ($row['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                                <option value='Completed' " . ($row['status'] == 'Completed' ? 'selected' : '') . ">Completed</option>
                                <option value='Cancelled' " . ($row['status'] == 'Cancelled' ? 'selected' : '') . ">Cancelled</option>
                            </select>
                            <input type='hidden' name='appointment_id' value='" . $row['id'] . "'>
                            <button type='submit' name='update_status' class='btn btn-primary'>Update</button>
                        </form>
                    </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Footer -->
<footer class="bg-light text-center py-3 mt-5">
    <p class="mb-0">&copy; 2025 Care Compass Hospitals. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
