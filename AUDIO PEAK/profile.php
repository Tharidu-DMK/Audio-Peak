<?php 
    include './components/db-connect.php';
	include './components/web/header.php';
    
    session_start();

   if(isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
   }else{
      $user_id = '';
   };

   include './components/web/add-cart.php';
   include './components/web/nav.php';

?>



<section class="profile-order section" id="profile-order">
    <?php
        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $select_profile->execute([$user_id]);
        if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
    ?>
        <div class="wrapper-1">
            <div class="card-1">
                <div class="card-1-info">
                <h2 class="name"><?= $fetch_profile['name']; ?></h2>
                    <p><span>Email:</span> <?= $fetch_profile['email']; ?></p>
                    <p><span>Location:</span> <?= $fetch_profile['number']; ?></p>
                    <p><span>Occupation:</span> <?= $fetch_profile['address']; ?></p>
                </div>
            </div>
            <div class="button-container-1">
                <a href="logout.php" class="detail__button button">Logout</a>
                &nbsp;&nbsp;
                <a href="update-ad.php?uid=<?= $fetch_profile['id']; ?>" class="detail__button button">Update</a>
            </div>        
        </div>
        <div class="wrapper-2">
            <?php
                if($user_id == ''){
                    echo '<p class="empty">please login to see your orders</p>';
                }else{
                    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
                    $select_orders->execute([$user_id]);
                    if($select_orders->rowCount() > 0){
                        while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
            ?>
                <div class="card-2">
                    <div class="card-2-info">
                        <p>PLACED ON : <span><?= $fetch_orders['placed_on']; ?></span></p>
                        <p>Name : <span><?= $fetch_orders['name']; ?></span></p>
                        <p>Email : <span><?= $fetch_orders['email']; ?></span></p>
                        <p>Number : <span><?= $fetch_orders['number']; ?></span></p>
                        <p>Address : <span><?= $fetch_orders['address']; ?></span></p>
                        <p>Payment method : <span><?= $fetch_orders['method']; ?></span></p>
                        <p>Your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
                        <p>Total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span></p>
                        <p>Payment status : <span style="color:<?php if($fetch_orders['order_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['order_status']; ?></span> </p>
                    </div>
                </div>
            <?php
                  }
                  }else{
                     echo '<p class="empty">no orders placed yet!</p>';
                  }
                  }
               ?>        
        </div>
    <?php
        }else{
    ?>
        <div class="wrapper-1" style="height: 60vh;">
            <div class="card-1">
                <div class="card-1-info">
                <h4 class="name">Login or Register first !!</h4>
                </div>
            </div>
            <div class="button-container-1" >
                <a href="login.php" class="detail__button button">Login or Register</a>
            </div>        
        </div>
    <?php
    }
    ?>
</section>




<?php 
	include './components/web/footer.php';
?>