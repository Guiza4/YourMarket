<?php
$is_invalid = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/connecdb.php";

    if (isset($_POST['usertype'])) {
        $userType = $_POST['usertype'];
        if ($userType === "seller") {
            $sql = sprintf("SELECT * FROM seller WHERE email = '%s'",
                $mysqli->real_escape_string($_POST["email"]));

            $result = $mysqli->query($sql);

            $user = $result->fetch_assoc();

            if ($user) {
                if (password_verify($_POST["password"], $user["password"])) {
                    session_start();
                    $_SESSION["user_id"] = $user["ID_Seller"];

                    header("Location: index.php");
                    exit;
                }
            }
        } else {
            $sql = sprintf("SELECT * FROM buyer WHERE email = '%s'",
                $mysqli->real_escape_string($_POST["email"]));

            $result = $mysqli->query($sql);

            $user = $result->fetch_assoc();

            if ($user) {
                if (password_verify($_POST["password"], $user["password"])) {
                    session_start();
                    $_SESSION["user_id"] = $user["ID_Buyer"];

                    header("Location: index.php");
                    exit;
                }
            }
        }
    }

    $is_invalid = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link href="../css/Clients-login.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container">
    <div class="left-side">
        <div class="login-form">
            <?php if ($is_invalid): ?>
                <h2>Invalid Login</h2>
            <?php else: ?>
                <h2>SIGN IN</h2>
            <?php endif; ?>

            <form method="post">
                <div>
                    <label for="email"></label>
                    <input type="email" name="email" id="email" placeholder="Email"
                           value="<?= htmlspecialchars(isset($_POST["email"]) ? $_POST["email"] : "") ?>">
                </div>
                <!--The value is used to keep the email in case of an invalid credential-->
                <div>
                    <label for="password"></label>
                    <input type="password" name="password" id="password" placeholder="Password">
                </div>
                <div>
                    <label for="seller"></label>
                    <input type="radio" name="usertype" id="seller" value="seller">seller
                    <label for="buyer"></label>
                    <input type="radio" name="usertype" id="buyer" value="buyer">buyer
                </div>
                <br>
                <div class="fp">
                    <label class="fp1"><a>Don't Have an Account ?</a>
                        <a href="../html/SignUp.html">SIGN UP</a></label>
                    <label class="fp2"><a href="../html/forgot-password.html">Forgot Password ?</a></label>
                </div>
                <br>
                <div class="bout">
                    <button class="white">
                        <a href="../html/User_Selection.html">
                            <img src="../image/arrow-left.png" width="25" height="auto">
                            <label class="back">BACK</label>
                        </a>
                    </button>
                    <button class="black">
                        <a href="index.php">
                            <label class="CONTINUE">CONTINUE</label>
                            <img src="../image/arrows-right.png" width="25">

                        </a>
                    </button>
                </div>
                <div class="social-login">
                    <h4>Or connect With Social Media</h4>
                    <a class="google" href="https://www.google.com/"><img src="../image/Google.png">Sign in with Google</a>
                    <a class="facebook" href="https://www.facebook.com/"><img src="../image/Facebook.png">Sign in with
                        Facebook</a>
                    <a class="apple" href="https://www.apple.com/"><img src="../image/apple.png">Sign in with Apple</a>
                </div>
        </div>
        <div class="logo">
            <img src="../image/logo.png" alt="Logo">
        </div>
    </div>
    <div class="right-side">
        <div class="logo-1">
            <center><img src="../image/logo-2.png"></center>
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