<?php
session_start();
$mysqli = require __DIR__ . "/connecdb.php";

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["user_type"])) {
    header("Location: login.php");
    exit;
}

$userType = $_SESSION["user_type"];
$userId = $_SESSION["user_id"];

if (isset($_POST['order'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $flat = $_POST['flat'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $pin_code = $_POST['pin_code'];

    // Retrieve the products from the user's cart
    $select_cart = $mysqli->prepare("SELECT * FROM cart WHERE user_id = ?");
    $select_cart->bind_param("i", $userId);
    $select_cart->execute();
    $cart_result = $select_cart->get_result();

    // Check if the cart is not empty
    if ($cart_result->num_rows > 0) {
        // Set the variable to store the complete order details
        $order_details = '';

        // Create an order for each product in the cart
        while ($cart_item = $cart_result->fetch_assoc()) {
            $ID_Article = $cart_item['ID_Article'];
            $productName = $cart_item['name'];
            $price = $cart_item['price'];
            $quantity = $cart_item['quantity'];
            $image_1 = $cart_item['image_1'];

            // Insert a new order into the "orders" table
            $insert_order = $mysqli->prepare("INSERT INTO orders (user_id, name, number, email, method, address, total_products, total_price, placed_on)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $insert_order->bind_param("issssssi", $userId, $name, $number, $email, $method, $address, $total_products, $total_price);

            // Build the product string for the order
            $product_details = "$productName x $quantity (Price: £" . number_format($price, 2) . ")";

            // Add the product details to the complete order
            $order_details .= $product_details . "<br>";

            // Calculate the total price for the order
            $total_price = $price * $quantity;

            // Insert a new entry into the "historique" table
            $insert_historique = $mysqli->prepare("INSERT INTO historique (user_id, ID_Article, name, price, quantity, image_1)
    VALUES (?, ?, ?, ?, ?, ?)");
            $insert_historique->bind_param("iissis", $userId, $ID_Article, $productName, $price, $quantity, $image_1);
            // Execute the insertion queries
            $insert_order->execute();
            $insert_historique->execute();

            // Delete the item from the user's cart after placing the order
            $delete_from_cart = $mysqli->prepare("DELETE FROM cart WHERE user_id = ? AND ID_Article = ?");
            $delete_from_cart->bind_param("ii", $userId, $ID_Article);
            $delete_from_cart->execute();
        }

        // Redirect to an order confirmation page or another appropriate page
        header('Location: index.php');
        exit;
    } else {
        // Display an error message if the cart is empty
        echo "Your cart is empty, please add items before placing an order.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>checkout</title>
    <link href="../css/checkout.css" rel="stylesheet" type="text/css">
</head>
<body>

<!-- Navigation Bar -->
<?php include 'navbar.php'; ?>
<?php if (empty($searchQuery) && empty($_GET['category'])): ?>
    <section class="checkout-orders">
        <form action="" method="POST">
            <h3>Your Orders</h3>
            <div class="display-orders">
                <?php
                $grand_total = 0;
                $select_cart = $mysqli->prepare("SELECT * FROM cart WHERE user_id = ?");
                $select_cart->bind_param("i", $userId);
                $select_cart->execute();
                $cart_result = $select_cart->get_result();

                while ($cart_item = $cart_result->fetch_assoc()) {
                    $productName = $cart_item['name'];
                    $price = $cart_item['price'];
                    $quantity = $cart_item['quantity'];
                    $image_1 = $cart_item['image_1'];
                    $total_price_item = $price * $quantity;
                    $grand_total += $total_price_item;
                    ?>
                    <div class="order-item">
                        <div class="order-item-details">
                            <span class="item-name"><?php echo $productName; ?></span>
                            <span class="item-quantity">Quantity: <?php echo $quantity; ?></span>
                            <span class="item-price">Price: £<?php echo number_format($price, 2); ?></span>
                            <span class="item-total">Total: £<?php echo number_format($total_price_item, 2); ?></span>
                        </div>
                    </div>
                <?php } ?>
                <div class="grand-total">Grand total: <span>£<?php echo number_format($grand_total, 2); ?></span></div>
            </div>
            <h3>Place Your Orders</h3>
            <div class="flex">
                <div class="inputBox">
                    <span>Your Name:</span>
                    <input type="text" name="name" placeholder="Enter your name" class="box" maxlength="20" required>
                </div>
                <div class="inputBox">
                    <span>Your Number:</span>
                    <input type="number" name="number" placeholder="Enter your number" class="box" min="0" max="9999999999"
                           required>
                </div>
                <div class="inputBox">
                    <span>Your Email:</span>
                    <input type="email" name="email" placeholder="Enter your email" class="box" maxlength="50" required>
                </div>
                <div class="inputBox">
                    <span>Payment Method:</span>
                    <select name="method" class="box" required>
                        <option value="credit card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Address Line 01:</span>
                    <input type="text" name="flat" placeholder="E.g. Flat number" class="box" maxlength="50" required>
                </div>
                <div class="inputBox">
                    <span>Address Line 02:</span>
                    <input type="text" name="street" placeholder="E.g. Street name" class="box" maxlength="50">
                </div>
                <div class="inputBox">
                    <span>City:</span>
                    <input type="text" name="city" placeholder="E.g. Mumbai" class="box" maxlength="50" required>
                </div>
                <div class="inputBox">
                    <span>State:</span>
                    <input type="text" name="state" placeholder="E.g. Maharashtra" class="box" maxlength="50" required>
                </div>
                <div class="inputBox">
                    <span>Country:</span>
                    <input type="text" name="country" placeholder="E.g. India" class="box" maxlength="50" required>
                </div>
                <div class="inputBox">
                    <span>Pin Code:</span>
                    <input type="number" min="0" name="pin_code" placeholder="E.g. 123456" min="0" max="999999" class="box"
                           required>
                </div>
            </div>
            <input type="submit" name="order" class="btn" value="Place Order">
        </form>
    </section>
<?php elseif ((isset($_GET['search']) || isset($_GET['category'])) && empty($products)): ?>
    <!-- Display a message when no search results or category is found -->
    <div id="main-content">
        <h1 class="heading">No results found!</h1>
    </div>
<?php endif; ?>
</body>
</html>
