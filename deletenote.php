<?php
//import connection
include 'connection.php';
//get note id
$id = $_POST['id'];
//query to run
$sql = "DELETE FROM notes WHERE id = '$id'";
//run query
$result = mysqli_query($connect , $sql);

if(!$result) {
 echo 'Unable to delete note. Please try again.';
 exit;
};

echo 'Note deleted successfully';
//close connection
mysqli_close($connect);
?>