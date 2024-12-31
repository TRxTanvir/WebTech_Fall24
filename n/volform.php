<?php
$conn = oci_connect("system", "scott", "//localhost/XE");

// Check connection
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $age = $_POST["age"];
    $reason = $_POST["reason"];

    // Check if the email address already exists
    $queryCheckDuplicate = "SELECT COUNT(*) AS duplicate_count FROM volform WHERE email = :email";
    $stmtCheckDuplicate = oci_parse($conn, $queryCheckDuplicate);
    oci_bind_by_name($stmtCheckDuplicate, ":email", $email);
    oci_execute($stmtCheckDuplicate);

    $rowDuplicate = oci_fetch_assoc($stmtCheckDuplicate);
    $duplicateCount = $rowDuplicate['DUPLICATE_COUNT'];
    oci_free_statement($stmtCheckDuplicate);

    if ($duplicateCount > 0) {
        echo "<p class='error-message'>An account with this email address already exists!</p>";
    } else {
        // Continue with the insertion logic
        $volform_id_sequence = "Volform_volform_id.NEXTVAL";
        $queryInsert = "INSERT INTO volform (volform_id, name, address, phone, email, age, reason) VALUES ($volform_id_sequence, :name, :address, :phone, :email, :age, :reason)";
        $statementInsert = oci_parse($conn, $queryInsert);
        oci_bind_by_name($statementInsert, ":name", $name);
        oci_bind_by_name($statementInsert, ":address", $address);
        oci_bind_by_name($statementInsert, ":phone", $phone);
        oci_bind_by_name($statementInsert, ":email", $email);
        oci_bind_by_name($statementInsert, ":age", $age);
        oci_bind_by_name($statementInsert, ":reason", $reason);

        // Execute the statement
        if (oci_execute($statementInsert)) {
            echo "<p>Data inserted successfully!</p>";
        } else {
            $e = oci_error($statementInsert);
            echo "<p class='error-message'>Error: " . $e['message'] . "</p>";
        }

        oci_free_statement($statementInsert);
    }
}

oci_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Form</title>
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
            width: 600px;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-top: 10px;
            font-size: 16px;
            color: #666;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .action-button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .action-button:hover {
            background-color: #45a049;
        }

        .logout-button {
            background-color: #f44336;
        }

        .logout-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Volunteer Form</h1>
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>

            <label for="reason">Why do you want to join us?</label>
            <textarea id="reason" name="reason" rows="4" required></textarea>

            <div class="action-buttons">
                <button class="action-button" type="submit">Submit</button>
                <button class="action-button" type="reset">Clear</button>
            </div>
        </form>

        <div class="action-buttons">
            <button class="logout-button" onclick="location.href='welcome.php'">Logout</button>
            <button class="logout-button" onclick="location.href='main.php'">Back</button>
        </div>
    </div>

    <?php
    $conn = oci_connect("system", "scott", "//localhost/XE");

    // Check connection
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $address = $_POST["address"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $age = $_POST["age"];
        $reason = $_POST["reason"];

    //     // Check if the email address already exists
    //     $queryCheckDuplicate = "SELECT COUNT(*) AS duplicate_count FROM volform WHERE email = :email";
    //     $stmtCheckDuplicate = oci_parse($conn, $queryCheckDuplicate);
    //     oci_bind_by_name($stmtCheckDuplicate, ":email", $email);
    //     oci_execute($stmtCheckDuplicate);

    //     $rowDuplicate = oci_fetch_assoc($stmtCheckDuplicate);
    //     $duplicateCount = $rowDuplicate['DUPLICATE_COUNT'];
    //     oci_free_statement($stmtCheckDuplicate);

    //     if ($duplicateCount > 0) {
    //         echo "<p class='error-message'>An account with this email address already exists!</p>";
        } else {
            // Continue with the insertion logic
            $volform_id_sequence = "Volform_volform_id.NEXTVAL";
            $queryInsert = "INSERT INTO volform (volform_id, name, address, phone, email, age, reason) VALUES ($volform_id_sequence, :name, :address, :phone, :email, :age, :reason)";
            $statementInsert = oci_parse($conn, $queryInsert);
            oci_bind_by_name($statementInsert, ":name", $name);
            oci_bind_by_name($statementInsert, ":address", $address);
            oci_bind_by_name($statementInsert, ":phone", $phone);
            oci_bind_by_name($statementInsert, ":email", $email);
            oci_bind_by_name($statementInsert, ":age", $age);
            oci_bind_by_name($statementInsert, ":reason", $reason);

            // Execute the statement
            if (oci_execute($statementInsert)) {
                echo "<p>Data inserted successfully!</p>";
            } else {
                $e = oci_error($statementInsert);
                echo "<p class='error-message'>Error: " . $e['message'] . "</p>";
            }

            oci_free_statement($statementInsert);
        }
    

    oci_close($conn);
    ?>
</body>

</html>

