<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $conn = oci_connect("system", "scott", "//localhost/XE");

    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $name = $_POST["name"];
    $fathersName = $_POST["fathersName"];
    $mothersName = $_POST["mothersName"];
    $email = $_POST["email"];
    $zid = $_POST["zid"];
    $orgId = $_POST["orgId"];
    $sid = $_POST["sid"];
    $roadNo = $_POST["roadNo"];
    $houseNo = $_POST["houseNo"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $salary = $_POST["salary"];
    $timeSection = $_POST["timeSection"];
    $shift = $_POST["shift"];

    $query = "INSERT INTO Adoption_Staff (
        NAME,
        FATHERS_NAME,
        MOTHERS_NAME,
        EMAIL,
        ZID,
        ORG_ID,
        SID,
        ROAD_NO,
        HOUSE_NO,
        AGE,
        GENDER,
        SALARY,
        TIME_SECTION,
        SHIFT
    ) VALUES (
        :name,
        :fathersName,
        :mothersName,
        :email,
        :zid,
        :orgId,
        :sid,
        :roadNo,
        :houseNo,
        :age,
        :gender,
        :salary,
        :timeSection,
        :shift
    )";

    $statement = oci_parse($conn, $query);

    oci_bind_by_name($statement, ":name", $name);
    oci_bind_by_name($statement, ":fathersName", $fathersName);
    oci_bind_by_name($statement, ":mothersName", $mothersName);
    oci_bind_by_name($statement, ":email", $email);
    oci_bind_by_name($statement, ":zid", $zid);
    oci_bind_by_name($statement, ":orgId", $orgId);
    oci_bind_by_name($statement, ":sid", $sid);
    oci_bind_by_name($statement, ":roadNo", $roadNo);
    oci_bind_by_name($statement, ":houseNo", $houseNo);
    oci_bind_by_name($statement, ":age", $age);
    oci_bind_by_name($statement, ":gender", $gender);
    oci_bind_by_name($statement, ":salary", $salary);
    oci_bind_by_name($statement, ":timeSection", $timeSection);
    oci_bind_by_name($statement, ":shift", $shift);

    if (oci_execute($statement)) {
        echo "<script>alert('Data inserted successfully!');</script>";
    } else {
        $e = oci_error($statement);
        echo "<script>alert('Error: " . htmlentities($e['message'], ENT_QUOTES) . "');</script>";
    }

    oci_free_statement($statement);
    oci_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: calc(100% - 10px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Insert Data</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="fathersName">Father's Name:</label>
                <input type="text" id="fathersName" name="fathersName" required>
            </div>
            <div class="form-group">
                <label for="mothersName">Mother's Name:</label>
                <input type="text" id="mothersName" name="mothersName" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="zid">ZID:</label>
                <input type="number" id="zid" name="zid" required>
            </div>
            <div class="form-group">
                <label for="orgId">OrgId:</label>
                <input type="number" id="orgId" name="orgId" required>
            </div>
            <div class="form-group">
                <label for="sid">SID:</label>
                <input type="number" id="sid" name="sid" required>
            </div>
            <div class="form-group">
                <label for="roadNo">RoadNumber:</label>
                <input type="number" id="roadNo" name="roadNo" required>
            </div>
            <div class="form-group">
                <label for="houseNo">houseNo:</label>
                <input type="number" id="houseNo" name="houseNo" required>
            </div>

            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required>
            </div>

            <div class="form-group">
                <label for="gender">gender:</label>
                <input type="text" id="gender" name="gender" required>
            </div>
            
            <div class="form-group">
                <label for="salary">salary:</label>
                <input type="text" id="salary" name="salary" required>
            </div>

            <div class="form-group">
                <label for="timeSection">timeSection:</label>
                <input type="text" id="timeSection" name="timeSection" required>
            </div>
            <div class="form-group">
                <label for="shift">shift:</label>
                <input type="text" id="shift" name="shift" required>
            </div>

            <!-- Add more form fields according to your table structure -->

            <button type="submit" name="submit">Submit</button>
            <button type="reset">Reset</button>
        </form>

         <!-- logout button -->
         <a href="welcome.php">Logout</a>

<!-- Main menu link -->
<a href="main.php">Main Menu</a>
    </div>
</body>
</html>
