<?php
session_start();
require 'config.php';
if (isset($_SESSION['user'])) {
    // $sql = "SELECT * FROM cart INNER JOIN product ON cart.pid = product.pid WHERE uid = $_SESSION[user] AND status = 1";
    $sql = "SELECT * FROM product WHERE pid IN (SELECT pid FROM cart WHERE uid = $_SESSION[user] AND status = 1)";
} else {
    if (isset($_COOKIE['cart']) && !empty($_COOKIE['cart'])) {    
        $cooke = $_COOKIE['cart'];
        $cart = json_decode($cooke, true);
        $products = implode(',', $cart);
        $sql = "SELECT * FROM product WHERE pid IN (" . $products . ")";
    }
}

$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
if ($rows == null) {
    echo "<script>confirm('Cart is empty!'); window.location.href = 'shop';</script>";
    die();
}

$totalPrice = 0;

if (!$result) {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

function removeFromCart($pid){
    require 'config.php';
    if (isset($_SESSION['user'])) {
        $sql = "DELETE FROM cart WHERE pid = '$pid' AND uid = $_SESSION[user] AND status = 1";
    } else {
        $cooke = $_COOKIE['cart'];
        $cart = json_decode($cooke, true);
        unset($cart[$pid]);
        $cart = json_encode($cart);
        setcookie('cart', $cart, time() + (86400 * 30), "/");
    }
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    } else {
        header('location: cart');
    }
}

if (isset($_POST['remove'])) {
    if (isset($_SESSION['user'])) {
        removeFromCart($_POST['pid']);
    } else {
        echo "<script>removeFromCart(" . $_POST['pid'] . ");</script>";
    }
}



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
  <link rel="stylesheet" href="css/cart.css">
</head>
<body>
    <div class="card mt-3">
        <div class="row">
            <!-- Column for the products list with scrolling enabled -->
            <div class="col-md-8">
                <div class="cart">
                    <div class="title">
                        <div class="row">
                            <div class="col"><h4><b>Shopping Cart</b></h4></div>
                            <div class="col align-self-center text-right text-muted"><?= count($rows) ?> items</div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-2"></div>
                            <div class="col-2">Product</div>
                            <div class="col-2"></div>
                            <div class="col-2"></div>
                            <div class="col-2 ml-3">Price</div>
                            <div class="col-2"></div>
                        </div>
                    </div>
                    <div class="cart-items">
                        <?php foreach ($rows as $row): ?>
                            <?php  $totalPrice += $row['price']; ?>
                        <div class="row border-top border-bottom">
                            <div class="row main align-items-center">
                                <div class="col-2"><img class="img-fluid" src="<?= $row['image_url'] ?>"></div>
                                
                                <div class="col">
                                    <a href="product?pid=<?= $row['pid'] ?>">
                                    <div style="white-space: pre-wrap;" class="row "><?= $row['title'] ?></div>
                                    </a>
                                    <div class="row text-muted small"><?= substr($row['description'], 0, 50).'...' ?></div>
                                </div>
                                <div class="col">
                                    <!-- <a href="#">-</a><a href="#" class="border">1</a><a href="#">+</a> -->
                                </div>
                                <div class="col">
                                    &dollar; <?= $row['price'] ?> 
                                    <form style="float: right; margin-top: -5px" method="POST" action="">
                                        <input type="submit" class="close" name="remove" value="&#10005">
                                        <input type="hidden" name="pid" value="<?= $row['pid'] ?>">
                                    <!-- <a href="javascript:removeFromCart(<?= $row['pid'] ?>)">
                                        <span class="close">
                                            &#10005;
                                        </span>
                                    </a> -->
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                    <div class="back-to-shop">
                        <a href="javascript:history.go(-1)">&leftarrow;<span class="text-muted"> Back to shop</span></a>
                    </div>
                </div>
            </div>

            <!-- Summary section -->
            <div class="col-md-4 summary">
                <div><h5><b>Summary</b></h5></div>
                <hr>
                <div class="row">
                    <div class="col" style="padding-left:0;">ITEMS <?= count($rows) ?></div>
                    <div class="col text-right">&dollar; <?= $totalPrice ?></div>
                </div>
                <!-- <form> -->
                    <p>SHIPPING</p>
                    <select><option class="text-muted">Standard-Delivery- &dollar;5.00</option></select>
                    <p>GIVE CODE</p>
                    <input id="code" placeholder="Enter your code">
                <!-- </form> -->
                <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                    <div class="col">TOTAL PRICE</div>
                    <div class="col text-right">&dollar; <?= $totalPrice ?></div>
                </div>
                
                <form action="checkout" method="post">
                <input type="hidden" name="totalPrice" value="<?= $totalPrice ?>">
                <input type="submit" value="CHECKOUT" class="btn" name="checkout">
                </form>
            </div>
        </div>
    </div>
    <script src="js/custom.js"></script>
</body>

</html>