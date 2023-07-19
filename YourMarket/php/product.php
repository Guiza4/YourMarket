<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
$highestBid = 0; // Initialize $highestBid with 0
if (isset($_POST['bid'])) {
    $ID_Article = $_POST['ID_Article'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image_1 = $_POST['image'];
    $maximumBid = $_POST['maximum_bid'];

    if ($maximumBid < $price) {
        $message = "You cannot set a maximum bid lower than the starting bid!";
    } else {
        // Add auction bid logic here
        if ($highestBid < $maximumBid) {
            $highestBid = $highestBid + 1;
        }

        // Get the current highest bid from the database
        $select_highest_bid = $mysqli->prepare("SELECT MAX(highest_bid) AS highest_bid FROM `article` WHERE ID_Article = ?");
        if (!$select_highest_bid) {
            die('Error: ' . $mysqli->error);
        }
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
            // Update the highest bid and ID_Buyer in the article table
            $update_article = $mysqli->prepare("UPDATE `article` SET highest_bid = ?, ID_Buyer = ? WHERE ID_Article = ?");
            if (!$update_article) {
                die('Error: ' . $mysqli->error);
            }
            $update_article->bind_param("dii", $maximumBid, $_SESSION["user_id"], $ID_Article);
            $update_article_result = $update_article->execute();

            if ($update_article_result) {
                $message = 'Your bid has been placed successfully!';
            } else {
                $message = 'Error updating the highest bid and ID_Buyer: ' . $mysqli->error;
            }
        } else {
            $message = "Your maximum bid is lower than the current highest bid!";
        }
    }
}

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
            if ($highestBid < $maximumBid) {
                $highestBid = $highestBid + 1;
            }
            // Get the current highest bid from the database
            $select_highest_bid = $mysqli->prepare("SELECT MAX(highest_bid) AS highest_bid FROM `article` WHERE ID_Article = ?");
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
                // Update the highest bid and ID_Buyer in the article table
                $update_article = $mysqli->prepare("UPDATE `article` SET highest_bid = ?, ID_Buyer = ? WHERE ID_Article = ?");
                $update_article->bind_param("iii", $maximumBid, $_SESSION["user_id"], $ID_Article);
                $update_article_result = $update_article->execute();

                if ($update_article_result) {
                    $message = 'Your bid has been placed successfully!';
                } else {
                    $message = 'Error updating the highest bid and ID_Buyer: ' . $mysqli->error;
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
                $message = 'Error adding to cart: ' . $mysqli->error;
            }
        }
    }
}
if (isset($_POST['submit_offer'])) {
    $ID_Article = $_POST['ID_Article'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image_1 = $_POST['image'];
    $offerPrice = $_POST['offer_price'];

    // Check if an offer already exists for the article by the current user
    $select_offer = $mysqli->prepare("SELECT * FROM `offer` WHERE ID_Article = ? AND user_id = ?");
    if (!$select_offer) {
        die('Error: ' . $mysqli->error);
    }
    $select_offer->bind_param("ii", $ID_Article, $_SESSION["user_id"]);
    $select_offer->execute();
    $offer_result = $select_offer->get_result();

    if ($offer_result->num_rows > 0) {
        // Update the existing offer price
        $update_offer = $mysqli->prepare("UPDATE `offer` SET offer_price = ? WHERE ID_Article = ? AND user_id = ?");
        if (!$update_offer) {
            die('Error: ' . $mysqli->error);
        }
        $update_offer->bind_param("dii", $offerPrice, $ID_Article, $_SESSION["user_id"]);
        $update_offer_result = $update_offer->execute();

        if ($update_offer_result) {
            $message = 'Your offer has been updated successfully!';
        } else {
            $message = 'Error updating the offer price: ' . $mysqli->error;
        }
    } else {
        // Insert a new offer
        $insert_offer = $mysqli->prepare("INSERT INTO `offer` (user_id, ID_Article, offer_price) VALUES (?, ?, ?)");
        if (!$insert_offer) {
            die('Error: ' . $mysqli->error);
        }
        $insert_offer->bind_param("iid", $_SESSION["user_id"], $ID_Article, $offerPrice);
        $insert_offer_result = $insert_offer->execute();

        if ($insert_offer_result) {
            $message = 'Your offer has been submitted successfully!';
        } else {
            $message = 'Error submitting the offer: ' . $mysqli->error;
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
<!-- Navigation Bar -->
<?php include 'navbar.php'; ?>

<?php if (empty($searchQuery) && empty($_GET['category'])): ?>
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
                    <?php elseif($product['selling_type']==='Best Offer'): ?>
                    <?php else:?>
                        <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="" value="1">
                    <?php endif; ?>
                </div>
                <div class="details"><?= $product['details']; ?></div>
                <?php if ($product['selling_type'] === 'Auction'): ?>
                    <div class="date">Starting Date:<span style="color: #3FBBF7"><?= $product['start_date']; ?></span> |   Ending date:<span style="color: #3FBBF7"><?= $product['end_date']; ?></span></div>
                    <div class="current-bid">
                        <?php
                        $select_highest_bid = $mysqli->prepare("SELECT MAX(highest_bid) AS highest_bid FROM `article` WHERE ID_Article = ?");
                        $select_highest_bid->bind_param("i", $ID_Article);
                        $select_highest_bid->execute();
                        $highest_bid_result = $select_highest_bid->get_result();

                        if ($highest_bid_result->num_rows > 0) {
                            $highestBid = $highest_bid_result->fetch_assoc()['highest_bid'];
                            echo "Current Highest Bid: £" . $highestBid;
                        } else {
                            echo "No bids yet.";
                        }
                        ?>
                    </div>
                    <div class="flex-btn">
                        <input type="submit" value="Bid" class="btn" name="bid">
                    </div>
                    <?php elseif ($product['selling_type'] === 'Best Offer'): ?>
                        <div class="make-offer">

                            <form action="" method="post">
                                <input type="hidden" name="ID_Article" value="<?= $product['ID_Article']; ?>">
                                <input type="hidden" name="name" value="<?= $product['name']; ?>">
                                <input type="hidden" name="price" value="<?= $product['price']; ?>">
                                <input type="hidden" name="image" value="<?= $product['image_1']; ?>">
                                <div class="best-offer-inputs">
                                    <label for="offer_price"><span>Your Offer:</span></label>
                                    <input type="number" name="offer_price" id="offer_price" min="<?= $product['price']; ?>" step="0.01" required>
                                </div>
                                <input type="submit" value="Submit Offer" class="btn" name="submit_offer">
                            </form>
                        </div>
                <?php else: ?>
                    <div class="flex-btn">
                        <input type="submit" value="Add to Cart" class="btn" name="add_to_cart">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
    <?php if (!empty($message)): ?>
        <div class="message"><?= $message; ?></div>
    <?php endif; ?>
    <?php elseif ((isset($_GET['search']) || isset($_GET['category'])) && empty($products)): ?>
        <!-- Display a message when no search results or category is found -->
        <div id="main-content">
            <h1 class="heading">No results found!</h1>
        </div>
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
