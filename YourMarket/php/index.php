<?php
session_start();
// Récupérer tous les produits de la base de données
$mysqli = require __DIR__ . "/connecdb.php";
$select_all_products = $mysqli->query("SELECT * FROM article");
$all_products = $select_all_products->fetch_all(MYSQLI_ASSOC);
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
        <a href="#">Promo -10% for new users with the code: Malik77</a>
    </div>

    <!-- Barre de navigation -->
    <?php include 'navbar.php'; ?>
    <?php if (empty($searchQuery) && empty($_GET['category'])): ?>
        <!-- Contenu principal -->
        <div id="main-content">
        <!-- Rectangle avec carrousel -->
        <div class="rounded-box">
            <div class="refurbished-left">
                <center><h2>Save Up To 50%</h2>
                    <h2>With Refurbished</h2><br>
                    <h4>Expertly restored, quality checked & a one-year seller guarantee</h4></center>
                <div class="shop-refurbished">
                    <a href="#">Shop Refurbished</a><img src="../image/arrows-right-2.png" width="24"
                                                         height="24">
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
                <label class="title-1"> Our Product</label>
                <label class="title-2"> The tech everybody wants !</label>
            </div>
            <!-- Afficher tous les produits -->
            <section class="search-results">
                <div class="product-container">
                    <div class="product">
                        <section class="show-products">
                            <div class="box-container">
                                <?php foreach ($all_products as $product): ?>
                                    <?php if ($_SESSION['user_type'] === 'buyer'): ?>
                                        <a class="go-to-product" href="product.php?ID=<?= $product['ID_Article']; ?>">
                                    <?php endif; ?>
                                    <div class="box">
                                        <!-- Afficher les détails du produit -->
                                        <img src="../uploaded_img/<?= $product['image_1']; ?>" alt="">
                                        <div class="name"><?= $product['name']; ?></div>
                                        <div class="price">£<span><?= $product['price']; ?></span></div>
                                        <div class="category">
                                            <span>Category:</span> <?= $product['category']; ?>
                                        </div>
                                        <div class="brand">
                                            <span>Brand:</span> <?= $product['brand']; ?>
                                        </div>
                                        <?php if ($product['selling_type'] === 'Auction'): ?>
                                            <div class="date">
                                                <span>Start:<?= $product['start_date']; ?> End:<?= $product['end_date']; ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="details"><span><?= $product['details']; ?></span></div>
                                        <br>
                                    </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    </div>
                </div>
            </section>

        </div>
    <?php elseif ((isset($_GET['search'])||isset($_GET['category'])) && empty($products)): ?>
        <!-- Display a message when no search results or category is found -->
        <div id="main-content">
            <h1 class="heading">No results found!</h1>
        </div>
    <?php endif; ?>
    </div>
<?php else: ?>
    <?php
    header("Location: login.php");
    exit;
    ?>
<?php endif; ?>
<center>
    <footer>
        <a href="mentions-legales.html">LEGAL</a>
        <a href="politique-confidentialite.html">PRIVACY CENTER</a>
        <a href="cookies.html">COOKIE</a>
        <a href="a-propos.html">ABOUT US</a>
    </footer>
</center>
</body>
</html>