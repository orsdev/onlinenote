$(document).ready(function () {

 //apply event to signup form
 $('#formsignup').submit(function(e) {
  //prevent form default action
  e.preventDefault();
  //collect and store users inputs
  let dataPost = $(this).serializeArray();

  //send data to signup.php using AJAX
  $.ajax({
   type: "POST",
   url: "signup.php",
   data: dataPost,
   success: function(response) {
     if(response) {
      $('.signup-message').html(response);
     };
   },
   error: function(error){
    let err = '<php class="alert alert-danger"> Something went wrong, Try again. </php>';
    $('.signup-message').html(err);
   }
  });

 

});

 
//apply event to login form
$('#formlogin').submit(function(e){
 //prevent form default action
 e.preventDefault();
 //collect and store users inputs
 let dataPost = $(this).serializeArray();

 //send data to login.php using AJAX
 $.ajax({
  type: "POST",
  url: "login.php",
  data: dataPost,
  success: function(response) { 
    if(response == 'success') {
     window.location = 'mainpage.php';
    }else {
    $('.login-message').html(response);
    }
  },
  error: function(error){
   let err = '<php class="alert alert-danger"> Something went wrong, Try again. </php>';
   $('.login-message').html(err);
  }
 });

});

//apply event to forgot password form
$('#forgotform').submit(function(e){
 //prevent button default action
 e.preventDefault();
  //collect and store users inputs
  let dataPost = $(this).serializeArray();

  //send dato forgot-password.php using Ajax
  $.ajax({
   type: 'POST',
   url: 'forgot-password.php',
   data: dataPost,
   success: function(response) {
    $('.forgot-message').html(response);
   },
   error: function(error) {
    let err = '<php class="alert alert-danger"> Something went wrong, Try again. </php>';
   $('.forgot-message').html(err);
   }
  });
});

});