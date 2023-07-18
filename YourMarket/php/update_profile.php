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
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $dateofbirth = $_POST['dateofbirth'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

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

    <?php if ($userType === "seller"): ?>
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
<!-- Contenu principal -->
<div CLASS="box-principal">
    <div class="box-update-profile">
        <div class="category-title">
            <br>
            <label class="title-1"> Update Profile</label>
        </div>
        <div class="bar-random">
            <!-- Cette barre ne sert complètement à rien, mais ça fait classe et c'est marrant à faire -->
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
</body>
</html>
