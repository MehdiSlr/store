<?php
session_start();
require 'config.php';

if(!isset($_GET['pid']) || empty($_GET['pid']) || !isset($_SESSION['user'])) {
    header('location: shop');
} else {
    $pid = $_GET['pid'];
    $sql = "INSERT INTO cart (pid, uid) VALUES ($pid, $_SESSION[user])";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['message'] = "Product added to cart";
        header('location: shop');
        // echo "<script>javascript:history.back()</script>";
    } else {
        echo "<script>alert('Something went wrong!" . mysqli_error($conn) . "')</script>";
    }
}
?>