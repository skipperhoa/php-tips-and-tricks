<?php
$host = 'db';  // Tên dịch vụ MySQL trong Docker Compose
$db_name = 'db_hoanguyencoder';  // Tên cơ sở dữ liệu
$username = 'hoanguyencoder';  // Tên người dùng
$password = '12345678';  // Mật khẩu

// Kết nối đến MySQL
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Kết nối thành công!<br>";
} catch (PDOException $e) {
    die("Lỗi kết nối: " . $e->getMessage());
}

function select()
{
    global $pdo;
    $t = '';
    $args = func_get_args();

    foreach ($args as &$a) {
        $t .= gettype($a) . '|';
    }
    if ($t != '') {
        $t = substr($t, 0, -1);
    }

    $sql = '';
    $stmtParams = [];
    switch ($t) {
        case 'integer':
            // search by ID
            $sql = "id = :id";
            $stmtParams['id'] = $args[0];
            break;
        case 'string':
            // search by username
            $sql = "username LIKE :username";
            $stmtParams['username'] = '%' . $args[0] . '%';
            break;
        case 'string|integer':
            // search by username AND status
            $sql = "username LIKE :username AND status = :status";
            $stmtParams['username'] = '%' . $args[0] . '%';
            $stmtParams['status'] = $args[1];
            break;
        case 'string|integer|integer':
            // search by username with limit
            $sql = "username LIKE :username LIMIT :offset, :limit";
            $stmtParams['username'] = '%' . $args[0] . '%';
            $stmtParams['offset'] = $args[1];
            $stmtParams['limit'] = $args[2];
            break;
        default:
            // :P
            $sql = '1 = 2';
    }

    // Prepare and execute the statement
    $stmt = $pdo->prepare("SELECT * FROM User WHERE $sql");

    $stmt->execute($stmtParams);

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        foreach ($users as $user) {
            echo "ID: {$user['id']} - Username: {$user['username']} - Email: {$user['email']}<br>";
        }
    } else {
        return "Người dùng không tồn tại.<br>";
    }
}

$res = select(1); // by ID
// $res = select('user'); // by username
// $res = select('user', 1); // by username and status
 //$res = select('user', 0, 5); // by username with limit
?>
