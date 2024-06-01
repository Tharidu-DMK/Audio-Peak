<?php 
    include '../components/db-connect.php';
	include '../components/admin/header.php';
    include '../components/admin/sidebar.php';

    session_start();

	$admin_id = $_SESSION['admin_id'];

	if(!isset($admin_id)){
	header('location:admin-login.php');
	}
?>

<section class="home-section">

<div class="home-nav">
    <span class="title">Dashboard</span>
</div>

<div class="short-info">
    <div class="stat">
        <?php
            $total_erning = 0;
            $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE order_status = ?");
            $select_completes->execute(['completed']);
            while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                $total_erning += $fetch_completes['total_price'];
            }
        ?>
        <p class="number"><?= $total_erning; ?></p>
        <p class="label">Total Erning</p>
    </div>
    <div class="stat">
        <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            $numbers_of_orders = $select_orders->rowCount();
        ?>
        <p class="number"><?= $numbers_of_orders; ?></p>
        <p class="label">Completed Orders</p>
    </div>
    <div class="stat">
        <?php
            $select_products = $conn->prepare("SELECT * FROM `products`");
            $select_products->execute();
            $numbers_of_products = $select_products->rowCount();
        ?>
        <p class="number"><?= $numbers_of_products; ?></p>
        <p class="label">Products</p>
    </div>
    <div class="stat">
        <?php
            $select_users = $conn->prepare("SELECT * FROM `users`");
            $select_users->execute();
            $numbers_of_users = $select_users->rowCount();
        ?>
        <p class="number"><?= $numbers_of_users; ?></p>
        <p class="label">Users</p>
    </div>
    <div class="stat">
        <?php
            $total_pendings = 0;
            $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE order_status = ?");
            $select_pendings->execute(['pending']);
            while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                $total_pendings += $fetch_pendings['total_price'];
            }
        ?>
        <p class="number"><?= $total_pendings; ?></p>
        <p class="label">Pending Orders</p>
    </div>
</div>
    

    
<div class="products">
    <div class="products-container">
        <div class="image-container img-one">
            <img src="../dimg/favorite-2.png"/>
            <div class="overlay">
              <h3>aa</h3>
            </div>
        </div>

        <div class="image-container img-two">
            <img src="../dimg/favorite-1.png"/>
            <div class="overlay">
              <h3>aa</h3>
            </div>
        </div>

        <div class="image-container img-three">
            <img src="../dimg/favorite-3.png" />
            <div class="overlay">
              <h3>aa</h3>
            </div>
        </div>

        <div class="image-container img-four">
            <img src="../dimg/favorite-4.png"/>
            <div class="overlay">
              <h3>aa</h3>
            </div>
        </div>

        <div class="image-container img-five">
            <img src="../dimg/favorite-1.png"/>
            <div class="overlay">
              <h3>aa</h3>
            </div>
        </div>

        <div class="image-container img-six">
            <img src="../dimg/favorite-2.png"/>
            <div class="overlay">
              <h3>aa</h3>
            </div>
        </div>
    </div>
</div>



<?php 
	include '../components/admin/footer.php';
?>