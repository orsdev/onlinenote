<?php
//The user is re-directed to this file after clicking the activation link
//Signup link contains two GET parameters: email and activation key
session_start();
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Account Activation</title>
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
 <div class="container-fluid mt-5">
  <div class="row">
   <div class="m-auto col-sm-10 contactForm">
    <h1>Account Activation</h1>
    <?php

    //check if email or key is missing
    if (
     !isset($_GET['email'])
     || !isset($_GET['key'])
    ) {

     $message =
      "<p class='alert alert-danger'>
      There was and error. Please click on the activation you received by email
      </p>";

     //output message
     echo $message;
     exit;
    };

    //store them in two variables
    $email = $_GET['email'];
    $key = $_GET['key'];
    //prepare variables for the query
    $email = mysqli_real_escape_string($connect, $email);
    $key = mysqli_real_escape_string($connect, $key);
    //write query
    $sql =
     "UPDATE users SET activation='activated' WHERE email='$email' AND activation='$key' LIMIT 1";
    //make query
    $result = mysqli_query($connect, $sql);

    // check if query is successful
    if (mysqli_affected_rows($connect) == 1) {

     //show success message
     $successMessage = "<p class='alert alert-success'>
     Your account has been activated
     </p>";
     echo $successMessage;
     echo "<a href='http://127.0.0.1:5500' type='button' class='btn btn-lg btn-success'>Login</a>";
    } else {

     //show error message
     $errorMessage = "<p class='alert alert-success'>
     Your account account could not be
     activated. Please try again later.
     </p>";
     echo $errorMessage;
    };

    ?>

   </div>
  </div>
 </div>
</body>

</html>