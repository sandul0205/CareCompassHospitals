<?php
require_once 'db_config.php'; 

// Fetch doctors from the database
$sql = "SELECT * FROM doctors";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_name = $_POST['name'];
    $patient_email = $_POST['email'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];

    // Insert appointment into the database
    $sql = "INSERT INTO appointments (patient_name, patient_email, doctor_id, appointment_date) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $patient_name, $patient_email, $doctor_id, $appointment_date);
    if ($stmt->execute()) {
        echo "<script>alert('Appointment booked successfully!');</script>";
    } else {
        echo "<script>alert('Error booking appointment.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;  
            font-family: 'Roboto', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .btn-back {
            margin-top:20px;
            margin-left:20px;
            margin-bottom: 20px;
            background-color: #6c757d;
            color: white;
            border: none;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .form-control {
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <!-- Back to Dashboard Button -->
    <a href="staff_dashboard.php" class="btn btn-back">Back to Dashboard</a>

    <div class="container mt-5 form-container">
        <h2 class="text-center mb-4">Book an Appointment</h2>

        <form method="POST" action="appointments.php">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="doctor" class="form-label">Select Doctor</label>
                <select class="form-control" id="doctor" name="doctor_id" required>
                    <option value="">Choose...</option>
                    <?php while ($doctor = $result->fetch_assoc()) { ?>
                        <option value="<?php echo $doctor['id']; ?>"><?php echo $doctor['name'] . " (" . $doctor['specialization'] . ")"; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="appointment_date" class="form-label">Appointment Date and Time</label>
                <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
