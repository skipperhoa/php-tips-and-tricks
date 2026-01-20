<?php

$servername = "localhost";
$username = "root";
$password = "Hoa@1234";

try {
    $conn = new PDO("mysql:host=$servername;dbname=laravel_app", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

class Database
{
    private $host = "localhost";
    private $db_name = "laravel_app";
    private $username = "root";
    private $password = "Hoa@1234";
    public $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}


$db = new Database();
if ($db->conn) {
    echo "Database connection established successfully.";
} else {
    echo "Failed to establish database connection.";
}




// getUsers  

$request = $conn->prepare("SELECT * FROM users order by id asc");
$request->execute();
$results = $request->fetchAll(PDO::FETCH_ASSOC);
// if($results){
//     print_r($results);
// }



//getUserById -->
$user_id = 1; // Example user ID
$request = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
$request->bindParam(':user_id', $user_id);
$request->execute();
$user = $request->fetch(PDO::FETCH_ASSOC);
if($user){
    print_r($user);
} else {
    echo "User not found.";
}



// createUser -->

 $name = "Hoa Nguyen Coder";
$email = "hoadev123@hoanguyenit.com";
$password = "password123";
$request = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
$request->bindParam(':name', $name);
$request->bindParam(':email', $email);
$request->bindParam(':password', $password);
$request->execute();
$newUserId = $conn->lastInsertId();
if ($newUserId) {
    echo "New user created successfully with ID: " . $newUserId;
} else {
    echo "Failed to create new user.";
}   
//return ;

// updateUser -->

$id = 1; // Example user ID
$name = "Updated Name";
$email = "updated1234567@hoanguyenit.com";
$request = $conn->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
$request->bindParam(':name', $name);
$request->bindParam(':email', $email);
$request->bindParam(':id', $id);
$request->execute();
if ($request->rowCount() > 0) {
    echo "User updated successfully.";
} else {
    echo "No changes made or user not found.";
}

//deleteUser -->

$id = 19; // Example user ID
$request = $conn->prepare("DELETE FROM users WHERE id = :id");
$request->bindParam(':id', $id);
$request->execute();
if ($request->rowCount() > 0) {
    echo "User deleted successfully.";
} else {
    echo "User not found.";
}
