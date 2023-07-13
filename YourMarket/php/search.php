<?php
$mysqli = require __DIR__ . "/connecdb.php";
$allproducts = $mysqli->query('SELECT * FROM article ORDER BY ID_Article DESC');
if (isset($GET['search']) and !empty($_GET['search'])) {
    $searchbar = htmlspecialchars($GET['search']);
    $allproducts = $mysqli->query('SELECT name FROM article WHERE name LIKE "%' . $searchbar . '%" ORDER BY ID_Article DESC');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Products</title>
    <meta charset="utf-8">
</head>
<body>
<form method="get">
    <input type="search" name="search" placeholder="Search Product" autocomplete="off">
    <input type="submit" name="send">
</form>

<section class="show_products">
    <?php
    if ($allproducts->rowCount() > 0) {
        while ($product = $allproducts->fetch()) {
            ?>
            <p><?= $product['name']; ?></p>
            <?php
        }
    } else {
        ?>
        <p>No Products Found !</p>
        <?php
    }
    ?>
</section>
</body>
</html>
