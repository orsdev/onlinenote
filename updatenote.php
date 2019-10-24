<?php

//import connection
include 'connection.php';
//store variables
$id = $_POST['id'];
$note = $_POST['mynote'];
$time = time();

//query
$sql = "UPDATE notes SET note='$note' , time='$time' WHERE id='$id'";

//run query
$result = mysqli_query($connect , $sql);

if(!$result){
 echo 'error';
 exit;
}; 

//close connection
mysqli_close($connect);
?>