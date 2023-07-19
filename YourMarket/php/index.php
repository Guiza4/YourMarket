<?php
session_start();
include 'search.php';
$mysqli = require __DIR__ . "/connecdb.php";

// Build the base query
$query = "SELECT * FROM article WHERE 1 = 1";

// Check if sorting parameter is set
if (isset($_GET['sort']) && $_GET['sort'] === 'name') {
    $query .= " ORDER BY name ASC";
} elseif (isset($_GET['sort']) && $_GET['sort'] === 'price') {
    $query .= " ORDER BY price ASC";
}

// Check if brand filter parameter is set
if (isset($_GET['brand']) && is_array($_GET['brand'])) {
    $brands = array_map(function ($brand) use ($mysqli) {
        return "'" . $mysqli->real_escape_string($brand) . "'";
    }, $_GET['brand']);
    $brandsCondition = implode(',', $brands);
    $query .= " AND brand IN ($brandsCondition)";
}

// Check if category filter parameter is set
if (isset($_GET['category']) && is_array($_GET['category'])) {
    $categories = array_map(function ($category) use ($mysqli) {
        return "'" . $mysqli->real_escape_string($category) . "'";
    }, $_GET['category']);
    $categoriesCondition = implode(',', $categories);
    if (strpos($query, "WHERE") !== false) {
        $query .= " AND category IN ($categoriesCondition)";
    } else {
        $query .= " WHERE category IN ($categoriesCondition)";
    }
}

// Check if selling type filter parameter is set
if (isset($_GET['selling_type']) && is_array($_GET['selling_type'])) {
    $sellingTypes = array_map(function ($sellingType) use ($mysqli) {
        return "'" . $mysqli->real_escape_string($sellingType) . "'";
    }, $_GET['selling_type']);
    $sellingTypesCondition = implode(',', $sellingTypes);
    if (strpos($query, "WHERE") !== false) {
        $query .= " AND selling_type IN ($sellingTypesCondition)";
    } else {
        $query .= " WHERE selling_type IN ($sellingTypesCondition)";
    }
}

$select_all_products = $mysqli->query($query);
$filtered_products = $select_all_products->fetch_all(MYSQLI_ASSOC);
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
    <!-- Promotion Banner -->
    <div id="promo-banner">
        <a href="#">Promo -10% for new users with the code: Malik77</a>
    </div>

    <!-- Navigation Bar -->
    <?php include 'navbar.php'; ?>
    <?php if (empty($searchQuery)): ?>
        <!-- Main Content -->
        <div id="main-content">
        <!-- Rounded Box with Carousel -->
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
        <!-- Most Wanted Category -->
        <div>
            <div class="category-title">
                <label class="title-1"> Our Product</label>
                <label class="title-2"> The tech everybody wants !</label>
            </div>
            <div class="pppp">
                <!-- Filter Form -->
                <div class="filter-container">
                    <div class="filter-box">
                        <p>Sort by:</p>
                        <button id="filter-alphabet" class="filter-button">Name</button>
                        <button id="filter-price" class="filter-button">Price</button>
                    </div>
                    <form action="index.php" method="get">
                        <!-- ... autres filtres existants ... -->

                        <!-- Filtre par marque -->
                        <div class="filter-option">
                            <label for="brand-filter">Brand:</label>
                            <select id="brand-filter" name="brand[]" multiple>
                                <option value="Apple">Apple</option>
                                <option value="Samsung">Samsung</option>
                                <option value="Sony">Sony</option>
                                <option value="HP">HP</option>
                            </select>
                        </div>

                        <!-- Filtre par type de vente -->
                        <div class="filter-option">
                            <label for="selling-type-filter">Selling Type:</label>
                            <select id="selling-type-filter" name="selling_type[]" multiple>
                                <option value="Buy Now">Buy Now</option>
                                <option value="Best Offer">Best Offer</option>
                                <option value="Auction">Auction</option>
                            </select>
                        </div>

                        <button type="submit" name="apply-filter">Apply Filter</button>
                        <button type="submit" name="reset-filter">Reset Filter</button>
                    </form>
                </div>

                <!-- Display All Products -->
                <section class="search-results">
                    <div class="product-container">
                        <div class="product">
                            <section class="show-products">
                                <div class="box-container">
                                    <?php foreach ($filtered_products as $product): ?>
                                        <?php if ($_SESSION['user_type'] === 'buyer'): ?>
                                            <a class="go-to-product" href="product.php?ID=<?= $product['ID_Article']; ?>">
                                        <?php endif; ?>
                                        <div class="box">
                                            <!-- Display Product Details -->
                                            <img src="../uploaded_img/<?= $product['image_1']; ?>" alt="">
                                            <div class="name"><?= $product['name']; ?></div>
                                            <?php if ($product['selling_type']!=='Best Offer'):?>
                                            <div class="price">£<span><?= $product['price']; ?></span></div>
                                            <?php endif;?>
                                            <div class="brand">
                                                <span>Brand:</span> <?= $product['brand']; ?>
                                            </div>
                                            <?php if ($product['selling_type'] === 'Auction'): ?>
                                                <div class="date">
                                                    <span>Start: <?= $product['start_date']; ?> End: <?= $product['end_date']; ?></span>
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
        </div>
    <?php elseif ((isset($_GET['search']) || isset($_GET['category'])) && empty($filtered_products)): ?>
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
