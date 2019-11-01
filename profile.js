$(document).ready(function() {
$('#editusername').submit(function(e){
//prevent button default action
e.preventDefault();
//store form inputs in object
let dataFile = $(this).serializeArray();
console.log(dataFile);
//make ajax call
$.ajax({
 url: 'updateusername.php',
 type: 'POST',
 data: dataFile,
success: function(response){
 if(response){
  $('.editusername-message').html(response);
 }else {
  location.reload();
 }
},
error: function(error){
 let message = "<div class='alert alert-danger'> <strong>'There was an error with the Ajax Call. Please try again later!'</strong></div>"
  $('.editusername-message').html(message);
}
})
});
})