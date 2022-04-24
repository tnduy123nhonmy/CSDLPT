<?php
    //check neu ko phai nhân viên thi chuyen ve page index
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
	if ($_SESSION['role'] !== 3) {
		header("Location: ../../index.php");
		exit();
	}
    
    $idUSer = $data["id"];
    $idStatus = 2;
    $statusTask = "In progress";
    $idTask = $_GET['idTask'];
    $sql = "UPDATE Task 
    SET idStatus=?, statusTask=? WHERE idEmployee=? and idTask=?";

    $conn = connect_db();
    $stm = $conn->prepare($sql);
    $stm->bind_param("isii", $idStatus, $statusTask, $idUSer, $_GET['idTask']);
    
    if (!$stm->execute()) {
        die('can not execute: ' . $stm->error);
    }
    header("location: details-task.php?id=$idTask");
?>