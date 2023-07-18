<?php
$is_invalid = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/connecdb.php";
    $sql = sprintf("SELECT * FROM admin WHERE email = '%s'",
        $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST["password"], $user["password"])) {
            session_start();
            $_SESSION["user_id"] = $user["ID_Admin"];

            header("Location: admin-view.php");
            exit;
        }
    }


    $is_invalid = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <link href="../css/admin-login.css" rel="stylesheet" type="text/css"/>
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
                <div class="bout">
                    <a href="../html/User_Selection.html" onclick="submitForm(event,'backButton')">
                        <button class="white" id="backButton">
                            <img src="../image/arrow-left.png" width="25" height="auto">
                            <label class="back">BACK</label>
                        </button>
                    </a>
                    <a href="index_admin.php" id="continue" onclick="submitForm(event)">
                        <button class="black">
                            <label class="CONTINUE">CONTINUE</label>
                            <img src="../image/arrows-right.png" width="25">
                        </button>
                    </a>
                </div>
            </form>
        </div>
        <div class="logo">
            <img src="../image/logo.png" alt="Logo">
        </div>
    </div>
    <div class="right-side">
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
<script>
    function submitForm(event, buttonId) {
        if (buttonId === 'backButton') {
            // Perform specific action for the 'backButton'
            window.location.href = '../html/User_Selection.html'; // Redirect to User_Selection.html
            event.preventDefault(); // Prevent the default action of the anchor tag
        } else {
            event.preventDefault(); // Prevent the default action of the anchor tag
            document.querySelector('form').submit();
        }
    }
</script>
</body>
</html>
