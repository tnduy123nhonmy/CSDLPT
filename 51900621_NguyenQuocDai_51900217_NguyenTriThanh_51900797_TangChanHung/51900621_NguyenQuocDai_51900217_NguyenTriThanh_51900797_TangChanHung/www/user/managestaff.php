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

	$conn = connect_db();
	$sql = "select * from account where role != 1";
	$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<title>Manage Staff</title>
</head>
<body>
	<?php include '../partial/header.php'?>

	<div class="container">
		<header class="text-center bg-light text-primary py-3 rounded">
			<h3 class="display-5 font-weight-bold mb-1 ">QUẢN LÝ TÀI KHOẢN NHÂN VIÊN</h3>
		</header>

		<a href="./addUser.php">
			<button id="create" class="btn btn-success mt-3 mb-3">THÊM NHÂN VIÊN</button>
		</a>

		<div class="table-responsive">
			<table class="table ">
				<thead class="thead-light">
					<tr class="text-center">
						<th>ID</th>
						<th>Username</th>
						<th>Fullname</th>
						<th>Email</th>
						<th>Position</th>
						<th>Department</th>
						<th>Operation</th>
						
					</tr>
				</thead>
			<?php
				while (($row = $result -> fetch_assoc())) {
					$id = $row['id'];
					$username = $row['username'];
					$name = $row['name'];
					$email = $row['email'];
					$phone = $row['phone'];
					$level = $row['levels'];
					$phongban = $row['phongban'];
			?>
			<tbody>
				<tr class="text-center">
					<td><?= $id ?></td>
					<td><?= $username ?></td>
					<td><?= $name ?></td>
					<td><?= $email ?></td>
					<?php if($level == "Trưởng phòng"){?>
						<td class="text-danger font-weight-bold"><?= $level ?></td>
					<?php }else{?>
						<td class=""><?= $level ?></td>
					<?php }?>
					<td><?= $phongban ?></td>
					<td class="text-center ">
						<a href="./detailUser.php?detailID=<?=  $id; ?>" class="btn btn-primary "><i class="fas fa-list"></i></a>
						<a href="./editUser.php?updateID=<?=  $id; ?>" class="btn btn-warning "><i class="fas fa-edit"></i></a>
						<!-- <a href="deleteUser.php?deleteID=<?=  $id; ?>" class="btn btn-danger "><i class="fas fa-trash"></i></a> -->
					</td>
					
				</tr>
			</tbody>
			<?php
				}
			?>
			</table>
		</div>

	</div>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/1542f0c587.js" crossorigin="anonymous"></script>
	<script src="./main.js"></script>
	<?php include '../partial/footer.php'?>

</body>
</html>