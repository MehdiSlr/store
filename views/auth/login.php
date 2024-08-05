<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/auth.css">
</head>
<?php
session_start();
$errorMsg = '';
if (isset($_SESSION['user'])) {
    header('location: /');
}
if (isset($_SESSION['error'])) {
    $errorMsg = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
<body>
    <div class="container">
        <div class="form_area">
            <p class="title">LOGIN</p>
            <form action="auth" method="post">
                <div class="form_group">
                    <label class="sub_title" for="email">Email</label>
                    <input placeholder="Enter your email" id="email" class="form_style" name="email" type="email" required>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="password">Password</label>
                    <input placeholder="Enter your password" id="password" class="form_style" name="password" type="password" required>
                </div>
                <p style="text-align: right; margin-right: 10px"><a class="link" href="/forgot-password">Forgot Password?</a></p>
                <span style="color:red; margin-bottom: 0;"><?= $errorMsg ?></span>
                <div>
                <input type="submit" name="login" value="LOGIN" class="btn">
                    <p>Are you new? <a class="link" href="signup">Sign Up Here!</a></p>
                </div>
        </a></form></div><a class="link" href="">
    </a></div>
</body>
</html>