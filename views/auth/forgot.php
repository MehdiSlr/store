<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>  
    <link rel="stylesheet" href="css/auth.css">
</head>
<?php
$errorMsg = '';
if (isset($_SESSION['error'])) {
    $errorMsg = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
<body>
<div class="container">
      <div class="form_area">
          <p class="title">FORGOT PASSWORD</p>
          <p style="margin: 0 auto">We've sent a code to your email address</p>
          <form action="auth" method="post">
                <div class="form_group">
                    <label class="sub_title" for="name">Email</label>
                    <input placeholder="Enter your email" class="form_style" name="email" type="email" required>
                <span style="color:red; margin-bottom: 0;"><?= $errorMsg ?></span>
                </div>
                <div>
                  <input type="submit" name="forgot" value="SEND" class="btn">
                </div>
            </form>
        </div>
    </div>
</body>
</html>