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




<!--==================== HOME ====================-->
         <section class="home section" id="home">
            <div class="home__container container grid">
               <div class="home__content">
                  <img src="dimg/home-img.png" alt="" class="home__img">
                  <h1 class="home__title">
                     <span>J</span>
                     <span>B</span>
                     <span>L</span>
                  </h1>
               </div>
               <p class="b-text">AUDIO-PEAK</p>
               <a href="#shop" class="home__button button">
                  Buy Now <i class="ri-flashlight-line"></i>
               </a>
               
               <div class="home__social">
                  <span class="home__social-text">FOLLOW US</span>
                  <div class="home__social-links">
                     <a href="" class="home__social-link"><i class="ri-instagram-line"></i></a>
                     <a href="" class="home__social-link"><i class="ri-facebook-line"></i></a>
                     <a href="" class="home__social-link"><i class="ri-whatsapp-line"></i></a>
                  </div>
               </div>
            </div>
         </section>

 
<!--==================== NEW ARRIVAL ====================-->
<section class="new section" id="new">
            <h2 class="section__title">NEW ARRIVAL</h2>
            <div class="new__container">
               <div class="new__swiper swiper">
                  <div class="swiper-wrapper">
                     <?php
                        $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 4");
                        $select_products->execute();
                        if($select_products->rowCount() > 0){
                              while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
                     ?>

                        <article class="new__article swiper-slide">
                        <img src="../image/<?= $fetch_products['image']; ?>" alt="" class="new__img">
                           <span class="new__model"><?= $fetch_products['name']; ?></span>
                        </article>

                     <?php
                              }
                        }else{
                              echo '<p class="empty">no products added yet!</p>';
                        }
                     ?>
                  </div>
               </div>
            </div>
         </section>

<!--==================== ABOUT ====================-->
         <section class="about section" id="about">
            <div class="about__container container grid">
               <div class="about__data">
                  <h2 class="section__title">ABOUT US</h2>
                  <p class="about__description">
                     We offer a curated selection of premium headphones 
                     and earphones to elevate your music, movies, and gaming experiences.
                     grab your one and discover the magic of audio! 
                     <br>
                     <br>
                      call us - 0125542853
                  </p>
               </div>
               <img src="dimg/about-img.png" alt="" class="about__img">
            </div>
         </section>



<!--==================== SHOP ====================-->
         <section class="shop section" id="shop">
            <h2 class="section__title">Shop</h2>
            <div class="products__container container grid">
               <?php
                  $select_products = $conn->prepare("SELECT * FROM `products`");
                  $select_products->execute();
                  if($select_products->rowCount() > 0){
                     while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
               ?>
                  <form action="" method="POST">
                     <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                     <article class="products__card">
                        <img src="../image/<?= $fetch_products['image']; ?>" alt="" class="products__img">
                        <h3 class="products__title"><?= $fetch_products['name']; ?></h3>
                        <span class="products__price"><?= $fetch_products['price']; ?></span>
                        <div class="products-overlay">
                        <a href="detail.php?pid=<?= $fetch_products['id']; ?>" class="button">View</a>
                           </div>
                     </article>
                  </form>
               <?php
                  }
               }else{
                  echo '<p class="empty">no products added yet!</p>';
               }
               ?>
            </div>
        </section>
         

<!--==================== SPONSOR ====================-->
<section class="sponsor section">
            <div class="sponsor__container container grid">
               <img src="dimg/sponsor-1.png" alt="" class="sponsor__img">
               <img src="dimg/sponsor-2.png" alt="" class="sponsor__img">
               <img src="dimg/sponsor-3.png" alt="" class="sponsor__img">
               <img src="dimg/sponsor-4.png" alt="" class="sponsor__img">
            </div>
         </section>         


<?php 
	include './components/web/footer.php';
?>