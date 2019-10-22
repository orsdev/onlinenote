$(document).ready(function () {

 let activeNote = 0;

 //make ajax call
 $.ajax({
  url: 'loadnotes.php',
  success: function (response) {
   $('.notes').html(response);
  },
  error: function (error) {
   $('.alert-container').show();
   $('#alert-content').text('There was an error with the Ajax Call. Please try again later!');
  }

 });


 $('#add-note').click(function () {

  //make ajax call
  $.ajax({
   url: 'createnotes.php',
   success: function (response) {

    if (response == 'error') {
     $('.alert-container').show();
     $('#alert-content').text('Unable to insert new note in the database');
    } else {
     //update activenote to id of new note
     activeNote = response;

     //empty textarea
     $('textarea').empty();

     /*
     hide and show targeted elements
     */
     $('.notes').hide()
     //show textarea container container
     $('.notepad-container').show();
     //hide add note button
     $('#add-note').hide();
     //show all note button
     $('#all-note').show();
     //show done button
     $('#done').show();
     //hide edit button
     $('#edit').hide();

     //focus textarea
     $('textarea').focus();

     //ajax call to updatenote.php
     $('textarea').on('keyup', function () {
      let dataFile = $(this).serializeArray();

      //make ajax call
      $.ajax({
       url: 'updatenote.php',
       type: 'POST',
       data: { notepad: $('textarea').val(), id: activeNote },
       success: function (response) {

        if (response == 'error') {
         $('.alert-container').show();
         $('#alert-content').text('Unable to update note in the database');
        }
       },
       error: function () {
        $('#alert-content').text('There was an error with the Ajax Call. Please try again later!');
       }
      })
     })

     //add click event to all-note button
     $('#all-note').click(function () {
      //hide target element(all note button)
      $(this).hide();
      //show all add note button
      $('#add-note').show();
      //hide done button
      $('#done').hide();
      //show edit button
      $('#edit').show();
      //show notes
      $('.notes').show();
      //hide textarea container
      $('.notepad-container').hide();


      //make ajax call
      $.ajax({
       url: 'loadnotes.php',
       success: function (response) {
        $('.notes').html(response);
       },
       error: function (error) {
        $('.alert-container').show();
        $('#alert-content').text('There was an error with the Ajax Call. Please try again later!');
       }

      });
     });


    }
   },
   error: function (error) {
    $('.alert-container').show();
    $('#alert-content').text('There was an error with the Ajax Call. Please try again later!');
   }
  })
 });



}); 