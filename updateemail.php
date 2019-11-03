<?php
//start session and connect
session_start();
include ('connection.php');

//get user_id and new email sent through Ajax
$id = $_SESSION['note_id'];


//define error messages
$missingEmail = '<p><strong> Please enter your new email address</strong> </p>';
$invalidEmail = '<p><strong> Please enter a valid email address</strong></p>';

//variables to be used later
$errors = '';
$email = null;

//get email
if (empty($_POST['mail'])) {
 //assign error message
 $errors .= $missingEmail;
} else {
 //sanitize email
 $email= filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);

 if(!filter_var($email , FILTER_VALIDATE_EMAIL)){
   //assign error message
    $errors .= $invalidEmail;
 }
};

//output error if there is an error
if ($errors) {
 $errorMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
 echo $errorMessage;
 exit;
};


//check if new email exists
$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($connect, $sql);
$count = $count = mysqli_num_rows($result);
if($count>0){
    echo "<div class='alert alert-danger'><strong>There is already as user registered with that email! Please choose another one!</strong></div>"; exit;
}

//get the current/old email
$sql = "SELECT * FROM users WHERE user_id='$id'";
$result = mysqli_query($connect, $sql);

$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_assoc($result); 
    $oldemail = $row['email']; 
}else{
    echo "<div class='alert alert-danger'><strong>There was an error retrieving the email from the database</strong></div>";
    exit;   
}

//create a unique activation code
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));

//insert new activation code in the users table
$sql = "UPDATE users SET activation='$activationKey' WHERE user_id = '$id'";
$result = mysqli_query($connect, $sql);
if(!$result){
    echo "<div class='alert alert-danger'><strong>There was an error inserting the user details in the database.</strong></div>";exit;
}else{
    //send email with link to activatenewemail.php with current email, new email and activation code
    $message = "Please click on this link prove that you own this email:\n\n";
$message .= "http://127.0.0.1:5500/note/activatenewemail.php?email=" .urlencode($oldemail) . "&newemail=" .urlencode($email) ."&key=$activationKey";
$subject = "Email Update for your Online Notes App";
$header = "From: onlinenote@gmail.com";


if(mail($email, $subject, $message, $header)){
       echo "<div class='alert alert-success'><strong>An email has been sent to $email. Please click on the link to prove you own that email address.</div></strong>";
}
    
}

mysqli_close($connect);
?>