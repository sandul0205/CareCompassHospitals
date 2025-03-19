<?php
session_start();
require_once 'db_config.php';  

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header("Location: login.php"); 
    exit();
}

// Fetch patient data from the users table
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ? AND role = 'patient'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

// Fetch doctors from the database for the appointment
$doctor_sql = "SELECT * FROM doctors";
$doctor_result = $conn->query($doctor_sql);

// Handle appointment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['email'], $_POST['doctor_id'], $_POST['appointment_date'])) {
    $patient_name = $_POST['name'];
    $patient_email = $_POST['email'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];

    $appointment_sql = "INSERT INTO appointments (patient_name, patient_email, doctor_id, appointment_date) 
                        VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($appointment_sql);
    $stmt->bind_param("ssis", $patient_name, $patient_email, $doctor_id, $appointment_date);
    if ($stmt->execute()) {
        echo "<script>alert('Appointment booked successfully!');</script>";
    } else {
        echo "<script>alert('Error booking appointment.');</script>";
    }
}

// Handle feedback submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rating'], $_POST['comments'])) {
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];

    $feedback_sql = "INSERT INTO feedback (id, rating, comments) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($feedback_sql);
    $stmt->bind_param("iis", $user_id, $rating, $comments);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Thank you for your feedback!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error submitting your feedback. Please try again later.</div>";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard - Care Compass Hospitals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;  
        }

        .navbar {
            background-color: #65befd;
        }

        .navbar-nav .nav-link {
            color: white !important;
            padding: 10px 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            transform: translateY(1px);
        }

        .navbar-nav .nav-item.active .nav-link {
            background-color: #004085;
            color: white !important;
            border-radius: 5px;
        }

        /* Blinking effect */
        @keyframes blink {
            0% {
                opacity: 1;
            }
            50% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        .nav-item.blinking .nav-link {
            animation: blink 2s infinite;
            border-radius: 10px;
            padding: 10px 10px;
            font-weight: bold;
        }

        .feedback-form {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .feedback-form h5 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .form-control {
            border-radius: 25px;  
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-submit {
            background-color: #65befd;
            border-radius: 25px;
            font-weight: bold;
            padding: 10px 20px;
            width: 100%;
        }

        .btn-submit:hover {
            background-color: #4ca3d3;
            transform: scale(1.05);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-logout {
            background-color: #d9534f;
            border-color: #d9534f;
        }

        .btn-logout:hover {
            background-color: #c9302c;
            border-color: #c12e2a;
        }
    </style>
</head>
<body>

    <!-- Navbar Code -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Care Compass Hospitals</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item blinking"><a class="nav-link" href="#appointments">Appointments</a></li>
                    <li class="nav-item"><a class="nav-link" href="viewMedicalReports.php">Medical Records</a></li>
                    <li class="nav-item"><a class="nav-link" href="payment.php">Payments</a></li>
                    <li class="nav-item"><a class="nav-link" href="#feedback">Feedback</a></li>
                    <li class="nav-item">
                        <form method="POST" action="login.php" class="d-inline">
                            <button type="submit" name="logout" class="btn btn-logout">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Welcome, <?php echo $patient['name']; ?></h2>

        <!-- Profile Section -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <img src="images/user.png" alt="Profile Picture" class="rounded-circle" width="150" height="150">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $patient['name']; ?></h5>
                        <p class="card-text">Patient</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> <?php echo $patient['name']; ?></p>
                        <p><strong>Email:</strong> <?php echo $patient['email']; ?></p>
                        <p><strong>Phone:</strong> <?php echo $patient['phone']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- Appointment Form -->
        <div id="appointments" class="card mt-5">
            <div class="card-header">
                <h5>Book an Appointment</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="patient_dashboard.php">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $patient['name']; ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $patient['email']; ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="doctor" class="form-label">Select Doctor</label>
                        <select class="form-control" id="doctor" name="doctor_id" required>
                            <option value="">Choose...</option>
                            <?php while ($doctor = $doctor_result->fetch_assoc()) { ?>
                                <option value="<?php echo $doctor['id']; ?>"><?php echo $doctor['name'] . " (" . $doctor['specialization'] . ")"; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="appointment_date" class="form-label">Appointment Date and Time</label>
                        <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Book Appointment</button>
                </form>
            </div>
        </div>

        <!-- Feedback Section -->
        <div id="feedback" class="feedback-form mt-5 mb-5">
            <h5>We Value Your Feedback</h5>
            <p class="mb-4">Please let us know how we can improve your experience with Care Compass Hospitals.</p>

            

            <!-- Feedback Form -->
            <form method="POST" action="patient_dashboard.php">
                <div class="form-group mb-3">
                    <label for="rating">Rating (1 to 5)</label>
                    <select class="form-control" id="rating" name="rating" required>
                        <option value="">Select Rating</option>
                        <option value="1">1 - Poor</option>
                        <option value="2">2 - Fair</option>
                        <option value="3">3 - Good</option>
                        <option value="4">4 - Very Good</option>
                        <option value="5">5 - Excellent</option>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="comments">Comments</label>
                    <textarea class="form-control" id="comments" name="comments" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-submit">Submit Feedback</button>
            </form>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="patient_dashboard.php">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $patient['name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $patient['email']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $patient['phone']; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 text-white" style="background-color: #65befd;">
    &copy; 2025 Care Compass Hospitals. All Rights Reserved.
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
