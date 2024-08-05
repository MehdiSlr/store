
<!DOCTYPE html>
<html lang="en">
<?php 
include __DIR__."/components/head.php"; 
require "config.php";
session_start();
if (!isset($_SESSION['admin'])) {
    header("location: $base_path");
} else {
    $name = $_SESSION['admin']['name'];
}
?>

<body class="g-sidenav-show  bg-gray-200">
  <?php 
  $active_page = "dashboard";
  include __DIR__."/components/sidebar.php"; 
  ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Dashboard</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <!-- -->
          </div>
          <?php include __DIR__."/components/navbar.php"; ?>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row min-vh-80 h-100">
        <div class="col-12">
          <?php include __DIR__."/components/theme.php"; ?>
        </div>
    </div>
  </div>
  </main>
</body>

</html>