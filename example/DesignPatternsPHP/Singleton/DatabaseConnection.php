<?php
/* 
Design Patterns - Singleton :
Singleton đảm bảo một lớp đặt bản một instance và cung cấp một điểm truy cập toàn cách đặt bản đó.
*/

require_once 'Singleton.php';

class DatabaseConnection extends Singleton {
    private $host = 'db'; 
    private $db_name = 'db_hoanguyencoder';
    private $username = 'hoanguyencoder';
    private $password = '12345678';
    private $pdo = null;

    // Kết nối đến MySQL
    private function connect() {
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Đang kết nối tới cơ sở dữ liệu...\n";
                echo "Kết nối thành công!\n";
            } catch (PDOException $e) {
                die("Lỗi kết nối: " . $e->getMessage());
            }
        }
    }

    // Phương thức để lấy kết nối hiện tại
    public function getConnection() {
        // Đảm bảo kết nối được khởi tạo
        $this->connect();
        return $this->pdo;
    }
}

?>
