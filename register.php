<?php
// session start!
session_start();

// check for user login!
if (isset($_SESSION['email'])) {
  header('Location: ./index.html?message=User already registered and logged in!');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/register.css">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <title>portGen</title>
</head>

<body>
    <div class="container d-flex align-items-center">
      <div class="row flex-fill">
        <div class="col-lg-10 col-xl-9 mx-auto">
          <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
            <div class="card-img-left d-none d-md-flex">
              <!-- Background image for card set in CSS! -->
            </div>
            <div class="card-body p-4 p-sm-5">
              <h5 class="card-title text-center mb-5 fw-light fs-3">Register</h5>
              <form action="./scripts/register.php" method="POST">

                <!-- <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInputUsername" placeholder="myusername" required autofocus>
                  <label for="floatingInputUsername">Username</label>
                </div> -->

                <div class="form-floating mb-3">
                  <input type="email" class="form-control" id="floatingInputEmail" name="email" placeholder="name@example.com">
                  <label for="floatingInputEmail">Email address</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                  <label for="floatingPassword">Password</label>
                </div>  

                <!-- <div class="form-floating mb-3">
                  <input type="password" class="form-control" id="floatingPasswordConfirm" placeholder="Confirm Password">
                  <label for="floatingPasswordConfirm">Confirm Password</label>
                </div> -->

                <div class="d-grid mb-2">
                  <button class="btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit">Register</button>
                </div>

                <a class="d-block text-center mt-2 small" href="./login.php">Have an account? Sign In</a>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/114cef75f0.js" crossorigin="anonymous"></script>

</body>

</html>