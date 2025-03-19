<?php
session_start();
require_once 'db_config.php';  

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'administrator') {
    header("Location: login.php");  
    exit();
}

// Handle the creation of a new doctor
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_doctor'])) {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $contact = $_POST['contact'];

    // Insert new doctor into the database
    $sql = "INSERT INTO doctors (name, specialization, contact) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        echo "<script>alert('Error preparing the query: " . $conn->error . "');</script>";
        exit();
    }

    $stmt->bind_param("sss", $name, $specialization, $contact);
    
    if ($stmt->execute()) {
        echo "<script>alert('Doctor added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding doctor: " . $stmt->error . "');</script>";
    }
}

// Handle doctor update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_doctor'])) {
    $doctor_id = $_POST['doctor_id']; 
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $contact = $_POST['contact'];

    $sql = "UPDATE doctors SET name = ?, specialization = ?, contact = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $specialization, $contact, $doctor_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Doctor updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating doctor: " . $stmt->error . "');</script>";
    }
}

// Handle doctor deletion
if (isset($_GET['delete_doctor_id'])) {
    $doctor_id = $_GET['delete_doctor_id'];
    $sql = "DELETE FROM doctors WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctor_id);
    if ($stmt->execute()) {
        echo "<script>alert('Doctor deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting doctor.');</script>";
    }
}

// Fetch all doctors from the database
$doctors_sql = "SELECT * FROM doctors";
$doctors_result = $conn->query($doctors_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Dashboard - Care Compass Hospitals</title>
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

        .table-bordered {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .table-bordered th, .table-bordered td {
            padding: 12px;
        }

        .btn-warning, .btn-danger {
            font-size: 14px;
        }

        .btn-primary, .btn-success {
            font-size: 16px;
        }

        .footer {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            color: #777;
        }

        .form-footer {
            font-size: 0.9rem;
            text-align: center;
            margin-top: 20px;
        }

        .back-btn {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome, Administrator</h2>

        <a href="admin_dashboard.php" class="btn btn-secondary back-btn">Back to Dashboard</a>

        <!-- Add Doctor Form -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>Add New Doctor</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="crud-doctors.php">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="specialization" class="form-label">Specialization</label>
                        <input type="text" class="form-control" id="specialization" name="specialization" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                    </div>
                    <button type="submit" name="add_doctor" class="btn btn-success">Add Doctor</button>
                </form>
            </div>
        </div>

        <!-- List of Doctors -->
        <h3 class="mt-5">Doctors List</h3>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($doctor = $doctors_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $doctor['name']; ?></td>
                        <td><?php echo $doctor['specialization']; ?></td>
                        <td><?php echo $doctor['contact']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDoctorModal" data-id="<?php echo $doctor['id']; ?>" data-name="<?php echo $doctor['name']; ?>" data-specialization="<?php echo $doctor['specialization']; ?>" data-contact="<?php echo $doctor['contact']; ?>">Edit</button>
                            <a href="crud-doctors.php?delete_doctor_id=<?php echo $doctor['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr> 
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Doctor Modal -->
    <div class="modal fade" id="editDoctorModal" tabindex="-1" aria-labelledby="editDoctorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDoctorModalLabel">Edit Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="crud-doctors.php">
                        <input type="hidden" name="doctor_id" id="doctor_id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_specialization" class="form-label">Specialization</label>
                            <input type="text" class="form-control" id="edit_specialization" name="specialization" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_contact" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="edit_contact" name="contact" required>
                        </div>
                        <button type="submit" name="update_doctor" class="btn btn-primary">Update Doctor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const editButtons = document.querySelectorAll('.btn-warning');
        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const doctorId = button.getAttribute('data-id');
                const doctorName = button.getAttribute('data-name');
                const doctorSpecialization = button.getAttribute('data-specialization');
                const doctorContact = button.getAttribute('data-contact');
                
                document.getElementById('doctor_id').value = doctorId;
                document.getElementById('edit_name').value = doctorName;
                document.getElementById('edit_specialization').value = doctorSpecialization;
                document.getElementById('edit_contact').value = doctorContact;
            });
        });
    </script>
</body>
</html>
