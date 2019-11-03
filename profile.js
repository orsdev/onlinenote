$(document).ready(function() {

 //update username
$('#editusername').submit(function(e){
//prevent button default action
e.preventDefault();
//store form inputs in object
let dataFile = $(this).serializeArray();

//make ajax call
$.ajax({
 url: 'updateusername.php',
 type: 'POST',
 data: dataFile,
success: function(response){
 if(response){
  $('.editusername-message').html(response);
 }
},
error: function(error){
 let message = "<div class='alert alert-danger'> <strong>'There was an error with the Ajax Call. Please try again later!'</strong></div>"
  $('.editusername-message').html(message);
}
})
});

//update password
$('#editpassword').submit(function(e){
//prevent button default action
e.preventDefault();
//store form inputs in object
let dataFile = $(this).serializeArray();

//make ajax call
$.ajax({
 url: 'updatepassword.php',
 type: 'POST',
 data: dataFile,
success: function(response){
 if(response){
  $('.editpassword-message').html(response);
 }
},
error: function(error){
 let message = "<div class='alert alert-danger'> <strong>'There was an error with the Ajax Call. Please try again later!'</strong></div>"
  $('.editusername-message').html(message);
}
})
});

 //update email
 $('#editemail').submit(function(e){
  //prevent button default action
  e.preventDefault();
  //store form inputs in object
  let dataFile = $(this).serializeArray();

  //make ajax call
  $.ajax({
   url: 'updateemail.php',
   type: 'POST',
   data: dataFile,
  success: function(response){
   if(response){
    $('.editemail-message').html(response);
   }else {
    location.reload();
   }
  },
  error: function(error){
   let message = "<div class='alert alert-danger'> <strong>'There was an error with the Ajax Call. Please try again later!'</strong></div>"
    $('.editemail-message').html(message);
  }
  })
  });

})