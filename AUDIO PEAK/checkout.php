<?php 
    include './components/db-connect.php';
	include './components/web/header.php';
    
    session_start();

   if(isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
   }else{
      $user_id = '';
   };

   include './components/web/nav.php';

    if(isset($_POST['order'])){

        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $number = $_POST['number'];
        $number = filter_var($number, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $method = $_POST['method'];
        $method = filter_var($method, FILTER_SANITIZE_STRING);
        $address = $_POST['address'];
        $address = filter_var($address, FILTER_SANITIZE_STRING);
        $total_products = $_POST['total_products'];
        $total_price = $_POST['total_price'];
     
        $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $check_cart->execute([$user_id]);
     
        if($check_cart->rowCount() > 0){
     
           if($address == ''){
              $message[] = 'please add your address!';
           }else{
              
              $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
              $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);
     
              $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
              $delete_cart->execute([$user_id]);
     
              $message[] = 'order placed successfully!';
              header('location:profile.php');
              exit;
           }
           
        }else{
           $message[] = 'your cart is empty';
        }
     
    }
     


?>

<section class="profile-order section" id="profile-order">
<h2 class="section__title">CHECKOUT</h2>

<form action="" method="POST">
    <div class="wrapper-1">
        <div class="card-1">
            <div class="card-1-info">
                <?php
                    $grand_total = 0;
                    $cart_items[] = '';
                    $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                    $select_cart->execute([$user_id]);
                    if($select_cart->rowCount() > 0){
                        while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                            $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
                            $total_products = implode($cart_items);
                            $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                ?>
        
                <p style="font-size: 1rem;">
                    <?= $fetch_cart['name']; ?> ---
                    (Rs:<?= $fetch_cart['price']; ?> 
                    x <?= $fetch_cart['quantity']; ?>)
                </p>
            
                <?php
                    }
                }else{
                    echo '<p class="empty">your cart is empty!</p>';
                    }
                ?>
            <h4 class="name">Grand total : Rs:<?= $grand_total; ?></h4>
            </div>
        </div>
        <div class="button-container-1">
            <a href="cart.php" class="detail__button button">Go to cart</a>
        </div>        
    </div>

    <?php
    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_profile->execute([$user_id]);
    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);  
    ?>

    <input type="hidden" name="total_products" value="<?= $total_products; ?>">
    <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
    <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
    <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
    <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
    <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">
    
    <div class="wrapper-2">
        <div class="card-2">
            <div class="card-2-info">
                <p><span>Name</span><?= $fetch_profile['name'] ?></p>
                <p><span>Tel-no</span></i><span><?= $fetch_profile['number'] ?></p>
                <p><span>Address</span><?= $fetch_profile['address'] ?></p>
                <select name="method" class="select"  required>
                        <option value="" disabled selected>select payment method --</option>
                        <option value="cash on delivery">cash on delivery</option>
                        <option value="credit card">credit card</option>
                </select>    
            </div>
        </div> 
        <input type="submit" value="Place order" class="button"  name="order">        
    </div>
</form>

</section>




<?php 
	include './components/web/footer.php';
?>