<?php
session_start();
include('db_config.php');

if (!isset($_SESSION['user_id'])) {
    die("You need to be logged in to make a payment.");
}

$patient_id = $_SESSION['user_id'];

// Fetch user profile details
$profile_sql = "SELECT * FROM users WHERE id = ?";
$profile_stmt = $conn->prepare($profile_sql);
$profile_stmt->bind_param("i", $patient_id); 
$profile_stmt->execute();
$profile_result = $profile_stmt->get_result();
$profile = $profile_result->fetch_assoc();

// Fetch payment history (if any)
$payment_sql = "SELECT * FROM payments WHERE id = ? ORDER BY payment_date DESC";
$payment_stmt = $conn->prepare($payment_sql);
$payment_stmt->bind_param("i", $patient_id);
$payment_stmt->execute();
$payment_result = $payment_stmt->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $status = "Pending";  

    // Insert payment details into the database
    $payment_sql = "INSERT INTO payments (id, amount, payment_method, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($payment_sql);
    $stmt->bind_param("idss", $patient_id, $amount, $payment_method, $status);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Your payment has been successfully processed! It is currently in 'Pending' status.</div>";
    } else {
        echo "<div class='alert alert-danger'>There was an error processing your payment. Please try again later.</div>";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Care Compass Hospitals</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
<div >
        <a href="patient_dashboard.php" class="btn back-button">Back to Dashboard</a>
    </div>
    <h2 class="text-center mb-4">Payment Information</h2>

    
    
    <!-- Profile Information -->
    <div class="mb-4">
        <h4>Profile Information</h4>
        <ul class="list-group">
            <li class="list-group-item"><strong>Name:</strong> <?php echo $profile['name']; ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?php echo $profile['email']; ?></li>
            <li class="list-group-item"><strong>Phone:</strong> <?php echo $profile['phone']; ?></li>
        </ul>
    </div>
    
    <!-- Payment History -->
    <div class="mt-5">
        <h3>Your Payment History</h3>
        <ul class="list-group">
            <?php
            if ($payment_result->num_rows > 0) {
                while ($row = $payment_result->fetch_assoc()) {
                    echo "<li class='list-group-item'>
                            <strong>Amount:</strong> Rs. " . $row['amount'] . "<br>
                            <strong>Payment Date:</strong> " . $row['payment_date'] . "<br>
                            <strong>Status:</strong> " . $row['status'] . "
                          </li>";
                }
            } else {
                echo "<li class='list-group-item'>No payments found.</li>";
            }
            ?>
        </ul>
    </div>

    <!-- Make a Payment Section -->
    <div class="mt-5">
        <h3>Make a New Payment</h3>
        <form method="POST" action="payment.php">
            <div class="form-group">
                <label for="amount">Amount (Rs.)</label>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount" required>
            </div>
            <div class="form-group mt-3">
                <label for="payment_method">Payment Method</label>
                <select class="form-control" id="payment_method" name="payment_method" required>
                    <option value="credit_card">Credit Card</option>
                    <option value="debit_card">Debit Card</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-3">Proceed to Payment</button>
        </form>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
