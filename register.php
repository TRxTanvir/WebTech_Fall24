<?php
session_start(); // Start the session

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: profile.php"); // Redirect to profile if already logged in
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('db.php'); // Include database connection

    // Sanitize and collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Encrypt password using MD5
    $job = $_POST['job']; // Collect job

    // Insert data into the database
    $stmt = $mysqli->prepare("INSERT INTO users (name, email, password, job) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $job);

    if ($stmt->execute()) {
        // Redirect to login page after successful registration
        header("Location: login.php");
        exit;
    } else {
        $error_message = "Error registering, please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
</head>
<body>
    <div class="container">
        <h1>Register</h1>

        <!-- Display error message if any -->
        <?php if (isset($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>

        <form method="POST">
            <div>
                <label for="name">Username:</label>
                <input type="text" name="name" id="name" required>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>

            <div>
                <label>Job:</label>
                <input type="radio" name="job" value="student" required> Student
                <input type="radio" name="job" value="teacher" required> Teacher
            </div>
            <div>
    <label>Country:</label>
    <select name="country" required>
        <option value="">Select a Country</option>
        <option value="USA">United States</option>
        <option value="Canada">Canada</option>
        <option value="UK">United Kingdom</option>
        <option value="Australia">Australia</option>
        <option value="India">India</option>
        <option value="Germany">Germany</option>
        <option value="France">France</option>
        <option value="Brazil">Brazil</option>
        <option value="Japan">Japan</option>
        <!-- Add more countries as needed -->
    </select>
</div>
            <div>
                <button type="submit">Register</button>
            </div>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
