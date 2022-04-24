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
    require_once('../admin/db.php');
    $s_username = $s_email = $s_name = $s_phone = $s_gender = $s_birthday = $s_ethnic 
    = $s_cmnd = $s_level = $s_department = $s_address = $s_nation = $s_password = $_role = $s_dayOff = $s_image = "";
    
    
    if (!empty($_POST)) {
        if (isset($_POST['username'])) {
            $s_username = $_POST['username'];
            $s_password = $_POST['username'];
            
        }

        if (isset($_POST['email'])) {
            $s_email = $_POST['email'];
        }

        if (isset($_POST['name'])) {
            $s_name = $_POST['name'];
        }

        if (isset($_POST['phone'])) {
            $s_phone = $_POST['phone'];
        }

        if (isset($_POST['gender'])) {
            $s_gender = $_POST['gender'];
            if ($s_gender == 1) {
                $s_image = "male.jpg";
            } else {
                $s_image = "female.jpg";
            }
        }

        if (isset($_POST['birthday'])) {
            $s_birthday = $_POST['birthday'];
        }

        if (isset($_POST['ethnic'])) {
            $s_ethnic = $_POST['ethnic'];
        }

        if (isset($_POST['cmnd'])) {
            $s_cmnd = $_POST['cmnd'];
        }

        if (isset($_POST['level'])) {
            $s_level = $_POST['level'];
            if($s_level == "Nhân viên" ){
                $s_role = 3;
            }
            else if($s_level == "Trưởng phòng") {
                $s_role = 2;
            }
            else{
                $s_role = "";
            }
        }

        if (isset($_POST['department'])) {
            $s_department = $_POST['department'];
            $sql = "SELECT * FROM department WHERE name=?";
            $conn = connect_db();
            $stm = $conn->prepare($sql);
            $stm->bind_param("s", $s_department); 
            if (!$stm->execute()){
                die('can not execute: ' . $stm->error);
            }
            $result = $stm->get_result();
            $data = $result->fetch_assoc();
            $s_maPB = $data['id'];
        }

        if (isset($_POST['address'])) {
            $s_address = $_POST['address'];
        }

        if (isset($_POST['nation'])) {
            $s_nation = $_POST['nation'];
        }
        //Kiểm tra lỗi
        
        $sql = "SELECT username FROM account where username = ?";
        $conn = connect_db();
        $stm = $conn->prepare($sql);
        
        $stm->bind_param("s", $_POST['username']);

        if (!$stm->execute()) {
            return array(
                'code' => 2,
                'message' => 'An error occured: ' . $stm->error,
            );
        }
        $checkUser = $stm -> fetch(); // Check xem có username nào trùng với username mới tạo không
        $error = '';
        if ($checkUser){
            $error = 'This username is existed';
        }
        else if (empty($s_username)) {
            $error = 'Please enter username';
        }
        else if (empty($s_email)) {
            $error = 'Please enter email';
        }
        else if (empty($s_name)) {
            $error = 'Please enter name';
        }
        else if (empty($s_phone)) {
            $error = 'Please enter phone number';
        }
        else if (empty($s_gender)) {
            $error = 'Please enter gender';
        }
        else if (empty($s_birthday)) {
            $error = 'Please enter birthday';
        }
        else if (empty($s_ethnic)) {
            $error = 'Please enter ethnic';
        }
        else if (empty($s_cmnd)) {
            $error = 'Please enter identify number';
        }
        else if (empty($s_maPB)) {
            $error = 'Please enter id of department';
        }
        else if (empty($s_level)) {
            $error = 'Please enter position'; 
        }
        else if (empty($s_department)) {
            $error = 'Please enter department';
        }
        else if (empty($s_address)) {
            $error = 'Please enter address';
        }
        else if (empty($s_nation)) {
            $error = 'Please enter nation';
        }
        else if (strlen($s_cmnd) != 9){
            $error = 'Invalid identify number';
        }
        else if (strlen($s_phone) != 10){
            $error = 'Invalid phone number';
        }
        else{
            $s_dayOff = 12;
            $s_dayOffLeft = 12;
            $s_dayOffUsed = 0;
            $s_password = password_hash($s_password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO account(username, password, email, name, phone, gender, birthday, cmnd, ethnic, levels, phongban, 
            address, nation, role, MaPB, dayOff, dayOffUsed, dayOffLeft, image) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $conn = connect_db();
            $stm = $conn->prepare($sql);
            $stm->bind_param("ssssisissssssisiiis", $s_username, $s_password, $s_email, $s_name, $s_phone, $s_gender, $s_birthday, $s_cmnd,
             $s_ethnic, $s_level, $s_department, $s_address, $s_nation, $s_role, $s_maPB, $s_dayOff, $s_dayOffUsed, $s_dayOffLeft, $s_image);

            if (!$stm->execute()){
                die('can not execute: ' . $stm->error);
            }
            header('Location: ./managestaff.php');
        }
        // header('Location: ./managestaff.php');
        // die();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<title>Add User</title>
</head>

<body>
	<?php include '../partial/header.php'?>

    <div class="container">
		<div class="panel panel-primary">
            
            <header class="text-center bg-light text-success py-3 rounded mt-3">
                <h3 class="display-5 font-weight-bold">THÊM TÀI KHOẢN NHÂN VIÊN</h3>
            </header>

            <div class="mt-3"></div>
                <div class="panel-body">
                    <form method="post" class="border rounded w-100 mb-3 mx-auto px-3 pt-3 bg-light">
                        <div class="row register-form">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="username">Tài khoản:</label>
                                    <!-- <input type="number" name="id" value="<?=$id?>" style="display: none;"> -->
                                    <input  type="text" class="form-control" id="username" name="username" value="<?php if(isset($_POST['username'])){echo htmlspecialchars($_POST['username']); }?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="text" class="form-control" id="email" name="email" value="<?php if(isset($_POST['email'])){echo htmlspecialchars($_POST['email']); }?>">
                                </div>
                                <div class="form-group">
                                    <label for="name">Họ và tên:</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php if(isset($_POST['name'])){echo htmlspecialchars($_POST['name']); }?>">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Số Điện Thoại:</label>
                                    <input type="number" class="form-control" id="phone" name="phone" value="<?php if(isset($_POST['phone'])){echo htmlspecialchars($_POST['phone']); }?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="gender">Giới tính:</label>
                                    <select name="gender" class="form-control">
                                        <option value="">Select...</option>
                                        <option value="1">Nam</option>
                                        <option value="2">Nữ</option>
                                    </select>
                                </div>
                                    <!-- <div class="form-group col-6">
                                        <label for="gender">Mã phòng ban:</label>
                                        <input type="text" class="form-control" id="MaPB" name="MaPB" placeholder="">
                                    </div> -->
                            
                                <div class="form-group">
                                    <label for="birthday">Ngày sinh:</label>
                                    <input type="date" class="form-control" id="birthday" name="birthday" placeholder="dd/mm/yy" value="<?php if(isset($_POST['birthday'])){echo htmlspecialchars($_POST['birthday']); }?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cmnd">CMND:</label>
                                    <input type="number" class="form-control" id="cmnd" name="cmnd" value="<?php if(isset($_POST['cmnd'])){echo htmlspecialchars($_POST['cmnd']); }?>">
                                </div>
                                <div class="form-group">
                                    <label for="ethnic">Dân tộc:</label>
                                    <input type="text" class="form-control" id="ethnic" name="ethnic" value="<?php if(isset($_POST['ethnic'])){echo htmlspecialchars($_POST['ethnic']); }?>">
                                </div>
                                <div class="form-select mb-3"> 
                                    <label for="department" class="">Chức vụ:</label>
                                    <select name="level" class="form-control">
                                        <option value="">Select...</option>
                                        <option value="Nhân viên">Nhân viên</option>
                    
                                    </select>
                                </div>
                                <div class="form-select mb-3"> 
                                    <label for="department" class="">Phòng ban:</label>
                                    <select name="department" class="form-control">
                                        <option disabled selected>-- Select department --</option>
                                        <?php
                                            $sql = "SELECT * FROM department";
                                            $conn = connect_db();
                                            $result = $conn->query($sql);
                                            while($data = $result->fetch_array())
                                            {// displaying data in option menu
                                                echo "<option value='". $data['name'] ."'>" .$data['name'] ."</option>";  
                                            }	
                                        ?>  
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="address">Địa chỉ:</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?php if(isset($_POST['address'])){echo htmlspecialchars($_POST['address']); }?>">
                                </div>
                                <div class="form-group">
                                    <label for="nation">Quốc tịch:</label>
                                    <input type="text" class="form-control" id="nation" name="nation" value="<?php if(isset($_POST['nation'])){echo htmlspecialchars($_POST['nation']); }?>">
                                </div>
                            </div>
                        </div>
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>  
                        <a href=""><button class="btn btn-success mb-3 px-5">Thêm mới</button></a>
                        <a href="./managestaff.php" class="btn btn-secondary mb-3 px-5">Quay lại</a>
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