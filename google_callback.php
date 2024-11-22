<?php
session_start();

// Include the Google API client library
include_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('YOUR_GOOGLE_CLIENT_ID');
$client->setClientSecret('YOUR_GOOGLE_CLIENT_SECRET');
$client->setRedirectUri('YOUR_REDIRECT_URI');
$client->addScope('email');

// If the user is already logged in, redirect them to the profile
if (isset($_SESSION['user_id'])) {
    header('Location: profile.php');
    exit;
}

// Check if the user is returning from Google
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Get user information from Google
    $google_oauth = new Google_Service_Oauth2($client);
    $google_user = $google_oauth->userinfo->get();

    // Check if the email exists in the database
    include('db.php');
    $email = $google_user->email;
    $stmt = $mysqli->prepare("SELECT id, name, job FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If the user exists, log them in
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $name, $job);
        $stmt->fetch();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;
        $_SESSION['job'] = $job;
        $_SESSION['email'] = $email;
        header('Location: profile.php');
    } else {
        // User does not exist, redirect to registration page
        $_SESSION['google_email'] = $email;
        $_SESSION['google_username'] = $google_user->name;
        header('Location: register.php');
    }
} else {
    header('Location: login.php');
    exit();
}
?>
