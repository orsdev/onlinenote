<?php
  //start session
  session_start();
  //connect to database
  include 'connection.php';

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
  $invalidEmail = '<p><strong> Please enter a valid email address</strong></p>';

  $errors = '';
  $email = null;

  //get username
  if (isset($_POST['forgotemail'])) {
   //if empty, assign error
   if (strlen($_POST['forgotemail']) == 0) {
    $errors .= $missingEmail;
    //if lesser than 5, assign error
   } else {
    //remove weird code from email
    $email = filter_var($_POST['forgotemail'], FILTER_SANITIZE_EMAIL);
    //check email if its valid
    if (!filter_var($_POST['forgotemail'], FILTER_VALIDATE_EMAIL)) {
     $errors .= $invalidEmail;
    }
   }
  };

  //if theres an error, output error messages
  if ($errors) {
   $errorMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
   echo $errorMessage;
   exit;
  }

  //no errors
  $email = mysqli_real_escape_string($connect, $email);

//query to check if email exist
$sql = "SELECT * FROM users WHERE email = '$email'";

//make query
$result = mysqli_query($connect, $sql);

//stop query from running if there is an error
if (!$result) {
 die("<p class='alert alert-danger'> Error: Query error</p>");
};

$numRows = mysqli_num_rows($result);

if (!$numRows) {
 //show message if username exist
 echo "<p class='alert alert-danger'> Email address does not exist.</p>";
 exit;
};

$row = mysqli_fetch_assoc($result);

//get user_id
$user_id = $row['user_id'];

//create unique activation code
$key = bin2hex(openssl_random_pseudo_bytes(16));

$time = time();
$status = 'pending';
//query to insert into table
$sql = "INSERT INTO 
forgotpassword(user_id , user_key, time , status)
 VALUES('$user_id' , '$key' , '$time' , '$status')";

//make query
$result = mysqli_query($connect, $sql);

//stop query from running if there is error
if (!$result) {
 die("<p class='alert alert-danger'> Error: Unable into insert user datails into database</p>");
};


/*
send user an email with a link to activate.php with
their email and activation code
*/
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
 //Server settings
     // Enable verbose debug output
 //$mail->SMTPDebug = SMTP::DEBUG_SERVER;        
 $mail->isSMTP();                                             //Send using SMTP
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
<p> Please click on the link below to reset your password. </p>

<a rel='nofollow' target='_blank' class='btn' href='http://127.0.0.1:5500/note/resetpassword.php?user_id=$user_id&key=$key'>Reset Password</a>

</div>
</body>
</html>";

 // Content
 $mail->isHTML(true); 
 $mail->Subject = 'Reset Your Password';
 $mail->Body    = $body;
 $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

 $mail->send();
 echo "<p class='alert alert-success'> <strong>An email has been sent to $email. Please click on the link sent to your mail to reset your password.</strong></p>";
} catch (Exception $e) {
  //debug message
 // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
 echo "Message could not be sent. Try again later!";
};


//close connection
mysqli_close($connect);
  ?>