<?php
session_start();

include('db_config.php');

if (!isset($_SESSION['user_id'])) {
    die("You need to be logged in to give feedback.");
}

$patient_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];

    // Insert feedback into the database
    $feedback_sql = "INSERT INTO feedback (id, rating, comments) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($feedback_sql);
    $stmt->bind_param("iis", $patient_id, $rating, $comments);

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
    <title>Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container my-5">
    <h2 class="text-center">Feedback</h2>
    <p class="text-center">We value your feedback. Please let us know how we can improve your experience.</p>

    <!-- Feedback Form -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="feedback.php">
                <div class="form-group">
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

                <div class="form-group">
                    <label for="comments">Comments</label>
                    <textarea class="form-control" id="comments" name="comments" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Submit Feedback</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

</body>
</html>
