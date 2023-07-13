<?php
$mysqli = require __DIR__ . "/connecdb.php";
session_start();
$sellerId = $_SESSION["user_id"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product</title>
    <link href="../css/product.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- Barre de navigation -->
<div id="navbar">
    <div class="nav-logo">
        <a CLASS="NAV" href="index.php"><img src="../image/logo-2.png" alt="Logo" height="64" width="180"></a>
    </div>
    <div class="nav-search">
        <input type="text" id="search-bar" placeholder="Search...">
    </div>
    <a class="NAV" href="#">
        <div class="nav-categorie">
            <div class="nav-dropdown">
                <img src="../image/categorie.png" width="25" height="49">Category
                <div class="dropdown-content">
                    <a href="#">Phone</a>
                    <a href="#">Computer</a>
                    <a href="#">Watch</a>
                    <a href="#">Video-game</a>
                </div>
            </div>
        </div>
    </a>
    <a class="NAV" href="profile.php">
        <div class="nav-account">
            <img src="../image/account.png" width="30" height="32">
            <span>Account</span>
        </div>
    </a>

    <?php if ($_SESSION["user_type"] === "seller"): ?>
        <!-- Display something specific for seller -->
        <a class="NAV" href="add-product.php">
            <div class="nav-cart">
                <img src="../image/sellings.png" width="38" height="34">
                <span>Sellings</span>
            </div>
        </a>
    <?php else: ?>
        <!-- Display the "Cart" link for other user types -->
        <a CLASS="NAV" href="#">
            <div class="nav-cart">
                <img src="../image/cart.png" width="38" height="34">
                <span>Cart</span>
            </div>
        </a>
    <?php endif; ?>
</div>
<section class="quick-view">

    <h1 class="heading">Product view</h1>

    <form action="" method="post" class="box">
        <input type="hidden" name="pid" value="">
        <input type="hidden" name="name" value="">
        <input type="hidden" name="price" value="">
        <input type="hidden" name="image" value="">
        <div class="row">
            <div class="image-container">
                <div class="main-image">
                    <img src="uploaded_img/" alt="">
                </div>
                <div class="sub-image">
                    <img src="uploaded_img/" alt="">
                    <img src="uploaded_img/" alt="">
                    <img src="uploaded_img/" alt="">
                </div>
            </div>
            <div class="content">
                <div class="name"></div>
                <div class="flex">
                    <div class="price"><span>£</span></div>

                    quantity:
                    <input type="number" name="qty" class="qty" min="1" max="99"
                           onkeypress="" value="1">
                </div>
                <div class="details"></div>
                <div class="flex-btn">
                    <input type="submit" value="add to cart" class="btn" name="add_to_cart">
                    <input class="option-btn" type="submit" name="add_to_wishlist" value="add to wishlist">
                </div>
            </div>
        </div>
    </form>
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
