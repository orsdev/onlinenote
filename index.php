<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>NOTIE || SAVE NOTES EASILY</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <nav class="navbar navbar-expand-sm navbar-light bg-transparent">
    <a class="navbar-brand">Notie</a>
    <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="my-nav" class="collapse navbar-collapse">
      <ul class="navbar-nav mr-auto">
        <li class=" nav-item mr-2 active">
          <a class="nav-link" href="#">Home<span class="sr-only">(current)</span></a>
        </li>
        <li class=" nav-item mr-2">
          <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Help</a>
        </li>
        <li class=" nav-item mr-2">
          <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Contact us</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class=" nav-item">
          <a class="nav-link" href="#loginmodal" class="btn" data-target="#loginmodal" data-toggle="modal">Login</a>
        </li>
      </ul>

      <!-- LOGIN MODAL & FORM -->
      <div id="loginmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="my-modal-title">Login</h5>
              <button class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="alert alert-danger login-message">
            </div>
            <div class="modal-body">
              <form action="" method="POST" id="formlogin">
                <div class="form-group">
                  <input type="email" name="email1" id="email1" class="email1 form-control form-control-lg" placeholder="Enter your email">
                </div>
                <div class="form-group">
                  <input type="password" name="password1" id="password1" class="password1 form-control form-control-lg" placeholder="Enter your password">
                </div>
                <div class="row">
                  <div class="col-6">
                    <input type="checkbox" name="remember" id="checkbox">
                    <label for="checkbox" id="remember">Remember me</label>
                  </div>
                  <div class="col-6 text-right">
                    <a href="#forgotmodal" class="text-primary" data-dismiss="modal" data-target="#forgotmodal" data-toggle="modal">Forgot Password?</a>
                  </div>
                </div>
                <div class="row">
                  <div class="col-6">
                    <button class="btn-md btn-primary btn text-light" data-dismiss="modal" data-target="#signupmodal" data-toggle="modal"> Register </button>
                  </div>
                  <div class="col-6 text-right">
                    <input type="submit" value="Login" class="btn btn-md login text-light" name="login">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <main>
    <div class="jumbotron bg-light jumbotron-fluid text-center">
      <h1 class="display-4">Online Note App</h1>
      <p class="lead">Have an idea, Take a Note</p>
      <p class="lead">Easy to use, protects all your notes</p>
      <hr class="my-2">
      
      <!-- SIGN UP MODAL & FORM -->
      <button class="btn btn-lg text-light signup-btn" data-target="#signupmodal" data-toggle="modal">SIGN UP</button>
      <div id="signupmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="my-modal-title">Sign Up</h5>
              <button class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="alert alert-danger signup-message">
            </div>
            <div class="modal-body">
              <form action="" method="POST" id="formsignup">
                <div class="form-group">
                  <input type="text" name="username" id="user" class="username form-control form-control-lg" placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="email" name="email" id="email" class="email form-control form-control-lg" placeholder="Email address">
                </div>
                <div class="form-group">
                  <input type="password" name="password" id="password" class="password form-control form-control-lg" placeholder="Enter a password">
                </div>
                <div class="form-group">
                  <input type="password" name="confirm-password" id="confirm-password" class="confirm-password form-control form-control-lg" placeholder="Confirm password">
                </div>
                <div class="form-group">
                  <input type="submit" name="signup" value="Submit" class="btn-lg btn text-light">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- FORGOT MODAL & FORM -->
      <div id="forgotmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="forgotmodal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="my-modal-title">Enter your email address to reset your password</h5>
              <button class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="alert alert-danger forgot-message">
            </div>
            <div class="modal-body">
              <form action="" method="POST" id="forgotform">
                <div class="form-group">
                  <input type="email" name="forgotemail" id="forgotemail" class="email form-control form-control-lg" placeholder="Email address">
                </div>
                <div class="form-group"> 
                <input type="submit" value="Submit" class="btn-md forgot btn text-light" name="forgetbutton">
                </div>
              </form>
            </div>
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