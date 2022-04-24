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
    $idEmployee = $data['id'];

    $_SESSION['role'] = $data['role'];
	if ($_SESSION['role'] !== 2) {
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
    //Nếu status đang New, In progress, Rejected, Canceled, Completed thì sẽ ko thể vào trang rejectTask bằng url
    if($checkStatus == 1 || $checkStatus == 2 || $checkStatus == 4 || $checkStatus == 6 || $checkStatus == 5){
        header('Location: index-task.php');
        exit();
    }
?>
<?php
    require_once('../../admin/db.php');

    $note = $idStatus = $statusTask = $message = "";

    $sql = "SELECT * FROM Task where idTask=?";
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
    $deadlineTask = $data['deadlineTask'];
    $submitday = $data['dateTimeAuto'];
    $nameEmployee = $data['nameEmployee'];

    $idStatus = 4;
    $statusTask = "Rejected";
    
    if (!empty($_POST)) {
        if (isset($_POST['note'])) {
            $note = $_POST['note'];
        }

        if (empty($_POST['deadlineTask'])) {
            $deadlineTask = $data['deadlineTask'] ;
        }

        if (!empty($_POST['deadlineTask'])) {
            $deadlineTask = $_POST['deadlineTask'];
        }

        //Kiem tra loi
        if (isset($_POST['save'])) {
            $filename = "reject-".$idTask."-".$_FILES['upload-file']['name'];
            $destination = 'filesend/' . $filename;
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
            $file = $_FILES['upload-file']['tmp_name'];
            $size = $_FILES['upload-file']['size'];
        
        }
        if (empty($note)) {
            $error = 'Please enter notes';
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
            SET idStatus=?, statusTask=?, note=?, deadlineTask=?, fileExtra=? WHERE idTask=?";

            $conn = connect_db();
            $stm = $conn->prepare($sql);
            $stm->bind_param("issssi", $idStatus, $statusTask, $note, $deadlineTask, $fileExtra, $idTask);
            $fileExtra = $filename;
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
	<title>Reject Task</title>
</head>

<body>
	<?php include '../../partial/header.php'?>

    <div class="container">
		<div class="panel panel-primary">
            
            <header class="text-center bg-light text-danger py-3 rounded mt-3">
                <h3 class="display-5 font-weight-bold">REJECT TASK</h3>
            </header>

            <div class="mt-3"></div>
                <div class="panel-body">
                    <form method="POST" enctype="multipart/form-data" class="border rounded w-100 mb-3 mx-auto px-3 pt-3 bg-light">
                        <div class="register-form">
                            <div class="row ml-1">
                                    <label for="dateOffFromm" class="col-3 ml-1 font-weight-bold">Mã task:</label>
                                    <label for="dateOffFromm" class="col-3 ml-3 font-weight-bold">Ngày submit:</label>
                                    <label for="dateOffFromm" class="col-3 ml-3 font-weight-bold">Tên nhân viên:</label>
                                </div>
                                <div class="row ml-1 mb-2">
                                    <input  type="number" class="form-control col-3 ml-3"  value="<?= $idTask ?>" placeholder="<?= $idTask?>" readonly="readonly">
                                    <input  type="date" class="form-control col-3 ml-3"  value="<?= $submitday ?>" placeholder="<?= $submitday?>" readonly="readonly">
                                    <input  type="text" class="form-control col-3 ml-3"  value="<?= $nameEmployee ?>" placeholder="<?= $nameEmployee?>" readonly="readonly">
                                </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Ghi chú:</label>
                                    <textarea  type="text" class="form-control" id="note" name="note"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="">Đính kèm:</label>
                                    <div class="custom-file">
                                        <input name="upload-file" type="file" class="custom-file-input" id="upload-file" value="<?= $fileExtra ?>" accept="file_extension">
                                        <label class="custom-file-label" for="upload-file">Choose file</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Gia hạn deadline:</label>
                                    <input type="date" class="form-control" id="deadlineTask" name="deadlineTask" >
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
                        <a href=""><button type="submit" name="save" class="btn btn-danger mb-3 px-5 ml-3">Reject</button></a>
                        <a href="details-task.php?id=<?= $idTask ?>" class="btn btn-secondary mb-3 px-4">Quay lại</a>
                    </form>
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