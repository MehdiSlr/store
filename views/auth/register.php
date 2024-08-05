<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/auth.css">
</head>
<?php
session_start();
$errorMsg="";
if (isset($_SESSION['user'])) {
    header('location: index.php');
}
if (isset($_SESSION['error'])) {
    $errorMsg = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
<body>
  <div class="container">
      <div class="form_area">
          <p class="title">SIGN UP</p>
          <form action="auth" method="post">
              <div class="form_group">
                  <label class="sub_title" for="name">Name</label>
                  <input placeholder="Enter your full name" class="form_style" name="name" type="text" required>
              </div>
              <div class="form_group">
                  <label class="sub_title" for="email">Email</label>
                  <input placeholder="Enter your email" id="email" name="email" class="form_style" type="email" required>
              </div>
              <div class="form_group">
                  <label class="sub_title" for="password">Password</label>
                  <input placeholder="Enter your password" id="password" name="password" class="form_style" type="password" required>
              </div>
              <div class="form_group">
                  <label class="sub_title" for="password">Re-Enter Password</label>
                  <input placeholder="Re-enter your password" id="repassword" name="repassword" class="form_style" type="password" required>
                </div>
                <span style="color:red; margin-bottom: 0;"><?= $errorMsg ?></span>
              <div>
                  <input type="submit" name="register" value="SIGN UP" class="btn">
                  <p>Have an Account? <a class="link" href="login">Login Here!</a></p>
          </form></div><a class="link" href="">
  </a></div>
</body>
</html>