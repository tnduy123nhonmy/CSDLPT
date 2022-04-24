<?php
    //check neu ko phai admin thi chuyen ve page index
	session_start();
	require_once('../function.php');
    if (!isset($_SESSION['user'])) {
        header('Location: ../login.php');
        exit();
    }else{
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
            header('Location: ../changepass.php');
            exit();
        }
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
    if (isset($_POST['deleteID']) && !empty($_POST['deleteID'])) {
        require_once('../admin/db.php');
        $sql = 'delete from account where id = ?';
        $conn = connect_db();
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = trim(($_POST['deleteID']));
            if (mysqli_stmt_execute($stmt)) {
                header('location: /user/managestaff.php');
                exit();
            } else {
                echo 'Xảy ra lỗi, vui lòng thử lại.';
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style.css">
	<title>Delete User</title>
</head>
<body>
	<?php include '../partial/header.php'?>

	<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center mt-3 mb-3">Xóa tài khoản</h3>
            <form method="POST" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <p class="alert alert-danger">Bạn chắc chắn muốn xóa nhân viên có mã <?= $_GET['deleteID'] ?> không?</p>
                <div class="form-group">
                    <!-- <label for="id">Mã phòng ban:</label> -->
                    <input type="hidden" name="deleteID" class="form-control" value="<?= $_GET['deleteID'] ?>">
                </div> 
                <div class="form-group text-center">
                    <input type="submit" class="btn btn-danger" value="Xóa">
                    <a href="/user/managestaff.php" class="btn btn-secondary">Quay lại</a>
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
	<?php include '../partial/footer.php'?>

</body>
</html>