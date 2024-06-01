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

    if(isset($_POST['login'])){

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
     
        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
        $select_user->execute([$email, $pass]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);
     
        if($select_user->rowCount() > 0){
           $_SESSION['user_id'] = $row['id'];
           header('location:audio-peak.php');
        }else{
           $message[] = 'incorrect username or password!';
        }
     
    }

?>



<section class="login-register section" id="login-register">




<form action=""method="post" class="form">
    <span class="signup">Log in</span>
    <input type="email" name="email" required placeholder="Enter your email" class="form--input" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="password" name="pass" required placeholder="Enter your password" class="form--input" maxlength="10" oninput="this.value = this.value.replace(/\s/g, '')">

    <button name="login" class="form--submit">
       Log in
    </button>

    <div class="form--marketing">
        <a href="register.php">Not member? <span>Sign up</span></a>
    </div>
</form>



</section>



<?php 
	include './components/web/footer.php';
?>