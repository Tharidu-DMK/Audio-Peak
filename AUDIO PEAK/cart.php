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


	if(isset($_POST['delete'])){
		$cart_id = $_POST['cart_id'];
		$delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
		$delete_cart_item->execute([$cart_id]);
		$message[] = 'cart item deleted!';
	}

	 if(isset($_POST['update_qty'])){
		$cart_id = $_POST['cart_id'];
		$qty = $_POST['qty'];
		$qty = filter_var($qty, FILTER_SANITIZE_STRING);
		$update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
		$update_qty->execute([$qty, $cart_id]);
		$message[] = 'cart quantity updated';
	}

	$grand_total = 0;
?>


<section class="cart section">
	<div class="cart__container container">
		<h1>Shopping Cart</h1>
		<div class="shop">
			<?php
			$grand_total = 0;
			$select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
			$select_cart->execute([$user_id]);
			if ($select_cart->rowCount() > 0) {
				while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
			?>
					<form action="" method="POST">
						<input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
						<div class="box">
							<img src="../image/<?= $fetch_cart['image']; ?>" alt="">
							<div class="content">
								<h2 class="pname"><?= $fetch_cart['name']; ?></h2>
								<p>Price : <?= $fetch_cart['price']; ?></p>
								<p>Sub : <?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></p>
								<input type="number" name="qty" class="button" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
								<button type="submit" class="button" name="update_qty">U</button>
								<button class="cart_remove button"  name="delete" onclick="return confirm('delete this item?');"><i class="ri-delete-bin-fill"></i></button>
							</div>
						</div>
					</form>
				<?php
					$grand_total += $sub_total;
				}
				?>
		</div>
		<p>
			<span>Total Price</span>
			<span>Rs:<?= $grand_total; ?></span>
		</p>
		<div class="button-container-1">
			<a href="checkout.php" <?= ($grand_total > 1) ? '' : 'disabled'; ?> class="detail__button button">Checkout</a>
		</div>
	<?php
			} else {
				echo '
			<div class="wrapper-1" style="height: 40vh;">
				<div class="card-1">
					<div class="card-1-info">
					<h4 class="name">Your Cart is empty !!</h4>
					</div>
				</div>
				<div class="button-container-1" >
					<a href="audio-peak.php" class="detail__button button">Shop now</a>
				</div>        
			</div>
			';
			}
	?>

	</div>
	
	

</div>
    
</section>




<?php 
	include './components/web/footer.php';
?>