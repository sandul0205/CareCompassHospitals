<?php
session_start();
require_once 'db_config.php';  

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'administrator') {
    header("Location: login.php"); 
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();  
    header("Location: login.php");  
    exit();
}

// Fetch administrator data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ? AND role = 'administrator'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Fetch all patients and staff for management
$patients_sql = "SELECT * FROM users WHERE role = 'patient'";
$staff_sql = "SELECT * FROM users WHERE role = 'hospital_staff'";

// Fetch patients and staff
$patients_result = $conn->query($patients_sql);
$staff_result = $conn->query($staff_sql);

// Handle the update of patient or staff
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    $sql = "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $phone, $user_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating user.');</script>";
    }
}

// Handle the deletion of patient or staff
if (isset($_GET['delete_user_id'])) {
    $user_id = $_GET['delete_user_id'];
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting user.');</script>";
    }
}
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
        }

        .btn-warning, .btn-danger {
            font-size: 14px;
        }

        .btn-primary, .btn-success {
            font-size: 16px;
        }

        .table th, .table td {
            text-align: center;
            background-color:#ffff;
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

        .logout-btn {
            float: right;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome, Administrator <?php echo $admin['name']; ?></h2>

        <a href="admin_dashboard.php?logout=true" class="btn btn-danger logout-btn">Logout</a>

        <!-- Manage Users Section -->
        <div class="mt-4">
            <h3>Manage Users</h3>
            <div class="d-flex justify-content-start mt-3">
                <a href="crud-doctors.php" class="btn btn-success me-3">Add Doctor</a>
                <a href="staff.php" class="btn btn-primary me-3">Add Staff</a>
                <a href="crud-appointment.php" class="btn btn-primary me-3">Appointments</a>
                <a href="manage_payments.php" class="btn btn-primary">Payments</a>
            </div>

            <h5 class="mt-4">Patients</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($patient = $patients_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $patient['name']; ?></td>
                            <td><?php echo $patient['email']; ?></td>
                            <td><?php echo $patient['phone']; ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="<?php echo $patient['id']; ?>" data-name="<?php echo $patient['name']; ?>" data-email="<?php echo $patient['email']; ?>" data-phone="<?php echo $patient['phone']; ?>">Edit</button>
                                <a href="admin_dashboard.php?delete_user_id=<?php echo $patient['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <h5>Hospital Staff</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($staff = $staff_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $staff['name']; ?></td>
                            <td><?php echo $staff['email']; ?></td>
                            <td><?php echo $staff['phone']; ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="<?php echo $staff['id']; ?>" data-name="<?php echo $staff['name']; ?>" data-email="<?php echo $staff['email']; ?>" data-phone="<?php echo $staff['phone']; ?>">Edit</button>
                                <a href="admin_dashboard.php?delete_user_id=<?php echo $staff['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="admin_dashboard.php">
                            <input type="hidden" name="user_id" id="user_id">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="edit_phone" name="phone" required>
                            </div>
                            <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const editButtons = document.querySelectorAll('.btn-warning');
        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const userId = button.getAttribute('data-id');
                const userName = button.getAttribute('data-name');
                const userEmail = button.getAttribute('data-email');
                const userPhone = button.getAttribute('data-phone');
                
                document.getElementById('user_id').value = userId;
                document.getElementById('edit_name').value = userName;
                document.getElementById('edit_email').value = userEmail;
                document.getElementById('edit_phone').value = userPhone;
            });
        });
    </script>
</body>
</html>
