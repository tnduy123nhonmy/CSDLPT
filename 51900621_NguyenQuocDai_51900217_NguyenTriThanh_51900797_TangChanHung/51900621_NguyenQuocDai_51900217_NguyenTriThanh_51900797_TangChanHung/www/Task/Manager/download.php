<?php
    require_once('../../admin/db.php');
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM Task WHERE idTask = $id";
        $conn = connect_db();
        $result = mysqli_query($conn, $sql);
        $file = mysqli_fetch_assoc($result);
        $filepath = 'filesubmit/' . $file['fileSubmit'];
        if (file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($filepath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            readfile($filepath);
            exit;
        }
    }
?>