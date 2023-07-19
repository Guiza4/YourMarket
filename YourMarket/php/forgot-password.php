<?php
$is_updated = false;
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/connecdb.php";
    $email = $_POST["email"];
    $new_password = $_POST["new_password"];

    $select_user = $mysqli->prepare("SELECT * FROM seller WHERE email = ?");
    $select_user->bind_param("s", $email);
    $select_user->execute();
    $user_result = $select_user->get_result();
    $user = $user_result->fetch_assoc();

    if (!$user) {
        $select_user = $mysqli->prepare("SELECT * FROM buyer WHERE email = ?");
        $select_user->bind_param("s", $email);
        $select_user->execute();
        $user_result = $select_user->get_result();
        $user = $user_result->fetch_assoc();
    }

    if ($user) {
        // Mettre à jour le mot de passe dans la base de données
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $update_password = $mysqli->prepare("UPDATE seller SET password = ? WHERE ID_Seller = ?");
        $update_password->bind_param("si", $hashed_password, $user["ID_Seller"]);
        $update_password->execute();
        $update_password->close();

        $update_password = $mysqli->prepare("UPDATE buyer SET password = ? WHERE ID_Buyer = ?");
        $update_password->bind_param("si", $hashed_password, $user["ID_Buyer"]);
        $update_password->execute();
        $update_password->close();

        $is_updated = true;
    } else {
        $is_invalid = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change Password</title>
    <meta charset="UTF-8">
    <link href="../css/Clients-login.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container">
    <div class="left-side">
        <div class="login-form">
            <?php if ($is_updated): ?>
                <h2>Password Updated</h2>
                <p>Your password has been updated successfully.</p>
            <?php else: ?>
                <h2>Change Password</h2>
                <?php if ($is_invalid): ?>
                    <p class="error">Invalid email address. Please try again.</p>
                <?php endif; ?>
                <form method="post">
                    <div>
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email" required>
                    </div>
                    <div>
                        <label for="new_password">New Password:</label>
                        <input type="password" name="new_password" id="new_password" placeholder="Enter new password" required>
                    </div>
                    <div>
                        <button type="submit">Change Password</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
        <div class="logo">
            <a href="login.php"><img src="../image/logo.png" alt="Logo"></a>
        </div>
    </div>
    <div class="right-side">
        <div class="logo-1">
            <center><a href="login.php"><img src="../image/logo-2.png"></a></center>
        </div>
        <div class="Fout">
            <footer>
                <a href="mentions-legales.html">LEGAL</a>
                <a href="politique-confidentialite.html">PRIVACY CENTER</a>
                <a href="cookies.html">COOKIE</a>
                <a href="a-propos.html">ABOUT US</a>
            </footer>
        </div>
    </div>
</div>
</body>
</html>
