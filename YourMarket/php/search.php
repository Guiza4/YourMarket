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
} elseif (isset($_GET['category'])) {
    $category = $_GET['category'];
    $categoryQuery = 'SELECT * FROM article WHERE category = "' . $category . '" ORDER BY ID_Article DESC';
    $result = $mysqli->query($categoryQuery);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
}
