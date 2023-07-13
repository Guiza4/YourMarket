<?php
$mysqli = require __DIR__ . "/connecdb.php";
$products = [];

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchbar = htmlspecialchars($_GET['search']);
    $searchQuery = 'SELECT * FROM article WHERE name LIKE "%' . $searchbar . '%" ORDER BY ID_Article DESC';
    $result = $mysqli->query($searchQuery);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
}
?>
