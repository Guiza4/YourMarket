<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home Page</title>
    <link href="../css/home.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/home.js"></script>
</head>
<body>
<?php if (isset($_SESSION["user_id"]) && isset($_SESSION["user_type"])): ?>
    <!-- Barre de promotion -->
    <div id="promo-banner">
        <a href="#">Promo -10% for new users with the code : Malik77</a>
    </div>

    <!-- Barre de navigation -->
    <div id="navbar">
        <a href="logout.php"><img src="../image/logo-2.png" alt="Logo" height="64" width="180"></a>
        <input type="text" id="search-bar" placeholder="Search..."><span class="search-icon"></span>
        <img src="../image/categorie.png" width="25" height="49"><a href="#">Category</a>
        <img src="../image/account.png" width="30" height="32"><a href="#">Account</a>

        <?php if ($_SESSION["user_type"] === "seller"): ?>
            <!-- Display something specific for seller -->
            <img src="../image/sellings.png" width="38" height="34"><a href="add-product.php">Sellings</a>
        <?php else: ?>
            <!-- Display the "Cart" link for other user types -->
            <img src="../image/cart.png" width="38" height="34"><a href="#">Cart</a>
        <?php endif; ?>
    </div>

    <!-- Contenu principal -->
    <div id="main-content">
        <!-- Rectangle avec carrousel -->
        <div class="rounded-box">
            <div class="refurbished-left">
                <center><h2>Save Up To 50%</h2>
                    <h2>With Refurbished</h2><br>
                    <h4>Expertly restored, quality checked & a one-year seller guarantee</h4></center>
                <div class="shop-refurbished">
                    <a href="#">Shop Refurbished</a><img src="../image/arrows-right-2.png" width="24" height="24">
                </div>
            </div>
            <div class="refurbished-right">
                <div class="prev-button">
                    <center>
                        <button class="bg-arrow"><img src="../image/arrow-left.png"></button>
                    </center>
                </div>
                <div class="carousel-images">
                    <center><img src="../image/applewatch.png" alt="Image 1">
                        <img src="../image/Iphone.png" alt="Image 2">
                        <img src="../image/Ipad.png" alt="Image 3"></center>
                </div>
                <div class="next-button">
                    <center>
                        <button class="bg-arrow"><img src="../image/arrows-right-2.png"></button>
                    </center>
                </div>
            </div>
        </div>
        <!-- Catégorie Most Wanted -->
        <div>
            <div class="category-title">
                <label class="title-1"> Most Wanted</label>
                <label class="title-2"> The tech everybody wants !</label>
            </div>
            <div class="Most-Wanted">
                <div class="prev-button-item">
                    <center>
                        <button class="bg-arrow"><img src="../image/arrow-left.png"></button>
                    </center>
                </div>
                <!-- produit 1 -->
                <div class="product-box">
                    <div class="best-seller">
                        <center> Best Seller</center>
                    </div>
                    <div class="item-image">
                        <img src="../image/item-1.png">
                    </div>
                    <div class="description">
                        <label class="product-name"><p>Iphone 12</p></label>
                        <label class="product-description"><p>125 Gb-purple-unlocked</p>
                            <p>Warranty: 12 months</p>
                            <p>starting at:</p>
                        </label>
                        <label class="price"><p>£319.99</p></label>
                    </div>
                </div>
                <!-- produit 2 -->

                <div class="product-box">
                    <div class="best-seller">
                        <center> Best Seller</center>
                    </div>
                    <div class="item-image">
                        <img src="../image/item-2.png">
                    </div>
                    <div class="description">
                        <label class="product-name"><p>Iphone 12</p></label>
                        <label class="product-description"><p>125 Gb-Black-unlocked</p>
                            <p>Warranty: 12 months</p>
                            <p>starting at:</p>
                        </label>
                        <label class="price"><p>£339.99</p></label>
                    </div>
                </div>
                <div class="product-box">
                    <div class="best-seller">
                        <center> Best Seller</center>
                    </div>
                    <div class="item-image">
                        <img src="../image/item-3.png">
                    </div>
                    <div class="description">
                        <label class="product-name"><p>MacBook Air 13" (2019) - QWERTY - English</p></label>
                        <label class="product-description"><p>Retina - Core i5 - 1.6 GHz - 128 GB SSD - RAM 8GB</p>
                            <p>Warranty: 12 months</p>
                            <p>starting at:</p>
                        </label>
                        <label class="price"><p>£539.99</p></label>
                    </div>
                </div>
                <div class="product-box">
                    <div class="best-seller">
                        <center> Best Seller</center>
                    </div>
                    <div class="item-image">
                        <img src="../image/item-4.png">
                    </div>
                    <div class="description">
                        <label class="product-name"><p>Switch OLED </p></label>
                        <label class="product-description"><p>64GB - White</p>
                            <p>Warranty: 12 months</p>
                            <p>starting at:</p>
                        </label>
                        <label class="price"><p>£539.99</p></label>
                    </div>
                </div>
                <div class="product-box">
                    <div class="best-seller">
                        <center> Best Seller</center>
                    </div>
                    <div class="item-image">
                        <img src="../image/item-5.png">
                    </div>
                    <div class="description">
                        <label class="product-name"><p>Xbox One </p></label>
                        <label class="product-description"><p>500GB - Black</p>
                            <p>Warranty: 12 months</p>
                            <p>starting at:</p>
                        </label>
                        <label class="price"><p>£99.99</p></label>
                    </div>
                </div>
                <!-- Ajoutez plus de cases d'articles ici -->
                <div class="next-button-item">
                    <center>
                        <button class="bg-arrow"><img src="../image/arrows-right-2.png" width="24px" height="24px">
                        </button>
                    </center>
                </div>
            </div>
        </div>

        <!-- Catégorie Best Action -->
        <div>
            <div class="category-title">
                <label class="title-1"> Best Action</label>
                <label class="title-2"> Put a bid or best offer !</label>
            </div>
            <div class="Most-Wanted">
                <div class="prev-button-item">
                    <center>
                        <button class="bg-arrow"><img src="../image/arrow-left.png"></button>
                    </center>
                </div>
                <!-- produit 1 -->
                <div class="product-box">
                    <div class="best-seller">
                        <center> Best Seller</center>
                    </div>
                    <div class="item-image">
                        <img src="../image/item-1.png">
                    </div>
                    <div class="description">
                        <label class="product-name"><p>Iphone 12</p></label>
                        <label class="product-description"><p>125 Gb-purple-unlocked</p>
                            <p>Warranty: 12 months</p>
                            <p>starting at:</p>
                        </label>
                        <label class="price"><p>£319.99</p></label>
                    </div>
                </div>
                <!-- produit 2 -->

                <div class="product-box">
                    <div class="best-seller">
                        <center> Best Seller</center>
                    </div>
                    <div class="item-image">
                        <img src="../image/item-2.png">
                    </div>
                    <div class="description">
                        <label class="product-name"><p>Iphone 12</p></label>
                        <label class="product-description"><p>125 Gb-Black-unlocked</p>
                            <p>Warranty: 12 months</p>
                            <p>starting at:</p>
                        </label>
                        <label class="price"><p>£339.99</p></label>
                    </div>
                </div>
                <div class="product-box">
                    <div class="best-seller">
                        <center> Best Seller</center>
                    </div>
                    <div class="item-image">
                        <img src="../image/item-3.png">
                    </div>
                    <div class="description">
                        <label class="product-name"><p>MacBook Air 13" (2019) - QWERTY - English</p></label>
                        <label class="product-description"><p>Retina - Core i5 - 1.6 GHz - 128 GB SSD - RAM 8GB</p>
                            <p>Warranty: 12 months</p>
                            <p>starting at:</p>
                        </label>
                        <label class="price"><p>£539.99</p></label>
                    </div>
                </div>
                <div class="product-box">
                    <div class="best-seller">
                        <center> Best Seller</center>
                    </div>
                    <div class="item-image">
                        <img src="../image/item-4.png">
                    </div>
                    <div class="description">
                        <label class="product-name"><p>Switch OLED </p></label>
                        <label class="product-description"><p>64GB - White</p>
                            <p>Warranty: 12 months</p>
                            <p>starting at:</p>
                        </label>
                        <label class="price"><p>£539.99</p></label>
                    </div>
                </div>
                <div class="product-box">
                    <div class="best-seller">
                        <center> Best Seller</center>
                    </div>
                    <div class="item-image">
                        <img src="../image/item-5.png">
                    </div>
                    <div class="description">
                        <label class="product-name"><p>Xbox One </p></label>
                        <label class="product-description"><p>500GB - Black</p>
                            <p>Warranty: 12 months</p>
                            <p>starting at:</p>
                        </label>
                        <label class="price"><p>£99.99</p></label>
                    </div>
                </div>
                <!-- Ajoutez plus de cases d'articles ici -->
                <div class="next-button-item">
                    <center>
                        <button class="bg-arrow"><img src="../image/arrows-right-2.png" width="24px" height="24px">
                        </button>
                    </center>
                </div>
            </div>
            <!-- Ajoutez plus de cases d'articles ici -->
        </div>
    </div>
    <center>
        <footer>
            <a href="mentions-legales.html">LEGAL</a>
            <a href="politique-confidentialite.html">PRIVACY CENTER</a>
            <a href="cookies.html">COOKIE</a>
            <a href="a-propos.html">ABOUT US</a>
        </footer>
    </center>


<?php else:
    header("Location: login.php");
    exit; ?>
<?php endif; ?>

</body>
</html>
