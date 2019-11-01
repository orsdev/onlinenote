<?php
//start session
session_start();
//import connection.php
include 'connection.php';

//get id from session
$sessionUsername = $_SESSION['username'];

//define error messages
$missingUsername = '<p><strong> Please enter your new username</strong> </p>';
$usernameLength = '<p><strong>Your username should be at least 5 characters</strong></p>';

//variables to be used later
$errors = '';
$username = null;

//get email
if (empty($_POST['editusername'])) {
 //assign error message
 $errors .= $missingUsername;
} else {
 //sanitize email
 $username= filter_var($_POST['editusername'], FILTER_SANITIZE_EMAIL);

 if(strlen($_POST['editusername']) < 5){
   //assign error message
    $errors .= $usernameLength;
 }
};

//output error if there is an error
if ($errors) {
 $errorMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
 echo $errorMessage;
 exit;
};

//no errors
$username = mysqli_real_escape_string($connect , $username);

//query to run
$sql = "UPDATE users SET username = '$username' WHERE username='$sessionUsername'";

//run query
$result = mysqli_query($connect , $sql);

//check query for errors
if(!$result) {
 $message = '<div class="alert alert-danger"> <strong>Unable to change username. Please try again later!</strong></div>';
 echo $message;
 exit;
};

//re-assign new value to username session
$_SESSION['username'] = $username;

$message = 
  '<div class=" alert alert-success"> <strong>Username has been changed successfully.</div>';

echo $message;
//close connection
mysqli_close($connect);