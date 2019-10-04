<?php
//check session if user_id exit
if(isset($_SESSION['user_id']) &&
!empty(isset($_SESSION['user_id']))) {


 /*
 extract $authentifaction 1 & 2 from cookie,
 list() function assign the value exploded(an array) in $authentication 1 & 2
 */
list($authentificator1 ,
$authentificator2) = explode(',' , $_COOKIE['rememberme']);

/*
 $authentificatot2 is hexadecimal,
 since it is a hash binary data, I converted
 it back to binary
*/
$authentificator2 = hex2bin($authentificator2);

//hash $authentificator2 to match database f2authentificator2
$f2authentificator2 = hash('sha256' , $authentificator2);

  //look for authenficator1 in the rememberme table
$sql = "SELECT * FROM rememberme WHERE authentificator1='$authentificator1'";

$result =  mysqli_query($connect , $sql);
//if there an error making query, show error message
if(!$result){
 echo "<p class='alert alert-danger'> There was an error running query</p>";
 exit;
};

  //number of rows should be one
 $count = mysqli_num_rows($result);
//stop code from running if it's not
 if($count !== 1){
  echo "<p class='alert alert-danger'>Remember me process failed</p>";
  exit;
 };

 $row = mysqli_fetch_assoc($result);
 
 /*
  check if authentificator2 does not match,
  hash_equals(string1 , string2) function can be used to compare
  hashes
 */
if(!hash_equals($row['f2authentificator2'] , $f2authentificator2)){
 echo "<p class='alert alert-danger'>Remember me process failed</p>";
 exit;
}else {
  /*
  regenerate two random numbers
   and store in two variables
  */

   /*
   generate reandom strings and convert to hexadecimal,
   10bytes = 10 * 8(1 bytes = 8bits) => 80 => 80 / 4 => 20characters
  */
  $authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));
  /*
   generate reandom strings,
   20bytes = 20 * 8(1 bytes = 8bits) => 160 => 160 / 4 => 40characters
  */
  $authentificator2 = openssl_random_pseudo_bytes(20); 

  //store in a cookie

  /*
  concat function parameter a & b,
  convert $b to hexadecimal
  
  ** $authentificator 2 is only converted
  to hexadecimal in auth function, outside 
  of the function, it is random strings
  */
  function auth($a, $b)
  {
   $c = $a . "," . bin2hex($b);
   return $c;
  };

  //store cookie name and value in a variable
  $cookieName = 'rememberme';
  $cookieValue = auth($authentificator1, $authentificator2);

  //save to cookie
  setcookie(
   $cookieName,
   $cookieValue,
   time() + 1296000
  );

  /*
  run query 
  store in remember me database
  */

  function auth2($a)
  {
   $b = hash('sha256', $a);
   return $b;
  };

  //store function value in a variable
  $f2authentificator2 = auth2($authentificator2);

  //retrieve user_id from session
  $user_id = $_SESSION['user_id'];

  /*
   date is 15days from now
   ie. current time * 60sec * 60min * 24hrs * 15
  */
  $expiration = date('Y-m-d H:i:s', time() + 1296000);

  /*
  save to rememberme table,
  $authentificator1 is hexadecimal,
  $authentificator2 is a hashed string
  */
  $sql = "INSERT INTO rememberme";
  $sql .= "(authentificator1, f2authentificator2, user_id, expires) ";
  $sql .= "VALUES('$authentificator1', '$f2authentificator2', '$user_id', '$expiration')";

  //make query
  $result = mysqli_query($connect, $sql);

  //stop query from running if there is an error
  if (!$result) {
   die("<p class='alert alert-danger'> Error: unable to store data. Try again later</p>");
  }

  //update session
  $_SESSION['user_id'] = $row['user_id'];
  //redirect user to mainpage
  header("Location: mainpage.php");
};
}