<?php
    include '../components/db-connect.php';
	include '../components/admin/header.php';
    include '../components/admin/sidebar.php';

    session_start();

	$admin_id = $_SESSION['admin_id'];
	if(!isset($admin_id)){
		header('location:admin-login.php');
		}

    if(isset($_POST['update_status'])){

        $order_id = $_POST['order_id'];
        $order_status = $_POST['order_status'];
        $update_status = $conn->prepare("UPDATE `orders` SET order_status = ? WHERE id = ?");
        $update_status->execute([$order_status, $order_id]);
        $message[] = 'order status updated!';

    }

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
        $delete_order->execute([$delete_id]);
        header('location:orders.php');
    }

?>

<section class="home-section">

<div class="home-nav">
    <span class="title">Orders</span>
</div>

<div class="responsive-table" >
    <table>
        <thead>
              <tr>
                <th>ID</th>
                <th>Placed on</th>
                <th>Name</th>
                <th>Email</th>
                <th>Number</th>
                <th>Address</th>
                <th>Total product</th>
                <th>Total price</th>
                <th>Payment method</th>
                <th>Order status</th>
                <th colspan="2">Action</th>
              </tr>
        </thead>
        <tbody>
            <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders`");
                $select_orders->execute();
                if($select_orders->rowCount() > 0){
                    while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
            ?>
              <tr>
                <td><?= $fetch_orders['user_id']; ?></td>
                <td><?= $fetch_orders['placed_on']; ?></td>
                <td><?= $fetch_orders['name']; ?></td>
                <td style="width: 20px;"><?= $fetch_orders['email']; ?></td>
                <td><?= $fetch_orders['number']; ?></td>
                <td><?= $fetch_orders['address']; ?></td>
                <td><?= $fetch_orders['total_products']; ?></td>
                <td><?= $fetch_orders['total_price']; ?></td>
                <td><?= $fetch_orders['method']; ?></td>
                
                <td>
                <form action="" method="POST">
                    <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                    <select name="order_status" class="drop-down">
                        <option value="" selected disabled><?= $fetch_orders['order_status']; ?></option>
                        <option value="pending">pending</option>
                        <option value="completed">completed</option>
                        <option value="deliverd">deliveard</option>
                    </select>
                </td>
                <td><button name="update_status" class="btn-up" >Update</button></td>
                </form>
                <td>    
                <a href="#" onclick="orderDeleteAlert(<?= $fetch_orders['id']; ?>)">
                    <button class="btn-de">Delete</button>
                </a>
                </td>
			  </tr>
            <?php
                    }
                }else{
                     echo '<p class="empty">no orders placed yet!</p>';
                }
            ?>
        </tbody>      
    </table>
</div>

<?php 
	include '../components/admin/footer.php';
?>