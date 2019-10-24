  <?php
  //import connection.php
  include 'connection.php';

  //store key & id in two variables
  $user_id = $_POST['user_id'];
  $key = $_POST['key'];

  //prepare error messages
  $missingPassword = '<p><strong>Please enter a password</strong></p>';
  $invalidPassword = '<p><strong>Your password should be at least 6 characters long and include a capital letter and one number</strong></p>';
  $missingPassword2 = '<p><strong> Please re-enter your password</string></p>';
  $differentPassword = '<p><strong> Passwords don\'t match</p>';

  $errors = '';
  $username = null;
  $password = null;
  $confirmPassword = null;


  //get password
  if (isset($_POST['password'])) {
   //if empty, assign error
   if (strlen($_POST['password']) == 0) {
    $errors .= $missingPassword;
    //if true, assign error
   } elseif (!(strlen($_POST['password']) >= 6 && preg_match('/[A-Z]/', $_POST['password']) && preg_match('/[0-9]/', $_POST['password']))) {
    $errors .= $invalidPassword;
   } else {
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    //check for confirm password input
    if (isset($_POST['confirm-password'])) {
     //if true, assign error
     if (strlen($_POST['confirm-password']) == 0) {
      $errors .= $missingPassword2;
      //if passwords dont match, assign error
     } else if (($password != $_POST['confirm-password'])) {
      $errors .= $differentPassword;
     } else {
      $confirmPassword = filter_var($_POST['confirm-password'], FILTER_SANITIZE_STRING);
     }
    }
   };
  };

  //output error message if error exist
  if ($errors) {
   echo "<div class='alert alert-danger text-center'>" . $errors . "</div>";
   exit;
  };

  //prepare for query
  $password = mysqli_real_escape_string($connect, $password);
  $user_id = mysqli_real_escape_string($connect, $user_id);

  //hash password
  $password = hash("sha256", $password);

  //query to run
  $sql = "UPDATE users SET password='$password' WHERE user_id = '$user_id'";

  //run query
  $result = mysqli_query($connect, $sql);

  //stop query if error is found
  if (!$result) {
   die("<p class='alert alert-danger'>
   Unable to reset your password. Please try again.</p>");
  };

  /*
   set key status to "used in the
   forgotpassword table to prevent 
   user from re-using a key
   */

  //query to set status to used
  $sql = "UPDATE forgotpassword SET status='used' where user_id='$user_id' AND user_key='$key'";

  //run query
  $result = mysqli_query($connect, $sql);

  //stop query if error is found
  if (!$result) {
   echo mysqli_error($connect);
   die("<p class='alert alert-danger'>
   Unable to reset your password. Please try again.</p>");
  };

  $successMessage = "<p class='alert alert-success'> Your password has been updated successfully. 
  <a href='http://127.0.0.1:5500' class=''>Login</a> </p>";

  echo $successMessage;

  //close connection
  mysqli_close($connect);
  ?>