<?php
session_start();
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Reset Password</title>
 <link href="css/bootstrap.css" rel="stylesheet">
 <style>
  h1 {
   color: purple;
  }

  .contactForm {
   border: 1px solid #7c73f6;
   margin-top: 50px;
   border-radius: 15px;
  }
 </style>

</head>

<body>
 <div class="container mt-5 px-5">
  <div class="row">
   <div class="m-auto col-sm-8 col-md-8 col-lg-6 contactForm">
    <h1>Reset Password</h1>
    <div class="message py-3">

    </div>
    <?php

    //check if user_id or key is missing
    if (
     !isset($_GET['user_id'])
     || !isset($_GET['key'])
    ) {
     $errorMessage = "<div class='alert alert-danger'>
      There was an error. Please click on
      the reset password link received by email.
      </div>";
     echo $errorMessage;
     exit;
    };

    //store them in two variables
    $user_id = $_GET['user_id'];
    $key = $_GET['key'];
    //24 hours ago
    $time = time() - 86400;
    //prepare variables for the query
    $email = mysqli_real_escape_string($connect, $user_id);
    $key = mysqli_real_escape_string($connect, $key);
    //write query
    $sql = "SELECT * FROM forgotpassword WHERE user_id= '$user_id' AND user_key='$key' AND time > '$time' AND status='pending'";

    //make query
    $result = mysqli_query($connect, $sql);
    //stop query from running if there is an error
    if (!$result) {
     die("<p class='alert alert-danger'> Error: Query error</p>");
    };

    $numRows = mysqli_num_rows($result);

    //show error and stop code if it doesn't exist
    if ($numRows !== 1) {
     //show message if username exist
     echo "<p class='alert alert-danger'> The link has expired. Please try again.</p>";
     exit;
    };

    $form = "
    <form method='POST' class='container' id='reset-form'>
    <input type='hidden' name='key' value='$key'>
    <input type='hidden' name='user_id' value='$user_id'>
        <div class='form-group'>
          <label for='password'> Enter your new Password </label>
         <input type='password' name='password' id='password' class='password form-control form-control-lg' placeholder='Enter Password'>
        </div>
        <div class='form-group'>
          <label for='confirm-password'> Re-enter Password </label>
         <input type='password' name='confirm-password' id='confirm-password' class='password form-control form-control-lg' placeholder='Re-enter Password'>
        </div>
        <div class='form-group'>
          <input type='submit' name='submit' class='btn btn-md btn-success' value='Reset Password'>
        </div>
    </form>";

    echo $form;

    //close connection
    mysqli_close($connect);
    ?>

   </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="reset.js"></script>
 </div>
</body>

</html>