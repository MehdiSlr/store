<?php
// session_start();
// require '../config.php';
if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
  $sql = "SELECT * FROM users WHERE uid = '$user'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $name = $row['name'];
  $access = $row['access'];
  if ($access == '0' || $access == '1' || $access == '2') {
      $_SESSION['admin'] = $row;
  }

  if (isset($_COOKIE['cart']) && !empty($_COOKIE['cart'])) {
      $cart = json_decode($_COOKIE['cart'], true);
      if (!is_array($cart)) {
          $cart = array();
      }
      $pcart = implode(',', $cart);
      $sql = "SELECT * FROM cart WHERE status = 1 AND uid = $user AND pid IN ($pcart)";
      $result = mysqli_query($conn, $sql);
      if (!$result) {
          echo "Error: " . $sql . "<br>" . $conn->error;
      } else {
          $cartUpdated = false;
          if (mysqli_num_rows($result) > 0) {
              $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
              foreach ($rows as $row) {
                  if (($key = array_search($row['pid'], $cart)) !== false) {
                      unset($cart[$key]);
                      $cartUpdated = true;
                  }
              }
          }

          if ($cartUpdated) {
              setcookie('cart', json_encode(array_values($cart)), time() + (86400 * 30), "/");
          }

          // Add remaining products in the cookie to the database
          foreach ($cart as $pid) {
              $sql = "INSERT INTO cart (uid, pid) VALUES ($user, $pid)";
              $result = mysqli_query($conn, $sql);
              if (!$result) {
                  echo "Error: " . $sql . "<br>" . $conn->error;
              }
          }

          setcookie('cart', '', time() - 3600, "/");
          header('Location: /cart');
      }
  }
}
else {
    $name = null;
}
?>
<header class="header_section">
   <nav class="navbar navbar-expand-lg custom_nav-container">
     <a class="navbar-brand" href="/">
       <span><?= $site_title ?></span>
     </a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
       <span class=""></span>
     </button>

     <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <ul class="navbar-nav">
         <li class="nav-item <?= $active_page == "home" ? "active" : '' ?>">
           <a class="nav-link" href="<?=$base_path?>">Home <span class="sr-only">(current)</span></a>
         </li>
         <li class="nav-item <?= $active_page == "shop" ? "active" : '' ?>">
           <a class="nav-link" href="<?= $active_page == "home" ? "#shop" : 'shop' ?>">Shop</a>
         </li>
         <li class="nav-item">
           <a class="nav-link" href="<?= $active_page == "home" ? "#why-us" : $base_path ?>">Why Us</a>
         </li>
         <li class="nav-item">
           <a class="nav-link" href="<?= $active_page == "home" ? "#testimonial" : $base_path ?>">Testimonial</a>
         </li>
         <li class="nav-item">
           <a class="nav-link" href="<?= $active_page == "home" ? "#contact-us" : $base_path ?>">Contact Us</a>
         </li>
       </ul>
       <div class="user_option">
         <?php if ($user != null) {
           $user_link = "#";
           $user_title = $name;
         } else {
           $user_link = "login";
           $user_title = "Login";
         }
         ?>
         <?php if ($user != null) { ?>
           <div class="dropdown">
             <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fa fa-user" aria-hidden="true"></i>
               <span><?= $user_title ?></span>
             </a>
             <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
              <?php if (isset($_SESSION['admin'])) { ?>
                <a class="dropdown-item" href="admin/dashboard" target="_blank">Admin</a>
              <?php } ?>
                <a class="dropdown-item" href=<?= "logout" ?>>Logout</a>
             </div>
           </div>
         <?php } else { ?>
           <a href="<?= $user_link ?>">
             <i class="fa fa-user" aria-hidden="true"></i>
             <span><?= $user_title ?></span>
           </a>
         <?php } ?>
         <a href="cart">
           <i class="fa fa-shopping-bag" aria-hidden="true"></i>
         </a>
         <!-- <form class="form-inline">
           <button class="btn nav_search-btn" type="submit">
             <i class="fa fa-search" aria-hidden="true"></i>
           </button>
         </form> -->
       </div>
     </div>
   </nav>
 </header>
