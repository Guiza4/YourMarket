<?php

session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

</head>
<body>
<h1>Home</h1>
<?php if (isset($_SESSION["user_id"])): ?>
    <p>You are logged in.</p>
    <p><a href="logout.php">Log out</a> </p>
<?php else:
    header("Location: login_admin.php");
    exit;?>
<?php endif; ?>

</body>
</html>