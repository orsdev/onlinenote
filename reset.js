$(document).ready(function(){
$('#reset-form').submit(function(e){
 //prevent button default action
 e.preventDefault();
 //store form inputs
 let formData = $(this).serializeArray();

 //make ajax call
 $.ajax({
  type: 'POST',
  data: formData,
  url: 'storeresetpassword.php',
  success: function(response) {
   $('.message').html(response);
  },
  error: function(error){
   let err = '<php class="alert alert-danger"> Something went wrong, Try again. </php>';
   $('.message').html(err);
  }
 })

})
});