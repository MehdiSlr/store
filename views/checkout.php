<?php
session_start();
require 'config.php';

if (isset($_POST['checkout'])) {
    $_SESSION['checkout'] = TRUE;
}

if (isset($_SESSION['checkout'])) {
    if (!isset($_SESSION['user'])) {
        header('location: login');
    } else {
        $sql = "UPDATE cart SET status = 2 WHERE uid = '$_SESSION[user]' AND status = 1";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        } else {
            unset($_SESSION['checkout']);
            echo '<script>confirm("Order placed successfully!"); window.location.href = "/store";</script>';
        }
    }
} else {
    header("location: $base_path");
}


?>