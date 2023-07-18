<?php
$mysqli = require __DIR__ . "/connecdb.php";
session_start();
$sellerId = $_SESSION["user_id"];
if (!isset($sellerId)) {
    header('location:login.php');
    exit();
}

$sellingtype = 'Buy Now'; // Initialize the variable with a default value

if (isset($_POST['add_product'])) {
    // Retrieve product details from the form inputs
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $brand = $_POST['brand'];
    $brand = filter_var($brand, FILTER_SANITIZE_STRING);
    $sellingtype = $_POST['sellingtype'];
    $sellingtype = filter_var($sellingtype, FILTER_SANITIZE_STRING);
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

    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $minimum_bid = $_POST['minimum_bid'];

    $select_products = $mysqli->prepare("SELECT * FROM `article` WHERE name = ? AND ID_Seller = ?");
    $select_products->bind_param("si", $name, $sellerId);
    $select_products->execute();
    $result = $select_products->get_result();
    $rowCount = $result->num_rows;

    if ($rowCount > 0) {
        $message[] = 'Product name already exists!';
    } else {
        if ($sellingtype === 'auction') {
            $insert_products = $mysqli->prepare("INSERT INTO `article` (ID_Seller, name, details, price, category, brand, sellingtype, image_1, image_2, image_3, start_date, end_date, minimum_bid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_products->bind_param("issssssssssss", $sellerId, $name, $details, $price, $category, $brand, $sellingtype, $image_1, $image_2, $image_3, $start_date, $end_date, $minimum_bid);
        } else {
            $insert_products = $mysqli->prepare("INSERT INTO `article` (ID_Seller, name, details, price, category, brand, sellingtype, image_1, image_2, image_3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_products->bind_param("isssssssss", $sellerId, $name, $details, $price, $category, $brand, $sellingtype, $image_1, $image_2, $image_3);
        }

        $insert_products->execute();

        if ($insert_products) {
            if ($image_size_1 > 2000000 || $image_size_2 > 2000000 || $image_size_3 > 2000000) {
                $message[] = 'Image size is too large!';
            } else {
                move_uploaded_file($image_tmp_name_1, $image_folder_1);
                move_uploaded_file($image_tmp_name_2, $image_folder_2);
                move_uploaded_file($image_tmp_name_3, $image_folder_3);
                $message[] = 'New product added!';
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_product_image = $mysqli->prepare("SELECT * FROM `article` WHERE ID_Article = ?");
    $delete_product_image->bind_param("i", $delete_id);
    $delete_product_image->execute();
    $result = $delete_product_image->get_result();
    $fetch_delete_image = $result->fetch_assoc();
    unlink('../uploaded_img/' . $fetch_delete_image['image_1']);
    unlink('../uploaded_img/' . $fetch_delete_image['image_2']);
    unlink('../uploaded_img/' . $fetch_delete_image['image_3']);
    $delete_product = $mysqli->prepare("DELETE FROM `article` WHERE ID_Article = ?");
    $delete_product->bind_param("i", $delete_id);
    $delete_product->execute();
    header('location:add-product.php');
}
?>

<!DOCTYPE html>
<html lang="en">
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
    <a href="profile.php">
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
                    <span>Brand (required)</span>
                    <select class="box" name="brand">
                        <option>Apple</option>
                        <option>Samsung</option>
                        <option>Xiaomi</option>
                        <option>Sony</option>
                        <option>HP</option>
                        <option>Asus</option>
                        <option>Nintendo</option>
                        <option>Microsoft</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Selling Type (required)</span>
                    <select class="box" name="sellingtype">
                        <option>Buy Now</option>
                        <option>Best Offer</option>
                        <option>Auction</option>
                    </select>
                </div>

                <div class="inputBox">
                    <span>Start Date (if Auction)</span>
                    <input type="date" class="box" name="start_date">
                    <span>End Date (if Auction)</span>
                    <input type="date" class="box" name="end_date">
                    <span>Minimum Bid (if Auction)</span>
                    <input type="number" min="0" class="box" name="minimum_bid">
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

    <section class="show-products">
        <h1 class="heading">Products Added</h1>
        <div class="box-container">
            <?php
            $select_products = $mysqli->prepare("SELECT * FROM `article` WHERE ID_Seller = ?");
            $select_products->bind_param("i", $sellerId);
            $select_products->execute();

            $result = $select_products->get_result();
            if ($result->num_rows > 0) {
                while ($fetch_products = $result->fetch_assoc()) {
                    ?>
                    <div class="box">
                        <img src="../uploaded_img/<?= $fetch_products['image_1']; ?>" alt="">
                        <div class="name"><?= $fetch_products['name']; ?></div>
                        <div class="price">£<span><?= $fetch_products['price']; ?></span></div>
                        <div class="category"><span>Category:</span> <?= $fetch_products['category']; ?> </div>
                        <div class="brand"><span>Brand:</span> <?= $fetch_products['brand']; ?> </div>
                        <div class="sellingtype"><span>Selling Type:</span> <?= $fetch_products['sellingtype']; ?>
                        </div>
                        <div class="details"><span><?= $fetch_products['details']; ?></span></div>
                        <div class="flex-btn">
                            <a href="update_product.php?update=<?= $fetch_products['ID_Article']; ?>"
                               class="option-btn">update</a>
                            <a href="add-product.php?delete=<?= $fetch_products['ID_Article']; ?>" class="delete-btn"
                               onclick="return confirm('delete this product?');">delete</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">No products added yet!</p>';
            }
            ?>
        </div>
    </section>
</div>


</body>
</html>
