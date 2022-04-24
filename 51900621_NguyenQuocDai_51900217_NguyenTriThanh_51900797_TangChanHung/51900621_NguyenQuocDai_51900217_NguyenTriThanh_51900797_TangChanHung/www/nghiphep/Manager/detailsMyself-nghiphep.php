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
		header("Location: ../../index.php");
		exit();
	}
?>
<?php
    $id = $_GET['id'];
    $sql_2 = "SELECT * FROM dayOff WHERE idDayOff = ?";

    $conn = connect_db();
    $stm = $conn->prepare($sql_2);
    $stm->bind_param("i", $id);
    if (!$stm->execute()){
        die('can not execute: ' . $stm->error);
    }
    $result = $stm->get_result();
    $data = $result->fetch_assoc();

    $idDayOff = $data['idDayOff'];
    $dayApplyOff = $data['dayApplyOff'];
    $idPersonPer = $data['idPersonPer'];
    $namePersonPer = $data['namePersonPer'];
    $idDepartment = $data['idDepartment'];
    $dayOff = $data['dayOff'];
    $dayOffUsed = $data['dayOffUsed'];
    $dayOffWant = $data['dayOffWant'];
    $dayOffLeft = $data['dayOffLeft'];
    $dayOffFrom = $data['dayOffFrom'];
    $Status = $data['Status'];
    $reason = $data['reason'];
    $idStatus = $data['idStatus'];
    $fileDayOff = $data['fileDayOff']; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css">
	<title>Details Day-off</title>
</head>
<body>
	<?php include '../../partial/header.php'?>
	<div class="container">
        <div class="justify-content-center">
            <header class="text-center bg-light text-info py-3 rounded">
                <h3 class="text-center mt-3 mb-3 display-5 font-weight-bold">XEM CHI TIẾT ĐƠN NGHỈ PHÉP</h3>
            </header>
           
            <hr />
            <dl class="dl-horizontal">
                <dt class="">Mã đơn</dt>
                <dd class=""><?= $idDayOff ?></dd>

                <dt>Ngày tạo</dt>
                <dd><?= $dayApplyOff ?></dd>

                <?php if(!empty($idPersonPer)){?>
                    <dt>Mã người duyệt</dt>
                    <dd><?= $idPersonPer ?></dd>
                <?php }?>

                <?php if(!empty($namePersonPer)){?>
                    <dt>Tên người duyệt</dt>
                    <dd><?= $namePersonPer ?></dd>
                <?php }?>

                <dt>Mã phòng ban</dt>
                <dd><?= $idDepartment ?></dd>

                <dt>Ngày nghỉ</dt>
                <dd><?= $dayOff ?></dd>

                <dt>Ngày đã nghỉ</dt>
                <dd><?= $dayOffUsed ?></dd>

                <dt>Ngày nghỉ còn lại</dt>
                <dd><?= $dayOffLeft ?></dd>

                <dt>Ngày muốn nghỉ</dt>
                <dd><?= $dayOffWant ?></dd>

                <dt>Muốn nghỉ từ ngày</dt>
                <dd><?= $dayOffFrom ?></dd>

                <dt>Trạng thái</dt>
                <dd><?= $Status?></dd>

                <dt>Lý do</dt>
                <dd><?= $reason?></dd>
                
                <?php if(!($fileDayOff == "$idDayOff-")){?>
                    <dt>File đính kèm</dt>
                    <div class="row">
                    <dd class="mr-4"><?= $fileDayOff ?></dd>
                        <dd><a class="btn btn-primary" href="../Admin/download-file-dayoff.php?id=<?= $idDayOff ?>"><i class="fas fa-download"></i></a></dd>
                    </div>
                <?php }?>
            </dl>
            
        </div>
       <div>
                <a href="./history-nghiphep.php" class="btn btn-secondary px-3">Quay lại</a>
       </div>
	</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/1542f0c587.js" crossorigin="anonymous"></script>
	<script src="/main.js"></script>
	<?php include '../../partial/footer.php'?>

</body>
</html>