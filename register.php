<?php
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  
    $role = 'patient';  
    $email = $_POST['email'];
    $name = $_POST['name']; 
    $phone = $_POST['phone'];  

    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "<div class='alert alert-danger'>Username or Email already exists.</div>";
    } else {
        // Insert new user into the users table
        $sql = "INSERT INTO users (username, password, role, email, name, phone) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $username, $password, $role, $email, $name, $phone);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Registration successful!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration - Care Compass Hospitals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fb; 
            font-family: 'Roboto', sans-serif;
        }
        
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
            min-height: 100vh;
        }

        .form-section {
            background-color: #f4f7fb;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .form-header {
            font-family: 'Merriweather', serif;
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius:10px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            padding: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px;
            width: 100%;
            font-size: 1rem;
            border-radius: 8px;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0056b3;
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
    </style>
</head>
<body>

    <div class="form-container">
        <div class="form-section">
            <h3 class="form-header text-center">Patient Registration</h3>

            <!-- Registration Form -->
            <form method="POST" action="register.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>

            <div class="form-footer">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Care Compass Hospitals. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
