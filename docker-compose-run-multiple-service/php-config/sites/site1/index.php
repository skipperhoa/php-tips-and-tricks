<?php 
  

$servername = "mysql";  // Tên dịch vụ của MySQL trong Docker Compose
$username = "hoacode";
$password = "12345678";
$dbname = "db_hoacode";

// Kết nối đến MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
echo json_encode(array("message" => "Hello from site1"));


?>