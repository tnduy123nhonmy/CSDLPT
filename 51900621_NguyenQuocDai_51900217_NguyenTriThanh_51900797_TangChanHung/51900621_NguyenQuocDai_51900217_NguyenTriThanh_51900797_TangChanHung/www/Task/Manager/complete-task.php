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
    //Nếu status đang New, In progress, Rejected, Canceled, Completed thì sẽ ko thể vào trang complete-Task bằng url
    if($checkStatus == 1 || $checkStatus == 2 || $checkStatus == 4 || $checkStatus == 6 || $checkStatus == 5){
        header('Location: index-task.php');
        exit();
    }
?>
<?php
    require_once('../../admin/db.php');

    $rate = $idStatus = $statusTask = $error = "";

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
    $submitday = $data['dateTimeAuto'];
    $nameEmployee = $data['nameEmployee'];
    $deadlineDate = strtotime($data['deadlineTask']);
    $submitDate = strtotime($data['dateTimeAuto']);
    $datediff = $deadlineDate - $submitDate; // thời gian deadline - thời gian submit.Kết quả âm thì trễ deadline, dương thì ngược lại

    $idStatus = 5;
    $statusTask = "Completed";
    

    if (!empty($_POST)) {
        if (isset($_POST['rate'])) {
            $rate = $_POST['rate'];
        }


        //Kiem tra loi
        if (!isset($_POST['rate'])) {
            $error = 'Please choose a rating';
        }
        else{
            $sql = "UPDATE Task 
            SET idStatus=?, statusTask=?, rate=?, dateDiff=? WHERE idTask=?";

            $conn = connect_db();
            $stm = $conn->prepare($sql);
            $stm->bind_param("isssi", $idStatus, $statusTask, $rate, $datediff, $idTask);
            
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
	<title>Approve Task</title>
</head>

<body>
	<?php include '../../partial/header.php'?>

    <div class="container">
		<div class="panel panel-primary">
            
            <header class="text-center bg-light text-success py-3 rounded mt-5">
                <h3 class="display-5 font-weight-bold">APPROVE TASK</h3>
            </header>

            <div class="mt-3"></div>
                <div class="panel-body">
                    <form method="POST" class="border rounded w-100 mb-3 mx-auto px-3 pt-3 bg-light">
                        <div class="register-form">
                                <div class="row">
                                    <label for="dateOffFromm" class="col-3 ml-1 font-weight-bold">Mã task:</label>
                                    <label for="dateOffFromm" class="col-3 ml-3 font-weight-bold">Ngày submit:</label>
                                    <label for="dateOffFromm" class="col-3 ml-3 font-weight-bold">Tên nhân viên:</label>
                                </div>
                                <div class="row">
                                    <input  type="number" class="form-control col-3 ml-3"  value="<?= $idTask ?>" placeholder="<?= $idTask?>" readonly="readonly">
                                    <input  type="date" class="form-control col-3 ml-3"  value="<?= $submitday ?>" placeholder="<?= $submitday?>" readonly="readonly">
                                    <input  type="text" class="form-control col-3 ml-3"  value="<?= $nameEmployee ?>" placeholder="<?= $nameEmployee?>" readonly="readonly">
                                </div>
                            <div class="col-md-3">
                                <div class="">
                                    <label class="font-weight-bold mt-2">Đánh giá:</label><br>
                                    <?php if($datediff > 0){//nếu datediff > 0 nghĩa là nộp trước deadline ?> 
                                        <div class="form-check text-success font-weight-bold">
                                        <input class="form-check-input" type="radio" name="rate" id="Radios1" value="Good" >
                                        <label class="form-check-label" for="exampleRadios1">
                                            Good
                                        </label>
                                        </div>
                                    <?php }?>

                                        <div class="form-check text-primary font-weight-bold">
                                        <input class="form-check-input" type="radio" name="rate" id="Radios2" value="OK">
                                        <label class="form-check-label" for="exampleRadios2">
                                            OK
                                        </label>
                                        </div>

                                        <div class="form-check text-secondary font-weight-bold">
                                        <input class="form-check-input" type="radio" name="rate" id="Radios3" value="Bad" >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Bad
                                        </label>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>  
                        <div class="mt-3">
                            <a href=""><button class="btn btn-success  mb-3 px-3">Approve</button></a>
                            <a href="details-task.php?id=<?= $idTask ?>" class="btn btn-secondary mb-3 px-3">Back</a>
                        </div>
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