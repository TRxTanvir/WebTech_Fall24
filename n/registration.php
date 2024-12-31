<html>
    <head>
        <title>Registration</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h1>Register for Help Child</h1>
<?php

$conn = oci_connect("system", "scott", "//localhost/XE");

// Check connection
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$query = "SELECT * FROM AC";
$statement = oci_parse($conn, $query);
oci_execute($statement);

while ($row = oci_fetch_array($statement, OCI_ASSOC + OCI_RETURN_NULLS)) {
    // Process each row of data
    // Example: echo $row['AC'];
}

oci_free_statement($statement);
oci_close($conn);


	$db_username = "system";
	$db_password = "scott";
	$connection_string="//localhost/xe";
	$conn=oci_connect($db_username, $db_password, $connection_string);

	if($conn)
	{
		if(isset($_POST['submit']))
		{
			if(isset($_POST['name']) && isset($_POST['username']) && isset($_POST['address']) && isset($_POST['phone']) && isset($_POST['password']))
			{
				if($_POST['name'] != "" && $_POST['username'] != "" && $_POST['address'] != "" && $_POST['phone'] != "" && $_POST['password'] != "")
                {
                    $name = $_POST['name'];
                    $username = $_POST['username'];
                    $address = $_POST['address'];
                    $phone = $_POST['phone'];
                    $password = $_POST['password'];
                    $c_id = 1;

                    //generate new id
                    // $query = "SELECT c_id FROM AC order by c_id desc";
                    // $result = oci_parse($conn, $query);
                    // oci_execute($result);
                    // $row =oci_fetch_assoc($result);
                    // $num_rows = oci_num_rows($result);
                    // if($num_rows == 1)
                    // {
                    //     $c_id = $row[1];
                    //     $c_id = $c_id + 10;
                    // }
                    // else
                    // {
                    //     $c_id = 5;
                    // }
                    $query = "SELECT c_id FROM AC ORDER BY c_id DESC";
$result = oci_parse($conn, $query);
oci_execute($result);

// Fetch the first row
$row = oci_fetch_assoc($result);

if ($row) {
    // If a row is fetched, increment the c_id by 10
    $c_id = $row['C_ID'] + 10;
} else {
    // If no row is fetched, set c_id to 5
    $c_id = 5;
}

oci_free_statement($result);

                    //insert into database
                    $query = "INSERT INTO AC VALUES ( '$name', '$username', '$address', '$phone', '$password', $c_id)";
                    $result = oci_parse($conn, $query);
                    oci_execute($result);
                    if($result)
                    {
                        echo "<div class='alert'>Registration Successful!</div>";
                    }
                    else
                    {
                        echo "<div class='alert'>Registration Failed!</div>";
                    }
                }
                else
                {
                    echo "<div class='alert'>Please fill in all fields!</div>";
                }
			}
			else
			{
				echo "<div class='alert'>Please fill up all the fields!</div>";
			}

			echo "<br><br>";
		}
	}
	else
	{
		echo "<div class='alert'>Connection Failed!</div>";
	}	
?>
        <form action="" method="POST">
            <fieldset>
                <legend> Registration</legend>
                <label for="name">Name</label><br>
                <input type="text" name="name"><br><br>
                <label for="username">Username</label><br>
                <input type="text" name="username"><br><br>
                <label for="address">Address</label><br>
                <input type="text" name="address"><br><br>
                <label for="phone">Phone</label><br>
                <input type="text" name="phone"><br><br>
                <label for="password">Password</label><br>
                <input type="password" name="password"><br><br>
                <input type="submit" name="submit" id="submit-btn" value="Register">
            </fieldset>
        </form>
    </body>
</html>