<?php 

class Database {
    // Biến tĩnh để lưu giữ instance duy nhất của class Database
    private static $instance = null;

    private $pdo;
    private $host = 'db'; 
    private $db_name = 'db_hoanguyencoder';
    private $username = 'hoanguyencoder';
    private $password = '12345678';
    private function __construct() {

        $charset = 'utf8mb4';
        $dsn = "mysql:host=$this->host;dbname=$this->db_name;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try { 
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (\PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    public static function getInstance() {
        if (self::$instance === null) {
            // Tạo một instance duy nhất nếu chưa có
            self::$instance = new Database();
        }
        // Trả về đối tượng PDO đã được tạo
        return self::$instance->pdo;
    }
}

// Usage:
$db1 = Database::getInstance();
$db2 = Database::getInstance();
var_dump($db1 === $db2); // true
// Output: The same instance
echo "\n";
echo $db1 === $db2 ? 'Giống nhau' : 'Khác nhau';




