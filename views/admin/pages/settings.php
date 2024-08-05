<!DOCTYPE html>
<html lang="en">
<?php include __DIR__."/components/head.php"; 
require "config.php";
session_start();
if (!isset($_SESSION['admin']) && ($_SESSION['admin']['access'] != 0 || $_SESSION['admin']['access'] != 1)) {
    header('location: /');
} else {
    $name = $_SESSION['admin']['name'];
}

// Read Slider Data from Database
$slider_sql = "SELECT * FROM slider WHERE status = '1' OR status = '0' ORDER BY sid DESC";
$slider_resault = mysqli_query($conn, $slider_sql);
$slider_rows = mysqli_fetch_all($slider_resault, MYSQLI_ASSOC);
//


// Add slider
  if (isset($_POST['add-slider'])) {
    $slider_title = htmlspecialchars($_POST['slider_title']);
    $slider_text = htmlspecialchars($_POST['slider_text']);
    $slider_btn_text = $_POST['slider_btn_text'];
    $slider_btn_link = $_POST['slider_btn_link'];

    $sql = "INSERT INTO slider (title, text, btn_text, btn_url) VALUES ('$slider_title', '$slider_text', '$slider_btn_text', '$slider_btn_link')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      if (isset($_FILES['slider_image'])) {
        if ($_FILES['slider_image']['error'] == 0) {
          $file_name = $_FILES['slider_image']['name'];
          $file_tmp = $_FILES['slider_image']['tmp_name'];
          $file_size = $_FILES['slider_image']['size'];
          $file_type = $_FILES['slider_image']['type'];
          $file_ext = explode('.', $file_name);
          $file_ext = strtolower(end($file_ext));

          $last_id = mysqli_insert_id($conn);
          $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/images/slider';
          $target_file = $upload_dir . '/s' . $last_id . '.' . $file_ext;
          $image_url = '/images/slider/s' . $last_id . '.' . $file_ext;
          if(move_uploaded_file($file_tmp, $target_file)) {
            $sql = "UPDATE slider SET image_url = '$image_url' WHERE sid = $last_id";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
              die('Error: ' . mysqli_error($conn));
            }
            else {
              header('location: /admin/site-settings');
            }
          }
          else {
            die('Failed to upload image' . $target_file);
          }
        }
      }
    }
  }
//

// Edit Slider
  if (isset($_POST['edit-slider'])) {
    $sid = $_POST['sid'];
    $status = $_POST['status'];

    $sql = "UPDATE slider SET status = '$status' WHERE sid = '$sid'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    else {
      echo '<script>alert("Slider updated successfully");</script>';
      header('location: /admin/site-settings');
    }
  }
//

//Read site settings from database
  $sql = "SELECT * FROM settings";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  $site_title = $row['title'];
  $site_logo = $row['logo_url'];
  $map = $row['map'];
  $footer = $row['footer'];

  $map = json_decode($map, true);
  $footer = json_decode($footer, true);

  $map_lat = $map['lat'];
  $map_long = $map['long'];

  $facebook = $footer['social']['facebook'];
  $twitter = $footer['social']['twitter'];
  $instagram = $footer['social']['instagram'];
  $youtube = $footer['social']['youtube'];

  $t1_title = $footer['descriptions']['t1_title'];
  $t1_desc = $footer['descriptions']['t1_desc'];
  $t2_title = $footer['descriptions']['t2_title'];
  $t2_desc = $footer['descriptions']['t2_desc'];

  $phone = $footer['contact']['phone'];
  $email = $footer['contact']['email'];
  $loc_name = $footer['contact']['loc_name'];
  $loc_link = $footer['contact']['loc_link'];
//

// Update Settings
if (isset($_POST['setting'])) {
  // site settings
  $site_title = $_POST['title'];

  // map settings
  $map_lat = $_POST['map-lat'];
  $map_long = $_POST['map-long'];

  // footer settings
    // social links
  $facebook = $_POST['facebook'];
  $twitter = $_POST['twitter'];
  $instagram = $_POST['instagram'];
  $youtube = $_POST['youtube'];
    // descriptions
  $t1_title = $_POST['t1_title'];
  $t1_desc = $_POST['t1_desc'];
  $t2_title = $_POST['t2_title'];
  $t2_desc = $_POST['t2_desc'];
    // contact us
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $loc_name = $_POST['loc_name'];
  $loc_link = $_POST['loc_link'];

  $map = array(
    'lat' => $map_lat,
    'long' => $map_long
  );

  $footer = array(
    'social' => array(
      'facebook' => $facebook,
      'twitter' => $twitter,
      'instagram' => $instagram,
      'youtube' => $youtube
    ),
    'descriptions' => array(
      't1_title' => $t1_title,
      't1_desc' => $t1_desc,
      't2_title' => $t2_title,
      't2_desc' => $t2_desc
    ),
    'contact' => array(
      'phone' => $phone,
      'email' => $email,
      'loc_name' => $loc_name,
      'loc_link' => $loc_link
    )
  );

  $footer = json_encode($footer);
  $map = json_encode($map);

  if (isset($_FILES['logo'])) {
    if ($_FILES['logo']['error'] == 0) {
      $file_name = $_FILES['logo']['name'];
      $file_tmp = $_FILES['logo']['tmp_name'];
      $file_size = $_FILES['logo']['size'];
      $file_type = $_FILES['logo']['type'];

      $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/images/';
      // $target_file = $upload_dir . basename($file_name);
      $target_file = $upload_dir . 'logo.png';
      if(move_uploaded_file($file_tmp, $target_file)) {
        $site_logo = '/images/logo.png';
      }
      else {
        die('Failed to upload image' . $target_file);
      }
    }
    else {
      echo 'File Error: ' . $_FILES['logo']['error'];
    }
  }
  else {
  }
  $sql = "UPDATE settings SET title = '$site_title', logo_url = '$site_logo', map = '$map', footer = '$footer'";
  // $sql = "INSERT INTO settings (title, logo_url, footer, map) VALUES ('$site_title', '$site_logo', '$footer', '$map')";
  $result = $conn->query($sql);

  if ($result) {
    header('location: /admin/site-settings');
  }

}

// Read Banner Data from Database
  $sql = "SELECT * FROM banner";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['bid'] == 1) {
        // بنر 1
        $b1_title = $row['title'];
        $b1_text = $row['text'];
        $b1_image = $row['image_url'];
        $b1_color = $row['color'];
        $b1_btn1_text = $row['btn1_text'];
        $b1_btn1_link = $row['btn1_link'];
        $b1_btn2_text = $row['btn2_text'];
        $b1_btn2_link = $row['btn2_link'];
        $b1_btn_count = ($b1_btn2_text == '') ? 1 : 2;
    } elseif ($row['bid'] == 2) {
        // بنر 2
        $b2_title = $row['title'];
        $b2_text = $row['text'];
        $b2_image = $row['image_url'];
        $b2_color = $row['color'];
        $b2_btn1_text = $row['btn1_text'];
        $b2_btn1_link = $row['btn1_link'];
        $b2_btn2_text = $row['btn2_text'];
        $b2_btn2_link = $row['btn2_link'];
        $b2_btn_count = ($b2_btn2_text == '') ? 1 : 2;
    }
  }
//

// Function to update the banner
function updateBanner($conn, $id, $title, $image, $text, $color, $btn1_text, $btn1_link, $btn2_text = '', $btn2_link = '') {
  // Prepare SQL statement
  $sql = "UPDATE banner SET 
              title = '$title', 
              text = '$text', 
              color = '$color', 
              btn1_text = '$btn1_text', 
              btn1_link = '$btn1_link', 
              btn2_text = '$btn2_text', 
              btn2_link = '$btn2_link',
              image_url = '$image'
          WHERE bid = $id";

  // Execute SQL statement
  $result = mysqli_query($conn, $sql);
  if (!$result) {
    echo "Error updating banner $id: " . mysqli_error($conn);
  }
  else {
    header('location: /admin/site-settings');
  }
}

if (isset($_POST['banner'])) {
  // Banner 1 values
  $b1_title = htmlspecialchars($_POST['b1_title']);
  if (isset($_FILES['b1_image'])) {
    if ($_FILES['b1_image']['error'] == 0) {
      $file_name = $_FILES['b1_image']['name'];
      $file_tmp = $_FILES['b1_image']['tmp_name'];
      $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/images/banner/';
      $target_file = $upload_dir . basename($file_name);
      if (move_uploaded_file($file_tmp, $target_file)) {
          $b1_image = '/images/banner/' . basename($file_name);
      } else {
          die('Failed to upload image ' . $target_file);
      }
    }
    else {
    $b1_image = '';
    }
  }
  else {
    $b1_image = $row['b1_image'];
  }
  $b1_text = htmlspecialchars($_POST['b1_text']);
  $b1_color = $_POST['b1_color'];
  $b1_btn1_text = $_POST['b1_btn1_text'];
  $b1_btn1_link = $_POST['b1_btn1_link'];
  $b1_btn2_text = ($_POST['b1_btn_count'] == 2) ? $_POST['b1_btn2_text'] : '';
  $b1_btn2_link = ($_POST['b1_btn_count'] == 2) ? $_POST['b1_btn2_link'] : '';

  // Update banner 1
  updateBanner($conn, 1, $b1_title, $b1_image, $b1_text, $b1_color, $b1_btn1_text, $b1_btn1_link, $b1_btn2_text, $b1_btn2_link);

  // Banner 2 values
  if (isset($_FILES['b2_image'])) {
    if ($_FILES['b2_image']['error'] == 0) {
      $file_name = $_FILES['b2_image']['name'];
      $file_tmp = $_FILES['b2_image']['tmp_name'];
      $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/images/banner/';
      $target_file = $upload_dir . basename($file_name);
      if (move_uploaded_file($file_tmp, $target_file)) {
          $b2_image = '/images/banner/' . basename($file_name);
      } else {
          die('Failed to upload image ' . $target_file);
      }
    }
    else {
    }
  }
  else {
  }
  $b2_title = htmlspecialchars($_POST['b2_title']);
  $b2_text = htmlspecialchars($_POST['b2_text']);
  $b2_color = $_POST['b2_color'];
  $b2_btn1_text = $_POST['b2_btn1_text'];
  $b2_btn1_link = $_POST['b2_btn1_link'];
  $b2_btn2_text = ($_POST['b2_btn_count'] == 2) ? $_POST['b2_btn2_text'] : '';
  $b2_btn2_link = ($_POST['b2_btn_count'] == 2) ? $_POST['b2_btn2_link'] : '';

  // Update banner 2
  updateBanner($conn, 2, $b2_title, $b2_image, $b2_text, $b2_color, $b2_btn1_text, $b2_btn1_link, $b2_btn2_text, $b2_btn2_link);
}
?>

<body class="g-sidenav-show  bg-gray-200">
<?php
  $active_page = "settings";
  include __DIR__."/components/sidebar.php";
  ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Settings</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Site Settings</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          </div>
          <?php include __DIR__."/components/navbar.php"; ?>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row min-vh-80 h-100">
         <!-- Slider Settings -->
          <!-- Slider list -->
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3"> Slider Settings</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Title</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Text</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Button</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($slider_rows as $slider): ?>
                    <form action="" method="POST">
                        <tr>
                          <td>
                            <div class="d-flex px-2 py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm"><?= nl2br($slider['title']); ?></h6>
                              </div>
                            </div>
                          </td>
                          <td>
                            <p style="white-space: pre-wrap;" class="text-xs font-weight-bold mb-0"><?= nl2br($slider['text']); ?></p>
                          </td>
                          <td class="align-middle text-center text-sm">
                            <p class="text-xs font-weight-bold mb-0">
                              <a href="<?= $slider['btn_url']; ?>" target="_blank"><?= $slider['btn_text']; ?></a>
                            </p>
                          </td>
                          <td class="align-middle">
                            <select class="form-select form-select-sm ms-2 px-0 border-1 rounded text-center" name="status" aria-label="Default select example">
                              <option value="1" <?= $slider['status'] == 1 ? 'selected' : ''; ?>>Active</option>
                              <option value="0" <?= $slider['status'] == 0 ? 'selected' : ''; ?>>Deactive</option>
                              <option value="delete" <?= $slider['status'] == 'delete' ? 'selected' : ''; ?>>Delete</option>
                            </select>
                          </td>
                          <td class="align-middle">
                            <input type="submit" class="btn btn-primary btn-sm mr-0 mt-3" value="Submit" name="edit-slider" >
                            <input type="hidden" name="sid" value="<?= $slider['sid']; ?>">
                          </td>
                        </tr>
                    </form>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
        <!-- end Slider list -->
        <!-- Add Slider -->
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <form action="#" method="POST" class="p-4" enctype="multipart/form-data">
                <label class="h5 mt-2">Add Slider</label><br>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Title</label>
                      <textarea style="border: 1px solid #ced4da; height: 40px; resize: none;" type="text" class="form-control p-2" name="slider_title" required></textarea>
                    </div>
                    <div class="col">
                      <label class="form-label">Image</label>
                      <input style="border: 1px solid #ced4da;" type="file" class="form-control p-2" name="slider_image" required>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Text</label>
                      <textarea style="border: 1px solid #ced4da; height: 100px; resize: none;" type="text" class="form-control p-2" name="slider_text" required></textarea>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Button Text</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" name="slider_btn_text">
                    </div>
                    <div class="col">
                      <label class="form-label">Button Link</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" name="slider_btn_link">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col text-center">
                      <input type="submit" class="btn btn-primary btn-sm" value="Add Slider" name="add-slider">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- end Add Slider -->

         <!-- end Slider Settings -->
         <!-- Banner Settings -->
         <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3"> Banner Settings</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <form action="#" method="POST" class="p-4" enctype="multipart/form-data">
                <label class="h5 mt-2">First Banner</label><br>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Title</label>
                      <textarea style="border: 1px solid #ced4da; height: 40px; resize: none;" type="text" class="form-control p-2" name="b1_title" required><?= $b1_title ?></textarea>
                    </div>
                    <div class="col">
                      <label class="form-label">Image</label>
                      <input style="border: 1px solid #ced4da;" type="file" class="form-control p-2" name="b1_image">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Text</label>
                      <textarea style="border: 1px solid #ced4da; height: 100px; resize: none;" type="text" class="form-control p-2" name="b1_text" required><?= $b1_text ?></textarea>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Color</label>
                      <input style="border: 1px solid #ced4da; height: 40px" value="<?= $b1_color ?>" type="color" class="form-control p-2" name="b1_color" required>
                    </div>
                    <div class="col">
                      <label for="access" class="form-label">Number of buttons</label>
                      <select id="buttonCount1" class="form-select p-2" name="b1_btn_count" aria-label="Default select example">
                        <option <?= $b1_btn_count == 1 ? 'selected' : '' ?> value="1">One Button</option>
                        <option <?= $b1_btn_count == 2 ? 'selected' : '' ?> value="2">Two Buttons</option>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Button 1 Text</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $b1_btn1_text ?>" name="b1_btn1_text">
                    </div>
                    <div class="col">
                      <label class="form-label">Button 1 Link</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $b1_btn1_link ?>" name="b1_btn1_link">
                    </div>
                  </div>
                  <div id="button2Inputs1" class="row mb-3" style="display: none;">
                    <div class="col">
                      <label class="form-label">Button 2 Text</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $b1_btn2_text ?>" name="b1_btn2_text">
                    </div>
                    <div class="col">
                      <label class="form-label">Button 2 Link</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $b1_btn2_link ?>" name="b1_btn2_link">
                    </div>
                  </div>
                  <label class="h5 mt-5">Second Banner</label><br>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Title</label>
                      <textarea style="border: 1px solid #ced4da; height: 40px; resize: none;" type="text" class="form-control p-2" name="b2_title" required><?= $b2_title ?></textarea>
                    </div>
                    <div class="col">
                      <label class="form-label">Image</label>
                      <input style="border: 1px solid #ced4da;" type="file" class="form-control p-2" name="b2_image">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Text</label>
                      <textarea style="border: 1px solid #ced4da; height: 100px; resize: none;" type="text" class="form-control p-2" name="b2_text" required><?= $b2_text ?></textarea>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Color</label>
                      <input style="border: 1px solid #ced4da; height: 40px" value="<?= $b2_color ?>" type="color" class="form-control p-2" name="b2_color" required>
                    </div>
                    <div class="col">
                      <label for="access" class="form-label">Number of buttons</label>
                      <select id="buttonCount2" class="form-select p-2" name="b2_btn_count" aria-label="Default select example">
                        <option <?= $b2_btn_count == 1 ? 'selected' : '' ?> value="1">One Button</option>
                        <option <?= $b2_btn_count == 2 ? 'selected' : '' ?> value="2">Two Buttons</option>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Button 1 Text</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $b2_btn1_text ?>" name="b2_btn1_text">
                    </div>
                    <div class="col">
                      <label class="form-label">Button 1 Link</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $b2_btn1_link ?>" name="b2_btn1_link">
                    </div>
                  </div>
                  <div id="button2Inputs2" class="row mb-3" style="display: none;">
                    <div class="col">
                      <label class="form-label">Button 2 Text</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $b2_btn2_text ?>" name="b2_btn2_text">
                    </div>
                    <div class="col">
                      <label class="form-label">Button 2 Link</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $b2_btn2_link ?>" name="b2_btn2_link">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col text-center">
                      <input type="submit" class="btn btn-primary btn-sm" value="Submit" name="banner">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- end Banner Settings -->
        <!-- site settings -->
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3"> Site Settings</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <form action="#" method="POST" class="p-4" enctype="multipart/form-data">
                  <label class="h5">Site Information</label>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Site Title</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $site_title ?>" name="title" required>
                    </div>
                    <div class="col">
                      <label class="form-label">Site Logo</label>
                      <input style="border: 1px solid #ced4da;" type="file" class="form-control p-2" name="logo">
                    </div>
                  </div>
                  <!-- map row -->
                  <label class="h5 mt-2">Map Location</label>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Latitude</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $map_lat ?>" name="map-lat" required>
                    </div>
                    <div class="col">
                      <label for="access" class="form-label">Longitude</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $map_long ?>" name="map-long" required>
                    </div>
                  </div>
                  <!-- end map row -->
                  <!-- footer row -->
                  <label class="h5 mt-2">Footer</label><br>
                    <!-- Social Links -->
                  <label class="h6 mt-1">Social Links</label>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Facebook</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $facebook ?>" name="facebook">
                    </div>
                    <div class="col">
                      <label class="form-label">Twitter</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $twitter ?>" name="twitter">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Instagram</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $instagram ?>" name="instagram">
                    </div>
                    <div class="col">
                      <label class="form-label">Youtube</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $youtube ?>" name="youtube">
                    </div>
                  </div>
                    <!-- end Social Links -->
                    <!-- Description -->
                  <label class="h6 mt-1">Descriptions</label>
                  <div class="row mb-3">
                    <div class="col">
                      <label class="form-label">Footer First Title</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $t1_title ?>" name="t1_title" required>
                    </div>
                    <div class="col">
                      <label class="form-label">Footer First Description</label>
                      <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $t1_desc ?>" name="t1_desc" required>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Footer Second Title</label>
                        <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $t2_title ?>" name="t2_title" required>
                      </div>
                      <div class="col">
                        <label class="form-label">Footer Second Description</label>
                        <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $t2_desc ?>" name="t2_desc" required>
                      </div>
                    </div>
                      <!-- end Description -->
                      <!-- Contact Us -->
                    <label class="h6 mt-1">Contact Us</label>
                    <div class="row mb-3">
                      <div class="col">
                        <label class="form-label">Phone</label>
                        <input style="border: 1px solid #ced4da;" type="number" class="form-control p-2" value="<?= $phone ?>" name="phone" required>
                      </div>
                      <div class="col">
                        <label class="form-label">Email</label>
                        <input style="border: 1px solid #ced4da;" type="email" class="form-control p-2" value="<?= $email ?>" name="email" required>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col">
                        <label class="form-label">Location Name</label>
                        <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $loc_name ?>" name="loc_name" required>
                      </div>
                      <div class="col">
                        <label class="form-label">Location Link</label>
                        <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" value="<?= $loc_link ?>" name="loc_link" required>
                      </div>
                    </div>
                  </div>
                    <!--end Contact Us -->
                  <!-- end footer row -->
                  <div class="row mb-3">
                    <div class="col text-center">
                      <input type="submit" class="btn btn-primary btn-sm" value="Submit" name="setting">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- end site settings -->
        </div>
    </div>
    
  </div>
  </main>
  <?php include __DIR__."/components/theme.php"; ?>


</body>

</html>