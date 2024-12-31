
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
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

        .error-message {
            color: #ff0000;
            margin-bottom: 10px;
            text-align: center;
        }

        .clear-button {
            background-color: #f44336;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 49%;
        }

        .clear-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <h1>Registration Form</h1>

 <?php
        $conn = oci_connect("system", "scott", "//localhost/XE");

        // Check connection
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $password = $_POST["password"]; // Assuming the password is a string
            $emailAddress = $_POST["emailAddress"];

            // Check if the email address already exists
            $queryCheckDuplicate = "SELECT COUNT(*) AS duplicate_count FROM rg WHERE Email_address = :email";
            $stmtCheckDuplicate = oci_parse($conn, $queryCheckDuplicate);
            oci_bind_by_name($stmtCheckDuplicate, ":email", $emailAddress);
            oci_execute($stmtCheckDuplicate);

            $rowDuplicate = oci_fetch_assoc($stmtCheckDuplicate);
            $duplicateCount = $rowDuplicate['DUPLICATE_COUNT'];
            oci_free_statement($stmtCheckDuplicate);

            if ($duplicateCount > 0) {
                echo "<p class='error-message'>An account with this email address already exists!</p>";
            } else {
                // Continue with the insertion logic
                $rgid_sequence = "Rg_rgid.NEXTVAL";
                $queryInsert = "INSERT INTO Rg (rgid, name, password, Email_address) VALUES ($rgid_sequence, :name, :password, :email)";
                $statementInsert = oci_parse($conn, $queryInsert);
                oci_bind_by_name($statementInsert, ":name", $name);
                oci_bind_by_name($statementInsert, ":password", $password);
                oci_bind_by_name($statementInsert, ":email", $emailAddress);

                // Execute the statement
                if (oci_execute($statementInsert)) {
                    echo "<p>Registration successful!</p>";
                } else {
                    $e = oci_error($statementInsert);
                    echo "<p class='error-message'>Error: " . $e['message'] . "</p>";
                }

                oci_free_statement($statementInsert);
            }
        }

        oci_close($conn);
 ?>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>


        <label for="emailAddress">Email Address:</label>
        <input type="email" id="emailAddress" name="emailAddress" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Register</button>
        <button type="button" class="clear-button" onclick="clearForm()">Clear</button>
        
    </form>

    <p>Already have an account? <a href="welcome.php" class="signin-link">Sign In</a></p>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        function clearForm() {
            document.getElementById("name").value = "";
            document.getElementById("password").value = "";
            document.getElementById("emailAddress").value = "";
        }
    </script>
</body>
</html>
