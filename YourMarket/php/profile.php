<?php

session_start();
$mysqli = require __DIR__ . "/connecdb.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
    <link href="../css/profile.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php if (isset($_SESSION["user_id"]) && isset($_SESSION["user_type"])): ?>
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
                        <!--cette bare ne sert completment a rien mais ca fait class et c marant a faire-->
                    </div>
                    <?php
                    $stmt = $mysqli->prepare("SELECT firstname FROM `seller` WHERE ID_Seller = ?");
                    $stmt->bind_param("i", $_SESSION["user_id"]); // Utilisez la valeur de l'ID de l'utilisateur actuel
                    $stmt->execute();
                    $stmt->bind_result($fetched_firstname);
                    $stmt->fetch();
                    $stmt->close();
                    ?>
                    <div class="first-name">
                        First Name : <?= $fetched_firstname; ?>
                    </div>
                    <?php
                    $stmt = $mysqli->prepare("SELECT lastname FROM `seller` WHERE ID_Seller = ?");
                    $stmt->bind_param("i", $_SESSION["user_id"]); // Utilisez la valeur de l'ID de l'utilisateur actuel
                    $stmt->execute();
                    $stmt->bind_result($fetched_lastname);
                    $stmt->fetch();
                    $stmt->close();
                    ?>
                    <div class="last-name">
                        Last Name : <?= $fetched_lastname; ?>
                    </div>
                    <?php
                    $stmt = $mysqli->prepare("SELECT dateofbirth FROM `seller` WHERE ID_Seller = ?");
                    $stmt->bind_param("i", $_SESSION["user_id"]); // Utilisez la valeur de l'ID de l'utilisateur actuel
                    $stmt->execute();
                    $stmt->bind_result($fetched_dateofbirth);
                    $stmt->fetch();
                    $stmt->close();
                    ?>
                    <div class="date-of-birth">
                        Date of Birth : <?= $fetched_dateofbirth; ?>
                    </div>
                    <div class="category-title">
                        <label class="title-1">Contact</label>
                    </div>
                    <div class="bar-random">
                        <!--cette bare ne sert completment a rien mais ca fait class et c marant a faire-->
                    </div>
                    <?php
                    $stmt = $mysqli->prepare("SELECT email FROM `seller` WHERE ID_Seller = ?");
                    $stmt->bind_param("i", $_SESSION["user_id"]); // Utilisez la valeur de l'ID de l'utilisateur actuel
                    $stmt->execute();
                    $stmt->bind_result($fetched_email);
                    $stmt->fetch();
                    $stmt->close();
                    ?>
                    <div class="email">
                        Email : <?= $fetched_email; ?>
                    </div>
                    <?php
                    $stmt = $mysqli->prepare("SELECT phone FROM `seller` WHERE ID_Seller = ?");
                    $stmt->bind_param("i", $_SESSION["user_id"]); // Utilisez la valeur de l'ID de l'utilisateur actuel
                    $stmt->execute();
                    $stmt->bind_result($fetched_phone);
                    $stmt->fetch();
                    $stmt->close();
                    ?>
                    <div class="phone-number">
                        Phone Number : <?= $fetched_phone; ?>
                    </div>
                    <a class="NAV" href="logout.php">
                        <div class="log-out">
                            <Center>LOG OUT</Center>
                        </div>
                    </a>
                </div>
                <div class="middel">
                    <div class="product">
                        <div class="category-title">
                            <label class="title-1">Activity</label>
                        </div>
                        <div class="bar-random">
                            <!--cette bare ne sert completment a rien mais ca fait class et c marant a faire-->
                        </div>
                        <section class="show-products">
                            <div class="box-container">
                                <?php
                                // Récupérer les produits ajoutés par l'utilisateur
                                $select_products = $mysqli->prepare("SELECT * FROM `article` WHERE ID_Seller = ?");
                                $select_products->bind_param("i", $_SESSION["user_id"]); // Utilisez l'ID de l'utilisateur actuel
                                $select_products->execute();
                                $result = $select_products->get_result(); // Obtenir le jeu de résultats

                                if ($result === false) {
                                    // Afficher le message d'erreur
                                    echo("Error fetching result set: " . $mysqli->error);
                                }

                                if ($result->num_rows > 0) {
                                    while ($fetch_products = $result->fetch_assoc()) {
                                        ?>
                                        <div class="box">
                                            <!-- Afficher les détails du produit -->
                                            <img src="../uploaded_img/<?= $fetch_products['image_1']; ?>" alt="">
                                            <div class="name"><?= $fetch_products['name']; ?></div>
                                            <div class="price">£<span><?= $fetch_products['price']; ?></span></div>
                                            <div class="category">
                                                <span>Category:</span> <?= $fetch_products['category']; ?>
                                            </div>
                                            <div class="stock"><span>Stock:</span> <?= $fetch_products['stock']; ?>
                                            </div>
                                            <div class="details"><span><?= $fetch_products['details']; ?></span></div>
                                            <br>
                                            <div class="flex-btn">
                                                <!-- Ajoutez ici les boutons de mise à jour et de suppression du produit -->
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo '<p class="empty">No products added yet!</p>';
                                }
                                ?>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="right-side">
                    <a class="NAV" href="logout.php">
                        <div class="change-setting">
                            <Center>Change setting</Center>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>
<?php else:
    header("Location: login.php");
    exit; ?>
<?php endif; ?>
</body>
</html>
