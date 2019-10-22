<?php
//start session
session_start();
//import connection
include 'connection.php';
//store variables
$id = $_POST['id'];
$note_pad = $_POST['notepad'];
$time = time();

//query
$sql = "UPDATE notes SET note='$note_pad' , time='$time' WHERE id='$id'";

//run query
$result = mysqli_query($connect , $sql);

if(!$result){
 echo 'error';
 exit;
}; 

echo mysqli_affected_rows($connect);

?>