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
    $stock = $_POST['stock'];
    $stock = filter_var($stock, FILTER_SANITIZE_STRING);

    $update_product = $mysqli->prepare("UPDATE `article` SET name = ?, price = ?, details = ?, category = ?, stock = ? WHERE ID_Article = ?");
    $update_product->bind_param("sssssi", $name, $price, $details, $category, $stock, $aid);
    $update_product->execute();

    $message[] = 'product updated successfully!';

    $old_image_1 = $_POST['old_image_1'];
    $image_1 = $_FILES['image_1']['name'];
    $image_1 = filter_var($image_1, FILTER_SANITIZE_STRING);
    $image_size_1 = $_FILES['image_1']['size'];
    $image_tmp_name_1 = $_FILES['image_1']['tmp_name'];
    $image_folder_1 = '../uploaded_img/' . $image_1;

    if (!empty($image_1)) {
        if ($image_size_1 > 2000000) {
            $message[] = 'image size is too large!';
        } else {
            $update_image_1 = $mysqli->prepare("UPDATE `article` SET image_1 = ? WHERE ID_Article = ?");
            $update_image_1->bind_param("si", $image_1, $aid);
            $update_image_1->execute();
            move_uploaded_file($image_tmp_name_1, $image_folder_1);
            unlink('../uploaded_img/' . $old_image_1);
            $message[] = 'image 1 updated successfully!';
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
            $message[] = 'image size is too large!';
        } else {
            $update_image_02 = $mysqli->prepare("UPDATE `article` SET image_2 = ? WHERE ID_Article = ?");
            $update_image_02->bind_param("si", $image_2, $aid);
            $update_image_02->execute();
            move_uploaded_file($image_tmp_name_2, $image_folder_2);
            unlink('../uploaded_img/' . $old_image_2);
            $message[] = 'image 2 updated successfully!';
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
            $message[] = 'image size is too large!';
        } else {
            $update_image_3 = $mysqli->prepare("UPDATE `article` SET image_3 = ? WHERE ID_Article = ?");
            $update_image_3->bind_param("si", $image_3, $aid);
            $update_image_3->execute();
            move_uploaded_file($image_tmp_name_3, $image_folder_3);
            unlink('../uploaded_img/' . $old_image_3);
            $message[] = 'image 3 updated successfully!';
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update product</title>
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
                               placeholder="enter product name" value="<?= $fetch_products['name']; ?>">
                        <span>Update Price</span>
                        <input type="number" name="price" required class="box" min="0" max="9999999999"
                               placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;"
                               value="<?= $fetch_products['price']; ?>">
                        <span>Update Details</span>
                        <textarea name="details" class="box" required cols="30"
                                  rows="10"><?= $fetch_products['details']; ?></textarea>
                        <span>Update Category</span>
                        <?php
                        $selected = $fetch_products['category'];
                        ?>
                        <select class="box" name="category">
                            <option <?php if($selected == 'Phone'){echo("selected");}?>>Phone</option>
                            <option <?php if($selected == 'Computer'){echo("selected");}?>>Computer</option>
                            <option <?php if($selected == 'Watch'){echo("selected");}?>>Watch</option>
                            <option <?php if($selected == 'Video Games'){echo("selected");}?>>Video Games</option>
                        </select>
                        <span>Update Stock</span>
                        <input type="number" name="stock" required class="box" min="0" max="9999999999"
                               placeholder="enter product stock" value="<?= $fetch_products['stock']; ?>">
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
                            <input type="submit" name="update" class="updatebtn" value="update">
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

<script>
    let mainImage = document.querySelector('.update-product .image-container .main-image img');
    let subImages = document.querySelectorAll('.update-product .image-container .sub-image img');

    subImages.forEach(image => {
        image.onclick = () => {
            src = image.getAttribute('src');
            mainImage.src = src;
        };
    });
</script>

</body>
</html>
