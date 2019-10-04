<?php
//start session
session_start();

//import connection.php
include 'connection.php';
//define error messages
$missingEmail = '<p><strong> Please enter a email</strong> </p>';
$missingPassword = '<p><strong>Please enter a password</strong></p>';


//variables to be used later
$errors = '';
$password = null;
$email = null;

//get email
if (empty($_POST['email1'])) {
 //assign error message
 $errors .= $missingEmail;
} else {
 //sanitize email
 $email = filter_var($_POST['email1'], FILTER_SANITIZE_EMAIL);
};

//get password
if (empty($_POST['password1'])) {
 //assign error message
 $errors .= $missingPassword;
} else {
 //sanitize email
 $password = filter_var($_POST['password1'], FILTER_SANITIZE_STRING);
};

//output error if there is an error
if ($errors) {
 $errorMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
 echo $errorMessage;
 exit;
}

//no errors
$email = mysqli_real_escape_string($connect, $email);
$password = mysqli_real_escape_string($connect, $password);
$password = hash('sha256', $password);

//write query
$sql = "SELECT * FROM users where email='$email' AND password='$password' AND activation='activated'";

//make query
$result = mysqli_query($connect, $sql);

//stop query from running if there is an error
if (!$result) {
 die("<p class='alert alert-danger'> Error: Query error</p>");
};
//store number of row return in a variable
$rowCount = mysqli_num_rows($result);

if ($rowCount == 1) {
 $row = mysqli_fetch_assoc($result);

 //store data into session
 $_SESSION['username'] = $row['username'];
 $_SESSION['email'] = $row['email'];

 if (empty($_POST['remember'])) {
  echo 'success';
 } else {
  /*
  session set here for
  remember.php
  */
  $_SESSION['user_id'] = $row['user_id'];
  /*
  generate two random numbers
   and store in two variables
  */

   /*
   generate reandom strings and convert to hexadecimal,
   10bytes = 10 * 8(1 bytes = 8bits) => 80 => 80 / 4 => 20characters
  */
  $authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));
  /*
   generate reandom strings,
   20bytes = 20 * 8(1 bytes = 8bits) => 160 => 160 / 4 => 40characters
  */
  $authentificator2 = openssl_random_pseudo_bytes(20); 

  //store in a cookie

  /*
  concat function parameter a & b,
  convert $b to hexadecimal
  
  ** $authentificator 2 is only converted
  to hexadecimal in auth function, outside 
  of the function, it is random strings
  */
  function auth($a, $b)
  {
   $c = $a . "," . bin2hex($b);
   return $c;
  };

  //store cookie name and value in a variable
  $cookieName = 'rememberme';
  $cookieValue = auth($authentificator1, $authentificator2);

  //save to cookie
  setcookie(
   $cookieName,
   $cookieValue,
   time() + 1296000
  );

  /*
  run query 
  store in remember me database
  */

  function auth2($a)
  {
   $b = hash('sha256', $a);
   return $b;
  };

  //store function value in a variable
  $f2authentificator2 = auth2($authentificator2);

  //retrieve user_id from session
  $user_id = $_SESSION['user_id'];

  /*
   date is 15days from now
   ie. current time * 60sec * 60min * 24hrs * 15
  */
  $expiration = date('Y-m-d H:i:s', time() + 1296000);

  /*
  save to rememberme table,
  $authentificator1 is hexadecimal,
  $authentificator2 is a hashed string
  */
  $sql = "INSERT INTO rememberme";
  $sql .= "(authentificator1, f2authentificator2, user_id, expires) ";
  $sql .= "VALUES('$authentificator1', '$f2authentificator2', '$user_id', '$expiration')";

  //make query
  $result = mysqli_query($connect, $sql);

  //stop query from running if there is an error
  if (!$result) {
   die("<p class='alert alert-danger'> Error: unable to store data. Try again later</p>");
  }else{
   echo "success";
  }

 }
} else {
 //output error message
 $errorMessage = "<div class='alert alert-danger'> Wrong email address or password</div>";
 echo $errorMessage;
 exit;
}
