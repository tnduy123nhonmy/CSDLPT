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
    $dayOffUsed = $data['dayOffUsed'];
    $dayOff = $data['dayOff'];
    $dayOffLeft = $dayOff - $dayOffUsed;
    $idPerson = $data['id'];
    $namePerson = $data['name'];
    $idDepartment = $data['MaPB'];
    $rolePerson = $data['role'];

    $_SESSION['role'] = $data['role'];

	if ($_SESSION['role'] !== 3) {
		header("Location: /index.php");
		exit();
	}
    ///////////////////////////////////////// 
?>
<?php
    require_once('../../admin/db.php');
    $reason = $dayOffFrom  = $dayOffWant = $message = "";
    $dateApplyOff = date("Y-m-d"); // set ngày tháng năm tự động để đánh dấu ngày 

    $sql = "SELECT * FROM dayOff ORDER BY idDayOff DESC";
    $conn = connect_db();
    $result = $conn->query($sql);
    $data = $result->fetch_array();
    
    $idDayOff = $data['idDayOff'] +1;
    $idStatus = 1;
    $Status = "Waiting";	
    if (!empty($_POST)) {
        if (isset($_POST['dayOffWant'])) {
            $dayOffWant = $_POST['dayOffWant'];
        }

        if (isset($_POST['reason'])) {
            $reason = $_POST['reason'];
        }

        if (isset($_POST['dayOffFrom'])) {
            $dayOffFrom = $_POST['dayOffFrom'];
        }
            //Kiem tra loi
            if (isset($_POST['save'])) {
                $filename = $idDayOff."-".$_FILES['upload-file']['name'];
                $destination = '../Manager/filedayoffEmp/' . $filename;
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
                $file = $_FILES['upload-file']['tmp_name'];
                $size = $_FILES['upload-file']['size'];
            
            }
        $error = '';
        if (empty($_POST['dayOffWant'])) {
                $error = 'Please choose number of day';
        }
        else if (empty($_POST['dayOffFrom'])) {
            $error = 'Please choose a date-off start';
        }
        else if (empty($reason)) {
            $error = 'Please enter reason';
        }
        else if (!in_array($extension, ['rar', 'zip', 'txt', 'doc', 'docx', 'png', 'jpg', 'jpeg', 'pdf', 'ppt', 'pptx', 'xls', 'xlsx',''])) {
            $message = "Định dạng đuôi file không hợp lệ.";
        }
        else if ($_FILES['upload-file']['size'] > 41943040) {
            $message = "Dung lượng file không vượt quá 40Mb.";
        }
        else{
            move_uploaded_file($file, $destination);
            $sql = "INSERT INTO dayOff(idDayOff, Status, idStatus, idPerson, namePerson, reason, dayOffFrom, 
            dayApplyOff, dayOffWant, dayOff, dayOffUsed, dayOffLeft, rolePerson, idDepartment, fileDayOff)
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $conn = connect_db();
            $stm = $conn->prepare($sql);
            $stm->bind_param("isiissssiiiiiss", $idDayOff, $Status, $idStatus, $idPerson, $namePerson, $reason, 
            $dayOffFrom, $dateApplyOff, $dayOffWant, $dayOff, $dayOffUsed, $dayOffLeft, $rolePerson, $idDepartment, $fileDayOff);
            $fileDayOff = $filename;
            if (!$stm->execute()) {
                die('can not execute: ' . $stm->error);
            }
            header("location: ./index-nghiphep.php");

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
	<title>Create Day-off</title>
</head>

<body>
	<?php include '../../partial/header.php'?>

    <div class="container">
		<div class="panel panel-primary">
            
            <header class="text-center bg-light text-success py-3 rounded mt-3">
                <h3 class="display-5 font-weight-bold">TẠO ĐƠN NGHỈ PHÉP</h3>
            </header>

            <div class="mt-3"></div>
                <div class="panel-body">
                    <form method="POST" enctype="multipart/form-data" class="border rounded w-100 mb-3 mx-auto px-3 pt-3 bg-light">
                        <div class="register-form">
                            <div class="d-flex justify-content-center row">
                                <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                    <label for="dateOffFromm" class="font-weight-bold">Mã đơn:</label>
                                    <input  type="number" class="form-control"  value="<?= $idDayOff ?>" placeholder="<?= $idDayOff?>" readonly="readonly">
                                </div>
                                <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                    <label for="dateOffFromm" class="font-weight-bold">Ngày tạo:</label>
                                    <input  type="date" class="form-control"  value="<?= $dateApplyOff ?>" placeholder="<?= $dateApplyOff?>" readonly="readonly">
                                </div>
                                <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                    <label for="dateOffFromm" class="font-weight-bold">Tên người lao động:</label>
                                    <input  type="text" class="form-control"  value="<?= $namePerson ?>" placeholder="<?= $namePerson?>" readonly="readonly">
                                </div>
                            </div>
                            <div class="form-select mb-3"> 
                                <label for="dayOffWant">Số ngày muốn nghỉ:</label>
                                <select name="dayOffWant" class="form-control">
                                    <option disabled selected>-- Select number --</option>
                                    <?php
                                        $sql = "SELECT * FROM account where id=?";
                                        $conn = connect_db();
                                        $stm = $conn->prepare($sql);
                                        $stm->bind_param("i", $idPerson); 
                                        if (!$stm->execute()){
                                            die('can not execute: ' . $stm->error);
                                        }
                                        $result = $stm->get_result();
                                        $data = $result->fetch_assoc();
                                        $dayOffWant = $data['dayOff'] - $data['dayOffUsed'];
                                        $daySelect = 1;
                                        while($daySelect <= $dayOffWant)
                                        {// displaying data in option menu
                                            echo "<option value='". $daySelect ."'>" .$daySelect ."</option>";  
                                            $daySelect++;
                                        }	
                                    ?>  
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="dayOffFrom">Nghỉ từ ngày:</label>
                                <input  type="date" class="form-control" id="dayOffFrom" name="dayOffFrom">
                            </div>

                            <div class="form-group">
                                <label for="reason">Lý do:</label>
                                <textarea  type="text" class="form-control" id="reason" name="reason"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="">Đính kèm:</label>
                                <div class="custom-file">
                                    <input name="upload-file" type="file" class="custom-file-input" id="upload-file" value="<?= $fileSend ?>" accept="file_extension">
                                    <label class="custom-file-label" for="upload-file">Choose file</label>
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
                        <a href="index-nghiphep.php" class="btn btn-secondary mb-3 px-3" >Quay lại</a>
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