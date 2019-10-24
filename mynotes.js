$(document).ready(function () {

 let activeNote = 0;

 //load notes function
 function loadNotes() {

  /*
    ajax call checks database to see
    if there are notes and loads it
   */
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
 }

 //function hides and show elements
 function hideShow(arr1, arr2) {
  /*
  loop through array and hide
  elements
  */
  arr1.forEach(value => {
   $(value).hide();
  });

  /*
loop through array and show
elements
*/
  arr2.forEach(value => {
   $(value).show();
  });

 }

 //all-note button function
 function allNote(val1, val2, val3, val4, val5, val6) {
  //add click event to all note button
  $('#all-note').click(function () {

   /*
call hideShow function and
hide and show targeted elements
*/
   hideShow([val1, val2, val3],
    [val4, val5, val6]
   );

   //call loadNote function
   loadNotes();

  });

 }

 //call load note function
 loadNotes();

 //add-note click event creates note row
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
     $('textarea').val('');

     /*
     call hideShow function and
     hide and show targeted elements
     */
     hideShow(['.notes', '#edit', '#add-note'],
      ['.notepad-container', '#all-note', '#done']
     );

     //focus textarea
     $('textarea').focus();

     //call all note function
     allNote('#all-note', '#done', '.notepad-container', '#add-note', '#edit', '.notes');
    }
   },
   error: function (error) {
    $('.alert-container').show();
    $('#alert-content').text('There was an error with the Ajax Call. Please try again later!');
   }
  })
 });

 //event to edit and update note
 $('.notes').on('click', '.mynote', function (e) {

  //store note text in a variable
  let note = $(this).find('.text').text();
  /*
 call hideShow function and
 hide and show targeted elements
 */
  hideShow(['.notes', '#edit', '#add-note'],
   ['.notepad-container', '#all-note', '#done']
  );

  //replace textarea  value with clicked note text
  $('textarea').val(note);
  //focus textarea
  $('textarea').focus();

  //change activeNote to id ot note to edit
  activeNote = $(this).attr('id');

  //call all note function
  allNote('#all-note', '#done', '.notepad-container', '#add-note', '#edit', '.notes');

 });

 //ajax call to updatenote.php
 $('textarea').on('keyup', function () {

  //make ajax call
  $.ajax({
   url: 'updatenote.php',
   type: 'POST',
   data: { mynote: $('textarea').val(), id: activeNote },
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
 });

}); 