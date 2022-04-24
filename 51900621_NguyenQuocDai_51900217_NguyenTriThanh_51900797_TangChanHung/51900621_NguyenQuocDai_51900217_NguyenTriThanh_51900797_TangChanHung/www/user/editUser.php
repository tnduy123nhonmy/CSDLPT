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
    $s_username = $s_email = $s_name = $s_phone = $s_gender = $s_birthday = $s_ethnic 
    = $s_cmnd = $s_level = $s_department = $s_address = $s_nation = $s_password = $_role = $id = "";
    
    require_once('../admin/db.php');
    $id = $_GET['updateID'];

    $sql_3 = "SELECT * FROM account where id = ?";
    $conn = connect_db();
    $stmt = $conn->prepare($sql_3);
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()){
        die('can not execute: ' . $stmt->error);
    }

    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $success = '';
    // echo ($id);
    if (isset($_POST)) { 
        // $success = 'Cập nhật thành công';
        //Nếu POST rỗng Gán biến bằng với giá trị cũ trong database
        if (empty($_POST['username'])) {
            $s_username = $data['username'];
        }

        if (empty($_POST['email'])) {
            $s_email = $data['email'];
        }

        if (empty($_POST['name'])) {
            $s_name = $data['name'];
        }

        if (empty($_POST['phone'])) {
            $s_phone = $data['phone'];
        }

        if (empty($_POST['gender'])) {
            $s_gender = $data['gender'];
        }

        if (empty($_POST['birthday'])) {
            $s_birthday = $data['birthday'];
        }

        if (empty($_POST['ethnic'])) {
            $s_ethnic = $data['ethnic'];
        }

        if (empty($_POST['cmnd'])) {
            $s_cmnd = $data['cmnd'];
        }

        if (empty($_POST['level'])) {
            $s_level = $data['levels'];
            $s_role = $data['role'];
        }

        if (empty($_POST['department'])) {
            $s_department = $data['phongban'];
        }

        if (empty($_POST['address'])) {
            $s_address = $data['address'];
        }

        if (empty($_POST['nation'])) {
            $s_nation = $data['nation'];
        }


        //Nếu POST ko rỗng Gán biến bằng với giá trị mới đã được nhập
        if (!empty($_POST['username'])) {
            $s_username = $_POST['username'];
            $s_password = $_POST['username']; // set mật khẩu mặc định giống với username
        }

        if (!empty($_POST['email'])) {
            $s_email = $_POST['email'];
        }

        if (!empty($_POST['name'])) {
            $s_name = $_POST['name'];
        }

        if (!empty($_POST['phone'])) {
            $s_phone = $_POST['phone'];
        }

        if (!empty($_POST['gender'])) {
            $s_gender = $_POST['gender'];
        }

        if (!empty($_POST['birthday'])) {
            $s_birthday = $_POST['birthday'];
        }

        if (!empty($_POST['ethnic'])) {
            $s_ethnic = $_POST['ethnic'];
        }

        if (!empty($_POST['cmnd'])) {
            $s_cmnd = $_POST['cmnd'];
        }

        if (!empty($_POST['level'])) {
            $s_level = $_POST['level'];
            if($s_level == "Nhân viên" ){
                $s_role = 3;
            }
            if($s_level == "Trưởng phòng") {
                $s_role = 2;
            }
            if(empty($s_level)){
                $s_role = $data['role'];
            }
        }

        if (!empty($_POST['department'])) {
            $s_department = $_POST['department'];
        }

        if (!empty($_POST['address'])) {
            $s_address = $_POST['address'];
        }

        if (!empty($_POST['nation'])) {
            $s_nation = $_POST['nation'];
        }
        // echo ($s_username);

        $sql_2 = "UPDATE account 
        SET username=?, email=?, name=?, phone=?, gender=?, birthday=?, cmnd=?, ethnic=?, 
        levels=?, phongban=?, address=?, nation=?, role=?  WHERE id=?";

        $conn = connect_db();
        $stm = $conn->prepare($sql_2);
        $stm->bind_param("ssssisisssssii", $s_username, $s_email, $s_name, $s_phone, $s_gender, $s_birthday, $s_cmnd, $s_ethnic, $s_level, $s_department, $s_address, $s_nation, $s_role, $id);
        // $success = 'Đã chỉnh sửa thành công';
        if (!$stm->execute()) {
            die('can not execute: ' . $stm->error);
        }
    }
    // header("Location: managestaff.php");   
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<title>Edit User</title>
</head>

<body>
	<?php include '../partial/header.php'?>

    <div class="container">
		<div class="panel panel-primary">
            
            <header class="text-center bg-light text-warning py-3 rounded mt-3">
                <h3 class="display-5 font-weight-bold">CHỈNH SỬA TÀI KHOẢN NHÂN VIÊN</h3>
            </header>
            <a href="./detailUser.php?detailID=<?=  $id; ?>" class="btn btn-primary mt-3">Chi tiết</a>
            <a href="<?php echo '../resetpass.php?resetID='.$id; ?>" class="btn btn-danger mt-3">Reset password</a>
            <div class="mt-3"></div>
                <div class="panel-body">
                    <form method="POST" class="border rounded w-100 mb-3 mx-auto px-3 pt-3 bg-light">
                        <div class="row register-form">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="username">Tài khoản:</label>
                                    <!-- <input type="number" name="id" value="<?=$id?>" style="display: none;"> -->
                                    <input  type="text" class="form-control" id="username" name="username" >
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="text" class="form-control" id="email" name="email" >
                                </div>
                                <div class="form-group">
                                    <label for="name">Họ và tên:</label>
                                    <input type="text" class="form-control" id="name" name="name" >
                                </div>
                                <div class="form-group">
                                    <label for="phone">Số Điện Thoại:</label>
                                    <input type="number" class="form-control" id="phone" name="phone" >
                                </div>
                                <div class="form-group">
                                    <label for="gender">Giới tính:</label>
                                    <select name="gender" class="form-control">
                                        <option value="">Select...</option>
                                        <option value="1">Nam</option>
                                        <option value="2">Nữ</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="birthday">Ngày sinh:</label>
                                    <input type="date" class="form-control" id="birthday" name="birthday" placeholder="dd/mm/yy">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cmnd">CMND:</label>
                                    <input type="number" class="form-control" id="cmnd" name="cmnd" >
                                </div>
                                <div class="form-group">
                                    <label for="ethnic">Dân tộc:</label>
                                    <input type="text" class="form-control" id="ethnic" name="ethnic" >
                                </div>
                                <div class="form-select mb-3"> 
                                    <label for="department" class="">Chức vụ:</label>
                                    <input type="text" class="form-control" readonly="readonly" placeholder="<?= $s_level ?>">
                                </div>
                                <div class="form-select mb-3"> 
                                    <label for="department" class="">Phòng ban:</label>
                                    <input type="text" class="form-control" readonly="readonly" placeholder="<?= $s_department ?>">
                                </div>
                                <div class="form-group">
                                    <label for="address">Địa chỉ:</label>
                                    <input type="text" class="form-control" id="address" name="address" >
                                </div>
                                <div class="form-group">
                                    <label for="nation">Quốc tịch:</label>
                                    <input type="text" class="form-control" id="nation" name="nation" >
                                </div>
                            </div>
                        </div>    
                        <?php
                            if (!empty($success)) {
                                echo "<div class='alert alert-success'>$success</div>";
                            }
                        ?>     
                        <a href="./managestaff.php"><button type="submit" class="btn btn-success mb-3">Cập nhật</button></a>
                        <a href="./managestaff.php" class="btn btn-secondary mb-3">Quay lại</a>
                    </form>
                </div>
            </div>
	    </div>
    </div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<?php include '../partial/footer.php'?>

</body>
</html>