<?php
// Include necessary database connection code and functions for validation and hashing

// Function to validate the reset token
function validateResetToken($token) {
    // Implement your logic to validate the reset token
    // Verify that the token exists in the database and is not expired
    return true; // Return true if the token is valid, false otherwise
}

// Function to update the user's password
function updatePassword($email, $newPassword) {
    // Implement your logic to update the user's password in the database
    return true; // Return true if the password is updated successfully
}

// Check if the token is provided in the URL
if (isset($_GET['token'])) {
    $resetToken = $_GET['token'];

    // Validate the reset token
    if (validateResetToken($resetToken)) {
        // Token is valid, allow the user to set a new password
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $newPassword = $_POST["new_password"];

            // Validate and sanitize the new password
            // Implement your validation logic here

            // Update the password in the database
            if (updatePassword($email, $newPassword)) {
                echo "<p>Password updated successfully. <a href='login.php'>Login</a></p>";
            } else {
                echo "<p>Error updating the password.</p>";
            }
        } else {
            // Display the form for setting a new password
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Set New Password</title>
                <style>
                    body {
                        background-color: #f0f0f0;
                        font-family: 'Arial', sans-serif;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                    }

                    form {
                        background-color: #ffffff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        width: 300px;
                    }

                    h1 {
                        text-align: center;
                        color: #333;
                    }

                    label {
                        display: block;
                        margin: 10px 0 5px;
                        color: #555;
                    }

                    input {
                        width: 100%;
                        padding: 8px;
                        margin-bottom: 10px;
                        box-sizing: border-box;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                    }

                    button {
                        background-color: #4caf50;
                        color: #fff;
                        padding: 10px 15px;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                        width: 100%;
                        margin-bottom: 10px;
                    }

                    button:hover {
                        background-color: #45a049;
                    }
                </style>
            </head>
            <body>
                <form action="" method="post">
                    <h1>Set New Password</h1>
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>
                    <button type="submit">Set Password</button>
                </form>
            </body>
            </html>
            <?php
        }
    } else {
        echo "<p>Invalid or expired token. Please try the password reset process again.</p>";
    }
} else {
    echo "<p>Token not provided. Please use the password reset link from your email.</p>";
}
?>
