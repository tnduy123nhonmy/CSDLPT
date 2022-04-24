<?php
    //check neu ko phai truong phong thi chuyen ve page index
	session_start();
	require_once('../../admin/db.php');
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css">
	<title>Day-off</title>
</head>
<body>
	<?php include '../../partial/header.php'?>

	<div class="container">
		<header class="text-center bg-light text-primary py-3 rounded">
			<h3 class="display-5 font-weight-bold mb-1 ">THÔNG TIN NGHỈ PHÉP</h3>
		</header>

		<a href="add-dayOff.php" id="create" class="btn btn-success mt-3 mb-3">TẠO ĐƠN NGHỈ PHÉP</a>
		<a href="list-nghiphep.php" id="" class="btn btn-primary mt-3 mb-3">ĐƠN CẦN DUYỆT</a>
		<a href="history-nghiphep.php" id="" class="btn btn-info mt-3 mb-3">LỊCH SỬ</a>

		<table class="table table-bordered ">
		<thead class="thead-light">
			<tr class="text-center">
				<th>Số ngày nghỉ phép</th>
				<th>Số ngày đã nghỉ</th>
				<th>Số ngày còn lại</th>
			</tr>
		</thead>
		<?php
			require_once('../../admin/db.php');
			$sql = "SELECT * FROM account WHERE username=?";
			$conn = connect_db();
			$stm = $conn->prepare($sql);
			$stm->bind_param("s", $user); 
			if (!$stm->execute()){
				die('can not execute: ' . $stm->error);
			}
			$result = $stm->get_result();
			while (($row = $result -> fetch_assoc())) {
				$dayOff = $row['dayOff'];
				$dayOffUsed = $row['dayOffUsed'];
				$dayOffLeft = $dayOff - $dayOffUsed;
		?>
		<tr>
			<td class="text-center"><?= $dayOff ?></td>
			<td class="text-center"><?= $dayOffUsed ?></td>
			<td class="text-center"><?= $dayOffLeft ?></td>
			
		</tr>
		<?php
			} 
			mysqli_free_result($result);
		?>
	</table>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/1542f0c587.js" crossorigin="anonymous"></script>
	<script src="/main.js"></script>
	<?php include '../../partial/footer.php'?>

</body>
</html>