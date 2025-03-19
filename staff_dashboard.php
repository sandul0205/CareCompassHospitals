<?php
session_start();
require_once 'db_config.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'hospital_staff') {
    header("Location: login.php");
    exit();
}

// Fetch hospital staff data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ? AND role = 'hospital_staff'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$staff = $result->fetch_assoc();

if (isset($_POST['update_status'])) {
    $appointment_id = $_POST['appointment_id'];
    $status = $_POST['status'];

    $appointment_id = mysqli_real_escape_string($conn, $appointment_id);
    $status = mysqli_real_escape_string($conn, $status);

    // Update the status of the appointment in the database
    $query = "UPDATE appointments SET status = '$status' WHERE id = '$appointment_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Status updated successfully.'); window.location.href='staff.php';</script>";
    } else {
        echo "<script>alert('Error updating status: " . mysqli_error($conn) . "'); window.location.href='staff.php';</script>";
    }
}

// Add a new appointment
if (isset($_POST['add_appointment'])) {
    $patient_name = $_POST['patient_name'];
    $patient_email = $_POST['patient_email'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $status = 'Pending';  

    $patient_name = mysqli_real_escape_string($conn, $patient_name);
    $patient_email = mysqli_real_escape_string($conn, $patient_email);
    $doctor_id = mysqli_real_escape_string($conn, $doctor_id);
    $appointment_date = mysqli_real_escape_string($conn, $appointment_date);

    // Insert the new appointment into the database
    $query = "INSERT INTO appointments (patient_name, patient_email, doctor_id, appointment_date, status) 
              VALUES ('$patient_name', '$patient_email', '$doctor_id', '$appointment_date', '$status')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Appointment added successfully.'); window.location.href='staff.php';</script>";
    } else {
        echo "<script>alert('Error adding appointment: " . mysqli_error($conn) . "'); window.location.href='staff.php';</script>";
    }
}

// Fetch appointments for the hospital staff (fetch all appointments)
$appointments_sql = "SELECT * FROM appointments";
$appointments_result = mysqli_query($conn, $appointments_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Staff Dashboard - Care Compass Hospitals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e9f7fc; 
            font-family: 'Roboto', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .btn-back {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #5cb85c;
            border-color: #5cb85c;
        }

        .btn-primary:hover {
            background-color: #4cae4c;
            border-color: #4cae4c;
        }

        .btn-logout {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #d9534f;
            color: white;
        }

        .btn-logout:hover {
            background-color: #c9302c;
        }

        .table th, .table td {
            text-align: center;
            background-color:#ffff;
        }
    </style>
</head>
<body>

    <!-- Logout Button -->
    <a href="logout.php" class="btn btn-logout">Logout</a>

    <div class="container mt-5">
        <h2>Welcome, <?php echo $staff['name']; ?> - Hospital Staff</h2>

        <div class="d-flex justify-content-start mt-3">
            <a href="appointments.php" class="btn btn-primary me-3">ADD Appointments</a>
            <a href="uploadMedicalReport.php" class="btn btn-primary">Medical Reports</a>
        </div>

        <!-- Manage Appointments -->
        <div class="container mt-5">
            <h2>Manage Appointments</h2>

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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
