<?php

//import connection.php file
include 'connection.php';

// Start Session;
session_start();
//define error messages
$missingEmail = '<p><strong> Please enter a email</strong> </p>';
$missingUsername = '<p><strong>Please enter a username</p>';
$usernameLength = '<p><strong>Your username should be at least 5 characters</strong></p>';
$invalidEmail = '<p><strong> Please enter a valid email address</strong></p>';
$missingPassword = '<p><strong>Please enter a password</strong></p>';
$invalidPassword = '<p><strong>Your password should be at least 6 characters long and include a capital letter and one number</strong></p>';
$missingPassword2 = '<p><strong> Please confirm your password</string></p>';
$differentPassword = '<p><strong> Passwords don\'t match</p>';

$errors = '';

//get username
if (isset($_POST['username'])) {
 //if empty, assign error
 if (strlen($_POST['username']) == 0) {
  $errors .= $missingUsername;
  //if lesser than 5, assign error
 } else if (strlen($_POST['username']) < 5) {
  $errors .= $usernameLength;
 } else {
  //remove weird code from username
  $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
 }
};

//get email
if (isset($_POST['email'])) {
 //if empty, assign error
 if (strlen($_POST['email']) == 0) {
  $errors .= $missingEmail;
 } else {
  //remove weird code from email
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  //check email if its valid
  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
   $errors .= $invalidEmail;
  }
 }
}

//get password
if (isset($_POST['password'])) {
 //if empty, assign error
 if (strlen($_POST['password']) == 0) {
  $errors .= $missingPassword;
  //if true, assign error
 } elseif (!(strlen($_POST['password']) > 6 && preg_match('/[A-Z]/', $_POST['password']) && preg_match('/[0-9]/', $_POST['password']))) {
  $errors .= $invalidPassword;
 } else {
  $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
  //check for confirm password input
  if (isset($_POST['confirm-password'])) {
   //if true, assign error
   if (strlen($_POST['confirm-password']) == 0) {
    $errors .= $missingPassword2;
    //if passwords dont match, assign error
   } else if (($password != $_POST['confirm-password'])) {
    $errors .= $differentPassword;
   } else {
    $confirmPassword = filter_var($_POST['confirm-password'], FILTER_SANITIZE_STRING);
   }
  }
 };
};

//if theres an error, output error messages
if ($errors) {
 $errorMessage = '<div class="alert alert-danger">' . $errors . '</div>';

 echo $errorMessage;
}

//no errors
$username = mysqli_real_escape_string($connect, $username);
$email = mysqli_real_escape_string($connect, $email);
$password = mysqli_real_escape_string($connect, $password);

//query to check if username exist
$sql = "SELECT * FROM users WHERE email = '$username'";

//make query
$result = mysqli_query($connect, $sql);

//stop query from running if there is an error
if (!$result) {
 die('<p class="alert alert-danger"> Error: Query error</p>');
};

$numRows = mysqli_num_rows($result);

if ($numRows > 0) {
 //show message if username exist
 echo '<p class="alert alert-danger"> Username is already taken</p>';
 exit;
}


//query to check if email exist
$sql = "SELECT * FROM users WHERE email = '$email'";

//make query
$result = mysqli_query($connect, $sql);

//stop query from running if there is an error
if (!$result) {
 die('<p class="alert alert-danger"> Error: Query error</p>');
};

$numRows = mysqli_num_rows($result);

if ($numRows > 0) {
 //show message if username exist
 echo '<p class="alert alert-danger"> Email address has already been registered.</p>';
 exit;
}
