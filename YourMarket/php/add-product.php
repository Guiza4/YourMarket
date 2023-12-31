<?php
$mysqli = require __DIR__ . "/connecdb.php";
session_start();
$sellerId = $_SESSION["user_id"];
if (!isset($sellerId)) {
    header('location:login.php');
    exit();
}

$selling_type = 'Buy Now'; // Initialize the variable with a default value

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
    $selling_type = $_POST['selling_type'];
    $selling_type = filter_var($selling_type, FILTER_SANITIZE_STRING);
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

    $start_date = '';
    $end_date = '';
    $minimum_bid = '';

    if ($selling_type === 'Auction') {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $minimum_bid = $price; // Set the minimum bid to the product price
    }

    $select_products = $mysqli->prepare("SELECT * FROM `article` WHERE name = ? AND ID_Seller = ?");
    $select_products->bind_param("si", $name, $sellerId);
    $select_products->execute();
    $result = $select_products->get_result();
    $rowCount = $result->num_rows;

    if ($rowCount > 0) {
        $message[] = 'Product name already exists!';
    } else {
        if ($selling_type === 'Auction') {
            $insert_products = $mysqli->prepare("INSERT INTO `article` (ID_Seller, name, details, price, category, brand, selling_type, image_1, image_2, image_3, start_date, end_date, minimum_bid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_products->bind_param("issssssssssss", $sellerId, $name, $details, $price, $category, $brand, $selling_type, $image_1, $image_2, $image_3, $start_date, $end_date, $minimum_bid);
        } else {
            $insert_products = $mysqli->prepare("INSERT INTO `article` (ID_Seller, name, details, price, category, brand, selling_type, image_1, image_2, image_3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_products->bind_param("isssssssss", $sellerId, $name, $details, $price, $category, $brand, $selling_type, $image_1, $image_2, $image_3);
        }

        $insert_products->execute();

        if ($insert_products) {
            if ($image_size_1 > 2000000 || $image_size_2 > 2000000 || $image_size_3 > 2000000) {
                $message[] = 'Image size is too large!';
            } else {
                move_uploaded_file($image_tmp_name_1, $image_folder_1);
                move_uploaded_file($image_tmp_name_2, $image_folder_2);
                move_uploaded_file($image_tmp_name_3, $image_folder_3);

                if ($selling_type === 'Auction') {
                    // Insert the auction-specific fields into the database
                    $insert_auction_fields = $mysqli->prepare("UPDATE `article` SET start_date = ?, end_date = ?, minimum_bid = ? WHERE ID_Article = ?");
                    $insert_auction_fields->bind_param("ssdi", $start_date, $end_date, $minimum_bid, $insert_products->insert_id);
                    $insert_auction_fields->execute();
                }

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
    <script>
        function updateFieldsVisibility(selectElement) {
            var priceContainer = document.getElementById('priceContainer');
            var startEndDateContainer = document.getElementById('startEndDateContainer');
            var endEndDateContainer = document.getElementById('endEndDateContainer');
            var priceInput = document.getElementById('price');

            if (selectElement.value === 'Best Offer') {
                priceContainer.style.display = 'none';
                startEndDateContainer.style.display = 'none';
                endEndDateContainer.style.display = 'none';
                priceInput.removeAttribute('required'); // Remove the 'required' attribute
            } else if (selectElement.value === 'Auction') {
                priceContainer.style.display = 'block';
                startEndDateContainer.style.display = 'block';
                endEndDateContainer.style.display = 'block';
                priceInput.setAttribute('required', 'required'); // Add the 'required' attribute
            } else {
                priceContainer.style.display = 'block';
                startEndDateContainer.style.display = 'none';
                endEndDateContainer.style.display = 'none';
                priceInput.setAttribute('required', 'required'); // Add the 'required' attribute
            }
        }
        updateFieldsVisibility(document.querySelector('select[name="selling_type"]'));
    </script>

</head>
<body>
<!-- Navigation Bar -->
<?php include 'navbar.php'; ?>
<?php if (empty($searchQuery) && empty($_GET['category'])): ?>
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
                    <div class="inputBox" id="priceContainer">
                        <label for="price"><span>Price:</span></label>
                        <input type="number" name="price" id="price" class="box" min="0.01" step="0.01" placeholder="Enter Product Price" required>
                    </div>
                    <div class="inputBox" id="startEndDateContainer" style="display: none;">
                        <span>Start Date (if Auction)</span>
                        <input type="date" class="box" name="start_date">
                    </div>
                    <div class="inputBox" id="endEndDateContainer" style="display: none;">
                        <span>End Date (if Auction)</span>
                        <input type="date" class="box" name="end_date">
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
                        <select class="box" name="selling_type" onchange="updateFieldsVisibility(this)">
                            <option>Buy Now</option>
                            <option>Best Offer</option>
                            <option>Auction</option>
                        </select>
                    </div>
                    <div class="inputBox">
                        <span>image 1 (required)</span>
                        <input type="file" name="image_1" accept="image/jpg, image/jpeg, image/png, image/webp"
                               class="box"
                               required>
                    </div>
                    <div class="inputBox">
                        <span>image 2 (required)</span>
                        <input type="file" name="image_2" accept="image/jpg, image/jpeg, image/png, image/webp"
                               class="box"
                               required>
                    </div>
                    <div class="inputBox">
                        <span>image 3 (required)</span>
                        <input type="file" name="image_3" accept="image/jpg, image/jpeg, image/png, image/webp"
                               class="box"
                               required>
                    </div>
                    <div class="inputBox">
                        <span>Product Details (required)</span>
                        <textarea name="details" placeholder="enter product details" class="box" required
                                  maxlength="500"
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
                            <?php if ($fetch_products['selling_type'] !== 'Best Offer'): ?>
                                <div class="price">£<span><?= $fetch_products['price']; ?></span></div>
                            <?php endif; ?>
                            <div class="category"><span>Category:</span> <?= $fetch_products['category']; ?> </div>
                            <div class="brand"><span>Brand:</span> <?= $fetch_products['brand']; ?> </div>
                            <div class="selling_type"><span>Selling Type:</span> <?= $fetch_products['selling_type']; ?>
                            </div>
                            <?php if ($fetch_products['selling_type'] === 'Auction'): ?>
                                <div class="date">
                                    <span>Start:<?= $fetch_products['start_date']; ?> End:<?= $fetch_products['end_date']; ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="details"><span><?= $fetch_products['details']; ?></span></div>
                            <div class="flex-btn">
                                <a href="update_product.php?update=<?= $fetch_products['ID_Article']; ?>"
                                   class="option-btn">update</a>
                                <a href="add-product.php?delete=<?= $fetch_products['ID_Article']; ?>"
                                   class="delete-btn"
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
<?php elseif ((isset($_GET['search']) || isset($_GET['category'])) && empty($products)): ?>
    <!-- Display a message when no search results or category is found -->
    <div id="main-content">
        <h1 class="heading">No results found!</h1>
    </div>
<?php endif; ?>
</body>
</html>
