<?php
 //connect to database
 $connect = mysqli_connect('localhost' , 'root' , '' , 'onlinenote');

 //check if connection is successfull
if(mysqli_connect_errno()){
 die('<p class="alert alert-danger"> Error: Unable to connect');
}

?>