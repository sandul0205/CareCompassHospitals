<?php
session_start();
include('db_config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'administrator') {
    die("You need to be logged in as an admin to manage payments.");
}

if (isset($_POST['update_payment_status'])) {
    $payment_id = $_POST['payment_id'];
    $new_status = $_POST['payment_status'];

    // Update the payment status in the database
    $update_sql = "UPDATE payments SET status = ? WHERE payment_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $new_status, $payment_id);

    if ($update_stmt->execute()) {
        echo "<div class='alert alert-success'>Payment status updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating payment status. Please try again.</div>";
    }
    $update_stmt->close();
}

// Fetch all payments from the database
$payment_sql = "SELECT * FROM payments ORDER BY payment_date DESC";
$payment_result = $conn->query($payment_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments - Care Compass Hospitals</title>
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

        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>
<body>


    <!-- Manage Payments Section -->
    <div class="container my-5">
        <a href="admin_dashboard.php" class="btn btn-secondary btn-back">Back to Dashboard</a>

        <h2 class="text-center mb-4">Manage Payments</h2>

        <!-- Payment History Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Patient ID</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display each payment from the database
                if ($payment_result->num_rows > 0) {
                    while ($row = $payment_result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['payment_id'] . "</td>
                                <td>" . $row['id'] . "</td>
                                <td>Rs. " . $row['amount'] . "</td>
                                <td>" . $row['payment_method'] . "</td>
                                <td>" . $row['payment_date'] . "</td>
                                <td>" . $row['status'] . "</td>
                                <td>
                                    <form method='POST' action='manage_payments.php'>
                                        <input type='hidden' name='payment_id' value='" . $row['payment_id'] . "'>
                                        <select name='payment_status' class='form-control'>
                                            <option value='Pending' " . ($row['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                                            <option value='Completed' " . ($row['status'] == 'Completed' ? 'selected' : '') . ">Completed</option>
                                            <option value='Failed' " . ($row['status'] == 'Failed' ? 'selected' : '') . ">Failed</option>
                                        </select>
                                        <button type='submit' name='update_payment_status' class='btn btn-primary mt-2'>Update</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No payments found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
