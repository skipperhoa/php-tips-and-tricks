<?php
class Singleton
{
    protected static self|null $instance = null;

    // Chặn khởi tạo trực tiếp
    final private function __construct() {}

    // Chặn nhân bản đối tượng
    final protected function __clone() {}

    // Chặn unserialize đối tượng
    final protected function __wakeup() {}

    // Phương thức lấy instance duy nhất
    public static function getInstance(): static
    {
        if (static::$instance === null) {
            echo "Đang khởi tạo instance...\n";
            static::$instance = new static;
        }
        echo "Instance tạo thành công!\n";
        return static::$instance;
    }
}