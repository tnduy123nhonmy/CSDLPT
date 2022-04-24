<?php
	// $host = 'mysql-server'; // tên mysql server
	// $user = 'root';
	// $pass = 'root';
	// $db = 'product_management'; // tên databse


	define('HOST', 'mysql-server');
    define('USER', 'root');
    define('PASS', 'root');
    define('DB', 'EmployeeN');
	function connect_db() {
        #  https://www.w3schools.com/php/php_mysql_select.asp
		$conn = new mysqli(HOST, USER, PASS, DB);
		$conn->set_charset("utf8");
		if ($conn->connect_error) {
			die('Không thể kết nối database: ' . $conn->connect_error);
		}
		return $conn;
    } 
	
?>
