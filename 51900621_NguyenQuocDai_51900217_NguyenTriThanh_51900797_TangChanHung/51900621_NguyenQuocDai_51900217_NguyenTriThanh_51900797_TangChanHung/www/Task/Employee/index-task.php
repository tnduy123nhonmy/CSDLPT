<?php
    //check neu ko phai nhân viên thi chuyen ve page index
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
	if ($_SESSION['role'] !== 3) {
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
	<link rel="stylesheet" href="./style.css">
	<title>Task List</title>
</head>
<body>
	<?php include '../../partial/header.php'?>
	
	<div class="container">
		<header class="text-center bg-light text-primary py-3 rounded">
			<h3 class="display-5 font-weight-bold mb-1 ">DANH SÁCH TASK</h3>
		</header>

		<!-- <a href="add-department.php" id="create" class="btn btn-success mt-3 mb-3">THÊM TASK</a> -->

		<table class="table "> 
		<thead class="thead-light">
			<tr class="text-center">
				<th>Mã Task</th>
				<th>Tiêu đề</th>
				<th>Tên trưởng phòng</th>
				<th>Trạng thái</th>
				<th>Ngày tạo task</th>
				<th>Deadline</th>
				<th>Chi tiết</th>
			</tr>
		</thead>
		<?php
			$mapb = $data["MaPB"]; // Mã phòng ban của nhân viên đang trong phiên session login
            $id = $data["id"]; // Mã nhân viên đang trong phiên session login

			$sql = "SELECT * FROM Task where idDepartment = ? and idEmployee = ? ORDER BY idStatus ASC, timeTask DESC, idTask  DESC";
			$conn = connect_db();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("si", $mapb, $id);
			if (!$stmt->execute()) {
				return array(
					'code' => 2,
					'message' => 'An error occured: ' . $stmt->error,
				);
			}
			$result = $stmt->get_result();
			while ($data = $result->fetch_assoc()) { 
				$idTask = $data['idTask'];
				$titleTask = $data['titleTask'];
				$nameManager = $data['nameManager'];
				$statusTask = $data['statusTask'];
				$timeTask = $data['timeTask'];
				$deadline = $data['deadlineTask'];
				$idStatus = $data['idStatus'];
		?>
		<tr class="text-center">
			<?php if($idStatus != 6){ //Mở if: Nếu idStatus khác 6 (canceled) thì sẽ show list ra ?>
				<td><?= $idTask ?></td>
				<td><?= $titleTask ?></td>
				<td><?= $nameManager ?></td>

				<?php if($idStatus == 1){ // Đánh dấu màu sắc cho từng trạng thái để dễ phân biệt
				?>
					<td class="text-success font-weight-bold"><?= $statusTask ?></td>
				<?php }?>

				<?php if($idStatus == 2){
				?>
					<td class="text-primary font-weight-bold"><?= $statusTask ?></td>
				<?php }?>

				<?php if($idStatus == 6){
				?>
					<td class="text-secondary font-weight-bold"><?= $statusTask ?></td>
				<?php }?>

				<?php if($idStatus == 3){
				?>
					<td class="text-warning font-weight-bold"><?= $statusTask ?></td>
				<?php }?>

				<?php if($idStatus == 4){
				?>
					<td class="text-danger font-weight-bold"><?= $statusTask ?></td>
				<?php }?>

				<?php if($idStatus == 5){
				?>
					<td class="text-info font-weight-bold"><?= $statusTask ?></td>
				<?php }?>

				<td><?= $timeTask ?></td>
				<td><?= $deadline ?></td>
				<td class="text-center">
					<a href="details-task.php?id=<?= $idTask ?>" class="btn btn-primary"><i class="fas fa-list"></i></a>
				</td>
			<?php } // đóng if?>
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
	<script src="./main.js"></script>
	
</body>
</html>