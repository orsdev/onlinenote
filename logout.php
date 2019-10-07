<?php
  if(isset($_SESSION['email'])
  && isset($_GET['logout']) == 'true'){
   //session is destroyed
   session_destroy();
   $_SESSION = array();
   /*
    delete cookie, 
    cookie expired an hour ago
    */
   setcookie('rememberme' , '' , time() - 3600 );
   //take user back to index page
   header("Location: index.php");
  
  };
?>