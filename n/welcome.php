<?php
$db_username = "system";
$db_password = "scott";
$connection_string = "//localhost/XE";
$conn = oci_connect($db_username, $db_password, $connection_string);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT * FROM rg WHERE Email_address = :email";
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ":email", $email);
        oci_execute($stmt);

        $row = oci_fetch_assoc($stmt);

        if ($row) {
            $storedPasswordHash = $row['PASSWORD'];

            // Verify the password using an alternative method
            if ($password === $storedPasswordHash) {
                // Passwords match, redirect to main.php
                header("Location: main.php", 301);
                exit();
            } else {
                echo "<div class='alert'>Incorrect password!</div>";
            }
        } else {
            echo "<div class='alert'>Email not found!</div>";
        }

        oci_free_statement($stmt);
    } else {
        echo "<div class='alert'>Please enter email and password!</div>";
    }
}

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Child Adoption Management System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            font-size: 16px;
        }

        input {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            color: #333;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .clear-button {
            background-color: #f44336;
            margin-right: 1px;
        }

        .clear-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to Child Adoption Management System</h1>
        <form action="" method="post">

            <div class="form-group">
                <label for="username">Email</label>
                <input type="text" id="username" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login">Login</button>
            <button type="button" class="clear-button" onclick="clearForm()">Clear</button>
        </form>
        <p>Create an account? <a href="rg.php" class="signup-link">Sign Up</a></p>
    </div>

    <script>
        function clearForm() {
            document.getElementById("username").value = "";
            document.getElementById("password").value = "";
        }
    </script>
</body>

</html>