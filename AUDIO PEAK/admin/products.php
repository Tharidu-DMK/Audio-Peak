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
		$price = $_POST['price'];
		$price = filter_var($price, FILTER_SANITIZE_STRING);
		$category = $_POST['category'];
		$category = filter_var($category, FILTER_SANITIZE_STRING);
		$brand = $_POST['brand'];
		$brand = filter_var($brand, FILTER_SANITIZE_STRING);
		$des = $_POST['des'];
		$des = filter_var($des, FILTER_SANITIZE_STRING);

		$image = $_FILES['image']['name'];
		$image = filter_var($image, FILTER_SANITIZE_STRING);
		$image_size = $_FILES['image']['size'];
		$image_tmp_name = $_FILES['image']['tmp_name'];
		$image_folder = '../image/'.$image;

		$select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
		$select_products->execute([$name]);

		if($select_products->rowCount() > 0){
			$message[] = 'product name already exists!';
		}else{
			if($image_size > 2000000){
				$message[] = 'image size is too large';
			}else{
				move_uploaded_file($image_tmp_name, $image_folder);

				$insert_product = $conn->prepare("INSERT INTO `products`(name, category, price, image, brand, description) VALUES(?,?,?,?,?,?)");
				$insert_product->execute([$name, $category, $price, $image, $brand, $des]);

				$message[] = 'new product added!';
			}

		}

	}


    if(isset($_GET['delete'])){

		$delete_id = $_GET['delete'];
		$delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
		$delete_product_image->execute([$delete_id]);
		$fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
		unlink('../uploaded_img/'.$fetch_delete_image['image']);
		$delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
		$delete_product->execute([$delete_id]);
		$delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
		$delete_cart->execute([$delete_id]);
		header('location:products.php');
		$message[] = ' product deleted';

	}

?>

<div class="addup-container-1">
    <div class="form-box">
        <header>
            <h1 id="title">Add Product</h1>
        </header>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="text" placeholder="Product name"  name="name" maxlength="100" required=""/>
            <input type="text" placeholder="Product brand" name="brand" maxlength="100" required=""/>
            <select name="category" class="select"  required="">
				<option value="" disabled selected>Category</option>
				<option value="headpone">Headpone</option>
				<option value="earphone">Earphone</option>
				<option value="earbuds">Earbuds</option>
				<option value="b-speakers">B-speakers</option>
			</select>
            <input type="number" placeholder="Product price" name="price" onkeypress="if(this.value.length == 10) return false;" required=""/>
            <textarea rows="5" placeholder="Description" name="des"  rows="5" required="" /></textarea>
            <input type="file" name="image" class="input" accept="image/jpg, image/jpeg, image/png, image/webp" required="" >
            <div class="f-buttons">
              <button class="btn1" onclick="closePopup()">Back</button>
              <button name="add" class="btn2">Add</button>
            </div>
        </form>
    </div>
</div>



<section class="home-section">




<div class="home-nav">
    <span class="title">Products</span>
	
</div>


<div class="addbtn">
    <button class="button" onclick="showPopup()">Add</button>
</div>

<div class="responsive-table" >
    <table>
        <thead>
            <tr>
              <th>ID</th>
              <th>Product image</th>
              <th>Product Brand</th>
              <th>Product Category</th>
              <th>Product Name</th>
              <th>Price</th>
              <th>Description</th>
              <th colspan="2">Action</th>
            </tr>
        </thead>
         <tbody>
            <?php
				$show_products = $conn->prepare("SELECT * FROM `products`");
				$show_products->execute();
				if($show_products->rowCount() > 0){
					while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
			?>
                <tr>
                <td><?= $fetch_products['id']; ?></td>
                <td><img height='100px' src="../image/<?= $fetch_products['image']; ?>" alt=""></td>
                <td><?= $fetch_products['brand']; ?></td>
                <td><?= $fetch_products['category']; ?></td>
                <td><?= $fetch_products['name']; ?></td>
                <td><?= $fetch_products['price']; ?></td>
                <td style="width:300px;"><?= $fetch_products['description']; ?></td>
                <td>
                    <a href="products-update.php?p-update=<?= $fetch_products['id']; ?>">
                        <button class="btn-up" >update</button>
					</a> 
                </td>
                <td>
					<a href="#" onclick="productDeleteAlert(<?= $fetch_products['id']; ?>)">
                    	<button class="btn-de">Delete</button>
                	</a>
                </tr>
            <?php
					}
				}else{
					echo '<p class="empty">no products added yet!</p>';
				}
			?>
        </tbody>
    </table>
</div>

<?php 
	include '../components/admin/footer.php';
?>