<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }

    require_once('./function.php');

    $error = '';
    $user = '';
    $pass = '';

    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        

        //$hash = password_hash($pass, PASSWORD_BCRYPT);
        //echo ($hash);

        if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (empty($pass)) {
            $error = 'Please enter your password';
        }
        else if (strlen($pass) < 6) {
            $error = 'Password must have at least 6 characters';
        }
        else {
            $result = login($user, $pass);

            if ($result['code'] === 0) {
                $data = $result['data'];
                $_SESSION['user'] = $user; 
                $_SESSION['name'] = $data['name'];
                $_SESSION['role'] = $data['role'];

                if ($_SESSION['role'] == 1) { //role 1 là admin - giam doc
                    header("Location: index.php");
                    exit();
                }

                if ($_SESSION['role'] == 2) { //role 2 là truong phong
                    header('Location: /index.php');
                    exit();
                }

                if ($_SESSION['role'] == 3) { //role 3 là nhan vien
                    header('Location: Task/Employee/index-task.php');
                    exit();
                }

                header('Location: index.php');
                exit();
            } else {
                $error = $result['message'];
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-5">
                <h3 class="text-center text-primary mt-5 mb-3 bg-light py-3 font-weight-bold">ĐĂNG NHẬP</h3>
                <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input value="<?= $user ?>" name="user" id="user" type="text" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input name="pass" value="<?= $pass ?>" id="password" type="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group custom-control custom-checkbox">
                        <input <?= isset($_POST['remember']) ? 'checked' : '' ?> name="remember" type="checkbox" class="custom-control-input" id="remember">
                        <label class="custom-control-label" for="remember">Remember login</label>
                    </div>
                    <div class="form-group"> 
                        <?php 
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>
                        <button type="submit" class="btn btn-success px-5">Login</button>
                        
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

</body>
</html>
