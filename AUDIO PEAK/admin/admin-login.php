
<?php 
    include '../components/db-connect.php';
	include '../components/admin/header.php';

    session_start();

    if(isset($_POST['login'])){

        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
        $select_admin->execute([$name, $pass]);
        
        if($select_admin->rowCount() > 0){
            $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
            $_SESSION['admin_id'] = $fetch_admin_id['id'];
            header('location:dashboard.php');
        }
        else{
            $message[] = 'incorrect username or password!';
        }

    }
?>

<h1 class="backdrop" onclick="showLogin()">AUDIO PEAK</h1>
<div class="login-container">
    <div class="form-box">
        <header>
            <h1 id="title">Login</h1>
        </header>
        <form action="" method="POST">
            <input type="text" placeholder="User Name" name="name" required="" oninput="this.value = this.value.replace(/\s/g, '')" />
            <input type="password" placeholder="Password" name="pass" required=""  oninput="this.value = this.value.replace(/\s/g, '')" />
            <input type="submit" class="login-btn" value="Login" name="login">
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr/latest/toastr.min.js"></script>    
<script src="../js/admin.js"></script>

</body>
</html>