<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request'])) {
    $conn = oci_connect("system", "scott", "//localhost/XE");

    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $contactPersonName = $_POST["contactPersonName"];
    $contactPersonPhone = $_POST["contactPersonPhone"];
    $cardNumber = $_POST["cardNumber"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];

    // Assuming REQUESTID is an auto-generated identity column
    $querySequence = "SELECT RFR_SEQ.NEXTVAL FROM DUAL";
    $stmtSequence = oci_parse($conn, $querySequence);
    oci_execute($stmtSequence);
    $row = oci_fetch_assoc($stmtSequence);
    $requestId = $row['NEXTVAL'];

    $queryInsert = "INSERT INTO RFR (
        REQUESTID,
        Contact_Person_Name,
        Contact_Person_Phone_Number,
        Card_Number,
        Gender,
        Address
    ) VALUES (
        :requestId,
        :contactPersonName,
        :contactPersonPhone,
        :cardNumber,
        :gender,
        :address
    )";

    $statementInsert = oci_parse($conn, $queryInsert);

    oci_bind_by_name($statementInsert, ":requestId", $requestId);
    oci_bind_by_name($statementInsert, ":contactPersonName", $contactPersonName);
    oci_bind_by_name($statementInsert, ":contactPersonPhone", $contactPersonPhone);
    oci_bind_by_name($statementInsert, ":cardNumber", $cardNumber);
    oci_bind_by_name($statementInsert, ":gender", $gender);
    oci_bind_by_name($statementInsert, ":address", $address);

    if (oci_execute($statementInsert)) {
        echo "<script>alert('Request submitted successfully!');</script>";
    } else {
        $e = oci_error($statementInsert);
        echo "<script>alert('Error: " . htmlentities($e['message'], ENT_QUOTES) . "');</script>";
    }

    oci_free_statement($stmtSequence);
    oci_free_statement($statementInsert);
    oci_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request for Rescue</title>
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
            margin-right: 10px;
        }

        .clear-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Request for Rescue</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="contactPersonName">Contact Person Name:</label>
                <input type="text" id="contactPersonName" name="contactPersonName" required>
            </div>
            <div class="form-group">
                <label for="contactPersonPhone">Contact Person Phone Number:</label>
                <input type="tel" id="contactPersonPhone" name="contactPersonPhone" required>
            </div>
            <div class="form-group">
                <label for="cardNumber">Card Number:</label>
                <input type="text" id="cardNumber" name="cardNumber" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <input type="text" id="gender" name="gender" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <button type="submit" name="request">Request</button>
            <button type="reset">Reset</button>
        </form>

           <!-- logout button -->
           <a href="welcome.php">Logout</a>

<!-- Main menu link -->
<a href="main.php">Main Menu</a>
    </div>
</body>
</html>