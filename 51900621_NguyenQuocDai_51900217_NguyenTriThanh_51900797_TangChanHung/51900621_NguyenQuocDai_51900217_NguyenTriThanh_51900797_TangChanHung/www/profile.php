<?php
	//check neu ko phai admin thi chuyen ve page index
	session_start();
	require_once('./function.php');
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
    $role = $data['role'];
?>
<?php
		require_once('./admin/db.php');
		$username = $_SESSION['user'];
		$sql_2 = "SELECT * FROM account WHERE username = ?";

		$conn = connect_db();
		$stm = $conn->prepare($sql_2);
		$stm->bind_param("s", $username,);
		

		if (!$stm->execute()){
			die('can not execute: ' . $stm->error);
		}

		$result = $stm->get_result();
        $data = $result->fetch_assoc();

		$id = $data['id'];
		$username = $data['username'];
		$name = $data['name'];
		$email = $data['email'];
		$phone = $data['phone'];
		$level = $data['levels'];
		$phongban = $data['phongban'];
		$maPB = $data['MaPB'];
        $role = $data['role'];
        $gender = $data['gender'];
        $birthday = $data['birthday'];
        $cmnd = $data['cmnd'];
        $ethnic = $data['ethnic'];
        $nation = $data['nation'];
        $address = $data['address'];
        $dayOff = $data['dayOff'];
        $dayOffUsed = $data['dayOffUsed'];
        $image = $data['image'];
?>
<?php
    require_once('admin/db.php');

    $message = '';
    if (!empty($_POST)) {
        if (isset($_POST['save'])) {
            
            $filename = $id . "-" . $_FILES['upload-file']['name'];
            $destination = 'images/' . $filename;
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $file = $_FILES['upload-file']['tmp_name'];
            $size = $_FILES['upload-file']['size'];
        }

        if (!in_array($extension, ['png', 'jpg', 'jpeg', 'gif', 'tiff', 'psd', 'pdf', 'eps', 'ai', 'indd', 'raw'])) {
            $message = "<p class='alert alert-danger'>Hình ảnh không hợp lệ.</p>";
        } else {
            move_uploaded_file($file, $destination);

            $sql = "UPDATE account SET image = ? WHERE id = ?";

            $conn = connect_db();
            $stm = $conn->prepare($sql);
            $stm->bind_param("si", $image, $id);
            $image = $filename;
            if (!$stm->execute()) {
                die('can not execute: ' . $stm->error);
            }

            $message = "<p class='alert alert-success'>Cập nhật thành công.</p>";
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
	<title>Profile</title>
</head>
<body>
	<?php include './partial/header.php'?>

			<header class="text-center bg-light text-primary py-3 rounded ">
                <h3 class="display-5 font-weight-bold">THÔNG TIN CÁ NHÂN</h3>
            </header>

    <div class="container d-flex justify-content-center m-auto row">
        <form method="POST" enctype="multipart/form-data" class="col-sm-12 col-md-4 col-lg-4 text-center">
                <img src="images/<?= $image ?>" alt="image" class="img-thumbnail w-80">
                <div class="form-group">
                    <div class="custom-file">
                        <input name="upload-file" type="file" class="custom-file-input" id="upload-file" value="<?= $image ?>" accept="file_extension">
                        <label class="custom-file-label text-left mt-2" for="upload-file">Thêm hình ảnh tại đây</label>
                    </div>
                </div>
                <?php echo $message; ?>
                <button type="submit" name="save" class="btn btn-success mb-3 px-5">Lưu</button> 
            </form>

        <div class="col-sm-12 col-md-8 col-lg-8 row">
            <div class="col-lg-6 col-md-12 col-sm-12">
				<div class="form-group">
                    <label for="">ID:</label>
                    <input type="text" class="form-control" placeholder="<?= $id ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="">Họ và tên:</label>
                    <input type="text" class="form-control" placeholder="<?= $name ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="">Username:</label>
                    <input type="text" class="form-control" placeholder="<?= $username ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="">Email:</label>
                    <input type="text" class="form-control" placeholder="<?= $email ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="">Số điện thoại:</label>
                    <input type="text" class="form-control" placeholder="<?= $phone ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="">Địa chỉ:</label>
                    <textarea type="text" class="form-control" placeholder="<?= $address ?>" disabled></textarea>
                </div>
                <div class="form-group">
                    <label for="">Giới tính:</label>
                    <input type="text" class="form-control" placeholder="<?php if($gender === 1){
						echo "Nam";
					}else{
						echo "Nữ";
					} ;?>" disabled>
                </div>
                <?php if($role != 1){?>
                    <div class="form-group">
                        <label for="">Ngày nghỉ phép:</label>
                        <input type="text" class="form-control" placeholder="<?= $dayOff ?>" disabled>
                    </div>
                <?php }?>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="">Số chứng minh thư:</label>
                    <input type="text" class="form-control" placeholder="<?= $cmnd ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="">Ngày sinh:</label>
                    <input type="text" class="form-control" placeholder="<?= $birthday ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="">Dân tộc:</label>
                    <input type="text" class="form-control" placeholder="<?= $ethnic ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="">Chức Vụ:</label>
                    <input type="text" class="form-control" placeholder="<?= $level ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="">Phòng ban:</label>
                    <input type="text" class="form-control" placeholder="<?= $phongban ?>" disabled>
                </div>
				<div class="form-group">
                    <label for="">Mã phòng ban:</label>
                    <input type="text" class="form-control" placeholder="<?= $maPB ?>" disabled>
                </div>
				<div class="form-group">
                    <label for="">Quốc tịch:</label>
                    <input type="text" class="form-control" placeholder="<?= $nation ?>" disabled>
                </div>
                <?php if($role != 1){?>
                    <div class="form-group">
                        <label for="">Ngày đã nghỉ:</label>
                        <input type="text" class="form-control" placeholder="<?= $dayOffUsed ?>" disabled>
                    </div>
                <?php }?>
            </div>
            <div class="form-group ml-3">
                    <a href="./changepassold.php" class="btn btn-danger" >Đổi mật khẩu</a>
                    <a href="/user/managestaff.php" class="btn btn-secondary mr-5"> Quay lại </a>
                </div>
        </div>
    </div>
</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<?php include './partial/footer.php'?>

</body>
</html>