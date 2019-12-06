<?php
//start session and connect
session_start();
include ('connection.php');

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './PHPMailer/Exception.php';
require './PHPMailer/PHPMailer.php';
require './PHPMailer/SMTP.php';

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
    echo "<div class='alert alert-danger'><strong>There is already a user registered with that email! Please choose another one!</strong></div>"; exit;
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
}

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
 //Server settings
     // Enable verbose debug output
 // $mail->SMTPDebug = SMTP::DEBUG_SERVER;         
 $mail->isSMTP();                                //Send using SMTP
 $mail->Host = 'smtp.gmail.com';
 $mail->SMTPAuth = true;
 $mail->Username = 'onlinenotie19@gmail.com'; 
 $mail->Password = 'Onlinenotie1995';                              
 $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
 $mail->Port = 587;                                
 //Recipients
 $mail->setFrom('onlinenotie19@gmail.com', 'Notie');
 $mail->addAddress($email);

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
<p> Please click on the link below to verify your new email address. </p>

<a rel='nofollow' target='_blank' class='btn' href='http://127.0.0.1:5500/note/activatenewemail.php?email=" .urlencode($oldemail) . "&newemail=" .urlencode($email) ."&key=$activationKey'>Verify Email Address</a>

</div>
</body>
</html>";

 // Content
 $mail->isHTML(true); 
 $mail->Subject = 'Notie Email Update';
 $mail->Body    = $body;
 $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

 $mail->send();
 echo "<div class='alert alert-success'><strong>An email has been sent to $email. Please click on the link to prove you own that email address.</div></strong>";
} catch (Exception $e) {
 //debug message
 // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
 echo "Message could not be sent. Try again later!";
};

mysqli_close($connect);
?>