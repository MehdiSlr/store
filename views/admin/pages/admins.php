<!DOCTYPE html>
<html lang="en">
<?php include __DIR__."/components/head.php"; 
include "config.php";
session_start();
if (!isset($_SESSION['admin']) && $_SESSION['admin']['access'] != 0 && $_SESSION['admin']['access'] != 1) {
    header("location: $base_path");
} else {
    $name = $_SESSION['admin']['name'];
}

// if ($_SESSION['admin']['access'] == 0 ) {
//   $sql = "SELECT * FROM users WHERE access = '0' or access = '1' or access = '2'";
// }
switch ($_SESSION['admin']['access']) {
  case 0:
    $sql = "SELECT * FROM users WHERE access = '0' or access = '1' or access = '2'";
    break;
  case 1:
    $sql = "SELECT * FROM users WHERE access = '2'";
    break;
}
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);


if (isset($_POST['edit'])) {
  $access = $_POST['access'];
  $uid = $_POST['uid'];

  $sql = "UPDATE users SET access = '$access' WHERE uid = '$uid'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    header('location: admins');
  } else {
    echo "<script>alert('Something went wrong: " . mysqli_error($conn) . "')</script>";
  }
}

if (isset($_POST['add'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = md5($_POST['password']);
  $access = $_POST['access'];


  $sql = "SELECT * FROM users WHERE email = '$email'";
  $result = mysqli_query($conn, $sql);
  $count = mysqli_num_rows($result);
  if ($count > 0) {
    $sql = "UPDATE users SET access = '$access' WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    header('location: admins');
  } else {
    $sql = "INSERT INTO users (name, email, pass, access) VALUES ('$name', '$email', '$password', '$access')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      header('location: admins');
    } else {
      echo "<script>alert('Something went wrong!')</script>";
    }
  }
}
?>

<body class="g-sidenav-show  bg-gray-200">
  <?php
  $active_page = "admins";
  include __DIR__."/components/sidebar.php";
  ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Admins</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Admins</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            </div>
          </div>
          <?php include __DIR__."/components/navbar.php"; ?>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row min-vh-80 h-100">
        <!-- admins table -->
        
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3"> Admins</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Function</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Set Role</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($rows as $admin): ?>
                    <form action="" method="POST">
                        <tr>
                          <td>
                            <div class="d-flex px-2 py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm"><?= $admin['name']; ?></h6>
                              </div>
                            </div>
                          </td>
                          <td>
                            <p class="text-xs font-weight-bold mb-0"><?= $admin['email']; ?></p>
                          </td>
                          <td class="align-middle text-center text-sm">
                            <p class="text-xs font-weight-bold mb-0">
                              <?php switch ($admin['access']) {
                                        case 0:
                                            echo "Super Admin";
                                            break;
                                        case 1:
                                            echo "Admin";
                                            break;
                                        case 2:
                                            echo "Editor";
                                            break;
                                    } ?>
                            </p>
                          </td>
                          <?php if ($admin['access'] == 0) {?>
                          <td class="align-middle">
                            <select class="form-select form-select-sm ms-2 px-0 border-1 rounded text-center" name="access" aria-label="Default select example" disabled>
                              <option value="0" <?= $admin['access'] == 0 ? 'selected disabled' : ''; ?>>Super Admin</option>
                              </select>
                          </td>
                          <td class="align-middle">
                          </td>
                            <?php } else {?>
                          <td class="align-middle">
                            <select class="form-select form-select-sm ms-2 px-0 border-1 rounded text-center" name="access" aria-label="Default select example">
                              <option value="1" <?= $admin['access'] == 1 ? 'selected' : ''; ?>>Admin</option>
                              <option value="2" <?= $admin['access'] == 2 ? 'selected' : ''; ?>>Editor</option>
                              <option value="3" <?= $admin['access'] == 3 ? 'selected' : ''; ?>>Normal User</option>
                            </select>
                          </td>
                          <td class="align-middle">
                            <input type="submit" class="btn btn-primary btn-sm mr-0 mt-3" value="Submit" name="edit" >
                            <input type="hidden" name="uid" value="<?= $admin['uid']; ?>">
                          </td>
                          <?php } ?>
                        </tr>
                    </form>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        
        <!-- end admins table -->
         <!-- add admin -->
        
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3"> Add New Admin</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <form action="#" method="POST" class="p-4">
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Name</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" name="name" required>
                    </div>
                    <div class="col">
                      <label class="form-label">Email</label>
                      <input style="border: 1px solid #ced4da;" type="email" class="form-control p-2" name="email" required>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Password</label>
                      <input style="border: 1px solid #ced4da;" type="password" class="form-control p-2" name="password" required>
                    </div>
                    <div class="col">
                      <label for="access" class="form-label">Role</label>
                      <select class="form-select p-2" name="access" aria-label="Default select example">
                        <option value="1">Admin</option>
                        <option selected value="2">Editor</option>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col text-center">
                      <input type="submit" class="btn btn-primary btn-sm" value="Add Admin" name="add">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- end add admin -->
      </div>
    </div>
  </div>
  </main>
  <?php include __DIR__."/components/theme.php"; ?>
</body>

</html>