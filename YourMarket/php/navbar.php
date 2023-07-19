<?php
include 'search.php';
// Retrieve all products from the database
$mysqli = require __DIR__ . "/connecdb.php";
$select_all_products = $mysqli->query("SELECT * FROM article");
$all_products = $select_all_products->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
    <link href="../css/navbar.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php if (isset($_SESSION["user_id"]) && isset($_SESSION["user_type"])): ?>
    <!-- Navigation Bar -->
    <div id="navbar">
        <div class="nav-logo">
            <a CLASS="NAV" href="index.php"><img src="../image/logo-2.png" alt="Logo" height="64" width="180"></a>
        </div>
        <form method="get" action="index.php">
            <input type="search" id="search-bar" name="search" placeholder="Search..."
                   value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        </form>
        <a class="NAV" href="#">
            <div class="nav-categorie">
                <div class="nav-dropdown">
                    <img src="../image/categorie.png" width="25" height="49">Category
                    <div class="dropdown-content">
                        <a href="index.php">All</a>
                        <a href="index.php?category=Phone">Phone</a>
                        <a href="index.php?category=Computer">Computer</a>
                        <a href="index.php?category=Watch">Watch</a>
                        <a href="index.php?category=Video-game">Video-game</a>
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
            <!-- Display something specific for sellers -->
            <a class="NAV" href="add-product.php">
                <div class="nav-cart">
                    <img src="../image/sellings.png" width="38" height="34">
                    <span>Sellings</span>
                </div>
            </a>
        <?php else: ?>
            <!-- Display the "Cart" link for other user types -->
            <a CLASS="NAV" href="cart.php">
                <div class="nav-cart">
                    <img src="../image/cart.png" width="38" height="34">
                    <span>Cart</span>
                </div>
            </a>
        <?php endif; ?>
    </div>
    <!-- Main Content -->
    <?php if (!empty($products)): ?>
        <?php if ((isset($_GET['search'])) && !empty($_GET['search'])): ?>
            <h1 class="heading">Results: </h1>
            <div id="main-content-search">
        <?php endif; ?>
        <section class="search-results">
            <div class="product-container">
                <div class="product">
                    <section class="show-products">
                        <div class="box-container">
                            <?php foreach ($products as $product): ?>
                                <?php if ($_SESSION['user_type'] === 'buyer'): ?>
                                    <a class="go-to-product" href="product.php?ID=<?= $product['ID_Article']; ?>">
                                <?php endif; ?>
                                <div class="box">
                                    <!-- Display product details -->
                                    <img src="../uploaded_img/<?= $product['image_1']; ?>" alt="">
                                    <div class="name"><?= $product['name']; ?></div>
                                    <?php if ($product['selling_type'] !== 'Best Offer'): ?>
                                        <div class="price">£<span><?= $product['price']; ?></span></div>
                                    <?php else: ?>
                                        <div class="bestoffer"><span>Best Offer</span></div>
                                    <?php endif; ?>
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
    <?php endif; ?>
    </div>
<?php endif; ?>
</body>
</html>
