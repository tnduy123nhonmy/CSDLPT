<?php 
    session_start();    
    require_once('./admin/db.php');
    if (!isset($_SESSION['user'])) {
        header('Location: /index.php');
        exit();
    }
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];

        $sql = "SELECT * FROM account WHERE username=?";
		$conn = connect_db();
        $stm = $conn->prepare($sql);
        $stm->bind_param("s", $user);
            
            
		if (!$stm->execute()){
			die('can not execute: ' . $stm->error);
		}
        $result = $stm->get_result();
        $data = $result->fetch_assoc();
        if(password_verify($user, $data['password']) == true){
            header('Location: /changepass.php');
            exit();
        }
    }

    if (isset($_POST['op']) && isset($_POST['np'])
        && isset($_POST['c_np'])) {

        $op = $_POST['op'];
        $np = $_POST['np'];
        $c_np = $_POST['c_np'];
        
        if(empty($op)){
        header("Location: /changepassold.php?error=Old Password is required");
        exit();
        }else if(empty($np)){
        header("Location: /changepassold.php?error=New Password is required");
        exit();
        }else if($np !== $c_np){
        header("Location: /changepassold.php?error=The confirmation password  does not match");
        exit();
        }else if($op == $np){
            header("Location: /changepassold.php?error=Old password must be different from new password");
            exit();
        }else if (strlen($np) < 6) {
            header("Location: /changepassolda.php?error=New password must have at least 6 characters");
            exit();
        }
        else{
            // hashing the password
            $np = password_hash($np, PASSWORD_BCRYPT);

            $user = $_SESSION['user'];

            $sql = "SELECT *
                    FROM account WHERE 
                    username=?";
			$conn = connect_db();
            $stm = $conn->prepare($sql);
            $stm->bind_param("s", $user);
            
			if (!$stm->execute()){
				die('can not execute: ' . $stm->error);
			}
            $result = $stm->get_result();
            $data = $result->fetch_assoc();

            if($result->num_rows == 1 && password_verify($op, $data['password']) == true){
                $sql_2 = "UPDATE account SET password=? WHERE username=?";
                $stmt = $conn->prepare($sql_2);
                $stmt->bind_param("ss", $np, $user); // update mật khẩu mới đã hash

				if (!$stmt->execute()){
					die('can not execute: ' . $stmt->error);
				}

                $result = $stmt->get_result();
                header("Location: /changepassold.php?success=Your password has been changed successfully");
                exit();
            }else {
                header("Location: /changepassold.php?error=Incorrect password");
                exit();
            }
        }
    }
 ?>
<DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot password</title>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</head>
<body>
	<?php include './partial/header.php'?>

    <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                        <h3 class="modal-title text-center text-danger mt-5 mb-3 font-weight-bold bg-light">ĐỔI MẬT KHẨU</h3>
                        <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                            <div class="modal-body">
                                <div class="form-group">
                                        <label for="old-password">Mật khẩu cũ</label>
                                        <input type="password" name="op" placeholder="" class="form-control">
                                </div>
                                <div class="form-group">
                                        <label for="new-password">Mật khẩu mới</label>
                                        <input type="password" name="np" placeholder="" class="form-control">
                                </div>
                                <div class="form-group">
                                        <label for="confirm-password">Xác nhận mật khẩu</label>
                                        <input type="password" name="c_np" placeholder="" class="form-control">
                                </div>
                                <div class="form-group">
                                        <?php if (isset($_GET['error'])) { ?>
                                            <p class="error alert alert-danger"><?php echo $_GET['error']; ?></p>
                                        <?php } ?>    
                                        <?php if (isset($_GET['success'])) { ?>
                                            <p class="success alert alert-success"><?php echo $_GET['success']; ?></p>
                                        <?php } ?>
                                </div>
                            <button type="submit" class="btn btn-success px-4">Đổi mật khẩu</button>
                            <a href="index.php" class="btn btn-outline-secondary px-4">Home</a> 
                        </form>
                </div>
            </div>
    </div>
    </div>


</body>
</html>


