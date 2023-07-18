<?php
$mysqli = require __DIR__ . "/connecdb.php";

?>
<!DOCTYPE html>
<body>
<head>
    <title>Filter Products</title>
    <link href="../css/filter.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/filter.js"></script>
</head>
<h2>Filter Products</h2>
<form action="index.php" method="post">
    <div class="filter-container">
        <div class="filter-box">
            <p>Price</p>
            <input type="range" class="form-range" name="price" value="100" min="1" max="2500" id="customrange">
            <div class="pricebar">
                <span class="min-value">1</span>
                <span class="selected-value" contenteditable="true">100</span>
                <span class="max-value">2500</span>
            </div>
            <div class="namebtn">
                <p>Name</p>
                <input type="checkbox" class="filter-button" id="filter-alphabet"><label>Sort by Name</label>
            </div>
            <div class="brandbtn">
                <p>Brand</p>
                <input type="radio" value="Apple" name="brand" class="filter-radio"><label>Apple</label><br>
                <input type="radio" value="Samsung" name="brand" class="filter-radio"><label>Samsung</label><br>
                <input type="radio" value="Xiaomi" name="brand" class="filter-radio"><label>Xiaomi</label><br>
                <input type="radio" value="Sony" name="brand" class="filter-radio"><label>Sony</label><br>
                <input type="radio" value="HP" name="brand" class="filter-radio"><label>HP</label><br>
                <input type="radio" value="Asus" name="brand" class="filter-radio"><label>Asus</label><br>
                <input type="radio" value="Nintendo" name="brand" class="filter-radio"><label>Nintendo</label><br>
                <input type="radio" value="Microsoft" name="brand" class="filter-radio"><label>Microsoft</label><br>
            </div>
            <div class="sellingtypebtn">
                <p>Buying</p>
                <input type="radio" value="Buy Now" name="sellingtype" class="filter-radio"><label>Buy Now</label><br>
                <input type="radio" value="Best offer" name="sellingtype" class="filter-radio"><label>Best Offer</label><br>
                <input type="radio" value="Auction" name="sellingtype" class="filter-radio"><label>Auction</label><br>
            </div>
        </div>
    </div>
</form>

</body>

