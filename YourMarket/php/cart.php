<?php
session_start();
$mysqli = require __DIR__ . "/connecdb.php";

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["user_type"])) {
    header("Location: login.php");
    exit;
}

$userType = $_SESSION["user_type"];
$userId = $_SESSION["user_id"];

if (isset($_POST['update_qty'])) {
    $cartId = $_POST['cart_id'];
    $qty = $_POST['qty'];

    // Mettre à jour la quantité du produit dans le panier
    $update_qty = $mysqli->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
    if (!$update_qty) {
        die('Error: ' . $mysqli->error);
    }
    $update_qty->bind_param("ii", $qty, $cartId);
    $update_qty_result = $update_qty->execute();

    if ($update_qty_result) {
        // Mise à jour réussie
        // Rediriger ou afficher un message de confirmation
        header("Location: cart.php");
        exit();
    } else {
        // Erreur lors de la mise à jour
        // Afficher un message d'erreur
        echo "Error updating quantity.";
    }
}

if (isset($_POST['delete'])) {
    $cartId = $_POST['cart_id'];

    // Supprimer un produit du panier
    $delete_item = $mysqli->prepare("DELETE FROM `cart` WHERE id = ?");
    if (!$delete_item) {
        die('Error: ' . $mysqli->error);
    }
    $delete_item->bind_param("i", $cartId);
    $delete_item_result = $delete_item->execute();

    if ($delete_item_result) {
        // Suppression réussie
        // Rediriger ou afficher un message de confirmation
        header("Location: cart.php");
        exit();
    } else {
        // Erreur lors de la suppression
        // Afficher un message d'erreur
        echo "Error deleting item.";
    }
}

if (isset($_GET['delete_all'])) {
    // Supprimer tous les produits du panier
    $delete_all = $mysqli->prepare("DELETE FROM `cart` WHERE user_id = ?");
    if (!$delete_all) {
        die('Error: ' . $mysqli->error);
    }
    $delete_all->bind_param("i", $userId);
    $delete_all_result = $delete_all->execute();

    if ($delete_all_result) {
        // Suppression réussie
        // Rediriger ou afficher un message de confirmation
        header("Location: cart.php");
        exit();
    } else {
        // Erreur lors de la suppression
        // Afficher un message d'erreur
        echo "Error deleting all items.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart</title>
    <link href="../css/cart.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- Barre de navigation -->
<?php include 'navbar.php'; ?>
<?php if (empty($searchQuery) && empty($_GET['category'])): ?>
<section class="products shopping-cart">

    <h3 class="heading">shopping cart</h3>

    <div class="box-container">

        <?php
        $total = 0; // Variable pour calculer le total du panier

        // Récupérer les produits du panier pour l'utilisateur connecté
        $get_cart_items = $mysqli->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        if (!$get_cart_items) {
            die('Error: ' . $mysqli->error);
        }
        $get_cart_items->bind_param("i", $userId);
        $get_cart_items->execute();
        $cart_items_result = $get_cart_items->get_result();

        while ($cart_item = $cart_items_result->fetch_assoc()) {
            $cartId = $cart_item['id'];
            $name = $cart_item['name'];
            $price = $cart_item['price'];
            $qty = $cart_item['quantity'];
            $image_1 = $cart_item['image_1'];
            $sub_total = $price * $qty;
            $total += $sub_total; // Ajouter le sous-total au total

            ?>
            <form action="" method="post" class="box">
                <input type="hidden" name="cart_id" value="<?= $cartId ?>">
                <a href="" class="fas fa-eye"></a>
                <img src="../uploaded_img/<?= $image_1 ?>" alt="">
                <div class="name"><?= $name ?></div>
                <div class="flex">
                    <div class="price">£<?= $price ?></div>
                    <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $qty ?>">
                    <button type="submit" class="fas fa-edit" name="update_qty">edit</button>
                </div>
                <div class="sub-total">sub total: <span>£<?= $sub_total ?></span></div>
                <input type="submit" value="delete item" onclick="" class="delete-btn" name="delete">
            </form>
        <?php } ?>

    </div>

    <div class="cart-total">
        <p>Total : <span>£<?= $total ?></span></p>
        <a href="index.php" class="option-btn">continue shopping</a>
        <a href="cart.php?delete_all" class="delete-btn" onclick="">delete all item</a>
        <a href="checkout.php" class="btn">proceed to checkout</a>
    </div>

</section>
<?php elseif ((isset($_GET['search']) || isset($_GET['category'])) && empty($products)): ?>
<!-- Display a message when no search results or category is found -->
<div id="main-content">
    <h1 class="heading">No results found!</h1>
</div>
<?php endif; ?>
</body>
</html>
