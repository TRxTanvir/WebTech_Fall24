<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="number"],
        input[type="text"],
        input[type="date"],
        button {
            width: calc(100% - 22px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #ff0000;
            margin-bottom: 10px;
        }

        a {
            color: #333;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        p.links {
            text-align: center;
            margin-top: 20px;
        }

        @media (max-width: 480px) {
            form {
                max-width: 100%;
            }
        }
        p.links {
            text-align: center;
            margin-top: 20px;
        }

        p.links a {
            color: red;
            margin: 0 10px;
        }

    </style>
</head>
<body>
<?php
 

 
        $conn = oci_connect("system", "scott", "//localhost/XE");

        // Check connection
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay'])) {
    $bkashNumber = $_POST["bkashNumber"];
    $trxID = $_POST["trxID"];
    $amount = $_POST["amount"];
    $date = $_POST["date"];

    $queryInsert = "INSERT INTO Transaction (BkashNumber, TrxID, Amount, TransactionDate) VALUES (:bkash_number, :trx_id, :amount, TO_DATE(:trx_date, 'YYYY-MM-DD'))";
    $statementInsert = oci_parse($conn, $queryInsert);
    oci_bind_by_name($statementInsert, ":bkash_number", $bkashNumber);
    oci_bind_by_name($statementInsert, ":trx_id", $trxID);
    oci_bind_by_name($statementInsert, ":amount", $amount);
    oci_bind_by_name($statementInsert, ":trx_date", $date);

    if (oci_execute($statementInsert)) {
        echo "<p>Payment recorded successfully!</p>";
        
    } else {
        $e = oci_error($statementInsert);
        echo "<p class='error-message'>Error: " . $e['message'] . "</p>";
    }

    oci_free_statement($statementInsert);
}

oci_close($conn);
?>

    <h1>Donation Form</h1>
    <form action="" method="post">
        <label for="bkashNumber">Bkash Number:</label>
        <input type="number" id="bkashNumber" name="bkashNumber" required>

        <label for="trxID">TrxID:</label>
        <input type="text" id="trxID" name="trxID" required>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <button type="submit" name="pay">Pay</button>
        <button type="button" onclick="clearForm()">Clear</button>
    </form>

    <p class="links">
        <a href="main.php">Back to Main</a>
        |
        <a href="welcome.php">Logout</a>
    </p>

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
