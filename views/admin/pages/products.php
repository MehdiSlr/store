
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

// Default filter values
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$order_filter = isset($_GET['order']) ? $_GET['order'] : 'DESC';

// Get all products with filters
$sql = "SELECT * FROM product INNER JOIN category ON product.gid = category.gid WHERE 1=1";
if ($category_filter != '') {
    $sql .= " AND product.gid = $category_filter";
}
if ($status_filter != '') {
    $sql .= " AND product.status = $status_filter";
}
$sql .= " ORDER BY product.pid $order_filter";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Edit product
if (isset($_POST['edit-product'])) {
    $pid = $_POST['pid'];
    $gid = $_POST['gid'];
    $status = $_POST['status'];
    $title = $_POST['title'];
    $description = ($_POST['description']);
    $price = $_POST['price'];
    $image_url = $_POST['old_image_url'];

    if (isset($_FILES['image_url'])) {
        if ($_FILES['image_url']['error'] == 0) {
            $file_name = $_FILES['image_url']['name'];
            $file_size = $_FILES['image_url']['size'];
            $file_tmp = $_FILES['image_url']['tmp_name'];
            
            // change file name to pid
            $file_name_new = "p" . $pid . "." . pathinfo($file_name, PATHINFO_EXTENSION);

            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/images/products';
            $file_destination = "$upload_dir/$file_name_new";

            move_uploaded_file($file_tmp, $file_destination);
            $image_url = "/images/products/$file_name_new";
        }
    }

    $stmt = $conn->prepare("UPDATE product SET gid = ?, status = ?, title = ?, description = ?, price = ?, image_url = ? WHERE pid = ?");
    $stmt->bind_param("isssisi", $gid, $status, $title, $description, $price, $image_url, $pid);
    $stmt->execute();

    // get conn error

    if ($stmt->error) {
        echo "Error: {$stmt->error}";
    }

    if ($result) {
        header('location: admin/products');
    }
}

// Add new product
if (isset($_POST['add-product'])) {
    $gid = $_POST['gid'];
    $status = $_POST['status'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql = "INSERT INTO product (gid, status, title, description, price) VALUES ($gid, $status, '$title', '$description', $price)";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (isset($_FILES['image_url'])) {
            if ($_FILES['image_url']['error'] == 0) {
                $file_name = $_FILES['image_url']['name'];
                $file_size = $_FILES['image_url']['size'];
                $file_tmp = $_FILES['image_url']['tmp_name'];
                $file_type = $_FILES['image_url']['type'];
                $file_ext = explode('.', $file_name);
                $file_actual_ext = strtolower(end($file_ext));
                
                if ($file_size > 2097152) {
                    echo "<script>alert('File size must be less than 2 MB');</script>";
                } else {
                    if ($file_type == 'image/jpeg' || $file_type == 'image/png' || $file_type == 'image/gif') {
                        $lastID = mysqli_insert_id($conn);
                        move_uploaded_file($file_tmp, $_SERVER['DOCUMENT_ROOT'] . "/images/products/$lastID.$file_actual_ext");
                        $image_url = "images/products/$lastID.$file_actual_ext";
                        $sql = "UPDATE product SET image_url = '$image_url' WHERE pid = $lastID";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            header('location: admin/products');
                        }
                    } else {
                        echo "<script>alert('File type must be JPEG, PNG, or GIF');</script>";
                    }
                }
            }
        }
    }
}
?>

<body class="g-sidenav-show  bg-gray-200">
  <?php 
  $active_page = "products";
  include __DIR__."/components/sidebar.php"; 
  ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Products</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Products</h6>
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
        
        <!-- Product List -->
        <div class="col-12">
          <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between">
                <h6 class="text-white text-capitalize ps-3"> Product List</h6>
                <button class="btn btn-secondary me-3" onclick="openAddForm()">Add Product</button>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <form action="" method="GET" class="p-3">
                <div class="row">
                  <div class="col-md-3">
                    <label for="categoryFilter">Category</label>
                    <select class="form-select p-2" id="categoryFilter" name="category">
                      <option value="">All</option>
                      <option value="1" <?= $category_filter == '1' ? 'selected' : ''; ?>>Electronics</option>
                      <option value="2" <?= $category_filter == '2' ? 'selected' : ''; ?>>Jewelery</option>
                      <option value="3" <?= $category_filter == '3' ? 'selected' : ''; ?>>Men's Clothing</option>
                      <option value="4" <?= $category_filter == '4' ? 'selected' : ''; ?>>Women's Clothing</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label for="statusFilter">Status</label>
                    <select class="form-select p-2" id="statusFilter" name="status">
                      <option value="">All</option>
                      <option value="1" <?= $status_filter == '1' ? 'selected' : ''; ?>>Active</option>
                      <option value="2" <?= $status_filter == '2' ? 'selected' : ''; ?>>Inactive</option>
                      <option value="0" <?= $status_filter == '0' ? 'selected' : ''; ?>>Delete</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label for="orderFilter">Order</label>
                    <select class="form-select p-2" id="orderFilter" name="order">
                      <option value="DESC" <?= $order_filter == 'DESC' ? 'selected' : ''; ?>>Descending</option>
                      <option value="ASC" <?= $order_filter == 'ASC' ? 'selected' : ''; ?>>Ascending</option>
                    </select>
                  </div>
                  <div class="col-md-3 align-items-end">
                    <label for="filter"></label>
                    <button type="submit" class="btn btn-primary w-100 mt-2">Filter</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Title</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($rows as $product): ?>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <a href="<?= $product['image_url']; ?>" target="_blank" ><img src="<?= $product['image_url']; ?>" class="avatar avatar-sm me-3 border-radius-lg" alt="user1"></a>
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 style="white-space: pre-wrap;" class="mb-0 text-sm"><?= $product['title']; ?></h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p style="white-space: pre-wrap;" class="text-xs font-weight-bold mb-0"><?= nl2br($product['description']); ?></p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <p class="text-xs font-weight-bold mb-0">
                          $<?= $product['price']; ?>
                        </p>
                      </td>
                      <td class="align-middle">
                        <?= $product['name']; ?>
                      </td>
                      <td class="align-middle text-center">
                        <?= $product['status'] == 1 ? 'Active' : 'Inactive'; ?>
                      </td>
                      <td class="align-middle">
                        <button class="btn btn-primary btn-sm mb-0" onclick="openEditForm(<?= $product['pid']; ?>)">Edit</button>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- End Products List -->
        <!-- Edit Form Modal -->
        <div class="modal fade" id="editFormModal" tabindex="-1" role="dialog" aria-labelledby="editFormModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editFormModalLabel">Edit Product</h5>
                <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                  <i class="fas fa-times"></i>
                </button>
                
              </div>
              <div class="modal-body">
                <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="editTitle">Title</label>
                    <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" id="editTitle" name="title">
                  </div>
                  <div class="row mb-3">
                  <div class="col">
                  <div class="form-group">
                    <label class="mt-3" for="editImage">Image</label>
                    <input style="border: 1px solid #ced4da;" type="file" class="form-control p-2" id="editImage" name="image_url" accept="image/*">
                  </div>
                  </div>
                  <div class="col">
                  <div class="form-group">
                    <label class="mt-3" for="showImage">Current Image</label>
                    <a id="showImageLink" href="<?= $product['image_url']; ?>" target="_blank">
                    <img style="height: 100px; width: 100px; margin-top: 10px" id="showImage" src="" width="100">
                    <input type="hidden" id="oldImageUrl" name="old_image_url">
                    </a>
                  </div>
                  </div>
                  </div>
                  <div class="form-group">
                    <label class="mt-3" for="editDescription">Description</label>
                    <textarea style="border: 1px solid #ced4da; resize: none; height: 100px" class="form-control p-2" id="editDescription" name="description"></textarea>
                  </div>
                  <div class="row mb-3">
                  <div class="col">
                  <div class="form-group">
                    <label class="mt-3" for="editPrice">Price ($)</label>
                    <input style="border: 1px solid #ced4da;" type="number" step="0.01" class="form-control p-2" id="editPrice" name="price">
                  </div>
                  </div>
                  <div class="col">
                  <div class="form-group">
                    <label class="mt-3" for="editCategory">Category</label>
                    <select class="form-select p-2" id="editCategory" name="gid">
                      <option value="1">Electronics</option>
                      <option value="2">Jewelery</option>
                      <option value="3">Men's Clothing</option>
                      <option value="4">Women's Clothing</option>
                    </select>
                  </div>
                  </div>
                  </div>
                  <div class="form-group">
                    <label for="editStatus">Status</label>
                    <select class="form-select p-2" id="editStatus" name="status">
                      <option value="1">Active</option>
                      <option value="2">Inactive</option>
                      <option value="0">Delete</option>
                    </select>
                  </div>
                  <input type="hidden" id="editProductId" name="pid">
                <!-- <button type="button" class="btn btn-secondary btn-sm mt-3" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="btn btn-primary btn-sm mt-3" name="edit-product">Save changes</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- End Edit Form Modal -->
         <!-- Add Modal -->
        <div class="modal fade" id="addFormModal" tabindex="-1" aria-labelledby="addFormModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="addFormModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                    <label for="addTitle" class="form-label">Title</label>
                    <input style="border: 1px solid #ced4da;" type="text" class="form-control p-2" id="addTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                    <label for="addImageUrl" class="form-label">Image</label>
                    <input style="border: 1px solid #ced4da; " type="file" class="form-control p-2" id="addImageUrl" name="image_url" required>
                    </div>
                    <div class="mb-3">
                    <label for="addDescription" class="form-label">Description</label>
                    <textarea style="border: 1px solid #ced4da; resize: none;" class="form-control p-2" id="addDescription" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                    <label for="addPrice" class="form-label">Price</label>
                    <input style="border: 1px solid #ced4da;" type="number" class="form-control p-2" id="addPrice" name="price" required>
                    </div>
                    <div class="mb-3">
                    <label for="addCategory" class="form-label">Category</label>
                    <select class="form-select p-2" id="addCategory" name="gid" required>
                        <option value="1">Electronics</option>
                        <option value="2">Jewelery</option>
                        <option value="3">Men's Clothing</option>
                        <option value="4">Women's Clothing</option>
                    </select>
                    </div>
                    <div class="mb-3">
                    <label for="addStatus" class="form-label">Status</label>
                    <select class="form-select p-2" id="addStatus" name="status" required>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                        <option value="0">Delete</option>
                    </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="add-product">Add Product</button>
                </div>
                </form>
            </div>
            </div>
        </div>
        <!-- End Add Form Modal -->
        <div class="col-12">
          <?php include __DIR__."/components/theme.php"; ?>
        </div>
    </div>
  </div>
  </main>
</body>

</html>