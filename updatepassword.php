<?php
//start session and connect
session_start();
include ('connection.php');

//define error messages
$missingCurrentPassword = '<p><strong>Please enter your Current Password!</strong></p>';
$incorrectCurrentPassword = '<p><strong>The password entered is incorrect!</strong></p>';
$missingPassword = '<p><strong>Please enter a new Password!</strong></p>';
$invalidPassword = '<p><strong>Your password should be at least 6 characters long and inlcude one capital letter and one number!</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password</strong></p>';

//get id
$id = $_SESSION["note_id"];

//check for errors
if(empty($_POST["currentpassword"])){
    $errors .= $missingCurrentPassword;
}else{
    $currentPassword = $_POST["currentpassword"];
    $currentPassword = filter_var($currentPassword, FILTER_SANITIZE_STRING);
    $currentPassword = mysqli_real_escape_string ($connect, $currentPassword);
    $currentPassword = hash('sha256', $currentPassword);

    //check if given password is correct
    $sql = "SELECT password FROM users WHERE user_id='$id'";
    $result = mysqli_query($connect, $sql);
    $count = mysqli_num_rows($result);

    if($count !== 1){
        echo '<div class="alert alert-danger">There was a problem running the query</div>';
    }else{
        $row = mysqli_fetch_assoc($result);
        
        if(!hash_equals($currentPassword , $row['password'])){
            $errors .= $incorrectCurrentPassword;
        }
    }
    
}

if(empty($_POST["newpassword"])){
    $errors .= $missingPassword; 
}elseif(!(strlen($_POST["newpassword"])>6
         and preg_match('/[A-Z]/',$_POST["newpassword"])
         and preg_match('/[0-9]/',$_POST["newpassword"])
        )
       ){
    $errors .= $invalidPassword; 
}else{
    $password = filter_var($_POST["newpassword"], FILTER_SANITIZE_STRING); 
    if(empty($_POST["confirmpassword"])){
        $errors .= $missingPassword2;
    }else{
        $password2 = filter_var($_POST["confirmpassword"], FILTER_SANITIZE_STRING);
        if($password !== $password2){
            $errors .= $differentPassword;
        }
    }
}

//if there is an error print error message
if($errors){
    $resultMessage = "<div class='alert alert-danger'>$errors</div>";
    echo $resultMessage;   
}else{
    $password = mysqli_real_escape_string($connect, $password);
    $password = hash('sha256', $password);
    //else run query and update password
    $sql = "UPDATE users SET password='$password' WHERE user_id='$id'";
    $result = mysqli_query($connect, $sql);
    if(!$result){
        echo "<div class='alert alert-danger'>The password could not be reset. Please try again later.</div>";
    }else{
        echo "<div class='alert alert-success'>Your password has been updated successfully.</div>";
    }
    
}

//close connection
mysqli_close($connect);
?>