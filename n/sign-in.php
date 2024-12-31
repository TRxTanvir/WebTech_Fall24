<html>
<head>
	<title>Log in</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<h1>Login for Help our Child </h1>
<?php
	$db_username = "system";
	$db_password = "scott";
	$connection_string="localhost/xe";
	$conn=oci_connect($db_username, $db_password, $connection_string);

	if($conn)
	{
		if(isset($_POST['submit']))
		{
			if(isset($_POST['username']) && isset($_POST['password']))
			{
				$username = $_POST['username'];
				$password = $_POST['password'];

				$query = "SELECT * FROM AC WHERE USERNAME = '$username' AND PASSWORD = '$password'";
				$result = oci_parse($conn, $query);
				oci_execute($result);
				$row = oci_fetch_array($result, OCI_BOTH);
				$num_rows = oci_num_rows($result);
				if($num_rows == 1)
				{
					echo "<div class='alert'>Success!</div>";
				}
				else
				{
					echo "<div class='alert'>Invalid username or password!</div>";
				}
			}
			else
			{
				echo "<div class='alert'>Please enter username and password!</div>";
			}

			echo "<br><br>";
		}
	}
	else
	{
		echo "<div class='alert'>Connection Failed!</div>";
	}	
?>
	
	<form action="main.php" method="POST">
		<fieldset>
			<legend>  Login</legend>
			<label for="username">Username</label><br>
			<input type="text" name="username">
			<br><br>
			<label for="password">Password</label><br>
			<input type="password" name="password">
			<br><br>
			<input type="submit" name="submit" id="submit-btn" value="Log in">
		</fieldset>
	</form>
</body>
</html>