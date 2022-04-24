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
<?php
    require_once('../admin/db.php');
    $id = $name = $description = '';
    $numberofrooms = 0;
    $id_error = $name_error = $numberofrooms_error = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $input_id = trim($_POST['id']);
        if (empty($input_id)) {
            $id_error = '*Vui lòng nhập mã phòng ban.';
        } else {
            $id = $input_id;
        }

        $input_name = trim($_POST['name']);
        if (empty($input_name)) {
            $name_error = '*Vui lòng nhập tên phòng ban.';
        } else {
            $name = $input_name;
        }

        $description = $_POST['description'];

        $input_numberofrooms = trim($_POST['numberofrooms']);
        if (!ctype_digit($input_numberofrooms)) {
            $numberofrooms_error = '*Vui lòng nhập số không âm.';
        } else {
            $numberofrooms = $input_numberofrooms;
        }

        if (empty($id_error) && empty($name_error) && empty($numberofrooms_error)) {
            $sql = 'insert into department (id, name, description, numberofrooms) values (?, ?, ?, ?)';
            $conn = connect_db();
            $stmt = $conn -> prepare($sql);
            $stmt->bind_param("sssi", $param_id, $param_name, $param_description, $param_numberofrooms);
            
            $param_id = $id;
            $param_name = $name;
            $param_description = $description;
            $param_numberofrooms = $numberofrooms;
            if ($stmt->execute()) {
                header('location: index-department.php');
                exit();
            } else {
                echo 'Xảy ra lỗi, vui lòng thử lại.';
            }
            // mysqli_stmt_close($stmt);
            // mysqli_close($conn);
        } 
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
	<title>Add department</title>
</head>
<body>
    <?php include '../partial/header.php'?>
    
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
        <header class="text-center bg-light text-success py-3 rounded mt-3 mb-3">
            <h3 class="display-5 font-weight-bold">THÊM PHÒNG BAN</h3>
        </header>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-group">
                    <label for="id">Mã phòng ban:</label>
                    <input type="text" name="id" class="form-control" value="<?= $id ?>">
                    <span class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="name">Tên phòng ban:</label>
                    <input type="text" name="name" class="form-control">
                    <span class="text-danger"><?php echo $name_error; ?></span>
                </div>
                <div class="form-group">
                    <label for="description">Mô tả:</label>
                    <textarea name="description" class="form-control"><?= $description ?></textarea>
                </div>
                <div class="form-group">
                    <label for="numberofrooms">Số phòng:</label>
                    <input type="number" name="numberofrooms" class="form-control" value="<?= $numberofrooms ?>">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="Thêm mới">
                    <a href="index-department.php" class="btn btn-secondary">Quay lại</a>
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