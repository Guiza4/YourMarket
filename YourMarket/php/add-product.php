<?php
?>
<!DOCTYPE html>
<head>
    <title>Add product</title>
    <link href="../css/add-product.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- Barre de navigation -->
<div id="navbar">
    <div class="nav-logo">
        <img src="../image/logo-2.png" alt="Logo" height="64" width="222">
    </div>
    <div class="nav-search">
        <input type="text" id="search-bar" placeholder="Search...">
    </div>
    <a href="#">
        <div class="nav-categorie">
            <img src="../image/categorie.png" width="25" height="49">
            <span>Category</span>
        </div>
    </a>
    <a href="#">
        <div class="nav-account">
            <img src="../image/account.png" width="30" height="32">
            <span>Account</span>
        </div>
    </a>
    <a href="#">
        <div class="nav-cart">
            <img src="../image/cart.png" width="38" height="34">
            <span>Cart</span>
        </div>
    </a>
</div>
<!-- Contenu principal -->
<div CLASS="box-principal">
    <div class="box-add-product">
        <div class="category-title">
            <br>
            <label class="title-1"> Add Product</label>
        </div>
        <div class="bar-random">
            <!--cette bare ne sert completment a rien mais ca fait class et c marant a faire-->
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="flex">
                <div class="inputBox">
                    <span>Product name (required)</span>
                    <input type="text" class="box" required maxlength="100" placeholder="Enter Product Name"
                           name="name">
                </div>
                <div class="inputBox">
                    <span>Product Price (required)</span>
                    <input type="number" min="0" class="box" required max="9999999999" placeholder="Enter Product Price"
                           onkeypress="if(this.value.length == 10) return false;" name="price">
                </div>
                <div class="inputBox">
                    <span>Category (required)</span>
                    <input type="text" class="box" required maxlength="100" placeholder="Enter Product Category"
                           name="categorie">
                </div>
                <div class="inputBox">
                    <span>Stock (required)</span>
                    <input type="number"  min="1" class="box" required max="9999999999" placeholder="Enter Quantity"
                           name="stock">
                </div>
                <div class="inputBox">
                    <span>image 01 (required)</span>
                    <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box"
                           required>
                </div>
                <div class="inputBox">
                    <span>image 02 (required)</span>
                    <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box"
                           required>
                </div>
                <div class="inputBox">
                    <span>image 03 (required)</span>
                    <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box"
                           required>
                </div>
                <div class="inputBox">
                    <span>Product Details (required)</span>
                    <textarea name="details" placeholder="enter product details" class="box" required maxlength="500"
                              cols="30" rows="10"></textarea>
                </div>
            </div>

            <input type="submit" value="add product" class="btn" name="add_product">
        </form>
    </div>
</div>
</body>