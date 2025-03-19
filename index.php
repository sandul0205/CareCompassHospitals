<?php
session_start();
include('db_config.php');




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Compass Hospitals</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css?<?php echo time(); ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Merriweather:wght@700&display=swap" rel="stylesheet">
</head>

<body>
<!-- Navigation Bar -->
<nav class="navbar bg-danger sticky-top py-0">
    <div class="container d-flex justify-content-between align-items-center">
        <span class="navbar-text text-white" style="background-color: #f44336; padding: 7px;">
            <strong>FOR EMERGENCY:</strong> <a href="tel:+94114000100" class="text-white">+94 011 4000 100</a>
        </span>

        <span class="navbar-text">
            <a href="#" class="text-white me-2"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white me-2"><i class="fab fa-linkedin"></i></a>
            <a href="#" class="text-white me-2"><i class="fab fa-google-plus"></i></a>
        </span>
    </div>
</nav>


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
                        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#feedback">Patient Reviews</a></li>
                        <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#packages">Health Packages</a></li>
                        <li class="nav-item"><a class="nav-link me-5" href="#contact">Contact Us</a></li>
                        <li class="nav-item"><a class="btn btn-outline-light " href="login.php">Patient Portal</a></li>
                    </ul>
                </div>
            </div>
        </nav>

<!-- Hero Section with Carousel -->
<div class="hero position-relative text-center">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/cover3.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/cover4.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/cover5.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Card on the Right Side -->
    <div class="hero-content position-absolute top-50 end-0 translate-middle-y">
        <div class="card" style="width: 13rem;">
            <img src="images/appointment.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Care Compass Hospital</h5>
                <p class="card-text">Book an appointment or learn more </p>
                <a href="login.php" class="btn btn-primary">Book Appointment</a>
            </div>
        </div>
    </div>
</div>


<!-- Info Blocks Section -->
<div class="container my-custom-margin">
    <div class="row text-white">
        <!-- Working Time Card -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Working Time</h5>
                    <ul>
                        <li>Hotline: +94 011 4000 100</li>
                        <li>Fax: – 9.30 – 17.30</li>
                        <li>Open Hours: 24/7 Open OPD</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Doctors Timetable Card -->
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Doctors</h5>
                    <p>Consult with our experienced doctors.</p>
                    <a href="doctors.php" class="btn btn-light">View Doctors</a>
                </div>
            </div>
        </div>

        <!-- Health Packages Card -->
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Health Packages</h5>
                    <p>Health is wealth. We offer a wide range of health packages for affordable prices for you to test your health conditions.</p>
                    <a href="#packages" class="btn btn-light">Health Packages</a>
                </div>
            </div>
        </div>

        <!-- Our Hotline Card -->
        <div class="col-md-3 mb-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Our Hotline</h5>
                    <p>+94 011 4000 100</p>
                    <p>Contact us for any sort of inquiries or more information. We are always here to help you...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Section -->
<div class="container my-5 welcome-container">
    <div class="row align-items-center">
        <!-- Left Column (Image) -->
        <div class="col-md-6">
            <img src="images/hospital.jpg" alt="Royal Hospital" class="img-fluid rounded">
        </div>

        <!-- Right Column (Text) -->
        <div class="col-md-6">
            <h2>Welcome to Care Compass Hospital</h2>
            <p>
                Welcome to Care Compass Hospital, where your health and well-being come first. We provide comprehensive care with access to a variety of medical and surgical specialties, ensuring that you receive the best treatment possible.
            </p>
            <p>
                Our team of dedicated professionals is committed to offering quality healthcare to inspire and empower you to lead a healthier life.
            </p>

            <p><strong>"Get to know what we are best at"</strong></p>
            <a href="#contact" class="btn btn-primary">MORE ABOUT US</a>
        </div>
    </div>
</div>


        <!-- Our Departments Section -->
        <div id="services" class="container my-5"> 
            <h2 class="text-center mb-4">Our Departments</h2>
            <div class="row">
                <!-- Pulmonary Unit Card -->
                <div class="col-md-3 text-center mb-4">
                    <div class="card shadow-sm">
                        <img src="images/PulmonaryUnit.jpg" alt="Pulmonary Unit" class="card-img-top" style="object-fit: cover; height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title">Pulmonary Unit</h5>
                            <p class="card-text">Provide outstanding medical care...</p>
                        </div>
                    </div>
                </div>

                <!-- Neurology Unit Card -->
                <div class="col-md-3 text-center mb-4">
                    <div class="card shadow-sm">
                        <img src="images/NeurologyUnit.jpg" alt="Neurology Unit" class="card-img-top" style="object-fit: cover; height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title">Neurology Unit</h5>
                            <p class="card-text">Deal with the disorders related...</p>
                        </div>
                    </div>
                </div>

                <!-- Dermatology Card -->
                <div class="col-md-3 text-center mb-4">
                    <div class="card shadow-sm">
                        <img src="images/Dermatology.jpg" alt="Dermatology" class="card-img-top" style="object-fit: cover; height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title">Dermatology</h5>
                            <p class="card-text">Concerned with the diagnosis...</p>
                        </div>
                    </div>
                </div>

                <!-- Nephrology Card -->
                <div class="col-md-3 text-center mb-4">
                    <div class="card shadow-sm">
                        <img src="images/Nephrology.jpg" alt="Nephrology" class="card-img-top" style="object-fit: cover; height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title">Nephrology</h5>
                            <p class="card-text">Deal with the problems and ailments...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Orthopaedic Unit Card -->
                <div class="col-md-3 text-center mb-4">
                    <div class="card shadow-sm">
                        <img src="images/Orthopaedic.jpg" alt="Orthopaedic Unit" class="card-img-top" style="object-fit: cover; height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title">Orthopaedic Unit</h5>
                            <p class="card-text">Focuses on injuries and diseases...</p>
                        </div>
                    </div>
                </div>

                <!-- Cardiology Card -->
                <div class="col-md-3 text-center mb-4">
                    <div class="card shadow-sm">
                        <img src="images/Cardiology.jpg" alt="Cardiology" class="card-img-top" style="object-fit: cover; height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title">Cardiology</h5>
                            <p class="card-text">Deal with disorders of the heart...</p>
                        </div>
                    </div>
                </div>

                <!-- Psychotherapy Card -->
                <div class="col-md-3 text-center mb-4">
                    <div class="card shadow-sm">
                        <img src="images/Psychotherapy.jpg" alt="Psychotherapy" class="card-img-top" style="object-fit: cover; height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title">Psychotherapy</h5>
                            <p class="card-text">Support and treat mental health...</p>
                        </div>
                    </div>
                </div>

                <!-- Endocrinology Card -->
                <div class="col-md-3 text-center mb-4">
                    <div class="card shadow-sm">
                        <img src="images/Endocrinology.jpg" alt="Endocrinology" class="card-img-top" style="object-fit: cover; height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title">Endocrinology</h5>
                            <p class="card-text">Concerned with hormone-related issues...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Sports Medicine Card -->
                <div class="col-md-3 text-center mb-4">
                    <div class="card shadow-sm">
                        <img src="images/SportsMedicine.jpg" alt="Sports Medicine" class="card-img-top" style="object-fit: cover; height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title">Sports Medicine</h5>
                            <p class="card-text">Focus on sports-related injuries...</p>
                        </div>
                    </div>
                </div>

                <!-- General Unit Card -->
                <div class="col-md-3 text-center mb-4">
                    <div class="card shadow-sm">
                        <img src="images/General.jpg" alt="General Unit" class="card-img-top" style="object-fit: cover; height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title">General Unit</h5>
                            <p class="card-text">General care for all patients...</p>
                        </div>
                    </div>
                </div>

                <!-- Rheumatology Card -->
                <div class="col-md-3 text-center mb-4">
                    <div class="card shadow-sm">
                        <img src="images/Rheumatology.jpg" alt="Rheumatology" class="card-img-top" style="object-fit: cover; height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title">Rheumatology</h5>
                            <p class="card-text">Focuses on joint and bone issues...</p>
                        </div>
                    </div>
                </div>

                <!-- Eye Unit Card -->
                <div class="col-md-3 text-center mb-4">
                    <div class="card shadow-sm">
                        <img src="images/Eye.jpg" alt="Eye Unit" class="card-img-top" style="object-fit: cover; height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title">Eye Unit</h5>
                            <p class="card-text">Care for eye disorders...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Health Packages Section -->
<div id="packages" class="container my-5">
    <h2 class="text-center mb-4">Our Health Packages</h2>
    <p class="text-center">We offer a variety of affordable health packages to help you maintain your well-being. Choose the right one for you and take a step toward a healthier future.</p>
    
    <div class="row">
        <!-- Health Package 1 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="images/healthpackage.jpg" alt="Health Package 1" class="card-img-top" style="object-fit: cover; height: 200px;">
                <div class="card-body">
                    <h5 class="card-title">Basic Health Package</h5>
                    <p class="card-text">Includes routine check-up, blood tests, and general consultation.</p>
                    <a href="#contact" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>

        <!-- Health Package 2 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="images/healthpackage.jpg" alt="Health Package 2" class="card-img-top" style="object-fit: cover; height: 200px;">
                <div class="card-body">
                    <h5 class="card-title">Comprehensive Health Package</h5>
                    <p class="card-text">Offers in-depth health screenings, including heart and lung function tests.</p>
                    <a href="#contact" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>

        <!-- Health Package 3 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="images/healthpackage.jpg" alt="Health Package 3" class="card-img-top" style="object-fit: cover; height: 200px;">
                <div class="card-body">
                    <h5 class="card-title">Premium Health Package</h5>
                    <p class="card-text">Full-body check-up with specialist consultations and diagnostic imaging.</p>
                    <a href="#contact" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</div>




    <!-- Feedback Section -->
<div id="feedback" class="container my-5">
    <h2 class="text-center mb-4">Your Feedback Matters</h2>

    <!-- Display Feedback -->
    <div class="row">
        <?php
            $sql = "SELECT f.rating, f.comments, u.name FROM feedback f 
                    JOIN users u ON f.id = u.id 
                    ORDER BY f.feedback_id DESC LIMIT 4";  
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-md-6 mb-4'>
                        <div class='card shadow-sm p-3'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$row['name']}</h5>
                                <div class='d-flex align-items-center'>
                                    <div class='rating'>
                                        " . str_repeat('<i class="fas fa-star text-warning"></i>', $row['rating']) . 
                                        str_repeat('<i class="fas fa-star text-muted"></i>', 5 - $row['rating']) . "
                                    </div>
                                    <span class='ms-2'>{$row['rating']}/5</span>
                                </div>
                                <p class='card-text mt-3'>{$row['comments']}</p>
                            </div>
                        </div>
                    </div>";
            }
        ?>
    </div>
</div>


<!-- Contact Us Section -->
<div id="contact" class="container my-5">
    <h2 class="text-center mb-4">Contact Us</h2>
    <p class="text-center">Have a question or need assistance? Reach out to us.</p>

    <div class="row">
        <!-- Left Column: Contact Information -->
        <div class="col-md-6">
            <h5>Our Address</h5>
            <p>Care Compass Hospitals, Colombo, Sri Lanka</p>

            <h5>Phone</h5>
            <p><a href="tel:+94112140000" class="text-muted">+94 11 214 0000</a></p>

            <h5>Email</h5>
            <p><a href="mailto:contactus@carecompass.com" class="text-muted">contactus@carecompass.com</a></p>

            <h5>Follow Us</h5>
            <a href="#" class="me-3"><i class="fab fa-facebook fa-2x text-primary"></i></a>
                    <a href="#" class="me-3"><i class="fab fa-instagram fa-2x text-danger"></i></a>
                    <a href="#" class="me-3"><i class="fab fa-linkedin fa-2x text-info"></i></a>
                    <a href="#"><i class="fab fa-youtube fa-2x text-danger"></i></a>
        </div>

        <!-- Right Column: Contact Form -->
        <div class="col-md-6">
            <h5>Send us a Message</h5>
            <form action="index.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </div>
</div>

<footer class="footer bg-light text-dark py-4">
    <div class="container">
        <div class="row">
            <!-- Column 1: Logo & About -->
            <div class="col-md-3 text-center text-md-start">
                <img src="images/Logo.jpg" alt="Care Compass Hospitals Logo" class="mb-3 me-3" style="max-width: 120px;">
                <p class="small">
                    Care Compass Hospitals is dedicated to providing top-quality healthcare services for over 75 years, ensuring your well-being and medical needs are met with excellence.
                </p>
            </div>

            <!-- Column 2: Quick Links -->
            <div class="col-md-3 text-center text-md-start">
               
                <ul class="list-unstyled">
                <h5 class="fw-bold">Quick Links</h5>
                    <li><a href="index.php" class="text-dark text-decoration-none">Home</a></li>
                    <li><a href="about.php" class="text-dark text-decoration-none">About Us</a></li>
                    <li><a href="services.php" class="text-dark text-decoration-none">Our Services</a></li>
                    <li><a href="doctors.php" class="text-dark text-decoration-none">Doctors</a></li>
                    <li><a href="contact.php" class="text-dark text-decoration-none">Contact Us</a></li>
                </ul>
            </div>

            <!-- Column 3: Contact Info -->
            <div class="col-md-3 text-center text-md-start">
            <ul class="list-unstyled">
                <li><h5 class="fw-bold">Contact Us</h5></li>
                <li><p class="mb-1"><strong>Phone:</strong> <a href="tel:+94112140000" class="text-dark text-decoration-none">+94 11 214 0000</a></p></li>
                <li><p class="mb-1"><strong>Email:</strong> <a href="mailto:contactus@carecompass.com" class="text-dark text-decoration-none">contactus@carecompass.com</a></p></li>
                <li><p><strong>Address:</strong> Colombo, Sri Lanka</p></li>
            </ul>
            </div>

            <!-- Column 4: Social Media -->
            <div class="col-md-3 text-center text-md-start">
            <h5 class="fw-bold">Follow Us</h5>
                <div class="d-flex justify-content-center justify-content-md-start">
                
                    <a href="#" class="me-3"><i class="fab fa-facebook fa-2x text-primary"></i></a>
                    <a href="#" class="me-3"><i class="fab fa-instagram fa-2x text-danger"></i></a>
                    <a href="#" class="me-3"><i class="fab fa-linkedin fa-2x text-info"></i></a>
                    <a href="#"><i class="fab fa-youtube fa-2x text-danger"></i></a>
                </div>
            </div>
        </div>

        <!-- Copyright Section -->
        <div class="text-center mt-4">
            <p class="mb-0 small">&copy; <?php echo date("Y"); ?> Care Compass Hospitals. All Rights Reserved.</p>
        </div>
    </div>
</footer>




    
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
