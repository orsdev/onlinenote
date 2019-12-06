<?php
// Start Session;
session_start();

//import connection.php file
include 'connection.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './PHPMailer/Exception.php';
require './PHPMailer/PHPMailer.php';
require './PHPMailer/SMTP.php';

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
$username = null;
$password = null;
$email = null;

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
 } elseif (!(strlen($_POST['password']) >= 6 && preg_match('/[A-Z]/', $_POST['password']) && preg_match('/[0-9]/', $_POST['password']))) {
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
 $errorMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
 echo $errorMessage;
 exit;
}

//no errors
$username = mysqli_real_escape_string($connect, $username);
$email = mysqli_real_escape_string($connect, $email);
$password = mysqli_real_escape_string($connect, $password);

//hash your password for security purposes, md5 is not the strongest hashing function, there are others
$password = hash('sha256', $password);

//query to check if username exist
$sql = "SELECT * FROM users WHERE username = '$username'";

//make query
$result = mysqli_query($connect, $sql);

//stop query from running if there is an error
if (!$result) {
 die("<p class='alert alert-danger'> Error: Query error</p>");
};

$numRows = mysqli_num_rows($result);

if ($numRows > 0) {
 //show message if username exist
 echo "<p class='alert alert-danger'> Username is already taken</p>";
 exit;
}


//query to check if email exist
$sql = "SELECT * FROM users WHERE email = '$email'";

//make query
$result = mysqli_query($connect, $sql);

//stop query from running if there is an error
if (!$result) {
 die("<p class='alert alert-danger'> Error: Query error</p>");
};

$numRows = mysqli_num_rows($result);

if ($numRows > 0) {
 //show message if username exist
 echo "<p class='alert alert-danger'> Email address has already been registered.</p>";
 exit;
};

//create unique activation code
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));

//query to insert into table
$sql = "INSERT INTO 
users(username , email, password , activation) 
VALUES('$username' , '$email' , '$password' , '$activationKey')";

//make query
$result = mysqli_query($connect, $sql);

//stop query from running if there is error
if (!$result) {
 die("<p class='alert alert-danger'> Error: Unable into insert user datails into database</p>");
};



// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
 //Server settings
     // Enable verbose debug output
 //$mail->SMTPDebug = SMTP::DEBUG_SERVER;        
 $mail->isSMTP();                                //Send using SMTP
 $mail->Host = 'smtp.gmail.com';
 $mail->SMTPAuth = true;
 $mail->Username = 'onlinenotie19@gmail.com'; 
 $mail->Password = 'Onlinenotie1995';             
 $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
 $mail->Port = 587;                                
 //Recipients
 $mail->setFrom('onlinenotie19@gmail.com', 'Notie');
 $mail->addAddress($email, $username);

$body = "<html>
<head>
<style>
h1 {
 padding: 20px 10px;
 opacity: .6;
 width: 100%;
 text-align: center;
}

.message-body {
 margin-top: 15px;
 width: 100%;
 text-align: center;
}

a.btn, a{
border-radius:3px;
color: white;
display:inline-block;
text-decoration:none;
background-color:#3490dc;
border-top:10px solid #3490dc;
border-right:18px solid #3490dc;
border-bottom:10px solid #3490dc;
border-left:18px solid #3490dc;
width: 120px;
margin: 0 auto;
text-align: center;
margin-top: 20px;
margin-bottom: 20px;
}

h3, p {
 text-align: left;
}

</style>
</head>
<body>

<h1> Notie </h1>
<div class='message-body'>
<h3> Hello! </h3>
<p> Please click the button below to verify your account. </p>

<a rel='nofollow' target='_blank' class='btn' href='http://127.0.0.1:5500/note/activate.php?email=" . urlencode($email) . "&key=$activationKey'>Verify Email Address</a>

</div>
</body>
</html>";

 // Content
 $mail->isHTML(true); 
 $mail->Subject = 'Verify Your Account';
 $mail->Body = $body;
 $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

 $mail->send();
 echo "<p class='alert alert-success'> <strong>Thank you for registering. A confirmation email has been sent to the email address provided. Please click on the activation link to activate your account</strong></p>";
} catch (Exception $e) {
 //debug message
 // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
 echo "Message could not be sent. Try again later!";
};

mysqli_close($connect);
?>