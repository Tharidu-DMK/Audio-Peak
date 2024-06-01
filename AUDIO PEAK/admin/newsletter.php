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
		$delete_email = $conn->prepare("DELETE FROM `newsletter` WHERE id = ?");
		$delete_email->execute([$delete_id]);
		header('location:newsletter.php');
	}

?>

<section class="home-section">

<div class="home-nav">
    <span class="title">Newsletter</span>
</div>

<div class="addbtn">
    <button class="button">Copy</button>
</div>

<div class="responsive-table" >
    <table>
        <thead>
            <tr>
                <td>Email</td>
            </tr>
        </thead>
        <tbody>
            <?php
				$select_newsletter = $conn->prepare("SELECT * FROM `newsletter`");
				$select_newsletter->execute();
				if($select_newsletter->rowCount() > 0){
					while($fetch_newsletter = $select_newsletter->fetch(PDO::FETCH_ASSOC)){
			?>
            <tr>
            	<td data-label="Id"><?= $fetch_newsletter['email']; ?></td>
			</tr>
            <?php
					}
				}else{
					echo '<p class="empty">you have no messages</p>';
				}
			?>
        </tbody> 
    </table>
</div>


<?php 
	include '../components/admin/footer.php';
?>