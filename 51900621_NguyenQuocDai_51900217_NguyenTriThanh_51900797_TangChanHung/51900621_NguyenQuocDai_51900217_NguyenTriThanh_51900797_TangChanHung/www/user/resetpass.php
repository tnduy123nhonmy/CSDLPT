<?php
	//check neu ko phai admin thi chuyen ve page index
	session_start();
	require_once('../function.php');
    if (!isset($_SESSION['user'])) {
        header('Location: ../login.php');
        exit();
    }
	$sql = "SELECT * FROM account where username = ?";
    $conn = connect_db();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['user']);  

	if (!$stmt->execute()) {
		return array(
			'code' => 2,
			'message' => 'An error occured: ' . $stmt->error,
		);
	}
	$result = $stmt->get_result();
    $data = $result->fetch_assoc();

    $_SESSION['role'] = $data['role'];
	if ($_SESSION['role'] !== 1) {
		header("Location: ../index.php");
		exit();
	}

?>
<?php

    require_once('../admin/db.php');
    
    $id = $_GET['resetID'];

    $sql_2 = "SELECT * FROM account WHERE id = ?";
    $conn = connect_db();
    $stm = $conn->prepare($sql_2);
    $stm->bind_param("i", $_GET['resetID']);
    if (!$stm->execute()){
        die('can not execute: ' . $stm->error);
    }
    $result = $stm->get_result();
    $data = $result->fetch_assoc();

    $np = $data['username']; //reset password: gán mật khẩu mới giống với username
    $np = password_hash($np, PASSWORD_BCRYPT);

    $user = $data['username'];

    // update mật khẩu mới đã hash
    $sql = "UPDATE account SET password=? WHERE username=?";
    $conn = connect_db();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $np, $user); 
    if (!$stmt->execute()) {
		return array(
			'code' => 2,
			'message' => 'An error occured: ' . $stmt->error,
		);
	}
    header("Location: ./managestaff.php");

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style.css">
	<title>Reset password</title>
</head>
<body>
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center mt-3 mb-3">Reset mật khẩu</h3>
            <form method="POST" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <p class="alert alert-danger">Bạn chắc chắn muốn reset mật khẩu nhân viên này không?</p>
                <div class="form-group">
                    <!-- <label for="id">Mã phòng ban:</label> -->
                   
                </div>
                <div class="form-group text-center">
                    <input type="submit" class="btn btn-danger" value="Reset">
                    <a href="./managestaff.php" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/1542f0c587.js" crossorigin="anonymous"></script>
	<script src="/main.js"></script>
</body>
</html>