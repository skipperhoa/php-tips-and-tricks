<?php

$host = 'db';  // Tên dịch vụ MySQL trong Docker Compose
$db_name = 'db_hoanguyencoder';  // Tên cơ sở dữ liệu
$username = 'hoanguyencoder';  // Tên người dùng
$password = '12345678';  // Mật khẩu

// Kết nối đến MySQL
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Kết nối thành công!<br>";
} catch (PDOException $e) {
    die("❌ Lỗi kết nối: " . $e->getMessage());
}

// 🟢 Thêm một user mới
$stmt = $pdo->prepare("INSERT INTO User (username, password, email) VALUES (:username, :password, :email)");
$stmt->execute(['username' => $username, 'password' => password_hash($password, PASSWORD_DEFAULT), 'email' => $email]);


// 📝 Lấy thông tin user theo id
$stmt = $pdo->prepare("SELECT * FROM User WHERE id = :id");
$stmt->execute(['id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


// 🔄 Cập nhật thông tin user theo id
$stmt = $pdo->prepare("UPDATE User SET username = :username, email = :email WHERE id = :id");
$stmt->execute(['username' => $username, 'email' => $email, 'id' => $id]);


// 🗑️ Xóa thông tin user theo id
$stmt = $pdo->prepare("DELETE FROM User WHERE id = :id");
$stmt->execute(['id' => $id]);







