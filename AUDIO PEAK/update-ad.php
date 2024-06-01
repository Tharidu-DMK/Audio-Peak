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

    if(isset($_POST['update'])){

        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
     
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $number = $_POST['number'];
        $number = filter_var($number, FILTER_SANITIZE_STRING);
        $address = $_POST['address'];
        $address = filter_var($address, FILTER_SANITIZE_STRING);
     
        if(!empty($name)){
           $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
           $update_name->execute([$name, $user_id]);
        }
     
        if(!empty($email)){
           $select_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
           $select_email->execute([$email]);
           if($select_email->rowCount() > 0){
              $message[] = 'email already taken!';
           }else{
              $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
              $update_email->execute([$email, $user_id]);
           }
        }
     
        if(!empty($number)){
           $select_number = $conn->prepare("SELECT * FROM `users` WHERE number = ?");
           $select_number->execute([$number]);
           if($select_number->rowCount() > 0){
              $message[] = 'number already taken!';
           }else{
              $update_number = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
              $update_number->execute([$number, $user_id]);
           }
        }
        if(!empty($address)){
            $update_address = $conn->prepare("UPDATE `users` SET address = ? WHERE id = ?");
            $update_address->execute([$address, $user_id]);
         }
        
        $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
        $select_prev_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
        $select_prev_pass->execute([$user_id]);
        $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
        $prev_pass = $fetch_prev_pass['password'];
        $old_pass = sha1($_POST['old_pass']);
        $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
        $new_pass = sha1($_POST['new_pass']);
        $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
        $confirm_pass = sha1($_POST['confirm_pass']);
        $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
     
        if($old_pass != $empty_pass){
           if($old_pass != $prev_pass){
              $message[] = 'old password not matched!';
           }elseif($new_pass != $confirm_pass){
              $message[] = 'confirm password not matched!';
           }else{
              if($new_pass != $empty_pass){
                 $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                 $update_pass->execute([$confirm_pass, $user_id]);
                 $message[] = 'password updated successfully!';
              }else{
                 $message[] = 'please enter a new password!';
              }
           }
        }  
        header('location:profile.php'); 
    }

?>



<section class="update-ad section" id="update-ad">

    <?php
        $uid = $_GET['uid'];
        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $select_profile->execute([$uid]);
        if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
    ?>
        

        <form  action=""method="post" class="form">
            <span class="signup">Update profile</span>
            <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" class="form--input" maxlength="50">
            <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="form--input" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input  type="tel" name="number" placeholder="<?= $fetch_profile['number']; ?>" class="form--input" min="0" max="9999999999" maxlength="10">
            <input type="text" name="address" placeholder="<?= $fetch_profile['address']; ?>" class="form--input" maxlength="255" >
            <input type="password" name="old_pass" placeholder="enter your old password" class="form--input" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="new_pass" placeholder="enter your new password" class="form--input" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="confirm_pass" placeholder="confirm your new password" class="form--input" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">

            <button name="update" class="form--submit">
                Update
            </button>

            <div class="form--marketing">
                <a href="profile.php">  <span>Go back</span></a>
            </div>
        </form>
    <?php
        }
    else{
        echo '<p class="empty">no products added yet!</p>';
        }
    ?> 


</section>



<?php 
	include './components/web/footer.php';
?>