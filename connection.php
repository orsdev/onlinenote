<?php
//turn off error reporting for users
error_reporting(0);
 //connect to database
 $connect = mysqli_connect('localhost' , 'root' , '' , 'onlnenote');

 //check if connection is successfull
if(mysqli_connect_errno()){
 die('<p class="alert alert-danger"> Error: Unable to connect to database');
}

?>