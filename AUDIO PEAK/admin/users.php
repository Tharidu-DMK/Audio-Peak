<?php
    include '../components/db-connect.php';
	include '../components/admin/header.php';
    include '../components/admin/sidebar.php';

    session_start();

	$admin_id = $_SESSION['admin_id'];
	if(!isset($admin_id)){
		header('location:admin-login.php');
		}

    if(isset($_GET['delete'])){
		$delete_id = $_GET['delete'];
		$delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
		$delete_users->execute([$delete_id]);
		$delete_order = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
		$delete_order->execute([$delete_id]);
		$delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
		$delete_cart->execute([$delete_id]);
		header('location:users.php');
	}


?>

<section class="home-section">

<div class="home-nav">
    <span class="title">Users</span>
</div>

<div class="responsive-table" >
    <table>
        <thead>
            <tr>
                <td>Id</td>
                <td>Name</td>
                <td>Email</td>
                <td>Tel-No</td>
                <td>Address</td>
                <td>Status</td>
            </tr>
        </thead>
        <tbody>
            <?php
				$select_account = $conn->prepare("SELECT * FROM `users`");
				$select_account->execute();
				if($select_account->rowCount() > 0){
					while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
			?>
                <tr>
                    <td data-label="Id"><?= $fetch_accounts['id']; ?></td>
                    <td data-label="Name"><?= $fetch_accounts['name']; ?></td>
                    <td data-label="Email"><?= $fetch_accounts['email']; ?></td>
                    <td data-label="Tel-No"><?= $fetch_accounts['number']; ?></td>
                    <td data-label="Address"><?= $fetch_accounts['address']; ?></td>
                    <td data-label="Status">
                        <a href="#" onclick="userDeleteAlert(<?= $fetch_accounts['id']; ?>)">
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