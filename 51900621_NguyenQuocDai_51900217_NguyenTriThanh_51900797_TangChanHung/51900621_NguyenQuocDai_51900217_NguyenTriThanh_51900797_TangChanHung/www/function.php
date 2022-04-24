<?php
    require_once('admin/db.php');

    function login($user, $pass) {
        // $hashed = password_hash($pass, PASSWORD_BCRYPT);
        $sql = "SELECT * FROM account where username = ?";
        $conn = connect_db();

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user);

        if (!$stmt->execute()) {
            return array(
                'code' => 2,
                'message' => 'An error occured: ' . $stmt->error,
            );
        }

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        
        if ($result->num_rows == 0) {
            return array(
                'code' => 1,
                'message' => 'This user does not exist',
            );
        }

        if (!password_verify($pass, $data['password'])) {
            return array(
                'code' => 1,
                'message' => 'Wrong password',
            );
        }

        if (password_verify($pass, $data['password'])){
            return array(
                'code' => 0,
                'message' => 'Login successfully',
                'data' => $data,
            );
        }
    }

    // function executeResult($sql) {
    //     //create connection toi database
    //     $conn = connect_db();
    
    //     //query
    //     $resultset = mysqli_query($conn, $sql);
    //     $list      = [];
    //     while ($row = mysqli_fetch_array($resultset, 1)) {
    //         $list[] = $row;
    //     }

    //     return $list;
    // }
?>