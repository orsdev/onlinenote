<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <title> NOTIE || PROFILE</title>
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
     <a class="nav-link active" href="#">Profile<span class="sr-only">(current)</span></a>
    </li>
    <li class=" nav-item mr-2">
     <a class="nav-link" href="help.php" tabindex="-1" aria-disabled="true">Help</a>
    </li>
    <li class=" nav-item mr-2">
     <a class="nav-link" href="contact.php" tabindex="-1" aria-disabled="true">Contact us</a>
    </li>
    <li class=" nav-item">
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
  <div class="container profile-container">
   <div class="row">
    <div class="col-md-12 text-center">
     <h2> Account Settings </h2>
    </div>
   </div>
   <div class="row">
    <div class="container m-auto table table-responsive">
     <table class="table-hover w-75 table-condensed m-auto">
      <tr data-target="#updateusername" data-toggle="modal">
       <td>Username</td>
       <td>Value</td>
      </tr>
      <tr data-target="#updateemail" data-toggle="modal">
       <td>Email</td>
       <td>Value</td>
      </tr>
      <tr data-target="#updatepassword" data-toggle="modal">
       <td>Password</td>
       <td>hidden</td>
      </tr>
     </table>
    </div>
   </div>
  </div>

  <!-- EDIT USERNAME MODAL & FORM -->
  <div id="updateusername" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="updateusernamelabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
    <div class="modal-content">
     <div class="modal-header">
      <h5 class="modal-title" id="my-modal-title">Edit Username</h5>
      <button class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
      </button>
     </div>
     <div class="alert alert-danger editusername-message">
     </div>
     <div class="modal-body">
      <form action="" method="POST" id="editusername">
       <div class="form-group">
       <label for="text" class="h5">Username</label>
        <input type="text" name="editusername" id="text" class="editusername form-control form-control-lg" maxlength="30" required value="">
       </div>
       <div class="row">
        <div class="col-12 text-center">
         <input type="submit" value="Submit" class="btn btn-md submitbutton text-light" name="editsubmit">
        </div>
       </div>
      </form>
     </div>
    </div>
   </div>
  </div>
  <!-- EDIT USERNAME MODAL & FORM END -->

    <!-- EDIT EMAIL MODAL & FORM -->
    <div id="updateemail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="updateemaillabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
    <div class="modal-content">
     <div class="modal-header">
      <h5 class="modal-title" id="my-modal-title">Edit Email</h5>
      <button class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
      </button>
     </div>
     <div class="alert alert-danger editemail-message">
     </div>
     <div class="modal-body">
      <form action="" method="POST" id="editemail">
       <div class="form-group">
       <label for="email" class="h5">Email</label>
        <input type="email" name="editemail" id="email" class="editemail form-control form-control-lg" minlength="11" required value="">
       </div>
       <div class="row">
        <div class="col-12 text-center">
         <input type="submit" value="Submit" class="btn btn-md submitbutton text-light" name="editsubmit">
        </div>
       </div>
      </form>
     </div>
    </div>
   </div>
  </div>
  <!-- EDIT EMAIL MODAL & FORM END -->

    <!-- EDIT PASSWORD MODAL & FORM -->
    <div id="updatepassword" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="updatepasswordlabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
    <div class="modal-content">
     <div class="modal-header">
      <h5 class="modal-title" id="my-modal-title">Edit Password</h5>
      <button class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
      </button>
     </div>
     <div class="alert alert-danger editpassword-message">
     </div>
     <div class="modal-body">
      <form action="" method="POST" id="editpassword">
       <div class="form-group"> 
       <label for="Current Password" class="sr-only">Email</label>
        <input type="password" name="currentpassword" id="currentpassword" class="currentpassword form-control form-control-lg" minlength="6" maxlength="20" value="" placeholder="Current Password" required>
       </div>
       <div class="form-group">
       <label for="New Password" class="sr-only">Email</label>
        <input type="password" name="newpassword" id="newpassword" class="newpassword form-control form-control-lg" minlength="6" maxlength="20" placeholder="New Password" required>
       </div>
       <div class="form-group">
       <label for="Confirm Password" class="sr-only">Email</label>
        <input type="password" name="confirmpassword" id="password" class="confirmpassword form-control form-control-lg" minlength="6" maxlength="20" placeholder="Confirm Password" required>
       </div>
       <div class="row">
        <div class="col-12 text-center">
         <input type="submit" value="Submit" class="btn btn-md submitbutton text-light" name="editsubmit">
        </div>
       </div>
      </form>
     </div>
    </div>
   </div>
  </div>
  <!-- EDIT PASSWORD MODAL & FORM END -->

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