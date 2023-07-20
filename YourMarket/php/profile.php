<?php
session_start();
$mysqli = require __DIR__ . "/connecdb.php";

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["user_type"])) {
    header("Location: login.php");
    exit;
}

$userType = $_SESSION["user_type"];
$userId = $_SESSION["user_id"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
    <link href="../css/profile.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- Navigation Bar -->
<?php include 'navbar.php'; ?>

<?php if (empty($searchQuery) && empty($_GET['category'])): ?>
    <div class="box-principal">
        <div class="box-profile">
            <div class="banniere">
                <div CLASS="profile-image">
                    <div class="profile-image2">
                        <img src="../image/user.png" width="70%" HEIGHT="70%">
                    </div>
                </div>
            </div>
            <div class="contenue">
                <div class="left-side">
                    <div class="category-title">
                        <label class="title-1"> Personal Information</label>
                    </div>
                    <div class="bar-random">
                        <!-- This bar is just for styling purposes -->
                    </div>
                    <?php
                    if ($userType === "seller") {
                        $stmt = $mysqli->prepare("SELECT firstname, lastname, dateofbirth FROM `seller` WHERE ID_Seller = ?");
                        $stmt->bind_param("i", $userId);
                    } else {
                        $stmt = $mysqli->prepare("SELECT firstname, lastname, dateofbirth FROM `buyer` WHERE ID_Buyer = ?");
                        $stmt->bind_param("i", $userId);
                    }

                    $stmt->execute();
                    $stmt->bind_result($fetched_firstname, $fetched_lastname, $fetched_dateofbirth);
                    $stmt->fetch();
                    $stmt->close();
                    ?>
                    <div class="first-name">
                        First Name: <?= $fetched_firstname; ?>
                    </div>
                    <div class="last-name">
                        Last Name: <?= $fetched_lastname; ?>
                    </div>
                    <div class="date-of-birth">
                        Date of Birth: <?= $fetched_dateofbirth; ?>
                    </div>
                    <div class="category-title">
                        <label class="title-1">Contact</label>
                    </div>
                    <div class="bar-random">
                        <!-- This bar is just for styling purposes -->
                    </div>
                    <?php
                    if ($userType === "seller") {
                        $stmt = $mysqli->prepare("SELECT email, phone FROM `seller` WHERE ID_Seller = ?");
                        $stmt->bind_param("i", $userId);
                    } else {
                        $stmt = $mysqli->prepare("SELECT email, phone FROM `buyer` WHERE ID_Buyer = ?");
                        $stmt->bind_param("i", $userId);
                    }

                    $stmt->execute();
                    $stmt->bind_result($fetched_email, $fetched_phone);
                    $stmt->fetch();
                    $stmt->close();
                    ?>
                    <div class="email">
                        Email: <?= $fetched_email; ?>
                    </div>
                    <div class="phone-number">
                        Phone Number: <?= $fetched_phone; ?>
                    </div>
                    <a class="NAV" href="logout.php">
                        <div class="log-out">
                            <center>LOG OUT</center>
                        </div>
                    </a>
                </div>
                <div class="middel">
                    <div class="product">
                        <div class="category-title">
                            <label class="title-1">Activity</label>
                        </div>
                        <div class="bar-random">
                            <!-- This bar is just for styling purposes -->
                        </div>
                        <section class="show-products">
                            <div class="box-container">
                                <?php
                                // Get the products added by the user
                                if ($userType === "seller") {
                                    $select_products = $mysqli->prepare("SELECT * FROM `article` WHERE ID_Seller = ?");
                                } else {
                                    $select_products = $mysqli->prepare("SELECT * FROM `historique` WHERE user_id = ?");
                                }

                                $select_products->bind_param("i", $userId); // Use the ID of the current user
                                $select_products->execute();
                                $result = $select_products->get_result(); // Get the result set

                                if ($result->num_rows > 0) {
                                    if ($userType === "seller") {
                                        while ($fetch_products = $result->fetch_assoc()) {
                                            ?>
                                            <div class="box">
                                                <!-- Display the product details -->
                                                <img src="../uploaded_img/<?= $fetch_products['image_1']; ?>" alt="">
                                                <div class="name"><?= $fetch_products['name']; ?></div>
                                                <?php if ($fetch_products['selling_type'] !== "Best Offer"): ?>
                                                    <div class="price">£<span><?= $fetch_products['price']; ?></span></div>
                                                <?php endif; ?>
                                                <div class="category">
                                                    <span>Category:</span> <?= $fetch_products['category']; ?>
                                                </div>
                                                <div class="brand"><span>brand:</span> <?= $fetch_products['brand']; ?>
                                                </div>
                                                <div class="sellingtype">
                                                    <span>SellingType:</span> <?= $fetch_products['selling_type']; ?></div>
                                                <div class="details"><span><?= $fetch_products['details']; ?></span></div>
                                                <br>
                                            </div>
                                            <?php
                                        }
                                    }
                                    if ($userType === "buyer") {
                                        while ($fetch_products = $result->fetch_assoc()) {
                                            ?>
                                            <div class="box">
                                                <!-- Display the product details -->
                                                <img src="../uploaded_img/<?= $fetch_products['image_1']; ?>" alt="">
                                                <div class="name"><?= $fetch_products['name']; ?></div>
                                                    <div class="price">£<span><?= $fetch_products['price']; ?></span></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                } else {
                                    echo '<p class="empty">No products added yet!</p>';
                                }
                                ?>
                            </div>
                        </section>

                        <?php
                        if ($userType === "seller") {
                            $select_offers = $mysqli->prepare("SELECT * FROM `offer` WHERE offer_id IN (SELECT ID_Article FROM `article` WHERE ID_Seller = ?)");
                            $select_offers->bind_param("i", $userId);
                            $select_offers->execute();

                            if ($select_offers->errno) {
                                echo "Execution failed: " . $select_offers->error;
                            }

                            $result_offers = $select_offers->get_result();

                            if ($result_offers->num_rows > 0) {
                                ?>
                                <section class="seller-offers">
                                    <div class="category-title">
                                        <label class="title-1">Offers Received</label>
                                    </div>
                                    <div class="bar-random">
                                        <!-- This bar is just for styling purposes -->
                                    </div>
                                    <?php
                                    while ($fetch_offers = $result_offers->fetch_assoc()) {
                                        ?>
                                        <div class="offer">
                                            <div class="offer-details">
                                                <div class="offer-buyer">Buyer: <?= $fetch_offers['user_id']; ?></div>
                                                <?php if ($fetch_offers['offer_status'] !== "Best Offer"): ?>
                                                    <div class="offer-price">Offer Price: £<?= $fetch_offers['offer_price']; ?></div>
                                                <?php endif; ?>
                                                <div class="offer-status">Status: <?= $fetch_offers['offer_status']; ?></div>
                                            </div>
                                            <div class="offer-message">
                                                <span>Message:</span> <?= $fetch_offers['offer_message']; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </section>
                                <?php
                            } else {
                                echo '<p class="empty">No offers received yet!</p>';
                            }
                        }

                        if ($userType === "buyer") {
                            $select_offers = $mysqli->prepare("SELECT * FROM `offer` WHERE user_id = ?");
                            $select_offers->bind_param("i", $userId);
                            $select_offers->execute();

                            if ($select_offers->errno) {
                                echo "Execution failed: " . $select_offers->error;
                            }

                            $result_offers = $select_offers->get_result();

                            if ($result_offers->num_rows > 0) {
                                ?>
                                <section class="buyer-offers">
                                    <div class="category-title">
                                        <label class="title-1">Offers Sent</label>
                                    </div>
                                    <div class="bar-random">
                                        <!-- This bar is just for styling purposes -->
                                    </div>
                                    <?php
                                    while ($fetch_offers = $result_offers->fetch_assoc()) {
                                        ?>
                                        <div class="offer">
                                            <div class="offer-details">
                                                <div class="offer-product-name"><?= $fetch_offers['product_name']; ?></div>
                                                <?php if ($fetch_offers['offer_status'] !== "Best Offer"): ?>
                                                    <div class="offer-price">Offer Price: £<?= $fetch_offers['offer_price']; ?></div>
                                                <?php endif; ?>
                                                <div class="offer-status">Status: <?= $fetch_offers['offer_status']; ?></div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </section>
                                <?php
                            } else {
                                echo '<p class="empty">No offers sent yet!</p>';
                            }
                        }
                        ?>

                    </div>
                </div>
                <div class="right-side">
                    <a class="NAV" href="update_profile.php">
                        <div class="change-setting">
                            <center>Change setting</center>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php elseif ((isset($_GET['search']) || isset($_GET['category'])) && empty($products)): ?>
    <!-- Display a message when no search results or category is found -->
    <div id="main-content">
        <h1 class="heading">No results found!</h1>
    </div>
<?php endif; ?>
</body>
</html>
