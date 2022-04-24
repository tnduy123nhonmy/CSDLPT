<?php
    //check neu ko phai admin thi chuyen ve page index
	session_start();
	require_once('../admin/db.php');
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
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css">
	<title>Department management</title>
</head>
<body>
	<?php include '../partial/header.php'?>

	<div class="container">
		<header class="text-center bg-light text-primary py-3 rounded">
			<h3 class="display-5 font-weight-bold mb-1 ">QUẢN LÝ PHÒNG BAN</h3>
		</header>

		<a href="add-department.php" id="create" class="btn btn-success mt-3 mb-3">THÊM PHÒNG BAN</a>
		<a href="add-manager.php" id="" class="btn btn-primary mt-3 mb-3">THÊM TRƯỞNG PHÒNG</a>

		<table class="table ">
		<thead class="thead-light">
			<tr class="text-center">
				<th>STT</th>
				<th>Mã phòng ban</th>
				<th>Tên phòng ban</th>
				<th>Mô tả</th>
				<th>Số phòng</th>
				<th>Thao tác</th>
			</tr>
		</thead>
		<?php
			require_once('../admin/db.php');
			$conn = connect_db();
			$sql = 'select * from department';
			$result = $conn -> query($sql);
			$i = 0;
			while (($row = $result -> fetch_assoc())) {
				$id = $row['id'];
				$name = $row['name'];
				$description = $row['description'];
				$numberofrooms = $row['numberofrooms'];
				$i += 1;
		?>
		<tr>
			<td class="text-center"><?= $i ?></td>
			<td class="text-center"><?= $id ?></td>
			<td class="text-center"><?= $name ?></td>
			<td><?= $description ?></td>
			<td class="text-center"><?= $numberofrooms ?></td>
			<td>
				<a href="<?php echo 'details-department.php?id='.$row['id']; ?>" class="btn btn-primary"><i class="fas fa-list"></i></a>
				<a href="<?php echo 'edit-department.php?id='.$row['id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
				<!-- <a href="" class="btn btn-danger"><i class="fas fa-trash"></i></a> -->
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
	<?php include '../partial/footer.php'?>

</body>
</html>