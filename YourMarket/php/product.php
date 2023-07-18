<?php
$mysqli = require __DIR__ . "/connecdb.php";
session_start();
$sellerId = $_SESSION["user_id"];

if (!isset($sellerId)) {
    header('location:login.php');
    exit();
}

if (isset($_GET['ID'])) {
    $ID_Article = $_GET['ID'];

    // Query to retrieve the product details
    $select_product = $mysqli->prepare("SELECT * FROM `article` WHERE ID_Article = ?");
    if (!$select_product) {
        die('Error: ' . $mysqli->error); // Display the specific query error
    }
    $select_product->bind_param("i", $ID_Article);
    $select_product->execute();
    $product_result = $select_product->get_result();
    $product = $product_result->fetch_assoc();
}
$message = '';

if (isset($_POST['add_to_cart'])) {
    $ID_Article = $_POST['ID_Article'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image_1 = $_POST['image'];
    $qty = $_POST['qty'];

    $selling_type = $product['selling_type']; // Get the selling type from the product

    if ($selling_type === 'Auction') {
        // Handling auction functionality

        // Get the maximum bid entered by the user
        $maximumBid = $_POST['maximum_bid'];

        if ($maximumBid < $price) {
            $message = "You cannot set a maximum bid lower than the starting bid!";
        } else {
            // Add auction bid logic here

            // Example: Automatically bid $1 higher than the current highest bid

            // Get the current highest bid from the database
            $select_highest_bid = $mysqli->prepare("SELECT MAX(bid_price) AS highest_bid FROM `auction_bids` WHERE ID_Article = ?");
            $select_highest_bid->bind_param("i", $ID_Article);
            $select_highest_bid->execute();
            $highest_bid_result = $select_highest_bid->get_result();

            if ($highest_bid_result->num_rows > 0) {
                $highestBid = $highest_bid_result->fetch_assoc()['highest_bid'];
            } else {
                $highestBid = $price; // If no bids yet, set the highest bid as the product price
            }

            // Calculate the next bid price
            $nextBid = $highestBid + 1;

            if ($maximumBid >= $nextBid) {
                // Add the user's bid to the database
                $insert_bid = $mysqli->prepare("INSERT INTO `auction_bids` (ID_Article, user_id, bid_price) VALUES (?, ?, ?)");
                $insert_bid->bind_param("iid", $ID_Article, $sellerId, $maximumBid);
                $insert_bid_result = $insert_bid->execute();

                if ($insert_bid_result) {
                    // Get the inserted bid ID
                    $bidId = $mysqli->insert_id;

                    // Update the highest bid and ID_Buyer in the article table
                    $update_article = $mysqli->prepare("UPDATE `article` SET highest_bid = ?, ID_Buyer = ? WHERE ID_Article = ?");
                    $update_article->bind_param("iii", $maximumBid, $_SESSION["user_id"], $ID_Article);
                    $update_article_result = $update_article->execute();

                    if ($update_article_result) {
                        $message = 'Your bid has been placed successfully!';
                    } else {
                        $message = 'Error updating the highest bid and ID_Buyer!';
                    }
                } else {
                    $message = 'Error placing your bid!';
                }
            } else {
                $message = "Your maximum bid is lower than the current highest bid!";
            }
        }
    } else {
        // Handling buy now or other selling types

        $check_cart_numbers = $mysqli->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
        if (!$check_cart_numbers) {
            die('Error: ' . $mysqli->error);
        }
        $check_cart_numbers->bind_param("si", $name, $sellerId);
        $check_cart_numbers->execute();
        $check_cart_result = $check_cart_numbers->get_result();

        if ($check_cart_result->num_rows > 0) {
            $message = 'already added to cart!';
        } else {
            $insert_cart = $mysqli->prepare("INSERT INTO `cart` (user_id, ID_Article, name, price, quantity, image_1) VALUES (?, ?, ?, ?, ?, ?)");
            if (!$insert_cart) {
                die('Error: ' . $mysqli->error);
            }
            $insert_cart->bind_param("iisdis", $sellerId, $ID_Article, $name, $price, $qty, $image_1);
            $insert_cart_result = $insert_cart->execute();

            if ($insert_cart_result) {
                $message = 'added to cart!';
            } else {
                $message = 'Error adding to cart!';
            }
        }
    }
}
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
        <a class="NAV" href="index.php"><img src="../image/logo-2.png" alt="Logo" height="64" width="180"></a>
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
        <a class="NAV" href="cart.php">
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
        <input type="hidden" name="ID_Article" value="<?= $product['ID_Article']; ?>">
        <input type="hidden" name="name" value="<?= $product['name']; ?>">
        <input type="hidden" name="price" value="<?= $product['price']; ?>">
        <input type="hidden" name="image" value="<?= $product['image_1']; ?>">
        <div class="row">
            <div class="image-container">
                <div class="main-image">
                    <img src="../uploaded_img/<?= $product['image_1']; ?>" alt="">
                </div>
                <div class="sub-image">
                    <img src="../uploaded_img/<?= $product['image_1']; ?>" alt="">
                    <img src="../uploaded_img/<?= $product['image_2']; ?>" alt="">
                    <img src="../uploaded_img/<?= $product['image_3']; ?>" alt="">
                </div>
            </div>
            <div class="content">
                <div class="name"><?= $product['name']; ?></div>
                <div class="flex">
                    <div class="price"><span>£</span><?= $product['price']; ?></div>
                    <div class="brand">Brand:<?= $product['brand']; ?></div>
                    <?php if ($product['selling_type'] === 'Auction'): ?>
                        <div class="auction-inputs">
                            <label for="maximum_bid">Maximum Bid:</label>
                            <input type="number" name="maximum_bid" id="maximum_bid" min="<?= $product['price']; ?>"
                                   step="1" required>
                        </div>
                    <?php else: ?>
                        <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="" value="1">
                    <?php endif; ?>
                </div>
                <div class="details"><?= $product['details']; ?></div>
                <?php if ($product['selling_type'] === 'Auction'): ?>
                    <div class="flex-btn">
                        <input type="submit" value="Bid" class="btn" name="bid">
                    </div>
                <?php else: ?>
                    <div class="flex-btn">
                        <input type="submit" value="add to cart" class="btn" name="add_to_cart">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
    <?php if (!empty($message)): ?>
        <div class="message"><?= $message; ?></div>
    <?php endif; ?>
    <script>
        let mainImage = document.querySelector('.quick-view .image-container .main-image img');
        let subImages = document.querySelectorAll('.quick-view .image-container .sub-image img');

        subImages.forEach(image => {
            image.onclick = () => {
                src = image.getAttribute('src');
                mainImage.src = src;
            };
        });
    </script>
</body>
</html>
