<?php
$mysqli = require __DIR__ . "/connecdb.php";
session_start();

if (isset($_POST['add_product'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $stock = $_POST['stock'];
    $stock = filter_var($stock, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    $image_1 = $_FILES['image_1']['name'];
    $image_1 = filter_var($image_1, FILTER_SANITIZE_STRING);
    $image_size_1 = $_FILES['image_1']['size'];
    $image_tmp_name_1 = $_FILES['image_1']['tmp_name'];
    $image_folder_1 = '../uploaded_img/' . $image_1;

    $image_2 = $_FILES['image_2']['name'];
    $image_2 = filter_var($image_2, FILTER_SANITIZE_STRING);
    $image_size_2 = $_FILES['image_2']['size'];
    $image_tmp_name_2 = $_FILES['image_2']['tmp_name'];
    $image_folder_2 = '../uploaded_img/' . $image_2;

    $image_3 = $_FILES['image_3']['name'];
    $image_3 = filter_var($image_3, FILTER_SANITIZE_STRING);
    $image_size_3 = $_FILES['image_3']['size'];
    $image_tmp_name_3 = $_FILES['image_3']['tmp_name'];
    $image_folder_3 = '../uploaded_img/' . $image_3;

    $select_products = $mysqli->prepare("SELECT * FROM `article` WHERE name = ?");
    $select_products->bind_param("s", $name); // Bind the parameter
    $select_products->execute(); // Execute the statement
    $result = $select_products->get_result(); // Get the result set
    $rowCount = $result->num_rows; // Get the row count

    if ($rowCount > 0) {
        $message[] = 'product name already exists!';
    } else {
        $insert_products = $mysqli->prepare("INSERT INTO `article`(name, details, price, category, stock, image_1, image_2, image_3) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_products->bind_param("ssssssss", $name, $details, $price, $category, $stock, $image_1, $image_2, $image_3);
        $insert_products->execute();

        if ($insert_products) {
            if ($image_size_1 > 2000000 or $image_size_2 > 2000000 or $image_size_3 > 2000000) {
                $message[] = 'image size is too large!';
            } else {
                move_uploaded_file($image_tmp_name_1, $image_folder_1);
                move_uploaded_file($image_tmp_name_2, $image_folder_2);
                move_uploaded_file($image_tmp_name_3, $image_folder_3);
                $message[] = 'new product added!';
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_product_image = $mysqli->prepare("SELECT * FROM `article` WHERE id = ?");
    $delete_product_image->bind_param("i", $delete_id);
    $delete_product_image->execute();
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/' . $fetch_delete_image['image_1']);
    unlink('../uploaded_img/' . $fetch_delete_image['image_2']);
    unlink('../uploaded_img/' . $fetch_delete_image['image_3']);
    $delete_product = $mysqli->prepare("DELETE FROM `article` WHERE id = ?");
    $delete_product->bind_param("i", $delete_id);
    $delete_product->execute();
    $delete_cart = $mysqli->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->bind_param("i", $delete_id);
    $delete_cart->execute();
    header('location:add-product.php');
}

?>

<!DOCTYPE html>
<head>
    <title>Add product</title>
    <link href="../css/add-product.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- Barre de navigation -->
<div id="navbar">
    <div class="nav-logo">
        <a href="index.php"><img src="../image/logo-2.png" alt="Logo" height="64" width="180"></a>
    </div>
    <div class="nav-search">
        <input type="text" id="search-bar" placeholder="Search...">
    </div>
    <a href="#">
        <div class="nav-categorie">
            <img src="../image/categorie.png" width="25" height="49">
            <span>Category</span>
        </div>
    </a>
    <a href="#">
        <div class="nav-account">
            <img src="../image/account.png" width="30" height="32">
            <span>Account</span>
        </div>
    </a>
    <a href="add-product.php">
        <div class="nav-sellings">
            <img src="../image/sellings.png" width="38" height="34">
            <span>Sellings</span>
        </div>
    </a>
</div>
<!-- Contenu principal -->
<div CLASS="box-principal">
    <div class="box-add-product">
        <div class="category-title">
            <br>
            <label class="title-1"> Add Product</label>
        </div>
        <div class="bar-random">
            <!--cette bare ne sert completment a rien mais ca fait class et c marant a faire-->
        </div>
        <form method="post" enctype="multipart/form-data">
            <div class="flex">
                <div class="inputBox">
                    <span>Product name (required)</span>
                    <input type="text" class="box" required maxlength="100" placeholder="Enter Product Name"
                           name="name">
                </div>
                <div class="inputBox">
                    <span>Product Price (required)</span>
                    <input type="number" min="0" class="box" required max="9999999999" placeholder="Enter Product Price"
                           onkeypress="if(this.value.length == 10) return false;" name="price">
                </div>
                <div class="inputBox">
                    <span>Category (required)</span>
                    <select class="box" name="category">
                        <option>Phone</option>
                        <option>Computer</option>
                        <option>Watch</option>
                        <option>Video Games</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Stock (required)</span>
                    <input type="number" min="1" class="box" required max="9999999999" placeholder="Enter Quantity"
                           name="stock">
                </div>
                <div class="inputBox">
                    <span>image 1 (required)</span>
                    <input type="file" name="image_1" accept="image/jpg, image/jpeg, image/png, image/webp" class="box"
                           required>
                </div>
                <div class="inputBox">
                    <span>image 2 (required)</span>
                    <input type="file" name="image_2" accept="image/jpg, image/jpeg, image/png, image/webp" class="box"
                           required>
                </div>
                <div class="inputBox">
                    <span>image 3 (required)</span>
                    <input type="file" name="image_3" accept="image/jpg, image/jpeg, image/png, image/webp" class="box"
                           required>
                </div>
                <div class="inputBox">
                    <span>Product Details (required)</span>
                    <textarea name="details" placeholder="enter product details" class="box" required maxlength="500"
                              cols="30" rows="10"></textarea>
                </div>
            </div>

            <input type="submit" value="add product" class="btn" name="add_product">
        </form>
    </div>
</div>
</body>