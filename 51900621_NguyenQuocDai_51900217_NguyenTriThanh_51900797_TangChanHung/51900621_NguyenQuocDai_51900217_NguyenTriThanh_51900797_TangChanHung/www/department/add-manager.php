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
    $id = $department = "";
    
    if (!empty($_POST)) {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];  
        }

        //Kiểm tra lỗi
        $error = '';

        $sql = "SELECT * FROM department where name=?";
        $conn = connect_db();
        $stm = $conn->prepare($sql);
        $stm->bind_param("s", $_POST['department']);
        if (!$stm->execute()) {
            return array(
                'code' => 2,
                'message' => 'An error occured: ' . $stm->error,
            );
        }
        error_reporting(E_ERROR | E_PARSE); // lệnh này dùng để ẩn warning ở web
        $result = $stm->get_result();
        $data = $result->fetch_assoc();

        $checkManager = $data['idUsername'];

        $sql = "SELECT * FROM account where id=?";
        $conn = connect_db();
        $stm = $conn->prepare($sql);
        $stm->bind_param("i", $_POST['id']);
        if (!$stm->execute()) {
            return array(
                'code' => 2,
                'message' => 'An error occured: ' . $stm->error,
            );
        }
        error_reporting(E_ERROR | E_PARSE); // lệnh này dùng để ẩn warning ở web 
        $result = $stm->get_result();
        $data = $result->fetch_assoc();
        $nameEmployee = $data["name"];
        $dayOff = $data['dayOff'] + 3;
        $dayOffLeft = $data['dayOffLeft'] + 3;
        

        $username = $data['username'];

        if ($data['role'] == 2){
            $error = 'This person have been already a manager';
        }
        else if (empty($_POST['id'])) {
            $error = 'Please choose employee';
        }
        else if(empty($nameEmployee)){
            $error = 'This employee does not exist';
        }
        else if (empty($_POST['department'])) {
            $error = 'Please enter department';
        }
        else if ($data['role'] == 1){
            $error = 'Admin can not be a manager';
        }
        else if (!empty($checkManager)){
            $error = 'This department have been already had a manager';
        }
        else if ($data['phongban'] != $_POST['department']){
            $error = 'This employee can not be a manager of another department';
        }
        else{
            $sql = "UPDATE department SET usernameTP=?, idUsername=? where name=?";
            $conn = connect_db();
            $stm = $conn->prepare($sql);
            $stm->bind_param("sis", $username, $id, $_POST['department']);

            if (!$stm->execute()){
                die('can not execute: ' . $stm->error);
            }
            $role = 2;
            $levels = "Trưởng phòng";

            $sql = "UPDATE account SET role=?, levels=?, dayOff=?, dayOffLeft=? where id=?";
            $conn = connect_db();
            $stm = $conn->prepare($sql);
            $stm->bind_param("isiii", $role, $levels, $dayOff, $dayOffLeft, $id);

            if (!$stm->execute()){
                die('can not execute: ' . $stm->error);
            }
            header("Location: index-department.php");
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
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<title>Add Manager</title>
</head>

<body>
<?php include '../partial/header.php'?>

<div class="container">
		<div class="panel panel-primary">
            
            <header class="text-center bg-light text-primary py-3 rounded mt-3">
                <h3 class="display-5 font-weight-bold">THÊM TRƯỞNG PHÒNG</h3>
            </header>

            <div class="mt-3"></div>
                <div class="panel-body">
                    <form method="post" class="border rounded w-100 mb-3 mx-auto px-3 pt-3 bg-light">
                            <div class="col-md-12">
                                <div class="form-group">
                                <label for="id">Nhân viên:</label>
                                <select name="id" class="form-control">
                                        <option value="">-- Select employee --</option>
                                        <?php
                                            $conn = connect_db();
                                            $roleCheck = 3;
                                            $sql = "SELECT * FROM account where role=?";
                                            $conn = connect_db();
                                            $stm = $conn->prepare($sql);
                                            $stm->bind_param("i", $roleCheck);
                                            if (!$stm->execute()) {
                                                return array(
                                                    'code' => 2,
                                                    'message' => 'An error occured: ' . $stm->error,
                                                );
                                            }
                                            $result = $stm->get_result();
                                            
                                            while($data = $result->fetch_assoc())
                                            {// displaying data in option menu
                                                echo "<option value='". $data['id'] ."'>" .$data['name']."-".$data['phongban']."</option>";  
                                            }	
                                        ?>  
                                    </select>
                                </div>
                                <div class="form-select mb-3"> 
                                    <label for="department" class="">Phòng ban:</label>
                                    <select name="department" class="form-control">
                                        <option disabled selected>-- Select department --</option>
                                        <?php
                                            $conn = connect_db();
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
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            } 
                        ?>  
                        <a href=""><button class="btn btn-success mb-4 px-5">Thêm mới</button></a>
                        <a href="index-department.php" class="btn btn-secondary mb-4">Quay lại</a>
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