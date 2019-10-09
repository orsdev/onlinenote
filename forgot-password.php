  <?php
  //start session
  session_start();
  //connect to database
  include 'connection.php';

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

$message = "Please click on this link to reset your password\n\n";
$message .= "http://127.0.0.1:5500/resetpassword.php?user_id=$user_id&key=$key";
$subject = "Reset your Password";
$header = "From: onlinenotes@gmail.com";

//check if mail has no error
if (mail($email, $subject, $message, $header)) {
 echo "<p class='alert alert-success'> An email has been sent to $email. Please click on the activation link to reset your password</p>";
};

//close connection
mysqli_close($connect);
  ?>