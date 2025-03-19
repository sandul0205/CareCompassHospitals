<?php
session_start();

$error = "";

$host = "localhost";
$username = "root";
$password = "";
$database = "care_compass_hospital"; 
$port = 4306; 

$conn = new mysqli($host, $username, $password, $database , $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = isset($_POST['username']) ? $_POST['username'] : null;
    $pass = isset($_POST['password']) ? $_POST['password'] : null;

    if ($user && $pass) {
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        if (!$stmt) {
            die("MySQL error: " . $conn->error);
        }
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($pass, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['username'] = $row['username'];

                switch ($row['role']) {
                    case 'administrator':
                        header("Location: admin_dashboard.php");
                        break;
                    case 'hospital_staff':
                        header("Location: staff_dashboard.php");
                        break;
                    case 'patient':
                        header("Location: patient_dashboard.php");
                        break;
                }
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
        $stmt->close();
    } else {
        $error = "Please enter both username and password.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Care Compass Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/styles.css?<?php echo time(); ?>" />
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
            max-width: 1000px;
            margin: auto;
        }

       
        
        .form-right{
            width: 60%;
        }


        .form-right {
            background-color: #f4f7fb;
            padding: 30px;
            margin-left:30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            font-family: 'Merriweather', serif;
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 20px;
        }

        .form-control {
            
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

        

    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg sticky-top py-3">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="images/Logo.jpg" alt="Hospital Logo" width="40" height="40" class="me-2">
                    <span class="h5 text-white">Care Compass Hospital</span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar" aria-controls="topNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="topNavbar">
                    <ul class="navbar-nav ms-auto">
                        
                        <li class="nav-item"><a class="btn btn-outline-light " href="index.php">Back to Home</a></li>
                    </ul>
                </div>
            </div>
        </nav>

    <div class="container mt-5">
        <div class="form-container">
            <!-- Left Side (User Instructions) -->
            <div>
            <h4 class="form-header">Log in to Care Compass Hospital's Patient Portal</h4>
                <ul><li>Book and manage appointments</li>
                    <li>Make online payments for your treatments</li>
                    <li>View your medical reports</li>
                    <li>Provide feedback on services</li>
                </ul>
                <p class="text-muted">Don't have an account? <a href="register.php">Sign up</a></p>
            </div>
                
            

            <!-- Right Side (Login Form) -->
            <div class="form-right">
                <h3 class="form-header">Sign in</h3>
                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Enter Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Enter password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Sign in</button>
                    <?php if (!empty($error)) { echo "<p class='text-danger mt-3'>$error</p>"; } ?>
                    
                </form>
            
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Care Compass Hospitals. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
