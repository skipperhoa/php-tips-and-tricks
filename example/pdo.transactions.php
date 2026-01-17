<?php
$servername = "localhost";
$username = "root";
$password = "";
try {
    $dbh = new PDO("mysql:host=$servername;dbname=laravel10", $username, $password);
   // set the PDO error mode to exception
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (Exception $e) {
    die("Unable to connect: " . $e->getMessage());
}

try {

    $dbh->beginTransaction();
    $dbh->exec("insert into users ( name, email,password) values ('hoacode123', 'hoacode@example.com', '12345678')");
    $dbh->exec("insert into salarychange (id, amount, changedate) 
      values (23, 50000, NOW())");
    $dbh->commit();
} catch (Exception $e) {
    $dbh->rollBack();
    echo "Failed: " . $e->getMessage();
}
