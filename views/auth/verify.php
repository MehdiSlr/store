<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <link rel="stylesheet" href="css/auth.css">
</head>
<?php
  session_start();
  $errorMsg = '';
  if(!isset($_SESSION['code'])) {
    session_destroy();
    header('location: signup.php');
  }
  if (isset($_SESSION['error'])) {
    $errorMsg = $_SESSION['error'];
    unset($_SESSION['error']);
  }
?>
<body>
    <div class="container">
      <div class="form_area">
          <p class="title">VERIFY EMAIL</p>
          <form action="auth" method="post">
                <div class="form_group">
                  <label class="sub_title" for="name">OTP Code</label>
                  <input placeholder="Enter your code" class="form_style" name="code" type="text" required>
                </div>
                  <p style="text-align: right; margin-right: 10px"><a class="link" href="javascript:history.back()">Edit Email</a></p>
                  <span style="color:red; margin-bottom: 0;"><?= $errorMsg ?></span>
                <p>The code is <?= $_SESSION['code'] ?></p>
                <div>
                  <input type="submit" name="verify" value="VERIFY" class="btn">
                </div>
            </form>
        </div>
    </div>
</body>
</html>