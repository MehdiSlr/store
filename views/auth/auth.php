<?php
session_start();
require_once 'config.php';


// Register
if (isset($_POST['register'])) {
  if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repassword'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    
    if ($password == $repassword) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['error'] = 'Email already exists!';
            header('location: signup');
        } else {
            $password = md5($password);
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $_SESSION['code'] = rand(999999, 111111);
            header("Location: verify");
        }
    } else {
        $_SESSION['error'] = 'Passwords does not match!';
        header('location: signup');
    }
  }
  else {
    $_SESSION['error'] = 'All fields are required!';
    header('location: signup');
  }
}


// Login
if (isset($_POST['login'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($password == $row['pass']) {
                $_SESSION['user'] = $row['uid'];
                header("Location: $base_path");
            }
            else {
                $_SESSION['error'] = 'Incorrect Email or Password!';
                header('location: login');
            }
        }
        else {
            $_SESSION['error'] = 'Incorrect Email or Password!';
            header('location: login');
        }
    }
    else {
        $_SESSION['error'] = 'All fields are required!';
        header('location: login');
    }
}

// Verify
if (isset($_POST['verify'])) {
    if (!empty($_POST['code'])) {
        if ($_POST['code'] == $_SESSION['code']) {
            $sql = "SELECT * FROM users WHERE email = '$_SESSION[email]'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $sql = "UPDATE users SET status = 'respass' WHERE email = '$_SESSION[email]'";
                $result = mysqli_query($conn, $sql);
                unset($_SESSION['code']);
                mysqli_close($conn);
                header('location: ./reset-password');
            }
            else {
                $sql = "INSERT INTO users (name, email, pass) VALUES ('$_SESSION[name]', '$_SESSION[email]', '$_SESSION[password]')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $sql = "SELECT * FROM users WHERE email = '$_SESSION[email]'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['user'] = $row['uid'];
                    unset($_SESSION['code']);
                    mysqli_close($conn);
                    header('location: /');
                }
                else {
                    $_SESSION['error'] = 'There was an error while registering. Please try again.';
                    header('location: signup');
                }
            }
        }
        else {
            $_SESSION['error'] = 'Incorrect code.';
            header('location: verify');
        }
    }
    else {
        $_SESSION['error'] = 'All fields are required.';
        header('location: verify');
    }
}


// forgot
if (isset($_POST['forgot'])) {
    if (!empty($_POST['email'])) {
        $sql = "SELECT * FROM users WHERE email = '$_POST[email]'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['code'] = rand(999999, 111111);
            header('location: verify');
        }
        else {
            $_SESSION['error'] = 'Incorrect Email!';
            header('location: forgot-password');
        }
    }
    else {
        $_SESSION['error'] = 'Fill the email field!';
        header('location: forgot-password');
    }
}



// Reset Password
if (isset($_POST['reset'])) {
    if ($_POST['password'] != $_POST['repassword']) {
        $_SESSION['error'] = 'Passwords does not match!';
        header('location: reset-password');
    } else {
        $password = md5($_POST['password']);
        $sql = "UPDATE users SET password = '$password', status = 'active' WHERE email = '$_SESSION[email]'";
        mysqli_query($conn, $sql);
        header("location: login");
    }
}
?>