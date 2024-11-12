<?php

class Logger
{
    // Đây là biến tĩnh, dùng để lưu giữ instance duy nhất của lớp Logger
    private static $instance = null;

    // thuộc tính để lưu giữ đường dẫn đến file log
    private $logFile;

    // Make the constructor private to prevent instantiation
    private function __construct()
    {
        // Đường dẫn file log (app.log)
        $this->logFile = __DIR__ . '/app.log';

        // ghi một header "---- Log Start ----" vào đầu file log (chỉ khi file chưa có nội dung)
       // Kiểm tra nếu file log trống hoặc không tồn tại thì mới ghi header
       if (!file_exists($this->logFile) || filesize($this->logFile) === 0) {
            file_put_contents($this->logFile, "---- Log Start ----\n", FILE_APPEND);
        }
    }

    // Method to get the single instance of the Logger
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Logger();
        }

        return self::$instance;
    }

    // Write a message to the log file
    public function log($message)
    {
        $timestamp = date('Y-m-d H:i:s');
        $formattedMessage = "[{$timestamp}] - {$message}\n";

        // Append the message to the log file
        file_put_contents($this->logFile, $formattedMessage, FILE_APPEND);
    }

    // Prevent cloning
    private function __clone() {}

    // Prevent unserialization
    private function __wakeup() {}
}
//__clone() và __wakeup() là các phương thức "magic" (phương thức đặc biệt) được PHP cung cấp sẵn

// Usage
$logger = Logger::getInstance();
$logger->log("Application started");

$anotherLogger = Logger::getInstance();
$anotherLogger->log("Another part of the application logs a message");

// Verify both instances are the same
var_dump($logger === $anotherLogger); // true

// Check the log file (app.log) to see the output
