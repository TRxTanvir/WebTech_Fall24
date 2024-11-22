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
    $password = md5($_POST['password']); // Using MD5 for password encryption

    // Check if the user exists in the database
    $stmt = $mysqli->prepare("SELECT id, name, job, email FROM users WHERE name=? AND password=?");
    $stmt->bind_param("ss", $name, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User exists, fetch data and set session variables
        $stmt->bind_result($user_id, $name, $job, $email);
        $stmt->fetch();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;
        $_SESSION['job'] = $job;
        $_SESSION['email'] = $email;

        // Redirect to the profile page
        header("Location: profile.php");
        exit;
    } else {
        $error_message = "Invalid credentials, please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
</head>
<body>
    <div class="container">
        <h1>Login</h1>

        <!-- Display error message if any -->
        <?php if (isset($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>

        <form method="POST">
            <div>
                <label for="name">Username:</label>
                <input type="text" name="name" id="name" required>
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div>
                <button type="submit">Login</button>
            </div>
        </form>

        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
