<? php ?>
<!DOCTYPE html>
<head>
    <title>Profile</title>
    <link href="../css/profile.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- Barre de navigation -->
<div id="navbar">
    <div class="nav-logo">
        <a CLASS="NAV" href="logout.php"><img src="../image/logo-2.png" alt="Logo" height="64" width="180"></a>
    </div>
    <div class="nav-search">
        <input type="text" id="search-bar" placeholder="Search...">
    </div>
    <a class="NAV" href="#">
        <div class="nav-categorie">
            <div class="nav-dropdown">
                <img src="../image/categorie.png" width="25" height="49">Category
                <div class="dropdown-content">
                    <a href="#">Phone</a>
                    <a href="#">Computer</a>
                    <a href="#">Watch</a>
                    <a href="#">Video-game</a>
                </div>
            </div>
        </div>
    </a>
    <a class="NAV" href="#">
        <div class="nav-account">
            <img src="../image/account.png" width="30" height="32">
            <span>Account</span>
        </div>
    </a>
    <a class="NAV" href="#">
        <div class="nav-cart">
            <img src="../image/cart.png" width="38" height="34">
            <span>Cart</span>
        </div>
    </a>
</div>
<div class="box-principal">
    <div class="box-profile">
        <div class="banniere">
            <div CLASS="profile-image">
                <div class="profile-image2">
                    <img src="../image/user.png" width="70%" HEIGHT="70%">
                </div>
            </div>
        </div>
        <div class="contenue">
            <div class="left-side">
                <div class="category-title">
                    <label class="title-1"> Personal Information</label>
                </div>
                <div class="bar-random">
                    <!--cette bare ne sert completment a rien mais ca fait class et c marant a faire-->
                </div>
                <div class="first-name">
                    First Name :
                </div>
                <div class="last-name">
                    Last Name :
                </div>
                <div class="date-of-birth">
                    Date of Birth :
                </div>
                <div class="category-title">
                    <label class="title-1">Contact</label>
                </div>
                <div class="bar-random">
                    <!--cette bare ne sert completment a rien mais ca fait class et c marant a faire-->
                </div>
                <div class="email">
                    Email :
                </div>
                <div class="phone-number">
                    Phone Number :
                </div>
                <a class="NAV" href="logout.php">
                    <div class="log-out">
                        <Center>LOG OUT</Center>
                    </div>
                </a>
            </div>
            <div class="middel">
                <div class="product">
                    <div class="category-title">
                        <label class="title-1">Activity</label>
                    </div>
                    <div class="bar-random">
                        <!--cette bare ne sert completment a rien mais ca fait class et c marant a faire-->
                    </div>

                </div>
            </div>
            <div class="right-side">
                <a class="NAV" href="logout.php">
                    <div class="change-setting">
                        <Center>Change setting</Center>
                    </div>
                </a>
            </div>
        </div>
    </div>

</div>
</body>

