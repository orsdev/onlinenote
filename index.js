$(document).ready(function () {

 $('#formsignup').submit(function(e) {
  //prevent form default action
  e.preventDefault();
  //collect and store users inputs in varibles
  let dataPost = $(this).serializeArray();

  //send them to signup.php using AJAX
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

});