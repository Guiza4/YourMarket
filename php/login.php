<?php
$is_invalid = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/connecdb.php";

    $sql = sprintf("SELECT * FROM buyer
                    WHERE email = '%s'",
        $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST["password"], $user["password"])) {
            die("Login Successful");
        } else {

        }
    }

    $is_invalid = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

</head>
<body>
<h1>Login</h1>
<?php if ($is_invalid): ?>
    <em>Invalid Login</em>
<?php endif; ?>

<form method="post">
    <label for="email">email</label>
    <input type="email" name="email" id="email" value="<?= htmlspecialchars(isset($_POST["email"]) ? $_POST["email"] : "") ?>">

    <label for="password">password</label>
    <input type="password" name="password" id="password">

    <button>Log in</button>
</form>
</body>
</html>