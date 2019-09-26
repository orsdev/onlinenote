<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <title> NOTIE || MAIN PAGE</title>
 <link rel="stylesheet" href="css/bootstrap.css">
 <link rel="stylesheet" href="css/style.css">
</head>

<body>
 <nav class="navbar navbar-expand-md navbar-light bg-transparent">
  <a class="navbar-brand">Notie</a>
  <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
   <span class="navbar-toggler-icon"></span>
  </button>
  <div id="my-nav" class="collapse navbar-collapse">
   <ul class="navbar-nav mr-auto">
    <li class=" nav-item mr-2">
     <a class="nav-link" href="profile.php">Profile<span class="sr-only">(current)</span></a>
    </li>
    <li class=" nav-item mr-2">
     <a class="nav-link" href="help.php" tabindex="-1" aria-disabled="true">Help</a>
    </li>
    <li class=" nav-item mr-2">
     <a class="nav-link" href="contact.php" tabindex="-1" aria-disabled="true">Contact us</a>
    </li>
    <li class=" nav-item active">
     <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Saved notes</a>
    </li>
   </ul>
   <ul class="navbar-nav ml-auto">
    <li class=" nav-item">
     <a class="nav-link" href="#" class="btn">Logged in as <b>%username%</b></a>
    </li>
    <li class=" nav-item">
     <a class="nav-link" href="#" class="btn">Log out</a>
    </li>
   </ul>
  </div>
 </nav>
 <main>
  <div class="container note-container">
   <div class="row p-1">
    <div class="col-lg-12 d-flex justify-content-between buttons">
     <div class="btn-group mr-2">
      <button id="add-note" class="btn btn-md btn-outline-info mr-1">Add Note</button>
      <button id="all-note" class="all-note btn btn-md btn-outline-info">All Note</button>
     </div>

     <div class="btn-group">
      <button id="done" class=" done btn btn-md btn-outline-success mr-1">Done</button>
      <button id="edit" class="btn btn-md btn-outline-info">Edit</button>
     </div>
    </div>

    <div class="row mt-4 notepad-container">
     <div class="col-lg-12">
      <div class="note-pad">
       <textarea name="notepad" id="notepad" class="notepad" cols="30" rows="10"></textarea>
      </div>
     </div>
    </div>

    <div class="row notes-wrapper mt-4">
     <div class="col-lg-12 notes container w-75">

     </div>
    </div>
   </div>
  </div>
 </main>

 <!--FOOTER-->
 <footer class="w-100">
  <div class="container-fluid text-center">
   <p class="small">&copy; Copyright 2018 - <?php echo date('Y') ?></p>
  </div>
 </footer>
 <script src="js/jquery.min.js"></script>
 <script src="js/popper.min.js"></script>
 <script src="js/bootstrap.min.js"></script>
 <script src="js/app.js"></script>
</body>

</html>