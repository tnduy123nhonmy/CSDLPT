<?php
    //check neu ko phai truong phong thi chuyen ve page index
	session_start();
	require_once('../../admin/db.php');
    if (!isset($_SESSION['user'])) {
        header('Location: ../../login.php');
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
            header('Location: /changepass.php');
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
    $idDepartmentM = $data['MaPB'];

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
	<title>List Day-off</title>
</head>
<body>
	<?php include '../../partial/header.php'?>

	<div class="container">
		<header class="text-center bg-light text-primary py-3 rounded">
			<h3 class="display-5 font-weight-bold mb-1 ">QUẢN LÝ ĐƠN NGHỈ PHÉP</h3>
		</header>

		<a href="index-nghiphep.php" id="create" class="btn btn-secondary mt-3 mb-3">QUAY LẠI</a>
		<!-- <a href="add-manager.php" id="" class="btn btn-primary mt-3 mb-3">THÊM TRƯỞNG PHÒNG</a> -->

		<table class="table table-bordered ">
		<thead class="thead-light">
			<tr class="text-center">
				<th>Mã đơn</th>
                <th>Ngày tạo</th>
                <th>Mã nhân viên</th>
				<th>Tên nhân viên</th>
				<th>Ngày muốn nghỉ</th>
				<th>Ngày nghỉ còn lại</th>
                <th>Nghỉ từ ngày</th>
				<th>Trạng thái</th>
                <th>Chi tiết</th>
			</tr>
		</thead>
		<?php
			require_once('../../admin/db.php');
            $rolePerson = 3;
			$conn = connect_db();
			$sql = "SELECT * from dayOff where idDepartment=? and rolePerson=? ORDER BY dayApplyOff DESC, idStatus ASC ";
			$stm = $conn->prepare($sql);
            $stm->bind_param("si", $idDepartmentM, $rolePerson); 
            if (!$stm->execute()) {
                return array(
                    'code' => 2,
                    'message' => 'An error occured: ' . $stm->error,
                );
            }
            $result = $stm->get_result();
			while ($data = $result->fetch_assoc()) {
                $idDayOff = $data['idDayOff'];
                $idPerson = $data['idPerson'];
                $namePerson = $data['namePerson'];
                $dayOffWant = $data['dayOffWant'];
                $dayOffLeft = $data['dayOffLeft'];
                $dayOffFrom = $data['dayOffFrom'];
                $dayApplyOff = $data['dayApplyOff'];
                $Status = $data['Status'];
		?>
		<tr>
			<td><?= $idDayOff ?></td>
			<td><?= $dayApplyOff ?></td>
			<td><?= $idPerson ?></td>
			<td><?= $namePerson ?></td>
			<td><?= $dayOffWant ?></td>
            <td><?= $dayOffLeft ?></td>
            <td><?= $dayOffFrom ?></td>
            <?php if($Status == "Waiting"){?>
                <td class="text-warning font-weight-bold text-center"><?= $Status ?></td>
            <?php }?>
			<?php if($Status == "Approved"){?>
                <td class="text-success font-weight-bold text-center"><?= $Status ?></td>
            <?php }?>
			<?php if($Status == "Refused"){?>
                <td class="text-danger font-weight-bold text-center"><?= $Status ?></td>
            <?php }?>
			<td class="text-center">
				<a href="<?php echo 'details-nghiphep.php?id='.$idDayOff; ?>" class="btn btn-primary"><i class="fas fa-list"></i></a>

			</td>
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