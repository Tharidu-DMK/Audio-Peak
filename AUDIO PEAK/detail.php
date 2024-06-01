<?php 
   include './components/db-connect.php';
  
	include './components/web/header.php';
   

   session_start();

    if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    }else{
    $user_id = '';
    header('location:home.php');
    };
    include './components/web/add-cart.php';
    include './components/web/nav.php';
?>



  <!--==================== DETAIL ====================-->
  <section class="detail section" id="detail">
            <h2 class="section__title">PRODUCT DETAIL</h2>
            <?php
               $pid = $_GET['pid'];
               $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
               $select_products->execute([$pid]);
               if($select_products->rowCount() > 0){
                  while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
            ?>
               <div class="detail__container container grid">
                  <img src="../image/<?= $fetch_products['image']; ?>" alt="" class="detail__img">
                  <div class="detail__data">
                     <h1 class="detail__title"><?= $fetch_products['name']; ?></h1>
                     <h2 class="detail__price">Rs <?= $fetch_products['price']; ?></h2>
                     <p class="detail__description"><?= $fetch_products['brand']; ?> - <?= $fetch_products['category']; ?></p>
                     <p class="detail__description"><?= $fetch_products['description']; ?></p>
                     <form action="" method="post" class="hform" >
                     <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                           <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                           <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                           <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                           <input type="hidden" name="qty" class="q-qty" min="1" max="99" value="1" maxlength="2">
                           <button type="submit" name="add_to_cart" class="detail__button button" >Add to cart</button>
                     </form>
                    
                     <a href="audio-peak.php" class="detail__button button">
                        Back 
                     </a>
                  </div>
               </div>
            <?php
                  }
               }else{
                  echo '<p class="empty">no products added yet!</p>';
               }
            ?>
         </section>

         <!--==================== S PRODUCTS ====================-->
         <section class="s-products section" id="s-products">
            <h2 class="section__title">MORE TO SHOP</h2>
            <div class="s-products__container container grid">
               <?php
                  $sample_size = 3;
                  $sql = "SELECT id FROM `products` ORDER BY RAND() LIMIT $sample_size";
                  $random_products = $conn->prepare($sql);
                  $random_products->execute();

                  if ($random_products->rowCount() > 0) {
                  $product_ids = array();
                  while ($row = $random_products->fetch(PDO::FETCH_ASSOC)) {
                     $product_ids[] = $row['id'];
                  }

                  $in_clause = implode(',', array_fill(0, $sample_size, '?'));
                  $sql = "SELECT * FROM `products` WHERE id IN ($in_clause)";
                  $selected_products = $conn->prepare($sql);
                  $selected_products->execute($product_ids);

                  if ($selected_products->rowCount() > 0) {
                     while ($fetch_product = $selected_products->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <form action="" method="POST">
                        <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                        <article class="s-products__card">
                           <img src="../image/<?= $fetch_product['image']; ?>" alt="" class="s-products__img">
                           <h3 class="s-products__title"><?= $fetch_product['name']; ?></h3>
                           <span class="s-products__price"><?= $fetch_product['price']; ?></span>
                           <div class="s-products-overlay">
                              <a href="detail.php?pid=<?= $fetch_product['id']; ?>" class="button">View</a>
                           </div>
                        </article>
                        </form>
                        <?php
                     }
                  } else {
                     echo "No products found in the selected random sample.";
                  }
                  } else {
                  echo "Not enough products in the database (need at least 3).";
                  }
               ?>
            </div>
         </section>



<?php 
	include './components/web/footer.php';
?>