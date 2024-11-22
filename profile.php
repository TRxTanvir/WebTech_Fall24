<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Get user data from session
$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];
$job = $_SESSION['job']; // Job is stored in the session
$email = ''; // Placeholder for email, will fetch from DB
$profile_pic = ''; // Placeholder for profile picture, will fetch from DB
$country = $_SESSION['country'];


// Include database connection
include('db.php');

// Fetch email and profile picture from the database based on user_id
$stmt = $mysqli->prepare("SELECT email, profile_pic FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($email, $profile_pic);
    $stmt->fetch();
} else {
    echo "Error fetching user data.";
}

// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_pic'])) {
    $errors = array();
    $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
    $file_name = $_FILES['profile_pic']['name'];
    $file_tmp = $_FILES['profile_pic']['tmp_name'];
    $file_size = $_FILES['profile_pic']['size'];
    $file_type = $_FILES['profile_pic']['type'];

    // Check if the uploaded file is an allowed type
    if (!in_array($file_type, $allowed_types)) {
        $errors[] = "Only JPEG, PNG, and GIF files are allowed.";
    }

    // Check if the file size is below the allowed limit (e.g., 2MB)
    if ($file_size > 2097152) {
        $errors[] = "File size must be less than 2MB.";
    }

    if (empty($errors)) {
        // Create a unique name for the file
        $new_file_name = "profile_" . $user_id . "_" . time() . "." . pathinfo($file_name, PATHINFO_EXTENSION);
        $upload_dir = "uploads/"; // Make sure the "uploads" directory exists
        $upload_path = $upload_dir . $new_file_name;

        // Move the uploaded file to the server's "uploads" folder
        if (move_uploaded_file($file_tmp, $upload_path)) {
            // Update the database with the new profile picture
            $update_stmt = $mysqli->prepare("UPDATE users SET profile_pic=? WHERE id=?");
            $update_stmt->bind_param("si", $new_file_name, $user_id);
            $update_stmt->execute();

            // Update the session with the new profile picture path
            $_SESSION['profile_pic'] = $new_file_name;

            // Redirect to the profile page to see the updated picture
            header("Location: profile.php");
            exit;
        } else {
            $errors[] = "There was an error uploading the file.";
        }
    }

    // If there were errors, show them
    if (!empty($errors)) {
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>" . $error . "</li>";
        }
        echo "</ul>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($name); ?>!</h1>

        <!-- Profile Info Section -->
        <div class="profile-info">
            <div>
                <p><strong>Name: </strong><?php echo htmlspecialchars($name); ?></p>
                <p><strong>Email: </strong><?php echo htmlspecialchars($email); ?></p> <!-- Email will now be displayed -->
                <p><strong>Job: </strong><?php echo htmlspecialchars($job); ?></p>
            </div>

            <div class="profile-pic-container">
                <!-- Display Profile Picture -->
                <?php if ($profile_pic): ?>
                    <img src="uploads/<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-pic">
                <?php else: ?>
                    <img src="uploads/default.png" alt="Profile Picture" class="profile-pic">
                <?php endif; ?>
            </div>
        </div>

        <!-- Form for Uploading New Profile Picture -->
        <div class="upload-form">
            <h3>Change Profile Picture</h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="file" name="profile_pic" required><br>
                <button type="submit">Upload</button>
            </form>
        </div>

        <!-- Logout Button -->
        <div class="logout-link">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>