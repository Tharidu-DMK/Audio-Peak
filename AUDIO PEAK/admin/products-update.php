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

		$pid = $_POST['pid'];
		$pid = filter_var($pid, FILTER_SANITIZE_STRING);
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
	 
		$update_product = $conn->prepare("UPDATE `products` SET name = ?, category = ?, price = ?, brand = ?, description = ? WHERE id = ?");
		$update_product->execute([$name, $category, $price, $brand, $des, $pid]);
	 
		$message[] = 'product updated!';
	 
		$old_image = $_POST['old_image'];
		$image = $_FILES['image']['name'];
		$image = filter_var($image, FILTER_SANITIZE_STRING);
		$image_size = $_FILES['image']['size'];
		$image_tmp_name = $_FILES['image']['tmp_name'];
		$image_folder = '../image/'.$image;
	 
		if(!empty($image)){
		   if($image_size > 2000000){
			  $message[] = 'images size is too large!';
		   }else{
			  $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
			  $update_image->execute([$image, $pid]);
			  move_uploaded_file($image_tmp_name, $image_folder);
			  unlink('../image/'.$old_image);
		   }
		}

        header('Location: products.php');
        exit;
	 
	}

?>





<section class="home-section">

<div class="home-nav">
    <span class="title">Products Update</span>
</div>

<div class="addbtn">
    <a href="./products.php">
        <button class="button">Back</button>
    </a>
</div>

<div class="form-box">
        <header>
            <h1 id="title">Update Product</h1>
        </header>
        <?php
			$update_id = $_GET['p-update'];
			$show_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
			$show_products->execute([$update_id]);
			if($show_products->rowCount() > 0){
				while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
		?>
            <form action="" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
				<input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">

                <input type="text" placeholder="Product name" name="name" maxlength="100" value="<?= $fetch_products['name']; ?>" />
                <input type="text" placeholder="Product brand" name="brand" maxlength="100" value="<?= $fetch_products['brand']; ?>"/>
                <select name="category" class="select"  >
					<option selected value="<?= $fetch_products['category']; ?>"><?= $fetch_products['category']; ?></option>
					<option value="headpone">Headpone</option>
					<option value="earphone">Earphone</option>
					<option value="earbuds">Earbuds</option>
					<option value="b-speakers">B-speakers</option>
				</select>
                <input type="number" placeholder="Product price" name="price" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['price']; ?>"/>
                <textarea rows="5" placeholder="Description" name="des"  rows="5" value="<?= $fetch_products['description']; ?>" /></textarea>
                <input type="file" name="image" class="input" accept="image/jpg, image/jpeg, image/png, image/webp"  >
                <div class="f-buttons">
                <button name="update" class="btn2">Update</button>
                </div>

            </form>
        <?php
				}
			}else{
				echo '<p class="empty">no products added yet!</p>';
			}
		?>
    </div>

<?php 
	include '../components/admin/footer.php';
?>