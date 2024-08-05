<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="/css/auth.css">
</head>
<?php
    session_start();
    require 'config.php';
    $errorMsg = '';
    $sql = "SELECT status FROM users WHERE email = '$_SESSION[email]'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if($row['status'] != 'respass') {
        header("location: 404");
    }
    if (isset($_SESSION['error'])) {
        $errorMsg = $_SESSION['error'];
        unset($_SESSION['error']);
    }
?>
<body>
<div class="container">
      <div class="form_area">
          <p class="title">RESET PASSWORD</p>
          <form action="auth" method="post">
              <div class="form_group">
                  <label class="sub_title" for="email">Email</label>
                  <input placeholder="Enter your email" id="email" name="email" class="form_style" type="email" value="<?= $_SESSION['email'] ?>" required disabled>
              </div>
              <div class="form_group">
                  <label class="sub_title" for="password">Password</label>
                  <input placeholder="Enter your password" id="password" name="password" class="form_style" type="password" required>
              </div>
              <div class="form_group">
                  <label class="sub_title" for="password">Re-Enter Password</label>
                  <input placeholder="Re-enter your password" id="repassword" name="repassword" class="form_style" type="password" required>
                  <p style="color:red; margin-bottom: 0"><?= $errorMsg ?></p>
              </div>
              <div>
                  <input type="submit" name="reset" value="RESET" class="btn">
          </form></div>
    </div>
</body>
</html>