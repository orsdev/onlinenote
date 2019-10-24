<?php
session_start();

//import connection
include 'connection.php';

/*
 retrieve note_id from session,
*/
$note_id = $_SESSION['note_id'];
//get current time
$time = time();

//query
$sql = "INSERT INTO notes(user_id , note, time) VALUES('$note_id' , '' , '$time')";

//run query
$result = mysqli_query($connect , $sql);
//if there is an error, stop query
if(mysqli_error($connect)){
 echo 'error';
 exit;
};

/*
 function returns recent id generated
 in table
*/
echo mysqli_insert_id($connect);

//close connection
mysqli_close($connect);

?>