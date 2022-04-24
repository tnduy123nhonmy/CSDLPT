<?php
    //check neu ko phai nhan vien thi chuyen ve page index
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

    $idEmployee = $data['id'];
    $idDepartmentE = $data["MaPB"];
    $nameEmployee = $data['name'];


    $_SESSION['role'] = $data['role'];

	if ($_SESSION['role'] !== 3) {
		header("Location: /index.php");
		exit();
	}

    $idTask = $_GET['idTask']; //mã của task
    $sql = "SELECT * FROM Task where idTask = ?";
    $conn = connect_db();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idTask);

	if (!$stmt->execute()) {
		return array(
			'code' => 2,
			'message' => 'An error occured: ' . $stmt->error,
		);
	}
	$result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $checkStatus = $data['idStatus'];
    //Nếu status đang New, Waiting, Canceled, Completed thì sẽ ko thể vào trang submitTask bằng url
    if($checkStatus == 1 || $checkStatus == 3 || $checkStatus == 6 || $checkStatus == 5){
        header('Location: index-task.php');
        exit();
    }
?>
<?php
    require_once('../../admin/db.php');

    $messenger = $idStatus = $statusTask = "";
    $error = "";
    $message = '';
    $idStatus = 3;
    $statusTask = "Waiting";	
    $dateTimeSubmit = date("Y-m-d"); // set ngày tháng năm tự động để đánh dấu ngày submit
        if (!empty($_POST)) {
            if (isset($_POST['messenger'])) {
                $messenger = $_POST['messenger'];
            }
    
            //Kiem tra loi
    
            if (isset($_POST['save'])) { 
                $filename = "submit-".$idTask."-".$_FILES['upload-file']['name'];
                $destination = '../Manager/filesubmit/' . $filename;
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
                $file = $_FILES['upload-file']['tmp_name'];
                $size = $_FILES['upload-file']['size'];
        
            }
    
            if (empty($messenger)) {
                $error = 'Please enter messenger';
            }
            else if (!in_array($extension, ['rar', 'zip', 'txt', 'doc', 'docx', 'png', 'jpg', 'jpeg', 'pdf', 'ppt', 'pptx', 'xls', 'xlsx',''])) {
                $message = "Định dạng đuôi file không hợp lệ.";
            }
            else if ($_FILES['upload-file']['size'] > 41943040) {
                $message = "Dung lượng file không vượt quá 40Mb.";
            }
            else{
                move_uploaded_file($file, $destination);
                $sql = "UPDATE Task 
                SET idStatus=?, statusTask=?, messenger=?, fileSubmit=?, dateTimeAuto=? WHERE idTask=?";
    
                $conn = connect_db();
                $stm = $conn->prepare($sql);
                $stm->bind_param("issssi", $idStatus, $statusTask, $messenger, $fileSubmit, $dateTimeSubmit, $idTask);
                $fileSubmit = $filename;
                if (!$stm->execute()) {
                    die('can not execute: ' . $stm->error);
                }
                header("location: ./index-task.php");
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
	<title>Submit Task</title>
</head>

<body>
	<?php include '../../partial/header.php'?>

    <div class="container">
		<div class="panel panel-primary">
            
            <header class="text-center bg-light text-primary py-3 rounded mt-3">
                <h3 class="display-5 font-weight-bold">SUBMIT TASK</h3>
            </header>

            <div class="mt-3"></div>
                <div class="panel-body">
                    <form method="POST" enctype="multipart/form-data" class="border rounded w-100 mb-3 mx-auto px-3 pt-3 bg-light">
                        <div class="row register-form">
                            <div class="col-md-12">
                                <div class="row">
                                    <label for="dateOffFromm" class="col-3 ml-1">Mã task:</label>
                                    <label for="dateOffFromm" class="col-3 ml-3">Ngày submit:</label>
                                    <label for="dateOffFromm" class="col-3 ml-3">Tên nhân viên:</label>
                                </div>
                                <div class="row">
                                    <input  type="number" class="form-control col-3 ml-3"  value="<?= $idTask ?>" placeholder="<?= $idTask?>" readonly="readonly">
                                    <input  type="date" class="form-control col-3 ml-3"  value="<?= $dateTimeSubmit ?>" placeholder="<?= $dateTimeSubmit?>" readonly="readonly">
                                    <input  type="text" class="form-control col-3 ml-3"  value="<?= $nameEmployee ?>" placeholder="<?= $nameEmployee?>" readonly="readonly">
                                </div>

                                <div class="form-group">
                                    <label for="">Tin nhắn:</label>
                                    <textarea  type="text" class="form-control" id="messenger" name="messenger"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Đính kèm: ()</label>
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
                        <button type="submit" name="save" class="btn btn-success mb-3 px-5">Submit</button> 
                        <a href="details-task.php?id=<?= $idTask ?>" class="btn btn-secondary mb-3 px-3" >Quay lại</a>
                    </form>
                </div> 
            </div>
        </div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<?php include '../../partial/footer.php'?>

</body>
</html>