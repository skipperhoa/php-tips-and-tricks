<?php
require 'connect.php';

// Function to create a new user
function createUser($username, $password, $email) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO User (username, password, email) VALUES (:username, :password, :email)");
    $stmt->execute(['username' => $username, 'password' => password_hash($password, PASSWORD_DEFAULT), 'email' => $email]);
    echo "Người dùng đã được thêm thành công!<br>";
}

// Function to read all users
function readAllUsers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM User");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $user) {
        echo "ID: {$user['id']} - Username: {$user['username']} - Email: {$user['email']}<br>";
    }
}

// Function to update a user
function updateUser($id, $username, $email) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE User SET username = :username, email = :email WHERE id = :id");
    $stmt->execute(['username' => $username, 'email' => $email, 'id' => $id]);
    echo "Người dùng đã được cập nhật thành công!<br>";
}

// Function to delete a user
function deleteUser($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM User WHERE id = :id");
    $stmt->execute(['id' => $id]);
    echo "Người dùng đã được xóa thành công!<br>";
}

// Function to read a single user
function readUser($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM User WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        echo "ID: {$user['id']} - Username: {$user['username']} - Email: {$user['email']}<br>";
    } else {
        echo "Người dùng không tồn tại.<br>";
    }
}

// Example usage
createUser('user6', 'password6', 'user6@example.com'); // Tạo người dùng mới
readAllUsers(); // Đọc tất cả người dùng
readUser(1); // Đọc người dùng với ID 1
updateUser(1, 'updatedUser', 'updated@example.com'); // Cập nhật người dùng với ID 1
deleteUser(6); // Xóa người dùng với ID 6

?>
