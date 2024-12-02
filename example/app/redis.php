<?php
/* 
Using Redis on Docker (docker-compose.yml) in PHP
Install : 
composer require predis/predis

Docker Compose : 

*/
require '../../vendor/autoload.php';
try {
    // Kết nối Redis
    $redis_host = getenv('REDIS_HOST') ?: 'default_host';
    $redis_port = getenv('REDIS_PORT') ?: 6379;
    $redis_pass = getenv('REDIS_PASSWORD') ?: null;
    $redis = new \Predis\Client([
        'scheme' => 'tcp',
        'host' => $redis_host, // Lấy biến môi trường từ file .env
        'port' => $redis_port, // Nếu cần sử dụng port,
        'password' => $redis_pass // Nếu cần sử dụng password
    ]);
    // Ví dụ:
    $key = "hoanguyencoder_dev";
    $ttl = 10; // thời gian sống của khóa (key) là 10 giây
    // Kiểm tra key, nếu không có ta set key cho nó
    $check = $redis->exists($key);
   
    // Nếu khóa (key) tồn tại
    if ($check) {
        // Kiểm tra thời gian sống của khóa (key)
        $ttl = $redis->ttl($key);
        echo $ttl ."\n";
        // Nếu khóa (key) còn thời gian sống
        if ($ttl > 0) {
            echo "Khóa $key tồn tại \n";
            echo $redis->get($key) ."\n";
        } 
        // Nếu khóa (key) đã hết thời gian sống
        else {
            echo "Khóa $key không có thời gian sống\n";
            // Xóa khóa (key)
            $redis->del($key);
            echo "Đã xóa khóa $key \n";
        }
    } 
    // Nếu khóa (key) không tồn tại
    else {
        echo "Lần đầu! \n";
        echo "Khóa $key không tồn tại \n";
        echo "Và khóa $key sẽ được tạo  \n";
        $redis->set($key, "Hoa Nguyen Coder");
        echo "Cài đặt thời gian $ttl giây  \n";
        $redis->expire($key, $ttl);
    }
   
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}