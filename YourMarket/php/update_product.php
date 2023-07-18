<?php
$mysqli = require __DIR__ . "/connecdb.php";
session_start();
$sellerId = $_SESSION["user_id"];

if (!isset($sellerId)) {
    header('location:login.php');
}

if (isset($_POST['update'])) {

    $aid = $_POST['ID_Article'];
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $brand = $_POST['brand'];
    $brand = filter_var($brand, FILTER_SANITIZE_STRING);
    $selling_type = $_POST['selling_type'];
    $selling_type = filter_var($selling_type, FILTER_SANITIZE_STRING);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $update_product = $mysqli->prepare("UPDATE `article` SET name = ?, price = ?, details = ?, category = ?, brand = ?, selling_type = ?, start_date = ?, end_date = ? WHERE ID_Article = ?");
    $update_product->bind_param("ssssssssi", $name, $price, $details, $category, $brand, $selling_type, $start_date, $end_date, $aid);
    $update_product->execute();

    $message[] = 'Product updated successfully!';

    $old_image_1 = $_POST['old_image_1'];
    $image_1 = $_FILES['image_1']['name'];
    $image_1 = filter_var($image_1, FILTER_SANITIZE_STRING);
    $image_size_1 = $_FILES['image_1']['size'];
    $image_tmp_name_1 = $_FILES['image_1']['tmp_name'];
    $image_folder_1 = '../uploaded_img/' . $image_1;

    if (!empty($image_1)) {
        if ($image_size_1 > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $update_image_1 = $mysqli->prepare("UPDATE `article` SET image_1 = ? WHERE ID_Article = ?");
            $update_image_1->bind_param("si", $image_1, $aid);
            $update_image_1->execute();
            move_uploaded_file($image_tmp_name_1, $image_folder_1);
            unlink('../uploaded_img/' . $old_image_1);
            $message[] = 'Image 1 updated successfully!';
        }
    }

    $old_image_2 = $_POST['old_image_2'];
    $image_2 = $_FILES['image_2']['name'];
    $image_2 = filter_var($image_2, FILTER_SANITIZE_STRING);
    $image_size_2 = $_FILES['image_2']['size'];
    $image_tmp_name_2 = $_FILES['image_2']['tmp_name'];
    $image_folder_2 = '../uploaded_img/' . $image_2;

    if (!empty($image_2)) {
        if ($image_size_2 > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $update_image_2 = $mysqli->prepare("UPDATE `article` SET image_2 = ? WHERE ID_Article = ?");
            $update_image_2->bind_param("si", $image_2, $aid);
            $update_image_2->execute();
            move_uploaded_file($image_tmp_name_2, $image_folder_2);
            unlink('../uploaded_img/' . $old_image_2);
            $message[] = 'Image 2 updated successfully!';
        }
    }

    $old_image_3 = $_POST['old_image_3'];
    $image_3 = $_FILES['image_3']['name'];
    $image_3 = filter_var($image_3, FILTER_SANITIZE_STRING);
    $image_size_3 = $_FILES['image_3']['size'];
    $image_tmp_name_3 = $_FILES['image_3']['tmp_name'];
    $image_folder_3 = '../uploaded_img/' . $image_3;

    if (!empty($image_3)) {
        if ($image_size_3 > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $update_image_3 = $mysqli->prepare("UPDATE `article` SET image_3 = ? WHERE ID_Article = ?");
            $update_image_3->bind_param("si", $image_3, $aid);
            $update_image_3->execute();
            move_uploaded_file($image_tmp_name_3, $image_folder_3);
            unlink('../uploaded_img/' . $old_image_3);
            $message[] = 'Image 3 updated successfully!';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Product</title>
    <link href="../css/update_product.css" rel="stylesheet" type="text/css">
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
            <label class="title-1"> Update Product</label>
        </div>
        <div class="bar-random">
            <!--cette bare ne sert completment a rien mais ca fait class et c marant a faire-->
        </div>
        <section class="update-product">

            <?php
            $update_id = $_GET['update'];
            $select_products = $mysqli->prepare("SELECT * FROM `article` WHERE ID_Article = ?");
            $select_products->bind_param("i", $update_id);
            $select_products->execute();
            $result = $select_products->get_result();

            if ($result->num_rows > 0) {
                while ($fetch_products = $result->fetch_assoc()) {
                    ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="ID_Article" value="<?= $fetch_products['ID_Article']; ?>">
                        <input type="hidden" name="old_image_1" value="<?= $fetch_products['image_1']; ?>">
                        <input type="hidden" name="old_image_2" value="<?= $fetch_products['image_2']; ?>">
                        <input type="hidden" name="old_image_3" value="<?= $fetch_products['image_3']; ?>">
                        <div class="image-container">
                            <div class="main-image">
                                <img src="../uploaded_img/<?= $fetch_products['image_1']; ?>" alt="">
                            </div>
                            <div class="sub-image">
                                <img src="../uploaded_img/<?= $fetch_products['image_1']; ?>" alt="">
                                <img src="../uploaded_img/<?= $fetch_products['image_2']; ?>" alt="">
                                <img src="../uploaded_img/<?= $fetch_products['image_3']; ?>" alt="">
                            </div>
                        </div>
                        <span>Update Name</span>
                        <input type="text" name="name" required class="box" maxlength="100"
                               placeholder="Enter product name" value="<?= $fetch_products['name']; ?>">
                        <span>Update Price (Starting Bid if Auction)</span>
                        <input type="number" name="price" required class="box" min="0" max="9999999999"
                               placeholder="Enter product price"
                               onkeypress="if(this.value.length == 10) return false;"
                               value="<?= $fetch_products['price']; ?>">
                        <span>Update Details</span>
                        <textarea name="details" class="box" required cols="30"
                                  rows="10"><?= $fetch_products['details']; ?></textarea>
                        <span>Update Category</span>
                        <?php
                        $selected_category = $fetch_products['category'];
                        ?>
                        <select class="box" name="category">
                            <option value="Phone" <?php if ($selected_category === 'Phone') echo 'selected'; ?>>Phone
                            </option>
                            <option value="Computer" <?php if ($selected_category === 'Computer') echo 'selected'; ?>>
                                Computer
                            </option>
                            <option value="Watch" <?php if ($selected_category === 'Watch') echo 'selected'; ?>>Watch
                            </option>
                            <option value="Video Games" <?php if ($selected_category === 'Video Games') echo 'selected'; ?>>
                                Video Games
                            </option>
                        </select>
                        <span>Update Brand</span>
                        <?php
                        $selected_brand = $fetch_products['brand'];
                        ?>
                        <select class="box" name="brand">
                            <option value="Apple" <?php if ($selected_brand === 'Apple') echo 'selected'; ?>>Apple
                            </option>
                            <option value="Samsung" <?php if ($selected_brand === 'Samsung') echo 'selected'; ?>>Samsung
                            </option>
                            <option value="Xiaomi" <?php if ($selected_brand === 'Xiaomi') echo 'selected'; ?>>Xiaomi
                            </option>
                            <option value="Sony" <?php if ($selected_brand === 'Sony') echo 'selected'; ?>>Sony
                            </option>
                            <option value="HP" <?php if ($selected_brand === 'HP') echo 'selected'; ?>>HP</option>
                            <option value="Asus" <?php if ($selected_brand === 'Asus') echo 'selected'; ?>>Asus
                            </option>
                            <option value="Nintendo" <?php if ($selected_brand === 'Nintendo') echo 'selected'; ?>>
                                Nintendo
                            </option>
                            <option value="Microsoft" <?php if ($selected_brand === 'Microsoft') echo 'selected'; ?>>
                                Microsoft
                            </option>
                        </select>
                        <span>Update Selling Type</span>
                        <?php
                        $selected_selling_type = $fetch_products['selling_type'];
                        ?>
                        <select class="box" name="selling_type">
                            <option value="Buy Now" <?php if ($selected_selling_type === 'Buy Now') echo 'selected'; ?>>
                                Buy Now
                            </option>
                            <option value="Best Offer" <?php if ($selected_selling_type === 'Best Offer') echo 'selected'; ?>>
                                Best Offer
                            </option>
                            <option value="Auction" <?php if ($selected_selling_type === 'Auction') echo 'selected'; ?>>
                                Auction
                            </option>
                        </select>
                        <?php if ($selected_selling_type === 'Auction'): ?>
                            <span>Update Starting Date (If Auction)</span>
                            <input type="date" name="start_date" class="box" maxlength="100"
                                   value="<?= $fetch_products['start_date']; ?>">
                            <span>Update Ending Date (If Auction)</span>
                            <input type="date" name="end_date" class="box" maxlength="100"
                                   value="<?= $fetch_products['end_date']; ?>">
                        <?php endif; ?>
                        <span>Update Image 1</span>
                        <input type="file" name="image_1" accept="image/jpg, image/jpeg, image/png, image/webp"
                               class="box">
                        <span>Update Image 2</span>
                        <input type="file" name="image_2" accept="image/jpg, image/jpeg, image/png, image/webp"
                               class="box">
                        <span>Update Image 3</span>
                        <input type="file" name="image_3" accept="image/jpg, image/jpeg, image/png, image/webp"
                               class="box">
                        <div class="flex-btn">
                            <input type="submit" name="update" class="updatebtn" value="Update">
                            <a href="add-product.php" class="option-btn">Go Back</a>
                        </div>
                    </form>

                    <?php
                }
            } else {
                echo '<p class="empty">No Product Found!</p>';
            }
            ?>

        </section>
    </div>
</div>

</body>
</html>
