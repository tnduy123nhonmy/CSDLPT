<?php   
    //check neu ko phai admin thi chuyen ve page index
	session_start();
	require_once('../function.php');
    if (!isset($_SESSION['user'])) {
        header('Location: /login.php');
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
    $id = $_GET['id']; //id của trưởng phòng cần xóa
    if(isset($_POST['id']) && !empty($_POST['id'])){
        require_once('../admin/db.php');
        if($id != 0){
            $sql = "SELECT * FROM account where id=?";
            $conn = connect_db();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id );

            if (!$stmt->execute()) {
                return array(
                    'code' => 2,
                    'message' => 'An error occured: ' . $stmt->error,
                );
            }
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();

            $idDepartment = $data['MaPB'];
            $nameDepartment = $data['phongban'];
            $dayOff = $data['dayOff'] - 3;
            $dayOffLeft = $data['dayOffLeft'] - 3;

            $role = 3;
            $levels = "Nhân viên";
            // update bên account
            $sql = "UPDATE account SET role=?, levels=?, dayOff=?, dayOffLeft=? where id=?";
            $conn = connect_db();
            $stm = $conn->prepare($sql);
            $stm->bind_param("isiii", $role, $levels, $dayOff, $dayOffLeft, $id);   
            if (!$stm->execute()) {
                die('can not execute: ' . $stm->error);
            }

            $usernameTP = $idUsername = "";
            // update bên phòng ban
            $sql_2 = "UPDATE department  SET usernameTP=?, idUsername=? where name=?";
            $conn = connect_db();
            $stm = $conn->prepare($sql_2);
            $stm->bind_param("sis", $usernameTP, $idUsername, $nameDepartment);
                
            if (!$stm->execute()) {
                die('can not execute: ' . $stm->error);
            }
            header("location: index-department.php");
            exit();
        }else{
            header("location: <?php echo 'edit-department.php?id='.$idDepartment; ?>");
            exit();
        }
    }
    $sql = "SELECT * FROM account where id=?";
    $conn = connect_db();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id );

    if (!$stmt->execute()) {
        return array(
            'code' => 2,
            'message' => 'An error occured: ' . $stmt->error,
        );
    }
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    error_reporting(E_ERROR | E_PARSE); // lệnh này dùng để ẩn warning ở web 

    $idDepartment = $data['MaPB'];
    $nameDepartment = $data['phongban'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style.css">
	<title>Delete Manager</title>
</head>
<body>
    <?php include '../partial/header.php'?>
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center mt-3 mb-3">Xóa trưởng phòng</h3>
            <form method="POST" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <p class="alert alert-danger">Bạn chắc chắn muốn xóa chức vụ trưởng phòng có mã <?= $_GET['id'] ?> không?</p>
                <div class="form-group">
                    <!-- <label for="id">Mã phòng ban:</label> -->
                    <input type="hidden" name="id" class="form-control" value="<?= $_GET['id'] ?>">
                </div>
                <div class="form-group text-center">
                    <input type="submit" class="btn btn-danger" value="Xóa">
                    <a href="<?php echo 'edit-department.php?id='.$idDepartment; ?>" class="btn btn-secondary">Quay lại</a>
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