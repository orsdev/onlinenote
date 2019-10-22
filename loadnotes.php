<?php
//start session
session_start();
//import connection.php
include 'connection.php';

//get note_id
$note_id = $_SESSION['note_id'];
//query to delete empty notes
$sql = "DELETE FROM notes where user_id='$note_id' AND note=''";
//run query
$result = mysqli_query($connect, $sql);

//if error, stop code from executing further
if (!$result) {
 $errorMessage = "<p class='alert  alert-warning'> 
An error occured!
 </p>";
 echo $errorMessage;
 exit;
};

//query to look for notes created by a user
$sql = "SELECT * FROM notes WHERE user_id='$note_id' ORDER BY time DESC";
//run query
$result = mysqli_query($connect, $sql);

//if error, stop code from executing further
if (!$result) {
 $errorMessage = "<p class='alert  alert-warning'> 
 An error occured!
  </p>";
 echo $errorMessage;
 exit;
};

//store rows
$count = mysqli_num_rows($result);

//show notes if found in database
if ($count > 0) {
 while ($row = mysqli_fetch_assoc($result)) {
  $note = $row['note'];
  $time = $row['time'];
  $date = date("F d Y H:i:s A" , $time);

  /*
   store note id in variable,
   to be used later to delete a note
   */
  $id = $row['id'];

  echo  "<div id='$id' class='mb-3 mx-auto mynote p-2 w-50'> 
<span class='d-block h4 text'> $note </span>
<span class='small'> $date </span>
</div>";
 }
} else {
 $message = "<p class='mt-4 alert text-center
  h1 alert-warning'> 
  You have no notes!
   </p>";
 echo $message;
 exit;
};
