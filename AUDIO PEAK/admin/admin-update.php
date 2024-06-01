<?php 
    include '../components/db-connect.php';
	include '../components/admin/header.php';
    include '../components/admin/sidebar.php';

	session_start();

	$admin_id = $_SESSION['admin_id'];
	if(!isset($admin_id)){
		header('location:admin-login.php');
	}

    if(isset($_POST['update'])){

		$name = $_POST['name'];
		$name = filter_var($name, FILTER_SANITIZE_STRING);
	 
		if(!empty($name)){
		   $select_name = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
		   $select_name->execute([$name]);
		   if($select_name->rowCount() > 0){
			  $message[] = 'username already taken!';
		   }else{
			  $update_name = $conn->prepare("UPDATE `admin` SET name = ? WHERE id = ?");
			  $update_name->execute([$name, $admin_id]);
		   }
		}
	 
		$empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
		$select_old_pass = $conn->prepare("SELECT password FROM `admin` WHERE id = ?");
		$select_old_pass->execute([$admin_id]);
		$fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
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
				 $update_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
				 $update_pass->execute([$confirm_pass, $admin_id]);
				 $message[] = 'password updated successfully!';
			  }else{
				 $message[] = 'please enter a new password!';
			  }
		   }
		}
        header('Location: admin.php');
        exit;
	 
	}


    
?>





<section class="home-section">

<div class="home-nav">
    <span class="title">Admin</span>
</div>

<div class="addbtn">
    <a href="./admin.php">
        <button class="button"> Back </button>
    </a>
</div>

<div class="form-box">
        <header>
            <h1 id="title">Update Admin</h1>
        </header>
        <form action="" method="POST">
            <input type="text" placeholder="User Name" name="name" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
            <input type="password" placeholder="Old Password" name="old_pass" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
            <input type="password" placeholder="New Password" name="new_pass" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
            <input type="password" placeholder="Confirm Password" name="confirm_pass" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
            <div class="f-buttons">
              <button name="update" class="btn2">Update</button>
            </div>
        </form>
    </div>


<?php 
	include '../components/admin/footer.php';
?>