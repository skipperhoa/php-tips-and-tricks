<?php
require_once 'DatabaseConnectionV2.php';

$db1 = Database::getInstance();
$db2 = Database::getInstance();
var_dump($db1 === $db2); // true
// Output: The same instance
echo "\n";
echo $db1 === $db2 ? 'Giống nhau' : 'Khác nhau';
echo "Show data users \n";
$result = $db1->query("SELECT * FROM User");
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    print_r($row);
}