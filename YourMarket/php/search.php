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

// Tri des produits
if (isset($_GET['order_by'])) {
    $orderBy = $_GET['order_by'];
    if ($orderBy === 'name') {
        usort($products, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
    } elseif ($orderBy === 'price') {
        usort($products, function ($a, $b) {
            return $a['price'] - $b['price'];
        });
    }
}

// Direction du tri
if (isset($_GET['order_direction'])) {
    $orderDirection = $_GET['order_direction'];
    if ($orderDirection === 'desc') {
        $products = array_reverse($products);
    }
}

return $products;
?>
