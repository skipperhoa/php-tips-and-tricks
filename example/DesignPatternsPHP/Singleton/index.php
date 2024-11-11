<?php 

require_once 'DatabaseConnection.php';

// Sử dụng Singleton
$db1 = DatabaseConnection::getInstance(); 
$db2 = DatabaseConnection::getInstance();
// Kiểm tra $db1 và $db2 có cùng instance
var_dump($db1 === $db2); // true
$conn = $db1->getConnection();


echo "Show data users \n";
$result = $conn->query("SELECT * FROM User");
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    print_r($row);
}
