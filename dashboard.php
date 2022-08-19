<?php
// session start!
session_start();

// check for user login!
if (!isset($_SESSION['email'])) {
  header('Location: ./login.php?message=Login first!');
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require('./includes/head.php') ?>

<body id="body-pd">
  <!-- snackbar -->
  <div id="snackbar"></div>
  <!-- end of snackbar -->
  <!-- nav toggle -->
  <?php require('./includes/header_toggle.php') ?>

  <!-- navbar section -->
  <?php require('./includes/navbar.php') ?>

  <!--Container Main start-->
  <div class="bg-light">

    <!--User part-->
    <?php require('./includes/user.php') ?>

    <!--Skills Part-->
    <?php require('./includes/skills.php') ?>

    <!--Projects Part-->
    <?php require('./includes/projects.php') ?>

    <!--Blogs part-->
    <?php require('./includes/blogs.php') ?>

    <!--Testimonials part-->
    <?php require('./includes/testimonials.php') ?>

    <!--Templates part-->
    <?php require('./includes/templates.php') ?>

  </div>
  <!-- js files -->
  <script>
    var email = "<?= $_SESSION['email'] ?>"
  </script>
  <?php require('./includes/jsfiles.php') ?>

</body>

</html>