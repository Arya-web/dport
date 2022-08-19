<?php

//include db
include "../../scripts/db.php";

$email = "a@b.com";
if (isset($_POST['email'])) {
  $email = $_POST['email'];
}

if ($email != "") {
  $userDet = "SELECT users.email, users.name, users.techstack, users.about, users.userImage, skills.skill, skills.prof FROM `users` INNER JOIN `skills` ON users.email = skills.email WHERE users.email = '$email'";
  $userDetRes = mysqli_query($conn, $userDet) or die(mysqli_error($conn));
  $user = mysqli_fetch_assoc($userDetRes);

  $userSkill = "SELECT * FROM `skills` WHERE `email` = '$email'";
  $userSkillRes = mysqli_query($conn, $userSkill) or die(mysqli_error($conn));
  $userS = mysqli_fetch_assoc($userSkillRes);

  $userProj = "SELECT * FROM `projects` WHERE `email` = '$email'";
  $userProjRes = mysqli_query($conn, $userProj) or die(mysqli_error($conn));

  $userBlog = "SELECT * FROM `blogs` WHERE `email` = '$email'";
  $userBlogRes = mysqli_query($conn, $userBlog) or die(mysqli_error($conn));

  $userTes = "SELECT * FROM `testimonials` WHERE `email` = '$email'";
  $userTesRes = mysqli_query($conn, $userTes) or die(mysqli_error($conn));

  $userSkillArr = explode(',', $user['skill']);
  $skillProfArr = explode(',', $user['prof']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?= $user['name'] ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="./style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.html">PortFolio</a></h1>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <?php if (mysqli_num_rows($userProjRes) > 0) { ?>
            <li><a class="nav-link scrollto " href="#work">Projects</a></li>
          <?php } ?>
          <?php if (mysqli_num_rows($userBlogRes) > 0) { ?>
            <li><a href="#testimonials" class="nav_link scrollto">Testimonials</a></li>
          <?php } ?>
          <?php if (mysqli_num_rows($userTesRes) > 0) { ?>
            <li><a class="nav-link scrollto " href="#blog">Blogs</a></li>
          <?php } ?>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->


  <!-- ======= Hero Section ======= -->
  <div id="hero" class="hero route bg-image">
    <div class="overlay-itro"></div>
    <div class="hero-content display-table">
      <div class="table-cell">
        <div class="container">
          <p class="display-6 color-d">Hello, world!</p>
          <h1 class="hero-title mb-4">I am <?= $user['name'] ?></h1>
          <p class="hero-subtitle"><span class="typed" data-typed-items=<?= $user['techstack'] ?>></span></p>
        </div>
      </div>
    </div>
  </div><!-- End Hero Section -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about-mf sect-pt4 route">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="box-shadow-full">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-sm-6 col-md-5">
                      <div class="about-img">
                        <img src="../../userImg/<?= $user['email'] ?>/user/<?= $user['userImage'] ?>" class="img-fluid rounded b-shadow-a" alt="userImg">
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-7">
                      <div class="about-info">
                        <p><span class="title-s">Name: </span> <span><?= $user['name'] ?></span></p>
                        <p><span class="title-s">Profile: </span> <span><?= $user['techstack'] ?></span></p>
                        <p><span class="title-s">Email: </span> <span><?= $user['email'] ?></span></p>
                        <!-- <p><span class="title-s">Phone: </span> <span>(617) 557-0089</span></p> -->
                      </div>
                    </div>
                  </div>
                  <div class="skill-mf">
                    <p class="title-s">Skills</p>
                    <?php
                    foreach ($userSkillArr as $id => $val) {
                    ?>
                      <div class="row">
                        <div class="col-2 text-end text-uppercase"><strong><?= $val ?></strong></div>
                        <div class="col-1"><span class="pull-right"><?= $skillProfArr[$id] ?>%</span></div>
                        <div class="col-9">
                          <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: <?= $skillProfArr[$id] ?>%;" aria-valuenow="<?= $skillProfArr[$id] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="about-me pt-4 pt-md-0">
                    <div class="title-box-2">
                      <h5 class="title-left">
                        About me
                      </h5>
                    </div>
                    <p class="lead">
                      <?= $user['about'] ?>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End About Section -->

    <?php if (mysqli_num_rows($userProjRes) > 0) { ?>
      <!-- ======= Projects Section ======= -->
      <section id="work" class="portfolio-mf sect-pt4 route">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="title-box text-center">
                <h3 class="title-a">
                  Projects
                </h3>
                <p class="subtitle-a">
                  Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                </p>
                <div class="line-mf"></div>
              </div>
            </div>
          </div>
          <div class="row d-flex justify-content-around">
            <?php while ($P = mysqli_fetch_assoc($userProjRes)) { ?>
              <div class="col-md-4">
                <div class="work-box">
                  <a href="../../userImg/<?= $user['email'] ?>/projects/<?= $P['pName'] ?>/<?= $P['pImage'] ?>" data-gallery="portfolioGallery" class="portfolio-lightbox">
                    <div class="work-img" onmouseover="visible(<?= $P['pName'] ?>)" onmouseout="notVisible(<?= $P['pName'] ?>)">
                      <img src="../../userImg/<?= $user['email'] ?>/projects/<?= $P['pName'] ?>/<?= $P['pImage'] ?>" alt="" height="400px" class="img-fluid">
                      <div class="centered hidden" id=<?= $P['pName'] ?>>
                        <div class="d-flex align-items-center justify-content-center" style="height: 100%;">
                          <div><?= $P['pDetails'] ?></div>
                        </div>
                      </div>
                    </div>
                  </a>
                  <div class="work-content">
                    <div class="row">
                      <div class="col-sm-8">
                        <h2 class="w-title text-uppercase "><?= $P['pName'] ?></h2>
                        <div class="w-more">
                          <span class="w-ctegory text-uppercase "><?= $P['pTech'] ?></span><!--  / <span class="w-date">18 Sep. 2018</span> -->
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="w-like">
                          <a href=<?= $P['pLink'] ?>><span class="bi bi-box-arrow-up-right"> Link</span></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </section>
      <!-- End Projects Section -->
    <?php } ?>

    <?php if (mysqli_num_rows($userTesRes) > 0) { ?>
      <!-- ======= Testimonials Section ======= -->
      <div class="testimonials paralax-mf bg-image" style="background-image: url(../../assets/images/overlay-bg.jpg)" id="testimonials">
        <div class="container">
          <div class="row">
            <div class="col-md-12">

              <div class="testimonials-slider swiper-container" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">
                  <?php while ($T = mysqli_fetch_assoc($userTesRes)) { ?>
                    <div class="swiper-slide">
                      <div class="testimonial-box">
                        <div class="author-test">
                          <img src="../../userImg/<?= $user['email'] ?>/tes/<?= $T['tesName'] ?>/<?= $T['tesImage'] ?>" alt="userImg" width="150px" height="150px" class="rounded-circle b-shadow-a">
                          <span class="author"><?= $T['tesName'] ?></span>
                          <span>( <?= $T['tesCred'] ?> )</span>
                        </div>
                        <div class="content-test">
                          <p class="description lead">
                            <?= $T['tesDetails'] ?>
                          </p>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
                <div class="swiper-pagination"></div>
              </div>

              <!--<div id="testimonial-mf" class="owl-carousel owl-theme">
        </div>-->
            </div>
          </div>
        </div>
      </div>
      <!-- End Testimonials Section -->
    <?php } ?>

    <!-- ======= Blog Section ======= -->
    <?php if (mysqli_num_rows($userBlogRes) > 0) { ?>
      <!-- ======= Blog Section ======= -->
      <section id="blog" class="blog-mf sect-pt4 route">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="title-box text-center">
                <h3 class="title-a">
                  Blogs
                </h3>
                <p class="subtitle-a">
                  Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                </p>
                <div class="line-mf"></div>
              </div>
            </div>
          </div>
          <div class="row d-flex justify-content-around">
            <?php while ($B = mysqli_fetch_assoc($userBlogRes)) { ?>
              <div class="col-md-4">
                <div class="card card-blog">
                  <div class="card-img text-center">
                    <a><img src="../../userImg/<?= $user['email'] ?>/blogs/<?= $B['bName'] ?>/<?= $B['bImage'] ?>" alt="" width="300px" class="img-fluid"></a>
                  </div>
                  <div class="card-body">
                    <div class="card-category-box">
                      <div class="card-category">
                        <h6 class="category"><?= $B['bType'] ?></h6>
                      </div>
                    </div>
                    <h3 class="card-title"><a><?= $B['bName'] ?></a></h3>
                    <p class="card-description">
                      <?= $B['bDetails'] ?> 
                    </p>
                    <p class="card-description text-center">
                      <a href="<?= $B['bLink'] ?>" class="text-center" style="color: blue">Link to the blog</a>
                    </p>
                  </div>
                  <div class="card-footer">
                    <div class="post-author">
                      <a href="#">
                        <img src="../../userImg/<?= $user['email'] ?>/user/<?= $user['userImage'] ?>" alt="" height="150px" class="avatar rounded-circle">
                        <span class="author"><?= $user['name'] ?></span>
                      </a>
                    </div>
                    <!-- <div class="post-date">
                                <span class="bi bi-clock"></span> 10 min
                            </div> -->
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </section>
      <!-- End Blog Section -->
    <?php } ?>

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="paralax-mf footer-paralax bg-image sect-mt4 route" style="background-image: url(../../assets/images/overlay-bg.jpg)">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="contact-mf">
              <div id="contact" class="box-shadow-full">
                <div class="row">
                  <div class="col-md-6">
                    <div class="title-box-2">
                      <h5 class="title-left">
                        Send Message
                      </h5>
                    </div>
                    <div>
                      <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                        <div class="row">
                          <div class="col-md-12 mb-3">
                            <div class="form-group">
                              <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                            </div>
                          </div>
                          <div class="col-md-12 mb-3">
                            <div class="form-group">
                              <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                            </div>
                          </div>
                          <div class="col-md-12 mb-3">
                            <div class="form-group">
                              <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                            </div>
                          </div>
                          <div class="col-md-12 text-center my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                          </div>
                          <div class="col-md-12 text-center">
                            <button type="submit" class="button button-a button-big button-rouded">Send Message</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="title-box-2 pt-4 pt-md-0">
                      <h5 class="title-left">
                        Get in Touch
                      </h5>
                    </div>
                    <div class="more-info">
                      <p class="lead">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolorum dolorem soluta quidem
                        expedita aperiam aliquid at.
                        Totam magni ipsum suscipit amet? Autem nemo esse laboriosam ratione nobis
                        mollitia inventore?
                      </p>
                      <ul class="list-ico">
                        <li><span class="bi bi-geo-alt"></span> 329 WASHINGTON ST BOSTON, MA 02108</li>
                        <li><span class="bi bi-phone"></span> (617) 557-0089</li>
                        <li><span class="bi bi-envelope"></span> contact@example.com</li>
                      </ul>
                    </div>
                    <div class="socials">
                      <ul>
                        <li><a href=""><span class="ico-circle"><i class="bi bi-facebook"></i></span></a></li>
                        <li><a href=""><span class="ico-circle"><i class="bi bi-instagram"></i></span></a></li>
                        <li><a href=""><span class="ico-circle"><i class="bi bi-twitter"></i></span></a></li>
                        <li><a href=""><span class="ico-circle"><i class="bi bi-linkedin"></i></span></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="copyright-box">
            <p class="copyright">&copy; Copyright <strong>Shreyas</strong>. Some Rights Reserved</p>
          </div>
        </div>
      </div>
    </div>
  </footer><!-- End  Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../../assets/vendor/php-email-form/validate.js"></script>
  <script src="../../assets/vendor/purecounter/purecounter.js"></script>
  <script src="../../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../../assets/vendor/typed.js/typed.min.js"></script>

  <!-- Template Main JS File -->
  <script src="./main.js"></script>

</body>

</html>

