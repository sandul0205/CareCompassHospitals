<?php
session_start();
include('db_config.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors - Care Compass Hospitals</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css?<?php echo time(); ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Merriweather:wght@700&display=swap" rel="stylesheet">
</head>
<body>

<!-- Include Navbar -->
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

<div class="container my-5">
    <h2 class="text-center mb-4">Meet Our Doctors</h2>
    <div class="row">
        <?php
        // Fetch doctors from the database
        $sql = "SELECT * FROM doctors";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='col-md-4 mb-4'>
                    <div class='card shadow-sm'>
                        <img src='images/doctor.jpg' alt='Doctor Profile' class='card-img-top' style='height: 250px; object-fit: cover;'>
                        <div class='card-body text-center'>
                            <h5 class='card-title'>{$row['name']}</h5>
                            <p class='card-text'><strong>Specialization:</strong> {$row['specialization']}</p>
                            <p class='card-text'><strong>Contact:</strong> {$row['contact']}</p>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "<p class='text-center'>No doctors found.</p>";
        }
        ?>
    </div>
</div>

<!-- Include Footer -->
<?php include('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
