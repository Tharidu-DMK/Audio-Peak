
<header class="header" id="header">
    <nav class="nav container">
        <a href="audio peak.php" class="nav__logo">Audio Peak</a>
        <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
                <li><a href="audio-peak.php" class="nav__link ">Home</a></li>
                <li><a href="audio-peak.php" class="nav__link">Shop</a></li>
                <li><a href="profile.php" class="nav__link">Profile</a></li>
            </ul>
            <div class="nav__close" id="nav-close">
                  <i class="ri-close-fill"></i>
            </div>
        </div>
        <div class="nav__btns">
            <a href="cart.php">
                <div class="nav__cart" id="nav-cart">
                <?php
                     $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                     $count_cart_items->execute([$user_id]);
                     $total_cart_items = $count_cart_items->rowCount();
                  ?>
                    <i class="ri-shopping-bag-2-line"></i>
                    <span class="cart__count"><?= $total_cart_items; ?></span>
                </div>
            </a>
            <div class="nav__toggle" id="nav-toggle">
                <i class="ri-menu-4-line"></i>
            </div>
        </div>
    </nav>
</header>

<main class="main"></main>
