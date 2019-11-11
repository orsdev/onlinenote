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

    //get element
    let notes = $('.notes').find('p.alert');

    /*notes.length returns 1 or 0,
    1 is element exists,
    0 if it doesn't
    */
    if (notes.length) {
     $('.notes').css('display', 'block'); console.log(
    } else {
     $('.notes').css('display', 'grid');
    }
   },
   error: function (error) {
    $('.alert-container').show();
    $('#alert-content').text('There was an error with the Ajax Call. Please try again later!');
   }

  });
 }

 //function hides and show buttons
 function hideShowButtons(arr1, arr2) {
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

 //load Notes and hide buttons
 function loadNotesHideButtons(id, val1, val2, val3, val4, val5, val6) {

  //click event added to id
  $(id).click(function () {

   /*
call hideShowButtons function and
hide and show targeted elements
*/
   hideShowButtons([val1, val2, val3],
    [val4, val5, val6]
   );

   //call loadNote function
   loadNotes();

  });

 }

 //call load note function
 loadNotes();

 //add-note click event creates row in database
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
     call hideShowButtons function and
     hide and show targeted elements
     */
     hideShowButtons(['.notes', '#edit', '#add-note'],
      ['.notepad-container', '#all-note', '#done']
     );

     //focus textarea
     $('textarea').focus();

     //call all note function
     loadNotesHideButtons('#all-note', '#all-note', '#done',
      '.notepad-container', '#add-note', '#edit', '.notes');
    }
   },
   error: function (error) {
    $('.alert-container').show();
    $('#alert-content').text('There was an error with the Ajax Call. Please try again later!');
   }
  })
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

 //edit button click event function
 $('#edit').click(function () {
  //hide and show element
  $('#edit').hide();
  $('#done').show();

  //show edit and delete icons
  $('.delete').show();
  $('.edit').show();

  //click event added to delete icon
  $('.delete').click(function (e) {
   //get targeted element
   let target = e.target;

   //get element data
   let dataId = $(this).attr('data-delete');

   //make ajax call
   $.ajax({
    url: 'deletenote.php',
    data: { id: dataId },
    type: 'POST',
    success: function (response) {
     $('.alert-container').show();
     $('#alert-content').text(response);

     //wait and hide alert-container
     setTimeout(() => {
      $('.alert-container').hide();
     }, 2500);

     //delete note container div
     if (target.tagName === 'I') {
      target.parentElement.remove();
     }

    },
    error: function () {
     $('#alert-content').text('There was an error with the Ajax Call. Please try again later!');
    }
   })
  });

  //click event added to edit icon
  $('.edit').click(function (e) {

   //store targeted note text in a variable
   let note = $(this).parent().find('span.h4').text();

   /*
  call hideShowButtons function and
  hide and show targeted elements
  */
   hideShowButtons(['.notes', '#edit', '#add-note'],
    ['.notepad-container', '#all-note', '#done']
   );

   //replace textarea  value with clicked note text
   $('textarea').val(note);
   //focus textarea
   $('textarea').focus();

   //change activeNote value
   activeNote = $(this).attr('data-edit');

   //call all note function
   loadNotesHideButtons('#all-note', '#all-note', '#done',
    '.notepad-container', '#add-note', '#edit', '.notes');
  });

  //call all note function
  loadNotesHideButtons('#done', '#all-note', '#done',
   '.notepad-container', '#add-note', '#edit', '.notes');

 })

}); 