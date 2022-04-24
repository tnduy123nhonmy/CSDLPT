<?php
    //check neu ko phai truong phong thi chuyen ve page index
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
	if ($_SESSION['role'] !== 2) {
		header("Location: /index.php");
		exit();
	}
?>
<?php
    require_once('../../admin/db.php');

    $idTask = $nameEmployee = $statusTask = $idStatus = $idManager = $idEmployee = $nameManager = $titleTask 
    = $detailTask = $timeTask = $deadlineTask = $idDepartmentE = $message = "";

    $idManager = $data["id"];
    $roleManager = $data['role'];
    $roleCheck = $roleManager + 1;
    $nameManager = $data["name"];
    $idDepartmentM = $data["MaPB"];
    $idStatus = 1;
    $statusTask = "New";

    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['idEmployee'])) {
            $idEmployee = $_POST['idEmployee'];
        }

        if (isset($_POST['titleTask'])) {
            $titleTask  = $_POST['titleTask'];
        }

        if (isset($_POST['detailTask'])) {
            $detailTask = $_POST['detailTask'];
        }

        if (isset($_POST['deadlineTask'])) {
            $deadlineTask = $_POST['deadlineTask'];
        }

        $timeTask = date("Y-m-d "); // set ngày tháng năm tự động để đánh dấu ngày tạo task

        $sql = "SELECT * FROM account where name = ?";
        $conn = connect_db();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_POST['nameEmployee']);
        $error = '';
        if (!$stmt->execute()) {
            // $error = 'Please enter correct id employee';
             return array(
                'code' => 2,
                'message' => 'An error occured: ' . $stmt->error,
            );
        }
        error_reporting(E_ERROR | E_PARSE); // lệnh này dùng để ẩn warning ở web khi select id bị null trong trường hợp nhập id ko có trong database
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $nameEmployee = $data["name"];
        $idEmployee = $data['id'];
        $idDepartmentE = $data["MaPB"];
        $roleEmployee = $data["role"];

        
        //Kiem tra loi

        if (isset($_POST['save'])) {
            $filename ="idEmp-".$idEmployee."-".$idDepartmentE."-".$_FILES['upload-file']['name'];
            $destination = 'filesend/' . $filename;
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
            $file = $_FILES['upload-file']['tmp_name'];
            $size = $_FILES['upload-file']['size'];
        
        }
        // if (empty($idEmployee)) {
        //     $error = 'Please enter id employee';
        // }
        if($idDepartmentE !=  $idDepartmentM && !empty($idDepartmentE)){
            $error = 'This employee belong to another department';
        }
        else if(empty($nameEmployee)){
            $error = 'Plese choose a employee';
        }
        else if($roleEmployee != 3){
            $error = 'This person is not employee';
        }
        else if (empty($titleTask)) {
            $error = 'Please enter title';
        }
        else if (empty($detailTask)) {
            $error = 'Please enter description task';
        }
        else if (empty($deadlineTask)) {
            $error = 'Please enter deadline';
        }
        else if (!in_array($extension, ['rar', 'zip', 'txt', 'doc', 'docx', 'png', 'jpg', 'jpeg', 'pdf', 'ppt', 'pptx', 'xls', 'xlsx', ''])) {
            $message = "Định dạng đuôi file không hợp lệ.";
        }
        else if ($_FILES['upload-file']['size'] > 41943040) {
            $message = "Dung lượng file không vượt quá 40Mb.";
        }
        else{
            move_uploaded_file($file, $destination);

            $sql = "INSERT INTO Task (nameEmployee, statusTask, idStatus, idManager, idEmployee, nameManager, titleTask, detailTask, 
            timeTask, deadlineTask, idDepartment, fileSend)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $conn = connect_db();
            $stm = $conn->prepare($sql);
            $stm->bind_param("ssiiisssssss", $nameEmployee, $statusTask, $idStatus, $idManager, $idEmployee, 
            $nameManager, $titleTask, $detailTask, $timeTask, $deadlineTask, $idDepartmentE, $fileSend);
            $fileSend = $filename;
            $numberofrows = $stm->num_rows;
                if (!$stm->execute()){
                    die('can not execute: ' . $stm->error);
                }
                header('Location: ./index-task.php');
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
	<link rel="stylesheet" href="../../style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<title>Add Task</title>
</head>

<body>
	<?php include '../../partial/header.php'?>
    
    <div class="container">
		<div class="panel panel-primary">
            
            <header class="text-center bg-light text-success py-3 rounded mt-3">
                <h3 class="display-5 font-weight-bold">THÊM TASK</h3>
            </header>

            <div class="mt-3"></div>
                <div class="panel-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" class="border rounded w-100 mb-3 mx-auto px-3 pt-3 bg-light">
                        <div class="row register-form">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Tên nhân viên:</label>
                                    <select name="nameEmployee" class="form-control">
                                        <option value="">-- Select name --</option>
                                        <?php
                                            $conn = connect_db();
                                            $sql = "SELECT * FROM account WHERE MaPB=? and role=?";
                                            $conn = connect_db();
                                            $stm = $conn->prepare($sql);
                                            $stm->bind_param("si", $idDepartmentM,$roleCheck); 
                                            if (!$stm->execute()){
                                                die('can not execute: ' . $stm->error);
                                            }
                                            $result = $stm->get_result();
                                            while($data = $result->fetch_assoc())
                                            {// displaying data in option menu
                                                echo "<option value='". $data['name'] ."'>" .$data['name'] ."</option>";  
                                            }	
                                        ?>  
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Tiêu đề:</label>
                                    <input type="text" class="form-control" id="titleTask" name="titleTask" >
                                </div>
                                <div class="form-group">
                                    <label for="">Mô tả:</label>
                                    <input type="text" class="form-control" id="detailTask" name="detailTask" >
                                </div>
                                <div class="form-group">
                                    <label for="">Hạn deadline:</label>
                                    <input type="date" class="form-control" id="deadlineTask" name="deadlineTask" >
                                </div>
                                <div class="form-group">
                                    <label for="">Đính kèm:</label>
                                    <div class="custom-file">
                                        <input name="upload-file" type="file" class="custom-file-input" id="upload-file" value="<?= $fileSend ?>" accept="file_extension">
                                        <label class="custom-file-label" for="upload-file">Choose file</label>
                                        
                                    </div>
					            </div>
                            </div>
                        </div>
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                            if (!empty($message)) {
                                echo "<div class='alert alert-danger'>$message</div>";
                            }
                        ?>  
                        <button type="submit" name="save" class="btn btn-success mb-3 px-5">Thêm mới</button>
                        <a href="./index-task.php" class="btn btn-secondary mb-3 px-3">Quay lại</a>
                    </form>
                </div>
            </div>
	    </div>
    </div>

	

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="../../main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
    
	<?php include '../../partial/footer.php'?>

</body>
</html>