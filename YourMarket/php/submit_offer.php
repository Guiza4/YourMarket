<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted offer details
    $item_id = $_POST['item_id'];
    $buyer_id = $_SESSION['user_id']; // Assuming you have the buyer's ID stored in the session
    $price = $_POST['price'];

    // Insert the offer into the database
    $insert_offer_query = "INSERT INTO offers (item_id, buyer_id, seller_id, price, status)
                         VALUES ('$item_id', '$buyer_id', '$seller_id', '$price', 'pending')";

    // Execute the query and check for success
    if ($mysqli->query($insert_offer_query)) {
        // Offer submitted successfully
        // You can redirect the user to a confirmation page or display a success message
        header("Location: offer_confirmation.php");
        exit();
    } else {
        // Error occurred while submitting the offer
        // Handle the error (e.g., display an error message)
        echo "Error: " . $mysqli->error;
    }
}
?>
