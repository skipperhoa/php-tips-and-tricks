<?php
$servername = "localhost";
$username = "root";
$password = "Hoa@1234"; 
try {
    $dbh = new PDO("mysql:host=$servername;dbname=laravel_app", $username, $password);
   // set the PDO error mode to exception
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully \n";
} catch (Exception $e) {
    die("Unable to connect: " . $e->getMessage());
}

try {

    $dbh->beginTransaction();
    $dbh->prepare("INSERT INTO users (name, email, password) 
    VALUES ('hoacode', 'hoadev3333@hoanguyenit.com', 'password123')")->execute();
    $lastId = $dbh->lastInsertId();
    echo "New record created successfully. Last inserted ID is: " . $lastId . "\n";

    $user_id = 1; // Example user ID
    $request = $dbh->prepare("SELECT * FROM users WHERE id = :user_id");
    $request->bindParam(':user_id', $user_id);
    $request->execute();
    $user = $request->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        throw new Exception("User not found with ID: " . $user_id);
    }
   

    $dbh->commit();
} catch (Exception $e) {
    $dbh->rollBack();
    echo "Failed: " . $e->getMessage();
}
