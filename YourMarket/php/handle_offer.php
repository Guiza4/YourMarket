<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offer_id = $_POST['offer_id'];
    $action = $_POST['action'];

    // Handle the different actions (accept, decline, counter offer)
    switch ($action) {
        case 'accept':
            // Update the offer status to "accepted"
            $update_offer_query = "UPDATE offers SET status = 'accepted' WHERE offer_id = ?";
            break;
        case 'decline':
            // Update the offer status to "declined"
            $update_offer_query = "UPDATE offers SET status = 'declined' WHERE offer_id = ?";
            break;
        case 'counter_offer':
            // Perform the necessary actions to handle the counter-offer
            // You can redirect the user to a separate page to handle the negotiation
            // or display a form to input the counter-offer price
            // ...
            break;
        default:
            // Invalid action
            // Handle the error (e.g., display an error message)
            echo "Invalid action";
            exit;
    }

    // Execute the update query and check for success
    $update_offer_stmt = $mysqli->prepare($update_offer_query);
    $update_offer_stmt->bind_param("i", $offer_id);

    if ($update_offer_stmt->execute()) {
        // Offer updated successfully
        // You can redirect the user to a confirmation page or display a success message
        header("Location: offer_updated.php");
        exit();
    } else {
        // Error occurred while updating the offer
        // Handle the error (e.g., display an error message)
        echo "Error: " . $mysqli->error;
    }
}
?>
