<?php 
    session_start();  
    require_once('./admin/db.php');  
    if (!isset($_SESSION['user'])) {
        header('Location: /login.php');
        exit();
    }
    if (isset($_POST['np']) && isset($_POST['c_np'])) {
        $user = $_SESSION['user'];
        $np = $_POST['np'];
        $c_np = $_POST['c_np'];
        
        
        if(empty($np)){
            header("Location: /changepass.php?error=New Password is required");
            exit();
        }
        else if($np !== $c_np){
            header("Location: /changepass.php?error=The confirmation password  does not match");
            exit();
        }
        else if (strlen($np) < 6) {
            header("Location: /changepass.php?error=New password must have at least 6 characters");
            exit();
        }
        else {
            // hashing the password
            $np = password_hash($np, PASSWORD_BCRYPT);

            $user = $_SESSION['user'];

            $sql = "UPDATE account SET password=? WHERE username=?";

            $conn = connect_db();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $np, $user); // update mật khẩu mới đã hash
			if (!$stmt->execute()){
				die('can not execute: ' . $stmt->error);
			}

            $sql_2 = "SELECT * FROM account where username = ?";
            $conn = connect_db();
            $stm = $conn->prepare($sql_2);
            $stm->bind_param("s", $_SESSION['user']);

            if (!$stm->execute()) {
                return array(
                    'code' => 2,
                    'message' => 'An error occured: ' . $stmt->error,
                );
            }

            $result = $stm->get_result();
            $data = $result->fetch_assoc();
            $_SESSION['role'] = $data['role'];
	        if ($_SESSION['role'] == 1) {
		        header("Location: user/managestaff.php");
		        exit();
	        }else if($_SESSION['role'] == 2){
                header("Location: Task/Manager/index-task.php");
                exit(); 
            }
            else{
                header("Location: Task/Employee/index-task.php");
                exit(); 
            }
            
        }
    }
 ?>
<DOCTYPE html>
<html lang="en">
<head>
    <title>Change password</title>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</head>
<body>
	<?php include './partial/header.php'?>

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
        <h3 class="modal-title text-center text-danger mt-5 mb-3 font-weight-bold bg-light">ĐỔI MẬT KHẨU</h3>
            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">

                <div class="form-group">
                        <label for="new-password">Mật khẩu mới</label>
                        <input type="password" name="np" placeholder="New Password" class="form-control">
                </div>

                <div class="form-group">
                    <label for="confirm-password">Xác nhận mật khẩu</label>
                    <input type="password" name="c_np" placeholder="Confirm New Password" class="form-control">
                </div>

                <div class="form-group">
                    <?php if (isset($_GET['error'])) { ?>
                    <p class="error alert alert-danger"><?php echo $_GET['error']; ?></p>
                    <?php } ?>    
                    <?php if (isset($_GET['success'])) { ?>
                    <p class="success alert alert-success"><?php echo $_GET['success']; ?></p>
                    <?php } ?>
                    <button type="submit" class="btn btn-success px-5">Đổi mật khẩu</button>
                </div>
            </form>
        </div>
    </div>


</body>
</html>
