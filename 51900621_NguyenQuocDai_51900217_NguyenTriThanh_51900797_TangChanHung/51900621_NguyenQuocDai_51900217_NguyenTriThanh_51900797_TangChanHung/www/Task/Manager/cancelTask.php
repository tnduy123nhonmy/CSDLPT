<?php
    //check neu ko phai trưởng phòng thi chuyen ve page index
	session_start();
	require_once('../../admin/db.php');
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
            header('Location: ../../changepass.php');
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
	if ($_SESSION['role'] !== 2) {
		header("Location: ../../index.php");
		exit();
	}
    $idUSer = $data["id"];//mã nhân viên

    $idTask = $_GET['idTask'];
    $sql = "SELECT * FROM Task where idTask = ?";
    $conn = connect_db();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idTask);

	if (!$stmt->execute()) {
		return array(
			'code' => 2,
			'message' => 'An error occured: ' . $stmt->error,
		);
	}
	$result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $checkStatus = $data['idStatus']; //idStatus của nhân viên có mã lấy từ $_GET['idTask']
    //Nếu status đang khác New (!= 1) thì sẽ ko thể vào trang cancelTask bằng url
    if($checkStatus != 1){
        header('Location: index-task.php');
        exit();
    }
    
    $idStatus = 6;
    $statusTask = "Canceled";
    if($checkStatus == 1){ // Nếu idStatus là 1 (New) thì mới cancel được
        if (isset($_POST['idTask']) && !empty($_POST['idTask'])) {
            $sql = "UPDATE Task 
            SET idStatus=?, statusTask=? WHERE idManager=? and idTask=?";
            $conn = connect_db();
            $stm = $conn->prepare($sql);
            $stm->bind_param("isii", $idStatus, $statusTask, $idUSer, $_GET['idTask']);
                
            if (!$stm->execute()) {
                die('can not execute: ' . $stm->error);
            }
            header("location: ./index-task.php");
        }  
    }else{
        header("location: ./index-task.php");
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
	<title>Cancel Task</title>
</head>
<body>
	<?php include '../../partial/header.php'?>

	<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center mt-3 mb-3 display-5 font-weight-bold text-danger ">CANCEL TASK</h3>
            <form method="POST" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <p class="alert alert-danger">Bạn chắc chắn muốn hủy task có mã <?= $_GET['idTask'] ?> không?</p>
                <div class="form-group">
                    <!-- <label for="id">Mã phòng ban:</label> -->
                    <input type="hidden" name="idTask" class="form-control" value="<?= $_GET['idTask'] ?>">
                </div>
                <div class="form-group text-center">
                    <input type="submit" class="btn btn-danger" value="Xóa">
                    <a href="./index-task.php" class="btn btn-secondary px-3" >Quay lại</a>
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