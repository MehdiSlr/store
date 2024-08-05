<!DOCTYPE html>
<html>
<?php

session_start();
require 'config.php';
if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];;
}
else {
  $user = null;
  $name = null;
}


// Get Product Info from Database
if (!isset($_GET['pid'])) {
  header('location: shop');
} else {
  $pid = $_GET['pid'];
  $sql = "SELECT * FROM product INNER JOIN category ON product.gid = category.gid WHERE pid = $pid";
  $result = mysqli_query($conn, $sql);
  $product = mysqli_fetch_assoc($result);
}

// Get Settings from Database
$settings_sql = "SELECT * FROM settings";
$settings_resault = mysqli_query($conn, $settings_sql);
$row = mysqli_fetch_assoc($settings_resault);

$site_title = $row['title'];
$site_logo = $row['logo_url'];
$map = $row['map'];
$footer = $row['footer'];

$map = json_decode($map, true);
$footer = json_decode($footer, true);

$map_lat = $map['lat'];
$map_long = $map['long'];

$facebook = $footer['social']['facebook'];
$twitter = $footer['social']['twitter'];
$instagram = $footer['social']['instagram'];
$youtube = $footer['social']['youtube'];

$t1_title = $footer['descriptions']['t1_title'];
$t1_desc = $footer['descriptions']['t1_desc'];
$t2_title = $footer['descriptions']['t2_title'];
$t2_desc = $footer['descriptions']['t2_desc'];

$phone = $footer['contact']['phone'];
$email = $footer['contact']['email'];
$loc_name = $footer['contact']['loc_name'];
$loc_link = $footer['contact']['loc_link'];


?>
<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

  <title>
    Giftos
  </title>
  <!-- font awesome style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>
<body>
<div class="hero_area">
    <!-- header section strats -->
    <?php 
    $active_page = "home";
    include 'header.php';
    ?>
    <!-- end header section -->
    <!-- slider section -->

    <section class="product_section">
  <div class="slider_container">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-7 text">
                <div class="detail-box">
                  <div class="back-arrow">
                    <a href="javascript:history.back()"><i class="fas fa-arrow-left"></i></a>
                  </div>
                  <h2><?= $product['title'] ?></h2>
                  <p><?= $product['description'] ?></p>
                  <!-- price -->
                  <h1 class="price">$<?= $product['price'] ?></h1>
                  <div class="row">
                    <div class="col-md-6">
                    <a href="<?= $user != null ? "addtocart?pid=" . $product['pid'] : "javascript:addtocart(" . $product['pid'] . ")" ?>">
                      Add to cart
                    </a>
                    </div>
                    <div class="col-md-6">
                      <p class="category"><?= ucfirst($product['name']) ?></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-5 img">
                <div class="img-box">
                  <img style="object-fit: contain; mix-blend-mode: multiply" src="<?= $product['image_url'] ?>" alt="" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- end slider section -->
  </div>
  <!-- end hero area -->

  <!-- info section -->

  <section class="info_section  layout_padding2-top">
    <div class="social_container">
      <div class="social_box">
        <a href="<?= $facebook; ?>">
          <i class="fa fa-facebook" aria-hidden="true"></i>
        </a>
        <a href="<?= $twitter; ?>">
          <i class="fa fa-twitter" aria-hidden="true"></i>
        </a>
        <a href="<?= $instagram; ?>">
          <i class="fa fa-instagram" aria-hidden="true"></i>
        </a>
        <a href="<?= $youtube; ?>">
          <i class="fa fa-youtube" aria-hidden="true"></i>
        </a>
      </div>
    </div>
    <div class="info_container ">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-3">
            <h6>
              <?= $t1_title ?>
            </h6>
            <p>
              <?= $t1_desc ?>
            </p>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="info_form ">
              <h5>
                Newsletter
              </h5>
              <form action="#">
                <input type="email" placeholder="Enter your email">
                <button>
                  Subscribe
                </button>
              </form>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <h6>
              <?= $t2_title ?>
            </h6>
            <p>
              <?= $t2_desc ?>
            </p>
          </div>
          <div class="col-md-6 col-lg-3">
            <h6>
              CONTACT US
            </h6>
            <div class="info_link-box">
              <a href="<?= $loc_link ?>">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span> <?= $loc_name ?> </span>
              </a>
              <a href="tel:+<?= $phone ?>">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>+<?= $phone ?></span>
              </a>
              <a href="mailto:<?= $email ?>">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span> <?= $email ?></span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- footer section -->
    <footer class=" footer_section">
      <div class="container">
        <p>
          &copy; <span id="displayYear"></span> All Rights Reserved By
          <a href="https://html.design/">Free Html Templates</a>
        </p>
      </div>
    </footer>
    <!-- footer section -->

  </section>

  <!-- end info section -->


  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <script src="js/custom.js"></script>

</body>

</html>