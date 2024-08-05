<?php

require 'config.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header('location: /');
}

$testImg = 'images/products/p5.png';
if (!file_exists($testImg)) {
    echo "File not found: $testImg";
} else {
    echo "File found: $testImg";
}

// فعال کردن گزارش خطا برای توابع mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function importData($conn) {
    $products = json_decode(file_get_contents('https://fakestoreapi.com/products'), true);
    foreach ($products as $product) {
        $title = $conn->real_escape_string($product['title']);
        $description = $conn->real_escape_string($product['description']);
        $price = $product['price'];
        $category = $product['category'];
        
        switch ($category) {
            case 'electronics':
                $category = 1;
                break;
            case 'jewelery':
                $category = 2;
                break;
            case 'men\'s clothing':
                $category = 3;
                break;
            case 'women\'s clothing':
                $category = 4;
                break;
            default:
                $category = 0; // Default category if none match
                break;
        }

        // Check if product already exists
        $stmt = $conn->prepare("SELECT * FROM product WHERE title = ?");
        if (!$stmt) {
            die("Prepare failed (SELECT): (" . $conn->errno . ") " . $conn->error);
        }

        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo "Product " . $title . " already exists<br>";
            continue; // Skip to next product
        } 

        // Insert new product
        $stmt = $conn->prepare("INSERT INTO product (title, description, price, gid) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed (INSERT): (" . $conn->errno . ") " . $conn->error);
        }

        $stmt->bind_param("ssdi", $title, $description, $price, $category);
        $stmt->execute();
        
        if ($stmt->error) {
            echo "Error inserting product " . $title . ": " . $stmt->error . "<br>";
            continue;
        }

        $lastID = $conn->insert_id;
        $image_url = $product['image'];
        $image = file_get_contents($image_url);
        file_put_contents('images/products/p' . $lastID . '.jpg', $image);

        $sql = "UPDATE product SET image_url = '/images/products/p" . $lastID . ".jpg' WHERE pid = $lastID";
        if (!$conn->query($sql)) {
            echo "Error updating image URL for product " . $title . ": " . $conn->error . "<br>";
        } else {
            echo "Product " . $title . " imported successfully<br>";
        }
    }
}

if (isset($_POST['import'])) {
    $error = importData($conn);
    if ($error) {
        echo $error;
    } else {
        echo "<script>alert('Data imported successfully!')</script>";
        echo "<hr>";
        echo "<h3>Products imported successfully!</h3>";
        echo "<a href='/admin/products'>View Products</a>";
    }
}
$products = json_decode(file_get_contents('https://fakestoreapi.com/products'), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Data</title>
</head>
<body>
    <h1>API Fake Data</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><img style="width: 100px;" src="<?= $product['image'] ?>" alt=""></td>
                    <td><?= htmlspecialchars($product['title']) ?></td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td><?= $product['price'] ?></td>
                    <td><?= htmlspecialchars($product['category']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <form action="" method="post">
        <input style="margin-top: 20px; margin-bottom: 20px; width: 100%; height: 40px; cursor: pointer; border-radius: 5px; border: none; background-color: #0d6efd;" class="btn btn-primary" type="submit" value="Import" name="import">
    </form>
</body>
</html>
