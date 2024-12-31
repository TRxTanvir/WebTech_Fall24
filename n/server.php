<?php
session_start();

// initializing variables
 


    $conn = oci_connect("system", "scott", "//localhost/XE");

    // Check connection
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }


// connect to the database
$tns = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = XE)))";
$db_username = "system";
$db_password = "scott";

try {
    $conn = new PDO("oci:dbname=".$tns, $db_username, $db_password);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $username = $conn->quote($_POST['username']);
    $email = $conn->quote($_POST['email']);
    $password_1 = $conn->quote($_POST['password_1']);
    $password_2 = $conn->quote($_POST['password_2']);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // first check the database to make sure 
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE username=:username OR email=:email";
$stmt = $conn->prepare($user_check_query);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

  
    if ($user) { // if user exists
        if ($user['USERNAME'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['EMAIL'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database

        $query = "INSERT INTO users (username, email, password) 
                  VALUES($username, $email, '$password')";
        $conn->exec($query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: main.php');
    }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = $conn->quote($_POST['username']);
    $password = $conn->quote($_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username=$username AND password='$password' AND ROWNUM = 1";
        $result = $conn->query($query);
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: main.php');
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

?>
