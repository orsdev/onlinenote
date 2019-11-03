<?php
//The user is re-directed to this file after clicking the link received by email and aiming at proving they own the new email address
//link contains three GET parameters: email, new email and activation key
session_start();
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>New Email activation</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <style>
            h1{
                color:purple;   
            }
            .contactForm{
                border:1px solid #7c73f6;
                margin-top: 50px;
                border-radius: 15px;
            }
        </style> 

    </head>
        <body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10 contactForm">
            <h1>Email Activation</h1>
<?php

//If email, new email or activation key is missing show an error
if(!isset($_GET['email']) || !isset($_GET['newemail']) || !isset($_GET['key'])){
    echo '<div class="alert alert-danger">There was an error. Please click on the link you received by email.</div>'; exit;
}
//else
    //Store them in three variables
$email = $_GET['email'];
$newemail = $_GET['newemail'];
$key = $_GET['key'];
    //Prepare variables for the query
$email = mysqli_real_escape_string($connect, $email);
$newemail = mysqli_real_escape_string($connect, $newemail);
$key = mysqli_real_escape_string($connect, $key);
    //Run query: update email
$sql = "UPDATE users SET email='$newemail', activation='activated' WHERE (email='$email' AND activation='$key') LIMIT 1";
$result = mysqli_query($connect, $sql);
    //If query is successful, show success message
if(mysqli_affected_rows($connect) == 1){
  
    //session is destroyed
    session_destroy();
    $_SESSION = array();

    /*
     delete cookie, 
     cookie expired an hour ago
     */
    setcookie('rememberme' , '' , time() - 3600 );

    $successMessage = "<p class='alert alert-success'>
    Your account has been activated
    </p>";
   
    echo $successMessage;
    echo "<a href='http://127.0.0.1:5500/note' type='button' class='btn btn-lg btn-success'>Login</a>";
    
}else{
    //Show error message
    echo '<div class="alert alert-danger">Your email could not be updated. Please try again later.</div>';
    
}

//close connection
mysqli_close($connect);
?>
            
        </div>
    </div>
</div>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        </body>
</html>