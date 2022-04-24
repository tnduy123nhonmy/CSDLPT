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
    if (isset($_GET['id'])) {
        require_once('../admin/db.php');
        $sql = 'select * from department where id = ?';
        $conn = connect_db();
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_id);
            $param_id = trim(($_GET['id']));
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    $id = $row['id'];
                    $name = $row['name'];
                    $description = $row['description'];
                    $numberofrooms = $row['numberofrooms'];
                    $usernameTP = $row['usernameTP'];
                    $idUsername = $row['idUsername'];
                } else {
                    header('location: error.php');
                    exit();
                }
            } else { 
                echo 'Xảy ra lỗi, vui lòng thử lại.';
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        header('location: error.php');
        exit();
    }
     //lấy tên trưởng phòng ra từ table account
     $sql = "SELECT * FROM account where username = ?";
     $conn = connect_db();
     $stmt = $conn->prepare($sql);
     $stmt->bind_param("s", $usernameTP);
 
     if (!$stmt->execute()) {
         return array(
             'code' => 2,
             'message' => 'An error occured: ' . $stmt->error,
         );
     }
     error_reporting(E_ERROR | E_PARSE); // lệnh này dùng để ẩn warning ở web 
     $result = $stmt->get_result();
     $data = $result->fetch_assoc();
     $nameTP = $data['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css">
	<title>Details department</title>
</head>
<body>
    <?php include '../partial/header.php'?>
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <header class="text-center bg-light text-primary py-3 rounded mt-3">
                <h3 class="display-5 font-weight-bold mt-1 mb-1">XEM CHI TIẾT PHÒNG BAN</h3>
            </header>
            <form method="" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light mt-3">
                <div class="form-group">
                    <label for="id">Mã phòng ban:</label>
                    <input type="text" readonly="readonly" class="form-control" value="<?= $id ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="name">Tên phòng ban:</label>
                    <input type="text" readonly="readonly" class="form-control" value="<?= $name ?>">
                </div>
                <?php if($idUsername == 0){ ?>
                    <div class="form-group">
                        <label for="id">ID trưởng phòng:</label>
                        <input type="text" readonly="readonly" class="form-control" value="" readonly="readonly">
                    </div>
                <?php }else{?>
                    <div class="form-group">
                        <label for="id">ID trưởng phòng:</label>
                        <input type="text" readonly="readonly" class="form-control" value="<?= $idUsername ?>" readonly="readonly">
                    </div>
                <?php }?>
                <div class="form-group">
                    <label for="name">Tên trưởng phòng:</label>
                    <input type="text" readonly="readonly" class="form-control" value="<?= $nameTP ?>" >
                </div>
                <div class="form-group">
                    <label for="description">Mô tả:</label>
                    <textarea readonly="readonly" class="form-control" ><?= $description ?></textarea>
                </div>
                <div class="form-group">
                    <label for="numberofrooms">Số phòng:</label>
                    <input type="text" readonly="readonly" class="form-control" value="<?= $numberofrooms ?>">
                </div>
                <div class="form-group ">
                    <a href="<?php echo 'edit-department.php?id='.$row['id']; ?>" class="btn btn-warning">Chỉnh sửa</a>
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