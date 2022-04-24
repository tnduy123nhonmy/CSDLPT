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
    $sql_2 = "SELECT * FROM Task WHERE idTask = ?";

    $conn = connect_db();
    $stm = $conn->prepare($sql_2);
    $stm->bind_param("i", $id,);
    

    if (!$stm->execute()){
        die('can not execute: ' . $stm->error);
    }

    $result = $stm->get_result();
    $data = $result->fetch_assoc();

    $idTask = $data['idTask'];
    $titleTask = $data['titleTask'];
    $detailTask = $data['detailTask'];
    $statusTask = $data['statusTask'];
    $timeTask = $data['timeTask'];
    $deadlineTask = $data['deadlineTask'];
    $dateSubmit = $data['dateTimeAuto'];
    $idDepartment = $data['idDepartment'];
    $idManager = $data['idManager'];
    $nameManager = $data['nameManager'];
    $idEmployee = $data['idEmployee'];
    $nameEmployee = $data['nameEmployee'];
    $fileSend = $data['fileSend'];
    $fileExtra = $data['fileExtra'];
    $fileSubmit = $data['fileSubmit'];
    $messenger = $data['messenger'];
    $idStatus = $data['idStatus'];
    $rate = $data['rate'];
    $note = $data['note'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css">
	<title>Details task</title>
</head>
<body>
	<?php include '../../partial/header.php'?>

	<div class="container">
        <div class="justify-content-center">
            <header class="text-center bg-light text-info py-3 rounded">
                <h3 class="text-center mt-3 mb-3 display-5 font-weight-bold">XEM CHI TIẾT TASK</h3>
            </header>
           
            <hr />
            <dl class="dl-horizontal">
                <dt class="">Mã Task</dt>
                <dd class=""><?= $idTask ?></dd>

                <dt>Ngày tạo</dt>
                <dd><?= $timeTask ?></dd>

                <dt>Deadline</dt>
                <dd><?= $deadlineTask ?></dd>
                
                <?php if(!empty($dateSubmit)){?>
                    <dt>Ngày submit</dt>
                    <dd><?= $dateSubmit ?></dd>
                <?php }?>

                <dt>Mã phòng ban</dt>
                <dd><?= $idDepartment ?></dd>

                <dt>Mã trưởng phòng</dt>
                <dd><?= $idManager ?></dd>

                <dt>Tên trưởng phòng</dt>
                <dd><?= $nameManager ?></dd>

                <dt>Mã nhân viên</dt>
                <dd><?= $idEmployee ?></dd>

                <dt>Tên nhân viên</dt>
                <dd><?= $nameEmployee ?></dd>

                <dt>Tiêu đề</dt>
                <dd><?= $titleTask ?></dd>

                <dt>Mô tả</dt>
                <dd><?= $detailTask ?></dd>

                <dt>Trạng thái</dt>
                <dd><?= $statusTask ?></dd>

                <?php if(!empty($rate)){?>
                    <dt>Đánh giá</dt>
                    <dd><?= $rate ?></dd>
                <?php }?>

                <?php if(!empty($messenger)){?>
                    <dt>Tin nhắn</dt>
                    <dd><?= $messenger ?></dd>
                <?php }?>

                <?php if(!empty($note)){?>
                    <dt>Ghi chú</dt>
                    <dd><?= $note ?></dd>
                <?php }?>
                
                <?php if(!($fileSend == "idEmp-$idEmployee-$idDepartment-")){?> 
                    <dt >File đính kèm</dt>
                    <div class="row">
                        <dd class="mr-4 ml-3"><?= $fileSend ?></dd>
                        <dd><a class="btn btn-primary" href="../Manager/download-file-send.php?id=<?= $idTask ?>"><i class="fas fa-download"></i></a></dd>
                    </div>
                <?php }?>

                <?php if(!($fileExtra == "reject-$idTask-")){?> 
                    <dt>File đính kèm rejected</dt>
                    <div class="row">
                        <dd><?= $fileExtra ?></dd>
                        <dd><a class="btn btn-primary" href="../Manager/download-file-extra.php?id=<?= $idTask ?>"><i class="fas fa-download"></i></a></dd>
                    </div>
                <?php }?>

                <?php if(!($fileSubmit == "submit-$idTask-")){?> 
                    <dt>File submit</dt>
                    <div class="row">
                        <dd class="mr-4 ml-3 "><?= $fileSubmit ?></dd>
                        <dd><a class="btn btn-primary" href="../Manager/download.php?id=<?= $idTask ?>"><i class="fas fa-download"></i></a></dd>
                    </div>
                <?php }?>
            </dl>
            
        </div>
       <div class="mb-3">
            <?php if($idStatus == 3){ //Mở if: Nếu idStatus là 3 (waiting) thì sẽ show ra ?>
                <a href="./complete-task.php?idTask=<?=  $idTask; ?>" class="btn btn-success"><i class=""></i>Approve</a>
                <a href="./rejectTask.php?idTask=<?=  $idTask; ?>" class="btn btn-danger"><i class=""></i>Reject</a>
            <?php } // đóng if?>
                <a href="./index-task.php" class="btn btn-secondary px-3" >Back to list</a>
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