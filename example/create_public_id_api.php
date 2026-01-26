<?php

$host = 'localhost';  // Tên dịch vụ MySQL trong Docker Compose
$db_name = 'DemoPHP';  // Tên cơ sở dữ liệu
$username = 'root';  // Tên người dùng
$password = 'Hoa@1234';  // Mật khẩu
$message = [];
// Kết nối đến MySQL
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $message[] = "✅ Kết nối công!";
} catch (PDOException $e) {
    $message[] = "❌ Lỗi kết nối: " . $e->getMessage();
}

$query_1 = "CREATE TABLE users (
    id int primary key auto_increment,
    name varchar(32) not null,
    email varchar(32) not null UNIQUE,
    public_id VARCHAR(24) NOT NULL UNIQUE
);";
$query_2 = "CREATE TABLE  orders(
    id int primary key auto_increment,
    name varchar(32) not null,
    public_id VARCHAR(24) NOT NULL UNIQUE,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);";
// lưu các cấu query vào mảng
$array_table = ['users', 'orders'];
$array_query = [$query_1, $query_2];

// hàm check table có tồn tại hay không
function tableExists($pdo, $table)
{
    try {
        $result = $pdo->query("SELECT 1 FROM {$table} LIMIT 1");
    } catch (Exception $e) {
        return FALSE;
    }
    return $result !== FALSE;
}
//check status table
$check = [];
try {

    foreach ($array_table as $key => $value) {
        if (!tableExists($pdo, $value)) {
            try {
                $pdo->exec($array_query[$key]);
                array_push($check, array(
                    'name' => $value,
                    'status' => 'success',
                    'message' => 'Table created successfully'
                ));
            } catch (PDOException $e) {
                array_push($check, array('name' => $value, 'status' => 'error', 'message2' => $e->getMessage()));
            }
        } else {
            array_push($check, array(
                'name' => $value,
                'status' => 'success',
                'message' => 'Table already exists'
            ));
        }
    }
} catch (PDOException $e) {

    $message[] = "❌ Lỗi tạo bảng: " . $e->getMessage();
}

// uuid
$uuid = uniqid(); // dựa theo thời gian, nên có thể đoán
$base64_encode = base64_encode(random_bytes(18)); // ngẫu nhiên
$hex = bin2hex(random_bytes(24)); // ngẫu nhiên
$public_id = [
    'uuid' => $uuid,
    'to_base64' => rtrim(strtr($base64_encode, '+/', '-_'), '='),
    'to_hex' => $hex
];

//Example 1:
try {
    $author = [
        'name' => 'Hoa Nguyen Coder',
        'email' => $uuid . '@example.com',
        'public_id' => $public_id['to_base64']
    ];
    $sql1 = "INSERT INTO users (name, email, public_id) VALUES (:name, :email,:public_id)";
    $stmt = $pdo->prepare($sql1);
    $stmt->bindParam(':name', $author['name']);
    $stmt->bindParam(':email', $author['email']);
    $stmt->bindParam(':public_id', $author['public_id']);
    $stmt->execute();
    $lastId = $pdo->lastInsertId();

    $message[] = "✅ New record created successfully. Last inserted ID is: " . $lastId . "\n";
} catch (PDOException $e) {
    $message[] = "❌ Lỗi insert data: " . $e->getMessage();
}



echo json_encode(
    [
        'message' => $message,
        'check' => $check,
        'public_id' => $public_id
    ],
    JSON_THROW_ON_ERROR
);
