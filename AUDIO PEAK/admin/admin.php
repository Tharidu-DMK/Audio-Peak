<?php 
    include '../components/db-connect.php';
	include '../components/admin/header.php';
    include '../components/admin/sidebar.php';

    session_start();

	$admin_id = $_SESSION['admin_id'];
	if(!isset($admin_id)){
		header('location:admin-login.php');
		}

    if(isset($_POST['add'])){

		$name = $_POST['name'];
		$name = filter_var($name, FILTER_SANITIZE_STRING);
		$pass = sha1($_POST['pass']);
		$pass = filter_var($pass, FILTER_SANITIZE_STRING);

		$select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
		$select_admin->execute([$name]);
		
		if($select_admin->rowCount() > 0){
		   $message[] = 'username already exists!';
		}else{
		    $insert_admin = $conn->prepare("INSERT INTO `admin`(name, password) VALUES(?,?)");
			$insert_admin->execute([$name, $pass]);
			$message[] = 'new admin registered!';
		}
	}


	if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
        $delete_admin->execute([$delete_id]);
        header('location:admin.php');
	}
    
?>


<div class="addup-container-1">
    <div class="form-box">
        <header>
            <h1 id="title">New Admin</h1>
        </header>
        <form action="" method="POST">
            <input type="text" placeholder="User Name" name="name" maxlength="20" required="" oninput="this.value = this.value.replace(/\s/g, '')"/>
            <input type="password" placeholder="Password" name="pass" maxlength="20" required="" oninput="this.value = this.value.replace(/\s/g, '')"/>
            <div class="f-buttons">
              <button class="btn1" onclick="closePopup()">Back</button>
              <button name="add" class="btn2">Add</button>
            </div>
        </form>
    </div>
</div>


<section class="home-section">

    <div class="home-nav">
        <span class="title">Admin</span>
    </div>

    <div class="addbtn">
        <button class="button" onclick="showPopup()">Add</button>
    </div>

    <div class="responsive-table" >
        <table>
            <thead>
                <tr>
                    <td>Id</td>
                    <td>User name</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $select_account = $conn->prepare("SELECT * FROM `admin`");
                    $select_account->execute();
                    if($select_account->rowCount() > 0){
                        while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
                ?>
                <tr>
                    <td data-label="Id"><?= $fetch_accounts['id']; ?></td>
                    <td data-label="Name"><?= $fetch_accounts['name']; ?></td>
                    <td data-label="Status">
                        <?php
                            if($fetch_accounts['id'] == $admin_id){
                                echo '
                                    <a href="admin-update.php">
                                        <button class="btn-up">Update</button>
                                    </a>';
                            }
                            else{
                                echo '<span></span>';
                            }
                        ?>
                        <a href="#" onclick="adminDeleteAlert(<?= $fetch_accounts['id']; ?>)">
                            <button class="btn-de">Delete</button>
                        </a>
                    </td>
                </tr>
                <?php
                        }
                    }else{
                        echo '<p class="empty">no accounts available</p>';
                    }
                ?>
            </tbody>     
        </table>
    </div>


<?php 
	include '../components/admin/footer.php';
?>