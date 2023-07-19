<?php
session_start();
$mysqli = require __DIR__ . "/connecdb.php";

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["user_type"])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION["user_id"];
$userType = $_SESSION["user_type"];

$message = '';

if (isset($_POST['update'])) {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $dateofbirth = $_POST['dateofbirth'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update the profile information based on the user type
    if ($userType === 'seller') {
        $update_profile = $mysqli->prepare("UPDATE `seller` SET firstname = ?, lastname = ?, dateofbirth = ?, email = ?, phone = ? WHERE ID_Seller = ?");
        $update_profile->bind_param("sssssi", $firstname, $lastname, $dateofbirth, $email, $phone, $userId);
        $update_profile->execute();
    } else {
        $update_profile = $mysqli->prepare("UPDATE `buyer` SET firstname = ?, lastname = ?, dateofbirth = ?, email = ?, phone = ? WHERE ID_Buyer = ?");
        $update_profile->bind_param("sssssi", $firstname, $lastname, $dateofbirth, $email, $phone, $userId);
        $update_profile->execute();
    }

    $message = 'Profile updated successfully!';
}

// Fetch user profile
if ($userType === 'seller') {
    $select_profile = $mysqli->prepare("SELECT firstname, lastname, dateofbirth, email, phone FROM `seller` WHERE ID_Seller = ?");
} else {
    $select_profile = $mysqli->prepare("SELECT firstname, lastname, dateofbirth, email, phone FROM `buyer` WHERE ID_Buyer = ?");
}

$select_profile->bind_param("i", $userId);
$select_profile->execute();
$result = $select_profile->get_result();

$profile = null; // Initialize the $profile variable

if ($result->num_rows > 0) {
    $profile = $result->fetch_assoc();
}

$select_profile->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Profile</title>
    <link href="../css/profile.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- Navigation Bar -->
<?php include 'navbar.php'; ?>

<?php if (empty($searchQuery) && empty($_GET['category'])): ?>
    <!-- Main Content -->
    <div CLASS="box-principal">
        <div class="box-update-profile">
            <div class="category-title">
                <br>
                <label class="title-1"> Update Profile</label>
            </div>
            <div class="bar-random">
                <!-- This bar is just for styling purposes -->
            </div>
            <section class="update-profile">
                <?php if ($profile !== null): ?>
                    <form action="" method="post">
                        <span>First Name</span>
                        <input type="text" name="firstname" id="firstname" required class="box" maxlength="100"
                               value="<?= isset($profile['firstname']) ? $profile['firstname'] : ''; ?>">
                        <span>Last Name</span>
                        <input type="text" name="lastname" id="lastname" required class="box" maxlength="100"
                               value="<?= isset($profile['lastname']) ? $profile['lastname'] : ''; ?>">
                        <span>Date Of Birth</span>
                        <input type="date" name="dateofbirth" id="dateofbirth" required class="box"
                               value="<?= isset($profile['dateofbirth']) ? $profile['dateofbirth'] : ''; ?>">
                        <span>Email</span>
                        <input type="email" name="email" id="email" required class="box"
                               value="<?= isset($profile['email']) ? $profile['email'] : ''; ?>">
                        <span>Phone</span>
                        <input type="tel" name="phone" id="phone"  class="box"
                               value="<?= isset($profile['phone']) ? $profile['phone'] : ''; ?>">
                        <div class="flex-btn">
                            <input type="submit" name="update" class="updatebtn" value="Update">
                            <a href="profile.php" class="option-btn">Go Back</a>
                        </div>
                    </form>
                    <?php if (!empty($message)): ?>
                        <p class="message"><?= $message; ?></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="empty">No profile found!</p>
                <?php endif; ?>
            </section>
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
