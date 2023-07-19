<?php
session_start();
$mysqli = require __DIR__ . "/connecdb.php";

$admin_id = $_SESSION['user_id'];

if (!isset($admin_id)) {
    header('location:login_admin.php');
    exit; // Ajout d'un exit pour terminer l'exécution du script après la redirection
}

if (isset($_GET['delete1'])) {
    $delete_id = $_GET['delete1'];

    // Supprimer l'utilisateur de la table `seller`
    $delete_user = $mysqli->prepare("DELETE FROM `seller` WHERE ID_Seller = ?");
    if (!$delete_user) {
        die("Erreur de préparation de la requête : " . $mysqli->error);
    }
    $delete_user->bind_param("i", $delete_id);
    $delete_user->execute();

    // Supprimer les articles de l'utilisateur de la table `article`
    $delete_article = $mysqli->prepare("DELETE FROM `article` WHERE ID_Seller = ?");
    if (!$delete_article) {
        die("Erreur de préparation de la requête : " . $mysqli->error);
    }
    $delete_article->bind_param("i", $delete_id);
    $delete_article->execute();

    header('location:admin-view.php');
    exit; // Ajout d'un exit pour terminer l'exécution du script après la redirection
}

if (isset($_GET['delete2'])) {
    $delete_id = $_GET['delete2'];

    // Supprimer l'utilisateur de la table `buyer`
    $delete_user = $mysqli->prepare("DELETE FROM `buyer` WHERE ID_Buyer = ?");
    if (!$delete_user) {
        die("Erreur de préparation de la requête : " . $mysqli->error);
    }
    $delete_user->bind_param("i", $delete_id);
    $delete_user->execute();

    // Supprimer les articles du panier de l'utilisateur de la table `cart`
    $delete_cart = $mysqli->prepare("DELETE FROM `cart` WHERE user_id = ?");
    if (!$delete_cart) {
        die("Erreur de préparation de la requête : " . $mysqli->error);
    }
    $delete_cart->bind_param("i", $delete_id);
    $delete_cart->execute();

    header('location:admin-view.php');
    exit; // Ajout d'un exit pour terminer l'exécution du script après la redirection
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <title>Admin View</title>

    <link rel="stylesheet" href="../css/admin-view.css">

</head>
<body>
<!-- Barre de navigation -->
<div id="navbar">
    <div class="nav-logo">
        <a href="logout_admin.php"> <img src="../image/logo-2.png" alt="Logo" height="64" width="180"></a>
    </div>
</div>

<section class="accounts">

    <h1 class="heading">Seller Accounts</h1>

    <div class="box-container">

        <?php
        // Utilisation de $mysqli pour exécuter une requête
        $select_accounts = $mysqli->prepare("SELECT * FROM `seller`");
        $select_accounts->execute();
        $result = $select_accounts->get_result();

        if ($result->num_rows > 0) {
            while ($fetch_accounts = $result->fetch_assoc()) {
                ?>
                <div class="box">
                    <p> user id : <span><?= $fetch_accounts['ID_Seller']; ?></span> </p>
                    <p> username : <span><?= $fetch_accounts['lastname']; ?><?= $fetch_accounts['firstname']; ?></span> </p>
                    <p> email : <span><?= $fetch_accounts['email']; ?></span> </p>
                    <a href="admin-view.php?delete1=<?= $fetch_accounts['ID_Seller']; ?>" onclick="return confirm('delete this account? the user related information will also be delete!')" class="delete-btn">delete</a>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">No accounts available!</p>';
        }
        ?>

    </div>

</section>
<section class="accounts">

    <h1 class="heading">buyer Accounts</h1>

    <div class="box-container">

        <?php
        // Utilisation de $mysqli pour exécuter une requête
        $select_accounts = $mysqli->prepare("SELECT * FROM `buyer`");
        $select_accounts->execute();
        $result = $select_accounts->get_result();

        if ($result->num_rows > 0) {
            while ($fetch_accounts = $result->fetch_assoc()) {
                ?>
                <div class="box">
                    <p> user id : <span><?= $fetch_accounts['ID_Buyer']; ?></span> </p>
                    <p> username : <span><?= $fetch_accounts['lastname']; ?><?= $fetch_accounts['firstname']; ?></span> </p>
                    <p> email : <span><?= $fetch_accounts['email']; ?></span> </p>
                    <a href="admin-view.php?delete2=<?= $fetch_accounts['ID_Buyer']; ?>" onclick="return confirm('delete this account? the user related information will also be delete!')" class="delete-btn">delete</a>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">No accounts available!</p>';
        }
        ?>

    </div>

</section>
</body>
</html>
